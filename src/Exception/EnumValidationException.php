<?php declare(strict_types=1);

namespace Cspray\Yape\Exception;

use Cspray\Yape\Internal\EnumDefinition;
use Cspray\Yape\Internal\ValidationResults;

/**
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
class EnumValidationException extends ValidationException {

    private $enumDefinition;

    public function __construct(EnumDefinition $enumDefinition, ValidationResults $results) {
        parent::__construct('An error was encountered validating that an EnumDefinition would result in valid PHP code.', 0, null);
        $this->enumDefinition = $enumDefinition;
        $this->setValidationResults($results);
    }

    public function getEnumDefinition() : EnumDefinition {
        return $this->enumDefinition;
    }

}