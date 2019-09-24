The Symfony MakerBundle
=======================

The MakerBundle is the fastest way to generate the most common code you'll
need in a Symfony app: commands, controllers, form classes, event subscribers
and more! This bundle is an alternative to [SensioGeneratorBundle][1] for modern
Symfony applications and requires Symfony 3.4 or newer and [Symfony Flex][2].

[Read the documentation][3]

Backwards Compatibility Promise
-------------------------------

This bundle shares the [backwards compatibility promise][4] from
Symfony. But, with a few clarifications.

A) The input arguments or options to a command *may* change between
   minor releases. If you're using the commands in an automated,
   scripted way, be aware of this.

B) The generated code itself may change between minor releases. This
   will allow us to continuously improve the generated code!

[1]: https://github.com/sensiolabs/SensioGeneratorBundle
[2]: https://symfony.com/doc/current/setup/flex.html
[3]: https://symfony.com/doc/current/bundles/SymfonyMakerBundle/index.html
[4]: https://symfony.com/doc/current/contributing/code/bc.html
