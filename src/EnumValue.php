<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 * Represents a method and value for a generated enum defined by an EnumDefinition.
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 * @see EnumDefinition
 */
class EnumValue {

    private $name;
    private $value;

    public function __construct(string $name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * The name of the enum value that will also serve as the name of the static method on the Enum.
     *
     * This value MUST be a valid PHP method name. The preferred convention is to return a PascalCased string.
     *
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * Return the backing value, this may be any scalar value OR an Enum type.
     *
     * @return string|int|bool|float|Enum
     */
    public function getValue() {
        return $this->value;
    }

}