<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
final class ValidationResults {

    private $isValid;
    private $errorMessages;

    public function __construct(bool $isValid, string ...$errorMessages) {
        $this->isValid = $isValid;
        $this->errorMessages = $errorMessages;
    }

    public function isValid() : bool {
        return $this->isValid;
    }

    public function getErrorMessages() : array {
        return $this->errorMessages;
    }

}