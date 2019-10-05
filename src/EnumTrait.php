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

    static public function values() : array {
        self::primeContainer();
        return array_values(self::$container);
    }

    static public function valueOf(string $name) {
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

    static protected function getSingleton(...$constructorArgs) : self {
        $name = $constructorArgs[0];
        if (!isset(self::$container[$name])) {
            self::$container[$name] = new self(...$constructorArgs);
        }

        return self::$container[$name];
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