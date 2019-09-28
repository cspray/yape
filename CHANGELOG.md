# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog] and this project adheres to [Semantic Versioning]

## 2.0.0-rc2 - 2019-09-28

#### Fixed

- Fixes an error in the `bin/yape` command where we were not handling autoload correctly when using from a 
Composer installation.
- Fixes a PHP error from being triggered if the output directory specified does not exist.

#### Removed

- Removed the unused `$value` property from generated enums.

## 2.0.0-rc1 - 2019-09-28

#### Added

- Adds a Symfony Console command for creating an enum.
- Adds a `values` static method that allows retrieving all of the values available on the enum.
- Adds a `valueOf` static method that allows retrieving an enum object from its `getName` return value.

#### Changed

- Removes type parameter on `equals`. The type parameter on this method was overly burdensome when attempting 
to compare a value to the enum in which you many not know if it is a valid object type. There is nothing 
especially gained by being this restrictive and equals comparisons can happen against all types.

#### Removed

- Removes the default `getValue` implementation. The way that a value was tied to the enum was not especially 
intuitive, led to too-verbose code, and was not particularly useful in practice. If a scalar value is needed 
for the enum it should be provided post code-generation and be given a semantic method name.

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

[Keep a Changelog]: https://keepachangelog.com/en/1.0.0/
[Semantic Versioning]: https://semver.org/spec/v2.0.0.html