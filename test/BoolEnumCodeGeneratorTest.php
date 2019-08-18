<?php declare(strict_types=1);

namespace Cspray\Yape\Test;

use Cspray\Yape\Enum;
use Cspray\Yape\EnumCodeGenerator;
use Cspray\Yape\EnumDefinition;
use Cspray\Yape\EnumDefinitionValidator;
use Cspray\Yape\EnumValue;
use Cspray\Yape\EnumValueType;
use PHPUnit\Framework\TestCase;

/**
 *
 * @package Cspray\Yape\Test
 * @license See LICENSE in source root
 */
class BoolEnumCodeGeneratorTest extends TestCase {

    public static function setUpBeforeClass() : void {
        parent::setUpBeforeClass();
        $enumDefinition = new EnumDefinition(
            'YourVendor\\YourApp\\YourEnum',
            'YesNoAnswer',
            EnumValueType::Bool(),
            new EnumValue('Yes', true),
            new EnumValue('No', false)
        );
        $code = (new EnumCodeGenerator(new EnumDefinitionValidator()))->generateEnumCode($enumDefinition);

        $code = preg_replace('/<\?php/', '', $code);

        eval($code);
    }

    public function enumValueProvider() {
        return [
            ['YourVendor\\YourApp\\YourEnum\\YesNoAnswer::Yes', true],
            ['YourVendor\\YourApp\\YourEnum\\YesNoAnswer::No', false],
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
    public function testEnumValuesHaveCorrectScalarValue(string $staticMethod, bool $expected) {
        $actual = call_user_func($staticMethod);

        $this->assertSame($expected, $actual->getValue());
    }

    public function toStringProvider() : array {
        return [
            ['YourVendor\\YourApp\\YourEnum\\YesNoAnswer::Yes', 'YourVendor\\YourApp\\YourEnum\\YesNoAnswer@Yes'],
            ['YourVendor\\YourApp\\YourEnum\\YesNoAnswer::No', 'YourVendor\\YourApp\\YourEnum\\YesNoAnswer@No'],
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
            ['YourVendor\\YourApp\\YourEnum\\YesNoAnswer::Yes', 'YourVendor\\YourApp\\YourEnum\\YesNoAnswer::Yes', true],
            ['YourVendor\\YourApp\\YourEnum\\YesNoAnswer::Yes', 'YourVendor\\YourApp\\YourEnum\\YesNoAnswer::No', false],
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