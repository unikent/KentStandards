Kent Standards
==============

##University of Kent Coding Standards and Style Guide

This document comprises what should be considered the standard
coding elements that are required to ensure a high level of technical
interoperability between shared PHP code.

The intent of this guide is to reduce cognitive friction when scanning code from different authors. It does so by enumerating a shared set of rules and expectations about how to format PHP code.

The style rules herein are derived from commonalities among the various member projects. When various authors collaborate across multiple projects, it helps to have one set of guidelines to be used among all those projects. Thus, the benefit of this guide is not in the rules themselves, but in the sharing of those rules.

The key words "MUST", "MUST NOT", "REQUIRED", "SHALL", "SHALL NOT", "SHOULD",
"SHOULD NOT", "RECOMMENDED", "MAY", and "OPTIONAL" in this document are to be
interpreted as described in [RFC 2119].

[RFC 2119]: http://www.ietf.org/rfc/rfc2119.txt
[PSR-0]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md

1. General
--------

### 1.1. PHP Tags

PHP code MUST use the long `<?php ?>` tags it MUST NOT use the 
short-echo `<?= ?>` tags or other tag variations.

### 1.2. Character Encoding

PHP code MUST use only UTF-8 without BOM.

### 1.3. Line Endings

- All PHP files SHOULD use use the Unix LF (linefeed) line ending. Whatever line ending
  is used it MUST be used consitently throughout a project.

### 1.4. Whitespace & Indentation

- All PHP files MUST end with a single blank line.

- The closing ?> tag MUST be omitted from files containing only PHP.

- There MUST NOT be trailing whitespace at the end of non-blank lines.

- Single blank lines MAY be added to improve readability and to indicate related blocks of code.

- Code MUST use tabs for indentation, and MUST NOT use spaces for indenting.

- The use of spaces is permitted for fine-grained inter-line alignment of operators, values etc.

### 1.5. Lines

- There MUST NOT be more than one statement per line.

- There MUST NOT be a hard limit on line length.

- The soft limit on line length MUST be 120 characters; automated style checkers MUST warn but MUST NOT error at the soft limit.

- Lines SHOULD NOT be longer than 80 characters; lines longer than that SHOULD be split into multiple subsequent lines of no more than 80 characters each.

### 1.6. Keywords and True/False/Null

- PHP keywords MUST be in lower case.

- The PHP constants true, false, and null MUST be in lower case.

### 1.7. Side Effects

- A file SHOULD declare new symbols (classes, functions, constants,
  etc.) and cause no other side effects, or it SHOULD execute logic with side
  effects, but SHOULD NOT do both.

The phrase "side effects" means execution of logic not directly related to
declaring classes, functions, constants, etc., *merely from including the
file*.

"Side effects" include but are not limited to: generating output, explicit
use of `require` or `include`, connecting to external services, modifying ini
settings, emitting errors or exceptions, modifying global or static variables,
reading from or writing to a file, and so on.

The following is an example of a file with both declarations and side effects;
i.e, an example of what to avoid:

```php
<?php
// side effect: change ini settings
ini_set('error_reporting', E_ALL);

// side effect: loads a file
include "file.php";

// side effect: generates output
echo "<html>\n";

// declaration
function foo()
{
    // function body
}
```

The following example is of a file that contains declarations without side
effects; i.e., an example of what to emulate:

```php
<?php
// declaration
function foo()
{
    // function body
}

// conditional declaration is *not* a side effect
if (! function_exists('bar')) {
    function bar()
    {
        // function body
    }
}
```


3. Namespace, Use Declarations and Class Names
----------------------------

- Namespaces and classes MUST follow [PSR-4] "autoloading".
  This means each class is in a file by itself, and is in a namespace of at
  least one level: a top-level vendor name.

- When present, there MUST be one blank line after the `namespace` declaration.

- When present, all `use` declarations MUST go after the `namespace`
  declaration.

- There MUST be one `use` keyword per declaration.

- There MUST be one blank line after the `use` block.

For example:

```php
<?php
namespace Vendor\Package;

use FooClass;
use BarClass as Bar;
use OtherVendor\OtherPackage\BazClass;

// ... additional PHP code ...

```

- Class names MUST be declared in `StudlyCaps`.

- Code written for PHP 5.3 and after MUST use formal namespaces.

For example:

```php
<?php
// PHP 5.3 and later:
namespace Vendor\Model;

class Foo
{
}
```

- Code written for 5.2.x and before SHOULD use the pseudo-namespacing convention
  of `Vendor_` prefixes on class names.

```php
<?php
// PHP 5.2.x and earlier:
class Vendor_Model_Foo
{
}
```

- The `extends` and `implements` keywords MUST be declared on the same line as
  the class name.

- The opening brace for the class MUST go on its own line; the closing brace
  for the class MUST go on the next line after the body.

```php
<?php
namespace Vendor\Package;

use FooClass;
use BarClass as Bar;
use OtherVendor\OtherPackage\BazClass;

class ClassName extends ParentClass implements \ArrayAccess, \Countable
{
    // constants, properties, methods
}
```

- Lists of `implements` MAY be split across multiple lines, where each
  subsequent line is indented once. When doing so, the first item in the list
  MUST be on the next line, and there MUST be only one interface per line.

```php
<?php
namespace Vendor\Package;

use FooClass;
use BarClass as Bar;
use OtherVendor\OtherPackage\BazClass;

class ClassName extends ParentClass implements
    \ArrayAccess,
    \Countable,
    \Serializable
{
    // constants, properties, methods
}
```

4. Class Constants, Properties, and Methods
-------------------------------------------

The term "class" refers to all classes, interfaces, and traits.

### 4.1. Constants

Class constants MUST be declared in all upper case with underscore separators.
For example:

```php
<?php
namespace Vendor\Model;

class Foo
{
    const VERSION = '1.0';
    const DATE_APPROVED = '2012-06-01';
}
```

### 4.2. Properties

- Properties and Variables MUST use an underscore format. For example `$variable_name`.

- Visibility MUST be declared on all properties.

- The `var` keyword MUST NOT be used to declare a property.

- There MUST NOT be more than one property declared per statement.

- Property names SHOULD NOT be prefixed with a single underscore to indicate
  protected or private visibility.

A property declaration looks like the following.

```php
<?php
namespace Vendor\Package;

class ClassName
{
    public $foo = null;
}
```

### 4.3. Methods

Method names MUST be declared in `camelCase()`.
