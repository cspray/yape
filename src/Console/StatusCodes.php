<?php declare(strict_types=1);

namespace Cspray\Yape\Console;

/**
 *
 * @package Cspray\Yape\Console
 * @license See LICENSE in source root
 */
class StatusCodes {

    const OK = 0;

    // Errors related to a problem with the Enum itself.
    const ENUM_INVALID_ERROR = 255;
    const ENUM_EXISTS_ERROR = 254;

    // Errors related to invalid input commands or filesystem errors
    const INPUT_OPTIONS_CONFLICT_ERROR = 155;

}