<?php declare(strict_types=1);

namespace Cspray\Yape;

use Cspray\Yape\Exception\EnumValidationException;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Creates an EnumDefinition from provided user input.
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
final class EnumDefinitionFactory {

    private $enumDefinitionValidator;

    public function __construct() {
        $this->enumDefinitionValidator = new EnumDefinitionValidator();
    }

    /**
     * Create an EnumDefinition based off of arguments passed to the bin/yape console app.
     *
     * @param InputInterface $input
     * @return EnumDefinition
     */
    public function fromConsole(InputInterface $input) : EnumDefinition {
        $enumDefinition = $this->createEnumDefinition($input);
        $results = $this->enumDefinitionValidator->validate($enumDefinition);
        if (!$results->isValid()) {
            throw new EnumValidationException($enumDefinition, $results);
        }
        return $enumDefinition;
    }

    private function createEnumDefinition(InputInterface $input) : EnumDefinition {
        $fqcn = $input->getArgument('enumClass');
        $segments = explode('\\', $fqcn);
        $class = array_pop($segments);
        $namespace = implode('\\', $segments);

        $enumValues = $input->getArgument('enumValues');

        return new EnumDefinition($namespace, $class, ...$enumValues);
    }

}