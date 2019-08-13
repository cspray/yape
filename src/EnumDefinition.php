<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
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

    public function getNamespace() : string {
        return $this->namespace;
    }

    public function getEnumName() : string {
        return $this->enumName;
    }

    public function getEnumValues() : array {
        return $this->enumValues;
    }

}