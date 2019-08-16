# YAPE - Yet Another PHP Enum

A PHP code generator to create type-safe enums that do not require extending an abstract enum nor 
does it require defining class level constants.

## Requirements

- PHP 7.2+

## Installation

```shell
composer require cspray/yape
```

### Usage

Generating an enum with YAPE is as simple as executing a binary script and providing the fully qualified 
class name you'd like for your enum and the values for your enum. The script will ask where you'd like 
to store your enum; provide a directory within context of the current working directory.

```shell script
vendor/bin/yape YourNamespace\\YourVendor\\Compass North South East West
> Where would you like to create your new enum? (src)
```

If the directory provided is writable the following code will be generated:

```php
<?php declare(strict_types=1);

namespace YourVendor\YourApp;

final class Compass {

    private static $north;
    private static $south;
    private static $east;
    private static $west;

    private $value;

    private function __construct(string $value) {
        $this->value = $value;
    }

    public static function North() : Compass {
        if (!isset(self::$north)) {
            self::$north = new self('North');
        }

        return self::$north;
    }

    public static function South() : Compass {
        if (!isset(self::$south)) {
            self::$south = new self('South');
        }

        return self::$south;
    }

    public static function East() : Compass {
        if (!isset(self::$east)) {
            self::$east = new self('East');
        }

        return self::$east;
    }

    public static function West() : Compass {
        if (!isset(self::$west)) {
            self::$west = new self('West');
        }

        return self::$west;
    }

    public function getValue() : string {
        return $this->value;
    }

}
```



