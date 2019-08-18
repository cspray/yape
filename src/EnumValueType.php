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

    private function __construct(string $enumConstName, string $value) {
        $this->enumConstName = $enumConstName;
        $this->value = $value;
    }

    protected static function getSingleton($value, ...$additionalConstructorArgs) {
        if (!isset(self::$container[$value])) {
            self::$container[$value] = new self(...array_merge([$value], $additionalConstructorArgs));
        }

        return self::$container[$value];
    }

    public static function String() : EnumValueType {
        return self::getSingleton('String', 'string');
    }

    public static function Int() : EnumValueType {
        return self::getSingleton('Int', 'int');
    }

    public static function Bool() : EnumValueType {
        return self::getSingleton('Bool', 'bool');
    }

    public static function Float() : EnumValueType {
        return self::getSingleton('Float', 'float');
    }

    public function getValue() : string {
        return $this->value;
    }

    public function equals(EnumValueType $enumValueType) : bool {
        return $this === $enumValueType;
    }

    public function toString() : string {
        return get_class($this) . '@' . $this->enumConstName;
    }

}