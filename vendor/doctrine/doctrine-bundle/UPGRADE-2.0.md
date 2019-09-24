UPGRADE FROM 1.x to 2.0
=======================

PHP and Symfony version support
-------------------------------

 * Support for PHP 5.5, 5.6 and 7.0 was dropped
 * Support for unsupported Symfony versions was dropped. The bundle now supports
   Symfony 3.4 LTS and 4.1 or newer.
 * Support for Twig 1.34 and below as well as 2.4 and below (for 2.x) releases
   was dropped.

Commands
--------

 * `Doctrine\Bundle\DoctrineBundle\Command` requires a `ManagerRegistry`
   instance when instantiating.
 * Dropped `setContainer` and `getContainer` in
   `Doctrine\Bundle\DoctrineBundle\Command`.
 * `Doctrine\Bundle\DoctrineBundle\Command` no longer implements
   `ContainerAwareInterface`.

Mapping
-------

 * Dropped `ContainerAwareEntityListenerResolver`, use
   `ContainerEntityListenerResolver` instead.

Types
-----

 * Marking types as commented in the configuration is no longer supported.
   Instead, mark them commented using the `requiresSQLCommentHint()` method of
   the type.
 * The `commented` configuration option for types will be dropped in a future
   release. You should not use it.
