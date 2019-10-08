<?php declare(strict_types=1);

namespace Cspray\Yape\Internal;

/**
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
interface DbalTypeCodeGenerator {

    public function generate(DbalTypeDefinition $dbalTypeDefinition) : string;

}