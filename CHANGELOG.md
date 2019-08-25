# Changelog

## 1.2.0 2019-08-25

#### Changed

- Updated the `getSingleton` method to have a simpler method signature and avoid need to 
merge arrays together.

## 1.1.0 2019-08-23

#### Added

- A confirmation prompt has been added in cases where an enum is attempted to be written to a file 
that already exists.

## 1.0.1 2019-08-18

#### Fixed

- Adds a missing isValidType method that was inadvertently overwritten when a new enum was generated.

## 1.0.0 2019-08-18

#### Added

- Adds a `vendor/bin/yape` CLI command to generate enum code.
- An `EnumCodeGenerator` that will create PHP code from an `EnumDefiniition` that provides a namespace, 
class, and a set of EnumValue to be used as enum constant name and value.
- An `EnumDefinitionFactory` that will parse arguments from various sources to generate an enum definition.
Comes out-of-the-box with the ability to create an EnumDefinition from CLI arguments to the vendor/bin/yape 
command.
- An `EnumValueType` enum that lists the types that enum values may have.
- Adds an `EnumDefinitionValidator` that will make basic checks against an EnumDefinition to make assurances
that valid PHP code will be created.
- An `EnumValueSet` that ensures a distinct set of EnumValue are stored.
