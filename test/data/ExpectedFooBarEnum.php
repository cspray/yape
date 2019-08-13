<?php declare(strict_types=1);

namespace YourVendor\YourApp\YourEnum;

final class ExpectedFooBarEnum {

    private static $foo;
    private static $bar;
    private static $baz;

    private $value;

    private function __construct(string $value) {
        $this->value = $value;
    }

    public static function Foo() : ExpectedFooBarEnum {
        if (!isset(self::$foo)) {
            self::$foo = new self('Foo');
        }

        return self::$foo;
    }

    public static function Bar() : ExpectedFooBarEnum {
        if (!isset(self::$bar)) {
            self::$bar = new self('Bar');
        }

        return self::$bar;
    }

    public static function Baz() : ExpectedFooBarEnum {
        if (!isset(self::$baz)) {
            self::$baz = new self('Baz');
        }

        return self::$baz;
    }

    public function getValue() : string {
        return $this->value;
    }

}