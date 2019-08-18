<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 * An EnumDefinition validator that ensures an EnumDefinition will result in valid PHP code as well as semantically
 * correct enum.
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
final class EnumDefinitionValidator {

    /**
     * All of the possible reserved words in PHP that cannot be used as either namespace or class names.
     */
    private const RESERVED_WORDS = [
        'self',
        'static',
        'parent',
        '__halt_compiler',
        'abstract',
        'and',
        'array',
        'as',
        'break',
        'callable',
        'case',
        'catch',
        'class',
        'clone',
        'const',
        'continue',
        'declare',
        'default',
        'die',
        'do',
        'echo',
        'else',
        'elseif',
        'empty',
        'enddeclare',
        'endfor',
        'endforeach',
        'endif',
        'endswitch',
        'endwhile',
        'eval',
        'exit',
        'extends',
        'final',
        'finally',
        'for',
        'foreach',
        'function',
        'global',
        'goto',
        'if',
        'implements',
        'include',
        'include_once',
        'instanceof',
        'insteadof',
        'interface',
        'isset',
        'list',
        'namespace',
        'new',
        'or',
        'print',
        'private',
        'protected',
        'public',
        'require',
        'require_once',
        'return',
        'switch',
        'throw',
        'trait',
        'try',
        'unset',
        'use',
        'var',
        'while',
        'xor',
        'yield',
        'yield from',
        '__CLASS__',
        '__DIR__',
        '__FILE__',
        '__FUNCTION__',
        '__LINE__',
        '__METHOD__',
        '__NAMESPACE__',
        '__TRAIT__'
    ];

    /**
     * Runs a specific set of validations on an EnumDefinition and will return whether or not it is valid as well as
     * specific error messages for why the EnumDefinition is invalid.
     *
     * Validations that are ran:
     *
     * 1. There MUST be a non-empty namespace value present that adheres to a regex for valid PHP namespaces.
     * 2. Each namespace section MUST NOT be a reserved word.
     * 3. There MUST be a non-empty class value present that adheres to a regex for valid PHP classes.
     * 4. The class MUST NOT be a reserved word
     * 5. There MUST be at least one EnumValue in the EnumValueSet
     *
     * We do not anticipate an EnumValueSet being constructed properly if members of that set are invalid with regards
     * to the data structure; i.e. if you construct an EnumValueSet and add duplicate members or a member with the
     * incorrect data type for its value that will result in an exception and the EnumDefinition for that EnumValueSet
     * will never be passed to this method.
     *
     * @param EnumDefinition $enumDefinition
     * @return ValidationResults
     */
    public function validate(EnumDefinition $enumDefinition) : ValidationResults {
        $errorMessages = [];
        $phpLabelRegex = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/';

        $namespaceParts = explode('\\', $enumDefinition->getNamespace());
        foreach ($namespaceParts as $namespacePart) {
            if (in_array(strtolower($namespacePart), self::RESERVED_WORDS)) {
                $errorMessages[] = 'The enum namespace must not have any PHP reserved words';
                break;
            }

            if (!preg_match($phpLabelRegex, $namespacePart)) {
                $errorMessages[] = 'The enum namespace must have only valid PHP namespace characters';
                break;
            }
        }

        if (in_array(strtolower($enumDefinition->getEnumName()), self::RESERVED_WORDS)) {
            $errorMessages[] = 'The enum class must not be a PHP reserved word';
        } else if (!preg_match($phpLabelRegex, $enumDefinition->getEnumName())) {
            $errorMessages[] = 'The enum class must have only valid PHP class characters';
        }

        if (count($enumDefinition->getEnumValues()) === 0) {
            $errorMessages[] = 'There must be at least one enum value';
        }

        foreach ($enumDefinition->getEnumValues() as $enumValue) {
            if (!preg_match($phpLabelRegex, $enumValue->getName())) {
                $errorMessages[] = 'All EnumValue names must have only valid PHP class method characters';
            }
        }

        return new ValidationResults(empty($errorMessages), ...$errorMessages);
    }

}