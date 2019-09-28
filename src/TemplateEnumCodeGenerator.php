<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 * Generates PHP code that represents an enum for a given EnumDefinition.
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 * @see resources/templates/enum.php
 * @codeCoverageIgnore We are ignoring code coverage because our test utilizes this class in the setupBeforeClass
 *                     and coverage is not counted. However, the very nature of testing out the enum proves that this
 *                     class functions correctly.
 */
final class TemplateEnumCodeGenerator implements EnumCodeGenerator {

    /**
     * Generate PHP code that can be saved to a file.
     *
     * The returned source code WILL include the opening <?php tag making this unsuitable for eval use. If you are
     * eval'ing your enums at runtime (which you shouldn't) you will need to take an extra step to remove the opening
     * tag. However you should generate your enums ahead of time and allow them to be proper first-class members of your
     * application.
     *
     * @param EnumDefinition $enumDefinition
     * @return string
     */
    public function generate(EnumDefinition $enumDefinition) : string {
        // this is its own anonymous function instead of doing this inline so that the template only has the
        // variables as defined by the EnumDefinition.
        $function = function() {
            ob_start();
            include dirname(__DIR__) . '/resources/templates/enum.php';
            return ob_get_clean();
        };

        return '<?php declare(strict_types=1);' . PHP_EOL . PHP_EOL . $function->call($enumDefinition);
    }

}