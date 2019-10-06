<?php declare(strict_types=1);

namespace Cspray\Yape;

use Cspray\Yape\Exception\InvalidArgumentException;

/**
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
trait EnumTrait {

    static private $container;

    private $enumValue;

    private function __construct(string $enumValue) {
        $this->enumValue = $enumValue;
    }

    static public function values() : array {
        self::primeContainer();
        return array_values(self::$container);
    }

    static public function valueOf(string $name) : self {
        self::primeContainer();
        if (!isset(self::$container[$name])) {
            $msg = sprintf('The value "%s" is not a valid %s name', $name, self::class);
            throw new InvalidArgumentException($msg);
        }
        return self::$container[$name];
    }

    public function equals($compare) : bool {
        return $this === $compare;
    }

    public function toString() : string {
        return $this->enumValue;
    }

    static protected function getSingleton(string $enumValue, ...$constructorArgs) : self {
        if (!isset(self::$container[$enumValue])) {
            self::$container[$enumValue] = new self($enumValue, ...$constructorArgs);
        }

        return self::$container[$enumValue];
    }

    static private function primeContainer() {
        $allowedValues = self::getAllowedValues();
        if (count(self::$container) !== count($allowedValues)) {
            foreach ($allowedValues as $enumValue) {
                self::$enumValue();
            }
        }
    }

    static abstract protected function getAllowedValues() : array;

}