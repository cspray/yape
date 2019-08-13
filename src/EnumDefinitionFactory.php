<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
class EnumDefinitionFactory {

    public function fromCliArgs(array $argv) : EnumDefinition {
        array_shift($argv);

        if (count($argv) <= 1) {
            echo "You must provide at least a fully qualified enum name and 1 value";
            exit(255);
        }

        $namespace = array_shift($argv);
        $classFragments = explode('\\', $namespace);
        $class = array_pop($classFragments);
        $namespace = implode('\\', $classFragments);
        $enumValues = $argv;

        return new EnumDefinition($namespace, $class, ...$enumValues);
    }

}