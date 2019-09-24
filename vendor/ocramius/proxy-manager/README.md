# Proxy Manager

This library aims at providing abstraction for generating various kinds of [proxy classes](http://ocramius.github.io/presentations/proxy-pattern-in-php/).

![ProxyManager](https://raw.githubusercontent.com/Ocramius/ProxyManager/917bf1698243a1079aaa27ed8ea08c2aef09f4cb/proxy-manager.png)

[![Build Status](https://travis-ci.org/Ocramius/ProxyManager.png?branch=master)](https://travis-ci.org/Ocramius/ProxyManager)
[![Code Coverage](https://scrutinizer-ci.com/g/Ocramius/ProxyManager/badges/coverage.png?s=ca3b9ceb9e36aeec0e57569cc8983394b7d2a59e)](https://scrutinizer-ci.com/g/Ocramius/ProxyManager/)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/Ocramius/ProxyManager/badges/quality-score.png?s=eaa858f876137ed281141b1d1e98acfa739729ed)](https://scrutinizer-ci.com/g/Ocramius/ProxyManager/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/69fe5f97-b1c8-4ddd-93ce-900b8b788cf2/mini.png)](https://insight.sensiolabs.com/projects/69fe5f97-b1c8-4ddd-93ce-900b8b788cf2)
[![Dependency Status](https://www.versioneye.com/package/php--ocramius--proxy-manager/badge.png)](https://www.versioneye.com/package/php--ocramius--proxy-manager)
[![Reference Status](https://www.versioneye.com/php/ocramius:proxy-manager/reference_badge.svg)](https://www.versioneye.com/php/ocramius:proxy-manager/references)

[![Total Downloads](https://poser.pugx.org/ocramius/proxy-manager/downloads.png)](https://packagist.org/packages/ocramius/proxy-manager)
[![Latest Stable Version](https://poser.pugx.org/ocramius/proxy-manager/v/stable.png)](https://packagist.org/packages/ocramius/proxy-manager)
[![Latest Unstable Version](https://poser.pugx.org/ocramius/proxy-manager/v/unstable.png)](https://packagist.org/packages/ocramius/proxy-manager)


## Documentation

You can learn about the proxy pattern and how to use the **ProxyManager** in the [docs](docs), which are also
[compiled to HTML](http://ocramius.github.io/ProxyManager).

## Help/Support

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/Ocramius/ProxyManager?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge)

## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
php composer.phar require ocramius/proxy-manager
```

## Proxy example

Here's how you build a lazy loadable object with ProxyManager using a *Virtual Proxy*

```php
$factory = new \ProxyManager\Factory\LazyLoadingValueHolderFactory();

$proxy = $factory->createProxy(
    \MyApp\HeavyComplexObject::class,
    function (& $wrappedObject, $proxy, $method, $parameters, & $initializer) {
        $wrappedObject = new \MyApp\HeavyComplexObject(); // instantiation logic here
        $initializer   = null; // turning off further lazy initialization
    }
);

$proxy->doFoo();
```

See the [online documentation](http://ocramius.github.io/ProxyManager) for more supported proxy types and examples. 
