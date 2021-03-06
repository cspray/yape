# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog] and this project adheres to [Semantic Versioning]. The changes in this file 
include those that may be part of the user-facing API as well as the developer-facing API. For example, changes to the 
Enum interface or CLI commands impact the user of this library while changes to the components under the `Cspray\Yape\Internal` 
namespace are intended for developers and maintainers working on YAPE itself.

## 3.0.0 - 2020-05-02

This update is largely modularizing the codebase so that you can have installed on your production deployments only the
code that is necessary. After upgrading you will need to add `cspray/yape-cli` and/or `cspray/yape-dbal`. 

#### Removed

- Removed the requirement to have Symfony Console installed and moved all CLI tools to its own package: cspray/yape-cli.
- Removed the AbstractEnumType and move it to its own package: cspray/yape-dbal.

#### Changed

- Updated documentation to reflect changes in project structure.

## 2.1.0 - 2019-10-25

This version represents some significant refactoring for how YAPE works internally. However, this did not alter the 
public API available through the Symfony console in a breaking manner nor did it alter the enum code that was generated. 
If you were reliant on the internal API, which is not supported and you should not rely on, there may be breaking changes 
with this release.

#### Added

- Adds a `create-enum-dbal-type` that will generate a Doctrine Type that allows an Enum to be persisted to a database 
using Doctrine. This includes all of the necessary validators, definitions, factories, and code generators to support 
this functionality.
- Adds a `ClassSignatureDefinition` that encapsulates the concept of a fully-qualified class name having a distinct 
namespace and class.
- Adds `EnumDefinition::getEnumClass` that returns a `ClassSignatureDefinition` representing the FQCN for the enum.
- Adds an `AbstractValidator` that can facilitate validating common aspects of both enum and DBAL Type classes.
- Adds a `AbstractEnumType` that extends from `Doctrine\DBAL\Types\Type` and holds the primary logic for converting 
an enum into a database value and vice versa. Only the name of the Doctrine Type as well as the FQCN for the Enum 
supported are required.

#### Changed

- Introduces an `Internal` namespace and moves all code that is not expected to be used by internal apps into this namespace.
- Changes the `ValidationResults` constructor to no longer require an explicit boolean for whether or not the results are
valid. This is now determined at construction time by whether or not there are error messages present.

#### Removed

- Removes the `EnumDefinition::getNamespace` and `EnumDefinition::getEnumName` in favor of the new `EnumDefinition::getEnumClass`.

## 2.0.0 - 2019-10-05

#### Changed

- Moved the implementation of the default constructor and toString implementations to EnumTrait allowing generated 
enums to have only the static constructor methods, a list of defined values, and whatver other custom functionality is 
required by the enum.

#### Added

- Adds appropriate governance documents for code of conduct, contributing to the project, and the discovery of security vulnerabilities.

## 2.0.0-rc3 - 2019-10-05

#### Changed

- Changed the return value of the `toString` method from an arbitrary string with the enum class name and 
the enum value to simply returning the enum value. In the example `YourNamespace\\Enums\\Compass@North` would 
now simply return 'North'.
- Instead of having each enum generate its own set of boilerplate much of the generically shared code has 
been moved to a trait to facilitate building your own enums without the code generator and making enums 
generally less "noisy".

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
