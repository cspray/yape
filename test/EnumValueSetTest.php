<?php declare(strict_types=1);

namespace Cspray\Yape\Test;

use Cspray\Yape\EnumValue;
use Cspray\Yape\EnumValueSet;
use Cspray\Yape\EnumValueType;
use PHPUnit\Framework\TestCase;

/**
 *
 * @package Cspray\Yape\Test
 * @license See LICENSE in source root
 */
class EnumValueSetTest extends TestCase {

    public function testConstructingSetWithInvalidValueTypesThrowException() {
        $goodEnumValue = new EnumValue('Good', 'foo');
        $badEnumValue = new EnumValue('Bad', 1);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('All added EnumValue MUST adhere to the EnumValueType and the value named "Bad" is not a proper "string" type');

        new EnumValueSet(EnumValueType::String(), $goodEnumValue, $badEnumValue);
    }

    public function testAddingToSetWithInvalidValueTypesThrowException() {
        $set = new EnumValueSet(EnumValueType::String());

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('All added EnumValue MUST adhere to the EnumValueType and the value named "Bad" is not a proper "string" type');

        $set->add(new EnumValue('Bad', true));
    }

    public function testConstructingSetWithDuplicateEnumNamesThrowsException() {
        $one = new EnumValue('One', 'one');
        $dupe = new EnumValue('One', 'two');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('A duplicated EnumValue name, "One", was encountered. All EnumValue names for a specific Enum MUST be unique');

        new EnumValueSet(EnumValueType::String(), $one, $dupe);
    }

    public function testAddingSetWithDuplicateEnumNamesThrowsException() {
        $one = new EnumValue('One', 'one');
        $dupe = new EnumValue('One', 'two');
        $set = new EnumValueSet(EnumValueType::String());

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('A duplicated EnumValue name, "One", was encountered. All EnumValue names for a specific Enum MUST be unique');

        $set->add($one);
        $set->add($dupe);
    }

    public function testIteratingOverValidAddedValues() {
        $one = new EnumValue('One', 1);
        $two = new EnumValue('Two', 2);
        $three = new EnumValue('Three', 3);

        $set = new EnumValueSet(EnumValueType::Int(), $one,  $two, $three);

        $actual = iterator_to_array($set);
        $expected = [$one, $two, $three];

        $this->assertSame($expected, $actual);
    }

    public function testCountingAddedValues() {
        $one = new EnumValue('One', 1);
        $two = new EnumValue('Two', 2);
        $three = new EnumValue('Three', 3);

        $set = new EnumValueSet(EnumValueType::Int(), $one,  $two, $three);

        $this->assertCount(3, $set);
    }

}