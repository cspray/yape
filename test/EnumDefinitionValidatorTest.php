<?php declare(strict_types=1);

namespace Cspray\Yape\Test;

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
class EnumDefinitionValidatorTest extends TestCase {

    /**
     * @var EnumDefinitionValidator
     */
    private $subject;

    public function setUp() : void {
        parent::setUp();
        $this->subject = new EnumDefinitionValidator();
    }

    public function testValidateWithBadNamespace() {
        $definition = new EnumDefinition('This is a bad namespace', 'EnumName', EnumValueType::String(), new EnumValue('One', 'One'));
        $results = $this->subject->validate($definition);

        $this->assertFalse($results->isValid());

        $expected = ['The enum namespace must have only valid PHP namespace characters'];
        $actual = $results->getErrorMessages();

        $this->assertSame($expected, $actual);
    }

    public function testValidateWithBadClassName() {
        $definition = new EnumDefinition('Vendor\\GoodApp', 'Bad Class Name', EnumValueType::String(), new EnumValue('One', 'One'));
        $results = $this->subject->validate($definition);

        $this->assertFalse($results->isValid());

        $expected = ['The enum class must have only valid PHP class characters'];
        $actual = $results->getErrorMessages();

        $this->assertSame($expected, $actual);
    }

    public function testValidatorWithEmptyEnumValue() {
        $definition = new EnumDefinition('Vendor\\GoodApp', 'GoodClassName', EnumValueType::String());
        $results = $this->subject->validate($definition);

        $this->assertFalse($results->isValid());

        $expected = ['There must be at least one enum value'];
        $actual = $results->getErrorMessages();

        $this->assertSame($expected, $actual);
    }

    public function testValidatorWithBadEnumValueName() {
        $definition = new EnumDefinition('Vendorr\\GoodApp', 'Some_Class_Name1', EnumValueType::String(), new EnumValue('Bad Method Name', 'one'));
        $results = $this->subject->validate($definition);

        $this->assertFalse($results->isValid());

        $expected = ['All EnumValue names must have only valid PHP class method characters'];
        $actual = $results->getErrorMessages();

        $this->assertSame($expected, $actual);
    }

    public function testValidatorWithReservedWordInNamespace() {
        $definition = new EnumDefinition('Parent\\Class', 'SomeClass', EnumValueType::Int(), new EnumValue('OhNo', 1));
        $results = $this->subject->validate($definition);

        $this->assertFalse($results->isValid());

        $expected = ['The enum namespace must not have any PHP reserved words'];
        $actual = $results->getErrorMessages();

        $this->assertSame($expected, $actual);
    }

    public function testValidatorWithReservedWordInClass() {
        $definition = new EnumDefinition('ParentNamespace\\SubNamespace', 'Class', EnumValueType::Int(), new EnumValue('OhNo', 1));
        $results = $this->subject->validate($definition);

        $this->assertFalse($results->isValid());

        $expected = ['The enum class must not be a PHP reserved word'];
        $actual = $results->getErrorMessages();

        $this->assertSame($expected, $actual);
    }

}