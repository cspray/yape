# Contributing to YAPE

First, I would like to thank you for taking the time to consider contributing to this project! I appreciate you looking 
at and using the code I have developed. To ensure that your constributes are accepted I recommend you follow the below 
guidelines.

## Open an RFC

If you're going to modify or add to the code in some important way you should open a GitHub Issue and label it with 'rfc' 
or simply open a Pull Request. If the change is substantial and is likely to require community consensus we recommend you 
open an Issue and describe the changes before major developments. This way you're less likely to put an investment into 
something that may not be accepted. If the change is small or is an obvious bug fix please feel free to simply submit a 
Pull Request directly

## Everything is tested

While I do not require a strict 100% code coverage it is important that all new features and bugs are well tested. If 
you're worried about testing asynchronous code we provide the amphp/phpunit-util library for development which greatly 
facilitates writing asynchronous tests. We recommend that you use this library when developing your own applications as 
well. Generally speaking a PR will not be accepted until it has good tests written for it.

## Keep it in Scope

This library is intended to provide a type-safe enum emulating a Java enum and to encourage the use of type-safe enums 
in PHP projects. Generally speaking the API of the enum itself is in place and future development on the project should 
include more robust code generators or 3rd-party integration that would encourage the use of enums in existing codebases.
If your PR changes the public API of the enum you should open up a PR to discuss whether the change is in scope of this 
library.