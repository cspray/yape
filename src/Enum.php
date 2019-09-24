<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 * A marker interface that identifies a class as one that is intended to serve as an Enum.
 *
 * If you use the provided code generator and specify a value that is an enum it MUST implement this interface. Any
 * yape-generated enum will implement this interface. If you build your own enums from scratch using the provided traits
 * it is not necessary to implement this interface.
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
interface Enum {

    static public function values() : array;

    static public function valueOf(string $enumName);

    public function equals($compare) : bool;

    public function toString() : string;
}