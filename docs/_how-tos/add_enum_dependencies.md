---
layout: article

title: Adding New Enum Dependencies
description: Sometimes your Enum may need to have multiple pieces of data associated with it. This guide details exactly how you can adjust the constructor dependencies that your Enum requires to provide additional pieces of data.
---
One of the advantages of object backed Enums is that you may have multiple pieces of data associated to them. The implementation
of the Enum was designed in such a way to make this a straight-forward, easy-to-implement process.

Expanding on the Compass enum from the [Creating an Enum Tutorial][create-enum-tutorial] we will adjust the
Compass to also provide the abbreviation for each direction. First, our original compass should look something like:

<div class="message is-info">
    <div class="message-body">
        It is also possible to implement the functionality detailed below by calculating the first character for each 
        enum's value. While this is a completely viable way to achieve the functionality this tutorial's aim is to ensure 
        you understand what is required when overriding constructor dependencies in scenarios where it is required.
    </div>
</div>

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
        return self::getSingleton(__FNCTION__);
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

For our example we'll implement the `'N'` abbreviation and leave the remaining three as an exercise left to
the reader.

#### Step 1 - Add the property for our piece of data

The first thing that we'll need to do is add a property that will store the new piece of data. This value **should be 
private** and only publicly accessible through a getter method.

```php
<?php

namespace YourNamespace\Enums;

use Cspray\Yape\Enum;
use Cspray\Yape\EnumTrait;

final class Compass implements Enum {

    use EnumTrait;

    private $abbreviation;

    // ... rest of the class

}
```

#### Step 2 - Override private constructor</h4>

The default constructor is provided by the `EnumTrait` and we'll want to override this to provide the additional 
abbreviation dependency. Keep in mind that the first dependency of an Enum `MUST` be its `toString` representation. 
This constructor `SHOULD` be private as we only want Enums to be generated through the static methods defined on the class.

```php
<?php

namespace YourNamespace\Enums;

use Cspray\Yape\Enum;
use Cspray\Yape\EnumTrait;

final class Compass implements Enum {

    use EnumTrait;

    private $abbreviation;

    private function __construct(string $name, string $abbreviation) {

    }

    // ... rest of the class

}
```

#### Step 3 - Set appropriate data in constructor

After we've created the constructor next we need to make sure the appropriate data is set on the enum properties. For
the `$name` we should ensure to call `setEnumValue()` which is provided by `EnumTrait`. The `$abbreviation` should be 
set to the property we added in step 1.

```php
<?php

namespace YourNamespace\Enums;

use Cspray\Yape\Enum;
use Cspray\Yape\EnumTrait;

final class Compass implements Enum {

    use EnumTrait;

    private $abbreviation;

    private function __construct(string $name, string $abbreviation) {
        $this->setEnumValue($name);
        $this->abbreviation = $abbreviation;
    }

    // ... rest of the class

}
```

<div class="message is-info">
  <div class="message-body">
    It is critical that you call `setEnumValue` if you override the constructor provided by `EnumTrait`. If this method 
    is not called your Enum is likely to not function correctly in all scenarios. Specifically the `toString` method 
    will fail and there will likely be other unintended consequences.
  </div>
</div>

#### Step 4 - Add getter method for new property

Though we may want to have the data be only available to enum implementation chances are we'll want to expose it through
some method. In our case we'll implement a simple <code>getAbbreviation</code> method that returns our abbreviation.

```php
<?php

namespace YourNamespace\Enums;

use Cspray\Yape\Enum;
use Cspray\Yape\EnumTrait;

final class Compass implements Enum {

    use EnumTrait;

    private $abbreviation;

    private function __construct(string $name, string $abbreviation) {
        $this->setEnumValue($name);
        $this->abbreviation = $abbreviation;
    }

    // ... rest of the class

    public function getAbbreviation() : string {
        return $this->abbreviation;
    }

}
```

#### Step 5 - Add new data to static method constructors

Each static method's call to `self::getSingleton()` will need to be adjusted to include the new dependency that we added 
to the constructor. Whatever arguments are passed to this method will be used as the arguments for the call to the constructor.

```php
<?php

namespace YourNamespace\Enums;

use Cspray\Yape\Enum;
use Cspray\Yape\EnumTrait;

final class Compass implements Enum {

    use EnumTrait;

    private $abbreviation;

    private function __construct(string $name, string $abbreviation) {
        $this->setEnumValue($name);
        $this->abbreviation = $abbreviation;
    }

    public static function North() : self {
        return self::getSingleton(__FUNCTION__, 'N');
    }

    // ... rest of the class

    public function getAbbreviation() : string {
        return $this->abbreviation;
    }

}
```

Now our Enum has multiple data points associated to it and we can now call a new method on our Compass instances to
retrieve this data point. An Enum can have as many constructor dependencies as is required for your use case.

[create-enum-tutorial]: {{site.baseurl}}/tutorials/create-enum