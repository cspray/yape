<?php declare(strict_types=1);

namespace Cspray\Yape;

use Cspray\Yape\Exception\InvalidArgumentException;
use http\Exception\BadQueryStringException;

/**
 * A reusable implementation of the methods and intent required by the Enum interface.
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
trait EnumTrait {

    static private $container;

    private $enumValue;

    /**
     * If this method is overridden it is critical that setEnumValue is called appropriately.
     *
     * @param string $enumValue
     */
    private function __construct(string $enumValue) {
        $this->setEnumValue($enumValue);
    }

    /**
     * Sets the value of the Enum, which corresponds to its toString value and the string necessary to return the instance
     * from valueOf.
     *
     * This should be called 1 time from within the constructor on instance creation.
     *
     * @param string $enumValue
     */
    private function setEnumValue(string $enumValue) : void {
        $this->enumValue = $enumValue;
    }

    /**
     * Returns an array of Enum instances that could be instantiated by this Enum.
     *
     * @return self[]
     */
    static public function values() : array {
        self::primeContainer();
        return array_values(self::$container);
    }

    /**
     * Return an Enum instance that matches the given $name or throw an InvalidArgumentException if the $Name is not a
     * valid value for this Enum.
     *
     * @param string $name
     * @return static
     */
    static public function valueOf(string $name) : self {
        self::primeContainer();
        if (!isset(self::$container[$name])) {
            $msg = sprintf('The value "%s" is not a valid %s name', $name, self::class);
            throw new InvalidArgumentException($msg);
        }
        return self::$container[$name];
    }

    /**
     * Returns whether or not this Enum is equal to $compare.
     *
     * @param $compare
     * @return bool
     */
    public function equals($compare) : bool {
        return $this === $compare;
    }

    /**
     * Returns the value passed to setEnumValue.
     *
     * @return string
     */
    public function toString() : string {
        return $this->enumValue;
    }

    /**
     * The factory method that static method constructors should use when creating their instances.
     *
     * This method guarantees that for each $enumValue only one instance will be created.
     *
     * @param string $enumValue
     * @param mixed ...$constructorArgs
     * @return static
     */
    static protected function getSingleton(string $enumValue, ...$constructorArgs) : self {
        if (!isset(self::$container[$enumValue])) {
            self::$container[$enumValue] = new self($enumValue, ...$constructorArgs);
        }

        return self::$container[$enumValue];
    }

    /**
     * Ensures that all values possible for this Enum are instantiated; primarily used to ensure that the values() and
     * valueOf() methods work appropriately.
     */
    static private function primeContainer() {
        $allowedValues = self::getAllowedValues();
        if (count(self::$container) !== count($allowedValues)) {
            foreach ($allowedValues as $enumValue) {
                self::$enumValue();
            }
        }
    }

    /**
     * Return an array of enum values, that correspond to static method constructors, that are allowed for this Enum.
     *
     * @return string[]
     */
    static abstract protected function getAllowedValues() : array;

}