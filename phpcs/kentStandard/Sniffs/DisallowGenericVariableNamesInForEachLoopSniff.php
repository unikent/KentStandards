<?php
/**
 * This sniff disallows the use of generic varible names in a foreach loop
 * inspired by the the Squiz/Sniffs/ControlStructures/ForEachLoopDeclarationSniff sniff
 *
 * this implements a check for 5.5 rule:
 * Avoid the use of $k, $v, $key, $value etc. for variables within a foreach, names SHOULD be descriptive
 *
 * @author Christian Cable <c.f.cable@kent.ac.uk>
 *
 */
namespace kentStandard\sniffs;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class DisallowGenericVariableNamesInForEachLoop implements Sniff
{
	/**
	 * Returns an array of tokens this test wants to listen for.
	 *
	 * @return array
	 */
	public function register()
	{
		return array(T_FOREACH);
	}//end register()


	/**
	 * Processes this test, when one of its tokens is encountered.
	 *
	 * @param \PHP_CodeSniffer\Files\File $phpcsFile The file being scanned.
	 * @param int                         $stackPtr  The position of the current token in the
	 *                                               stack passed in $tokens.
	 *
	 * @return void
	 */
	public function process(File $phpcsFile, $stackPtr)
	{
		$tokens = $phpcsFile->getTokens();

		$openingBracketPtr = $phpcsFile->findNext(T_OPEN_PARENTHESIS, $stackPtr);
		if ($openingBracketPtr === false) {
			$error = 'Possible parse error: FOREACH has no opening parenthesis';
			$phpcsFile->addWarning($error, $stackPtr, 'MissingOpenParenthesis');
			return;
		}
		
		if (isset($tokens[$openingBracketPtr]['parenthesis_closer']) === false) {
			$error = 'Possible parse error: FOREACH has no closing parenthesis';
			$phpcsFile->addWarning($error, $stackPtr, 'MissingCloseParenthesis');
			return;
		}

		$closingBracketPtr = $tokens[$openingBracketPtr]['parenthesis_closer'];


		for ($currentTokenPtr=$openingBracketPtr; $currentTokenPtr != $closingBracketPtr; $currentTokenPtr++) {
			if ($tokens[$currentTokenPtr]['type'] == 'T_VARIABLE') {
				$error = 'Avoid the use of $k, $v, $key, $value etc. for variables within a foreach, names SHOULD be descriptive. Found %s';
				$variable = $tokens[$currentTokenPtr]['content'];
			
				// assuming single character vars are not descriptive
				if (strlen($variable) <= 2) {
					$phpcsFile->addWarning($error, $currentTokenPtr, 'GenericVariableNamesInForEachLoop', $variable);
				}

				// check for generic variable names
				$genericNames = ['$value', '$key'];
				if (in_array($variable, $genericNames)) {
					$phpcsFile->addWarning($error, $currentTokenPtr, 'GenericVariableNamesInForEachLoop', $variable);
				}
			}
		}
	}
}
