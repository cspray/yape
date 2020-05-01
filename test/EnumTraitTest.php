<?php declare(strict_types=1);

namespace Cspray\Yape;

use Cspray\Yape\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class EnumTraitTest extends TestCase {

    public function tearDown(): void {
        parent::tearDown();

        // We are doing this to ensure that our expected state is always reset after each test and we don't have
        // erroneous references sticking around because we have to make use of static state. You should ABSOLUTELY NOT
        // do this within your own codebase.
        $reflection = new ReflectionClass(EnumTraitStub::class);
        $containerProperty = $reflection->getProperty('container');
        $containerProperty->setAccessible(true);
        $containerProperty->setValue([]);
    }

    public function testSuccessiveCallsToSameMethodAreSameObject() {
        $a = EnumTraitStub::Foo();
        $b = EnumTraitStub::Foo();
        $this->assertSame($a, $b);
    }

    public function testToStringReturnsNameOfEnumMethod() {
        $subject = EnumTraitStub::Bar();

        $this->assertSame('Bar', $subject->toString());
    }

    public function testEqualsTrueWhenSameEnumValue() {
        $this->assertTrue(EnumTraitStub::Bar()->equals(EnumTraitStub::Bar()));
    }

    public function testEqualsFalseWhenStringPassed() {
        $this->assertFalse(EnumTraitStub::Bar()->equals('Bar'));
    }

    public function testEqualsFalseWhenDifferentEnumValue() {
        $this->assertFalse(EnumTraitStub::Baz()->equals(EnumTraitStub::Foo()));
    }

    public function testValueOfReturnsInstanceWhenValueMatches() {
        $subject = EnumTraitStub::valueOf('Foo');

        $this->assertSame($subject, EnumTraitStub::Foo());
    }

    public function testValueOfThrowsExceptionIfValueIsInvalid() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The value "bad" is not a valid ' . EnumTraitStub::class . ' name');

        EnumTraitStub::valueOf('bad');
    }

    public function testValuesReturnsArrayOfInstances() {
        $actual = EnumTraitStub::values();
        $expected = [
            EnumTraitStub::Foo(),
            EnumTraitStub::Bar(),
            EnumTraitStub::Baz()
        ];

        $this->assertSame($expected, $actual);
    }

}