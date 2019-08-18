<?php declare(strict_types=1);

namespace Cspray\Yape\Test;

use Cspray\Yape\Enum;
use Cspray\Yape\EnumCodeGenerator;
use Cspray\Yape\EnumDefinition;
use Cspray\Yape\EnumDefinitionValidator;
use Cspray\Yape\EnumValue;
use Cspray\Yape\EnumValueType;
use Cspray\Yape\InvalidEnumValueException;
use PHPUnit\Framework\TestCase;

/**
 *
 * @package Cspray\Yape\Test
 * @license See LICENSE in source root
 */
class StringEnumCodeGeneratorTest extends TestCase {

    public static function setUpBeforeClass() : void {
        parent::setUpBeforeClass();
        $enumDefinition = new EnumDefinition(
            'YourVendor\\YourApp\\YourEnum',
            'Compass',
            EnumValueType::String(),
            new EnumValue('North', 'North'),
            new EnumValue('South', 'South'),
            new EnumValue('East', 'East'),
            new EnumValue('West', 'West')
        );
        $code = (new EnumCodeGenerator(new EnumDefinitionValidator()))->generateEnumCode($enumDefinition);

        $code = preg_replace('/<\?php/', '', $code);

        eval($code);
    }

    public function enumValueProvider() {
        return [
            ['YourVendor\\YourApp\\YourEnum\\Compass::North', 'North'],
            ['YourVendor\\YourApp\\YourEnum\\Compass::South', 'South'],
            ['YourVendor\\YourApp\\YourEnum\\Compass::East', 'East'],
            ['YourVendor\\YourApp\\YourEnum\\Compass::West', 'West']
        ];
    }

    /**
     * @param string $staticMethod
     * @dataProvider enumValueProvider
     */
    public function testEnumValuesAreSameObject(string $staticMethod) {
        $one = call_user_func($staticMethod);
        $two = call_user_func($staticMethod);

        $this->assertSame($one, $two);
    }

    /**
     * @param string $staticMethod
     * @dataProvider enumValueProvider
     */
    public function testEnumValuesImplementEnumInterface(string $staticMethod) {
        $one = call_user_func($staticMethod);

        $this->assertInstanceOf(Enum::class, $one);
    }

    /**
     * @param string $staticMethod
     * @param string $expected
     * @dataProvider enumValueProvider
     */
    public function testEnumValuesHaveCorrectScalarValue(string $staticMethod, string $expected) {
        $actual = call_user_func($staticMethod);

        $this->assertSame($expected, $actual->getValue());
    }

    public function toStringProvider() : array {
        return [
            ['YourVendor\\YourApp\\YourEnum\\Compass::North', 'YourVendor\\YourApp\\YourEnum\\Compass@North'],
            ['YourVendor\\YourApp\\YourEnum\\Compass::South', 'YourVendor\\YourApp\\YourEnum\\Compass@South'],
            ['YourVendor\\YourApp\\YourEnum\\Compass::East', 'YourVendor\\YourApp\\YourEnum\\Compass@East'],
            ['YourVendor\\YourApp\\YourEnum\\Compass::West', 'YourVendor\\YourApp\\YourEnum\\Compass@West']
        ];
    }

    /**
     * @param string $staticMethod
     * @param string $expected
     * @dataProvider toStringProvider
     */
    public function testToString(string $staticMethod, string $expected) {
        $actual = call_user_func($staticMethod);

        $this->assertSame($expected, $actual->toString());
    }

    public function equalsProvider() : array {
        return [
            ['YourVendor\\YourApp\\YourEnum\\Compass::North', 'YourVendor\\YourApp\\YourEnum\\Compass::North', true],
            ['YourVendor\\YourApp\\YourEnum\\Compass::North', 'YourVendor\\YourApp\\YourEnum\\Compass::South', false],
            ['YourVendor\\YourApp\\YourEnum\\Compass::North', 'YourVendor\\YourApp\\YourEnum\\Compass::East', false],
            ['YourVendor\\YourApp\\YourEnum\\Compass::North', 'YourVendor\\YourApp\\YourEnum\\Compass::West', false]
        ];
    }

    /**
     * @param string $firstMethod
     * @param string $secondMethod
     * @param bool $expected
     * @dataProvider equalsProvider
     */
    public function testEquals(string $firstMethod, string $secondMethod, bool $expected) {
        $one = call_user_func($firstMethod);
        $this->assertSame($expected, $one->equals(call_user_func($secondMethod)));
    }

}