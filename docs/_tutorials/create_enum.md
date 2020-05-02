---
layout: article
title: Creating an Enum

description: Teaches you how to create an Enum and the things that you can do with it afterwards. If you're new to the library or need a brush up on how to use the CLI command to generate Enums this is the place for you.
---
{% include labrador_cli_notice.html %}

The bread &amp; butter of yape, this command generates an enum for you. Using it is as simple as providing a **fully 
qualified class name** and a **set of enum values**. We'll take a look at creating a classic example of an enum, the 
four-sided compass. We simply need to execute the appropriate CLI command from the directory in which we installed 
yape:

```shell
vendor/bin/yape create-enum YourNamespace\\Enums\\Compass North South East West
```

If your enum was successfully created the path that it was stored in will be output otherwise an error message will
be displayed indicating why your code could not be generated. By default the enum will be stored in `./src/Enums`
but if this does not work for you the `--output-dir|-o` option allows you to change the directory, _under the current w
orking directory_, that the code should be stored in.

Upon successful generation your code will allow for the following code to be executed:

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use YourNamespace\Enums\Compass;

$north = Compass::North();
$south = Compass::South();
$east = Compass::East();
$west = Compass::West();

$values = Compass::values(); // [$north, $south, $east, $west]

$n = Compass::valueOf('North');
$north->equals(Compass::North());  // true
$north->equals($n); // true
$north->equals($south); // false
$north->equals('North'); // false
$north->toString(); // 'North'
```