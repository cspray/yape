<?php declare(strict_types=1);

namespace Cspray\Yape\Exception;

use Cspray\Yape\Internal\DbalTypeDefinition;
use Cspray\Yape\Internal\ValidationResults;

/**
 *
 * @package Cspray\Yape\Exception
 * @license See LICENSE in source root
 */
class DbalTypeValidationException extends ValidationException {

    private $definition;

    public function __construct(DbalTypeDefinition $definition, ValidationResults $results) {
        parent::__construct('An error was encountered validating that a DbalTypeDefinition would result in valid PHP code.', 0, null);
        $this->definition = $definition;
        $this->setValidationResults($results);
    }

    public function getDbalTypeDefinition() : DbalTypeDefinition {
        return $this->definition;
    }

}