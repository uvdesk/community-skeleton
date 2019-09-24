DoctrineCacheBundle
===================

Symfony Bundle for Doctrine Cache.

Master: [![Build Status](https://secure.travis-ci.org/doctrine/DoctrineCacheBundle.svg?branch=master)](https://travis-ci.org/doctrine/DoctrineCacheBundle)

Master: [![Coverage Status](https://coveralls.io/repos/doctrine/DoctrineCacheBundle/badge.png?branch=master)](https://coveralls.io/r/doctrine/DoctrineCacheBundle?branch=master)

## Installation

1. Add this bundle to your project as a composer dependency:

  ```bash
  composer require doctrine/doctrine-cache-bundle
  ```

2. Add this bundle in your application kernel:

    ```php
    // app/AppKernel.php
    public function registerBundles()
    {
        // ...
        $bundles[] = new \Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle();

        return $bundles;
    }
    ```

Read the [documentation](https://symfony.com/doc/current/bundles/DoctrineCacheBundle/index.html) to learn how to configure and
use your own cache providers.
