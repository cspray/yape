<?php declare(strict_types=1);

namespace Cspray\Yape\Exception;

use Cspray\Yape\Internal\ValidationResults;
use Throwable;

/**
 *
 * @package Cspray\Yape\Exception
 * @license See LICENSE in source root
 */
abstract class ValidationException extends Exception {

    private $validationResults;

    protected function setValidationResults(ValidationResults $validationResults) {
        $this->validationResults = $validationResults;
    }

    final public function getValidationResults() : ValidationResults {
        return $this->validationResults;
    }

}