<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 * Defines what a generated Enum should look like.
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
class EnumDefinition {

    private $namespace;
    private $enumName;
    private $enumValueType;
    private $enumValues;

    public function __construct(string $namespace, string $enumName, EnumValueType $enumValueType, EnumValue ...$enumValues) {
        $this->namespace = $namespace;
        $this->enumName = $enumName;
        $this->enumValueType = $enumValueType;
        $this->enumValues = new EnumValueSet($enumValueType, ...$enumValues);
    }

    /**
     * The namespace the enum will live under.
     *
     * This is currently a REQUIRED field and if no namespace is provided then syntactically incorrect PHP code will
     * be generated. There is not currently any plan to make this optional as it is strongly encouraged to have all
     * objects in your application properly namespaced.
     *
     * @return string
     */
    public function getNamespace() : string {
        return $this->namespace;
    }

    /**
     * The name of the enum class.
     *
     * @return string
     */
    public function getEnumName() : string {
        return $this->enumName;
    }

    /**
     * The type that each EnumValue is expected to adhere to.
     *
     * @return EnumValueType
     */
    public function getValueType() : EnumValueType {
        return $this->enumValueType;
    }

    /**
     * A set of unique EnumValues; each EnumValue represents a name (or static method call) as well as an underlying
     * scalar or Enum value that is associated with the enum.
     *
     * EnumValue uniqueness extends to both the name of the EnumValue as well as the value itself. An enum MUST NOT have
     * duplicate EnumValue or the generated PHP code will not work as expected.
     *
     * @return EnumValueSet
     */
    public function getEnumValues() : EnumValueSet {
        return $this->enumValues;
    }

}