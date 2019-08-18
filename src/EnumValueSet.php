<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 * Represents a distinct set of EnumValues that adhere to a specific EnumValueType
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
final class EnumValueSet implements \Countable, \IteratorAggregate {

    private $enumValueType;
    /**
     * @var EnumValue[]
     */
    private $enumValues = [];

    /**
     * Each of the provided $enumValues MUST adhere to the $enumValueType or an InvalidArgumentException will be thrown.
     *
     * @param EnumValueType $enumValueType
     * @param EnumValue ...$enumValues
     */
    public function __construct(EnumValueType $enumValueType, EnumValue ...$enumValues) {
        $this->enumValueType = $enumValueType;
        foreach ($enumValues as $enumValue) {
            $this->add($enumValue);
        }
    }

    /**
     * If the added $enumValue is either a duplicate value in the set OR does not adhere to the EnumValueType for this
     * set an InvalidArgumentException will be thrown.
     *
     * @param EnumValue $enumValue
     * @throws \InvalidArgumentException
     */
    public function add(EnumValue $enumValue) : void {
        if (!$this->enumValueType->isValidType($enumValue->getValue())) {
            $msg = 'All added EnumValue MUST adhere to the EnumValueType and the value named "%s" is not a proper "%s" type';
            throw new \InvalidArgumentException(sprintf($msg, $enumValue->getName(), $this->enumValueType->getValue()));
        }

        foreach ($this as $storedEnumValue) {
            if ($enumValue->getName() === $storedEnumValue->getName()) {
                $msg = 'A duplicated EnumValue name, "%s", was encountered. All EnumValue names for a specific Enum MUST be unique';
                throw new \InvalidArgumentException(sprintf($msg, $enumValue->getName()));
            }
        }

        $this->enumValues[] = $enumValue;
    }

    /**
     *
     * @return \Generator
     */
    public function getIterator() {
        foreach ($this->enumValues as $enumValue) {
            yield $enumValue;
        }
    }

    /**
     * Count elements of an object
     *
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count() {
        return count($this->enumValues);
    }
}