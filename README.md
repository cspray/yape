# YAPE - Yet Another PHP Enum

A PHP code generator that aims to create enums that operate similarly to the way enums operate in Java.

## Requirements

- PHP 7.2+

## Installation

```shell
composer require cspray/yape
```

### Features

- Enum values are type-safe objects backed by a scalar value.
- Enum classes provide a `static fromValue()` as well as a static method for each enum value name. A private constructor
enforces that this is the only way to create enum values.
- Enum values provide a `getValue` that returns the backing scalar value..
- Enum values provide a `toString` and `equals` method.

### Usage

Generating an enum with YAPE is as simple as executing a binary script and providing the fully qualified 
class name you'd like for your enum and the values for your enum. The script will ask where you'd like 
to store your enum; provide a directory within context of the current working directory.

```shell script
vendor/bin/yape YourNamespace\\YourVendor\\Compass North:north South:south East:east West:west
> Where would you like to create your new enum? (src)
> Your enum was successfully created!
```

After executing this shell script you have a Compass enum available to you! You can use it like 
the examples below:

```php
<?php

namespace YourNamespace\YourVendor;

$north = Compass::North();
$north instanceof Compass;  // true - Each enum value is an instance of the enum class
$north === Compass::North();  // true - the returned objects are singletons
$north->equals(Compass::South());  // false - the equals method is type-safe and hints against the Compass type
Compass::South()->getValue(); // 'south' - value provided after colon in CLI commanded, if not provided defaults to the name of the enum value
Compass::East()->toString(); // 'YourNamespace\\YourVendor\\Compass@East'
```

#### Code Generator Supported Types

We anticipate that all enum values will have at least 1 scalar value backing it, these values do not have 
to be unique and if a value is not provided for the enum value its name will be used. The CLI command 
will infer the type of value. All types discussed below are those returned from `getValue`

```php
vendor/bin/yape YourNamespace\\YourVendor\\ImplicitString One Two Three # results in string values 'One', 'Two', 'Three'
vendor/bin/yape YourNamespace\\YourVendor\\ExplicitString One:one Two:two Three:three # results in string values 'one', 'two', 'three'
vendor/bin/yape YourNamespace\\YourVendor\\ExplicitInteger One:1 Two:2 Three:3 # results in int values 1, 2, 3
vendor/bin/yape YourNamespace\\YourVendor\\ExplicitFloat One:1.0 Two:2.1 Three:3.2 # results in float values 1.0, 2.1, 3.2
vendor/bin/yape/ YourNamespace\\YourVendor\\ExplicitBool Yes:true No:false # results in bool values true and false
```

### Motivation

I have been using Java for more professional projects lately and have come to enjoy the way enums are 
handled in that language. The proper use of semantic enums increases the meaning and understanding of 
the codebase. I want similar benefits in my PHP project but PHP does not support a native enum concept.
I also did not want to have simple scalar values as constants and wanted to have the ability to have 
an enum object with multiple constructor dependencies, properties, and methods. Ultimately the desired 
functionality was not complex but is a fair amount of boilerplate to write. This project aims to make 
that boilerplate painless to generate and encourage the use of semantic, type-safe enums!