<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
trait HasSingletonContainer {

    private static $container = [];

    protected static function getSingleton($value) {
        if (!isset(self::$container[$value])) {
            self::$container[$value] = new self($value);
        }

        return self::$container[$value];
    }


}