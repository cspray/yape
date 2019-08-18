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
class IntEnumCodeGeneratorTest extends TestCase {

    public static function setUpBeforeClass() : void {
        parent::setUpBeforeClass();
        $enumDefinition = new EnumDefinition(
            'YourVendor\\YourApp\\YourEnum',
            'MagicNumbers',
            EnumValueType::Int(),
            new EnumValue('TheAnswer', 42),
            new EnumValue('States', 50),
            new EnumValue('HappyHour', 5)
        );
        $code = (new EnumCodeGenerator(new EnumDefinitionValidator()))->generateEnumCode($enumDefinition);

        $code = preg_replace('/<\?php/', '', $code);

        eval($code);
    }

    public function enumValueProvider() {
        return [
            ['YourVendor\\YourApp\\YourEnum\\MagicNumbers::TheAnswer', 42],
            ['YourVendor\\YourApp\\YourEnum\\MagicNumbers::States', 50],
            ['YourVendor\\YourApp\\YourEnum\\MagicNumbers::HappyHour', 5],
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
     * @param int $expected
     * @dataProvider enumValueProvider
     */
    public function testEnumValuesHaveCorrectScalarValue(string $staticMethod, int $expected) {
        $actual = call_user_func($staticMethod);

        $this->assertSame($expected, $actual->getValue());
    }

    public function toStringProvider() : array {
        return [
            ['YourVendor\\YourApp\\YourEnum\\MagicNumbers::TheAnswer', 'YourVendor\\YourApp\\YourEnum\\MagicNumbers@TheAnswer'],
            ['YourVendor\\YourApp\\YourEnum\\MagicNumbers::States', 'YourVendor\\YourApp\\YourEnum\\MagicNumbers@States'],
            ['YourVendor\\YourApp\\YourEnum\\MagicNumbers::HappyHour', 'YourVendor\\YourApp\\YourEnum\\MagicNumbers@HappyHour'],
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
            ['YourVendor\\YourApp\\YourEnum\\MagicNumbers::TheAnswer', 'YourVendor\\YourApp\\YourEnum\\MagicNumbers::TheAnswer', true],
            ['YourVendor\\YourApp\\YourEnum\\MagicNumbers::TheAnswer', 'YourVendor\\YourApp\\YourEnum\\MagicNumbers::States', false],
            ['YourVendor\\YourApp\\YourEnum\\MagicNumbers::TheAnswer', 'YourVendor\\YourApp\\YourEnum\\MagicNumbers::HappyHour', false],
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