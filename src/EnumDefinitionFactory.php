<?php declare(strict_types=1);

namespace Cspray\Yape;

/**
 * Creates an EnumDefinition from provided user input.
 *
 * @package Cspray\Yape
 * @license See LICENSE in source root
 */
final class EnumDefinitionFactory {

    /**
     * Create an EnumDefinition based off of arguments passed to a PHP shell script.
     *
     * The format of the CLI command expected is as follows:
     *
     * ./bin/<shell-script> YourNamespace\\YourVendor\\Compass North:north South:south East:east West:west
     *
     * The first argument to the shell script is the fully qualified class name for the enum. It is not necessary to
     * split the namespace and class up for the EnumDefinition, this implementation will take care of that.
     *
     * The arguments can have 1..n and are a series of EnumValue name:value pairs. The name is the static method that
     * will be generated and anything after the `:` is the value associated with the enum. If you do not explicitly
     * provide a value the name of the EnumValue will be used as its value as well.
     *
     * *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
     *
     * You MUST pass the $argv array from the PHP shell script unmodified. If you shift the filename off of the array
     * before passing it to this method your EnumDefinition will be invalid and either result in an exception when
     * validation is run or the generated PHP code will not be what was intended.
     *
     * You MUST provide a fully qualified enum name and AT LEAST ONE enum value. If you do not provide either of these
     * pieces of information an exception will be thrown.
     *
     * @param array $argv
     * @return EnumDefinition
     */
    public function fromCliArgs(array $argv) : EnumDefinition {
        array_shift($argv);


        if (count($argv) <= 1) {
            throw new \InvalidArgumentException("You must provide at least a fully qualified enum name and 1 value");
        }

        $namespace = array_shift($argv);
        $classFragments = explode('\\', $namespace);
        $class = array_pop($classFragments);
        $namespace = implode('\\', $classFragments);
        $enumValueType = EnumValueType::String();
        $enumValues = array_map(function($enumName) use(&$enumValueType, $argv) {
            $nameValue = explode(':', $enumName);
            if (count($nameValue) === 1) {
                return new EnumValue($enumName, $enumName);
            } else {
                $value = $nameValue[1];
                if (is_numeric($value)) {
                    if (strpos($value, '.') === false) {
                        $enumValueType = EnumValueType::Int();
                        $value = (int) $value;
                    } else {
                        $enumValueType = EnumValueType::Float();
                        $value = (float) $value;
                    }
                } else if ($value === 'true' || $value === 'false') {
                    $enumValueType = EnumValueType::Bool();
                    $value = $value === 'true' ? true : false;
                }
                return new EnumValue($nameValue[0], $value);
            }
        }, $argv);


        return new EnumDefinition($namespace, $class, $enumValueType, ...$enumValues);
    }

}