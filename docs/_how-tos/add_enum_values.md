---
layout: article

title: Adding New Enum Values
description: As business needs change so must your code. It is expected that you will need to add or modify Enum Values over time, this guide goes over the quick 2-step process to ensure new values are added correctly.
---
It is expected that enum values could change over time. Given enough enum usage over time you will almost undoubtedly
need to adjust the values post code generation. Fortunately this is an easy, straight-forward process but does require
some specific implementation which we'll go over.

Expanding on the Compass enum from [the Creating an Enum Tutorial][create-enum-tutorial] we will adjust the
Compass to allow 8-sides; NorthWest, NorthEast, etc. First our original compass should look something like:

```php
<?php

namespace YourNamespace\Enums;

use Cspray\Yape\Enum;
use Cspray\Yape\EnumTrait;

final class Compass implements Enum {

    use EnumTrait;

    public static function North() : self {
        return self::getSingleton(__FUNCTION__);
    }

    public static function South() : self {
        return self::getSingleton(__FUNCTION__);
    }

    public static function East() : self {
        return self::getSingleton(__FUNCTION__);
    }

    public static function West() : self {
        return self::getSingleton(__FUNCTION__);
    }

    protected static function getAllowedValues() : array {
        return [
            'North', 
            'South', 
            'East', 
            'West'
        ];
    }

}
```

For our example we'll implement the `NorthEast` value and leave the remaining three as an exercise left to the reader.

#### Step 1 - Add the public static method constructor
Enums have a private constructor and can only be constructed through their public static methods. First let's add the
appropriate method to generate the `NorthEast` value.

```php
<?php

namespace YourNamespace\Enums;

use Cspray\Yape\Enum;

final class Compass implements Enum {

    // ... all of the code listed above

    public static function NorthEast() : self {
        return self::getSingleton(__FUNCTION__);
    }
}
```

<div class="message is-info">
  <div class="message-body">
    It is important that you call <code>self::getSingleton()</code> to ensure that the same object is returned each time 
    this method is called. This is an important aspect of how yape works and if you do not return an instance created 
    through this method your Enum is likely to not function correctly in all scenarios.
  </div>
</div>

#### Step #2 - Adjust the list of allowed values

For many of the methods provided by the EnumTrait we need to know what the allowed values of your Enum could be. While it
may be possible to reflectively determine this there would not be a straight-forward way in which to do so. Instead, 
**each enum MUST provide the string values that it respects**. These values should match the static methods that were generated
or were added in step 1 of this guide.

```php
<?php

namespace YourNamespace\Enums;

use Cspray\Yape\Enum;
use Cspray\Yape\EnumTrait;

final class Compass implements Enum {

    // ... all of the previous methods

    public static function NorthEast() : self {
        return self::getSingleton(__FUNCTION__);
    }

    protected static function getAllowedValues() : array {
        return [
            'North', 
            'South', 
            'East', 
            'West', 
            'NorthEast'
        ];
    }

}
```

At this point you're finished adding the new value to your Enum!

[create-enum-tutorial]: {{site.baseurl}}/tutorials/create-enum
