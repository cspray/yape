# YAPE - Yet Another PHP Enum

YAPE is a PHP 7+ code generator designed to provide a type-safe, object-backed enum implementation. While there are many 
existing PHP enum implementations they almost all boil back to some scalar value in a constant and this isn't the type 
of enum provided by YAPE. The API for generated enums is inspired by Java and if you have worked with Java enums the 
objects provided by YAPE will feel familiar, if slightly more verbose in their implementation.

## Requirements

- PHP 7.2+

## Installation

```shell
composer require cspray/yape
```

### Features

- Enums are type-safe, singleton objects.
- Enums implement the `Cspray\Yape\Enum` interface and are final.
- Intended to loosely mimic Java enums.

### Documentation

The library is documented at http://yape.cspray.io, within the source code itself, and within the console tool by using 
the `--help` flag.

### Motivation

I have been fascinated with type-safe enums in PHP for quite some time. This is actually my _third_ attempt at creating 
a type-safe enum library; [Setty]\(v1) and [Enumable]\(v2) were my previous attempts/failures. Both projects were subpar, 
required too much boilerplate, or were simply not really the implementation that I was looking for. I happened to implement 
the general idea of the current library in a separate project and realized that with some proper thought and a little bit 
of code generation the viability of a type-safe enum may actually be possible. This is my latest, and likely last, at 
creating a type-safe enum in PHP that emulates, as much as is feasible or makes sense, the way enums work within Java.

Ultimately, I believe that the semantic use of types is an important tool in creating maintainable applications and the 
enum construct is a useful tool within that context. I encourage you to use type-safe, semantic enums in your own code 
and to try out YAPE if you choose to do so.

[Enumable]: https://github.com/cspray/enumable
[Setty]: https://github.com/cspray/setty