<?php declare(strict_types=1);

namespace Cspray\Yape;

use Cspray\Yape\Enum;

/**
 * An enum representing the value types that an enum value may have.
 *
 * @package Cspray\Yape
 */
final class EnumValueType implements Enum {

    private static $container = [];

    private $enumConstName;
    private $value;
    private $typeValidator;

    private function __construct(string $enumConstName, string $value, callable $typeValidator) {
        $this->enumConstName = $enumConstName;
        $this->value = $value;
        $this->typeValidator = $typeValidator;
    }

    protected static function getSingleton($value, ...$additionalConstructorArgs) {
        if (!isset(self::$container[$value])) {
            self::$container[$value] = new self(...array_merge([$value], $additionalConstructorArgs));
        }

        return self::$container[$value];
    }

    public static function String() : EnumValueType {
        return self::getSingleton('String', 'string', function($var) {
            return is_string($var);
        });
    }

    public static function Int() : EnumValueType {
        return self::getSingleton('Int', 'int', function($var) {
            return is_int($var);
        });
    }

    public static function Bool() : EnumValueType {
        return self::getSingleton('Bool', 'bool', function($var) {
            return is_bool($var);
        });
    }

    public static function Float() : EnumValueType {
        return self::getSingleton('Float', 'float', function($var) {
            return is_float($var);
        });
    }

    public function getValue() : string {
        return $this->value;
    }

    public function isValidType($var) : bool {
        return ($this->typeValidator)($var);
    }

    public function equals(EnumValueType $enumValueType) : bool {
        return $this === $enumValueType;
    }

    public function toString() : string {
        return get_class($this) . '@' . $this->enumConstName;
    }

}