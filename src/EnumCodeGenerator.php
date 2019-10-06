<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 *
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
interface EnumCodeGenerator {

    public function generate(EnumDefinition $enumDefinition) : string;

}