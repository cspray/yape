<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 * Generates PHP code that represents an enum in a given domain for a given EnumDefinition.
 *
 *
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
final class EnumCodeGenerator {

    public function generateEnumCode(EnumDefinition $enumDefinition) : string {
        $function = function() {
            ob_start();
            include dirname(__DIR__) . '/resources/templates/enum.php';
            return ob_get_clean();
        };

        return '<?php declare(strict_types=1);' . PHP_EOL . PHP_EOL . $function->call($enumDefinition);
    }


}