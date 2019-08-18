<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
class EnumValidationException extends \RuntimeException {

    private $enumDefinition;
    private $validationResults;

    public function __construct(EnumDefinition $enumDefinition, ValidationResults $results) {
        parent::__construct('An error was encountered validating that an EnumDefinition would result in valid PHP code.', 0, null);
        $this->enumDefinition = $enumDefinition;
        $this->validationResults = $results;
    }

    public function getEnumDefinition() : EnumDefinition {
        return $this->enumDefinition;
    }

    public function getValidationResults() : ValidationResults {
        return $this->validationResults;
    }

}