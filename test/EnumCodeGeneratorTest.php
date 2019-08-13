<?php declare(strict_types=1);

namespace Cspray\Yape\Test;

use Cspray\Yape\EnumCodeGenerator;
use Cspray\Yape\EnumDefinition;
use PHPUnit\Framework\TestCase;

/**
 *
 * @package Cspray\Yape\Test
 * @license See LICENSE in source root
 */
class EnumCodeGeneratorTest extends TestCase {

    public function testFullyQualifiedClassWithValidValuesConstructsCorrectEnum() {
        $enumDefinition = new EnumDefinition('YourVendor\\YourApp\\YourEnum', 'ExpectedFooBarEnum', 'Foo', 'Bar', 'Baz');
        $code = (new EnumCodeGenerator())->generateEnumCode($enumDefinition);

        $this->assertStringEqualsFile(__DIR__ . '/data/ExpectedFooBarEnum.php', $code);
    }

    public function testFullyQuallifiedClassNameWithValidValuesConstructsEnumWithCorrectValue() {
        $enumDefinition = new EnumDefinition('YourVendor\\YourApp\\YourEnum', 'Compass', 'North', 'South', 'East', 'West');
        $code = (new EnumCodeGenerator())->generateEnumCode($enumDefinition);

        $code = preg_replace('/<\?php/', '', $code);

        eval($code);

        $north = \YourVendor\YourApp\YourEnum\Compass::North();
        $south = \YourVendor\YourApp\YourEnum\Compass::South();
        $east = \YourVendor\YourApp\YourEnum\Compass::East();
        $west = \YourVendor\YourApp\YourEnum\Compass::West();

        $this->assertSame($north, \YourVendor\YourApp\YourEnum\Compass::North());
        $this->assertSame($south, \YourVendor\YourApp\YourEnum\Compass::South());
        $this->assertSame($east, \YourVendor\YourApp\YourEnum\Compass::East());
        $this->assertSame($west, \YourVendor\YourApp\YourEnum\Compass::West());

        $this->assertSame('North', $north->getValue());
        $this->assertSame('South', $south->getValue());
        $this->assertSame('East', $east->getValue());
        $this->assertSame('West', $west->getValue());
    }



}