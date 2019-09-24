Introduction
============

The Doctrine Reflection project is a simple library used by the various Doctrine projects which adds some additional
functionality on top of the reflection functionality that comes with PHP. It allows you to get the reflection information
about classes, methods and properties statically.

Installation
============

The library can easily be installed with composer.

.. code-block:: sh

    $ composer require doctrine/reflection

Setup
=====

.. code-block:: php

    use Doctrine\Common\Reflection\Psr0FindFile;
    use Doctrine\Common\Reflection\StaticReflectionParser;
    use App\Model\User;

    $finder = new Psr0FindFile(['App' => [
        '/path/to/project/src/App'
    ]]);

    $staticReflectionParser = new StaticReflectionParser(User::class, $finder);

Usage
=====

.. code-block:: php

    echo $staticReflectionParser->getClassName();
    echo $staticReflectionParser->getNamespaceName();

StaticReflectionClass
=====================

.. code-block:: php

    $staticReflectionClass = $staticReflectionParser->getReflectionClass();

    echo $staticReflectionClass->getName();

    echo $staticReflectionClass->getDocComment();

    echo $staticReflectionClass->getNamespaceName();

    print_r($staticReflectionClass->getUseStatements());

StaticReflectionMethod
======================

.. code-block:: php

    $staticReflectionMethod = $staticReflectionParser->getReflectionMethod('getSomething');

    echo $staticReflectionMethod->getName();

    echo $staticReflectionMethod->getDeclaringClass();

    echo $staticReflectionMethod->getNamespaceName();

    echo $staticReflectionMethod->getDocComment();

    print_r($staticReflectionMethod->getUseStatements());

StaticReflectionProperty
========================

.. code-block:: php

    $staticReflectionProperty = $staticReflectionParser->getReflectionProperty('something');

    echo $staticReflectionProperty->getName();

    echo $staticReflectionProperty->getDeclaringClass();

    echo $staticReflectionProperty->getDocComment();

    print_r($staticReflectionProperty->getUseStatements());
