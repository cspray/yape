<?php declare(strict_types=1);

namespace Cspray\Yape;

class EnumTraitStub {

    use EnumTrait;

    public static function Foo() : EnumTraitStub {
        return self::getSingleton('Foo');
    }

    public static function Bar() : EnumTraitStub {
        return self::getSingleton('Bar');
    }

    public static function Baz() : EnumTraitStub {
        return self::getSingleton('Baz');
    }

    static protected function getAllowedValues(): array {
        return ['Foo', 'Bar', 'Baz'];
    }
}