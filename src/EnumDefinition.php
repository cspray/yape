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
    private $enumValues;

    public function __construct(string $namespace, string $enumName, string ...$enumValues) {
        $this->namespace = $namespace;
        $this->enumName = $enumName;
        $this->enumValues = $enumValues;
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
     * A list of strings that correspond to the values, and static constructor methods, for the given enum.
     *
     * @return string[]
     */
    public function getEnumValues() : array {
        return $this->enumValues;
    }

}