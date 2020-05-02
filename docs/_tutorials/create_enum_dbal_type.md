---
layout: article
title: Creating an Enum DBAL Type

description: It is expected that you'll want to persist your enum to some storage solution. We provide support for creating Doctrine DBAL Types out-of-the-box and this will teach you how to use this functionality.
---
{% include labrador_cli_notice.html %}

It is anticipated that a common use case for an Enum is to be used as a property on an entity or model that needs to
be persisted to a database or some other data storage. To facilitate this YAPE provides a code generator to create a
[Doctrine DBAL Type]. Generating a DBAL Type is simple and just requires executing a CLI command and providing 
**the fully-qualified class name for the Type**, **the fully-qualified class name for the Enum**, and **the name of the 
DBAL Type**. Please note that the Enum _must_ already exist or an error will be thrown. If we were to create a DBAL Type 
for the four-sided compass [from creating an Enum tutorial][enum-tutorial] we'd execute a command similar to:

```shell
vendor/bin/yape create-enum-dbal-type YourNamespace\\Doctrine\\CompassType YourNamespace\\Enums\\Compass compass
```  

If your DBAL Type was successfully created the path that it was stored in will be output otherwise an error message will
be displayed indicating why your code could not be generated. By default the DBAL Type will be stored in `./src/Doctrine`
but if this does not work for you the `--output-dir|-o` option allows you to change the directory, _under the current 
working directory_, that the code should be stored in.

After code generation you should ensure that your Doctrine configuration has been updated to include the mapping for your
new custom Type. The exact steps necessary will be dependent upon how you configure Doctrine and are outside the scope
of this document. The [custom mapping section of DBAL Types][custom-mapping-types] or framework-specific integration 
documentation should provide the appropriate information.

[Doctrine DBAL Type]: https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/types.html#types
[enum-tutorial]: {{site.baseurl}}/tutorials/create-enum
[custom-mapping-types]: https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/types.html#custom-mapping-types