# YAPE - Yet Another PHP Enum

A PHP code generator that aims to create enums that operate similarly to the way enums operate in Java.

## Requirements

- PHP 7.2+

## Installation

```shell
composer require cspray/yape
```

### Features

- Enums are type-safe objects which may, or may not, have 1 or more scalar values associated to it.
- Enums implement an interface and are final.
- Intended to mimic Java enums.

### Documentation

_Docs to come_

### Motivation

I have been using Java for more professional projects lately and have come to enjoy the way enums are 
handled in that language. The proper use of semantic enums increases the meaning and understanding of 
the codebase. I want similar benefits in my PHP project but PHP does not support a native enum concept.
I also did not want to have simple scalar values as constants and wanted to have the ability to have 
an enum object with multiple constructor dependencies, properties, and methods. Ultimately the desired 
functionality was not complex but is a fair amount of boilerplate to write. This project aims to make 
that boilerplate painless to generate and encourage the use of semantic, type-safe enums!