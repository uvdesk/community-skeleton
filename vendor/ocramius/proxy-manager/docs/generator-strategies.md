---
title: Generator strategies
---

# Generator strategies

ProxyManager allows you to generate classes based on generator strategies and a
given `Zend\Code\Generator\ClassGenerator` as of
the [interface of a generator strategy](https://github.com/Ocramius/ProxyManager/blob/master/src/ProxyManager/GeneratorStrategy/GeneratorStrategyInterface.php).

Currently, 3 generator strategies are shipped with ProxyManager:

 * [`ProxyManager\GeneratorStrategy\BaseGeneratorStrategy`](https://github.com/Ocramius/ProxyManager/blob/master/src/ProxyManager/GeneratorStrategy/BaseGeneratorStrategy.php),
   which simply retrieves the string representation of the class from `ClassGenerator`
 * [`ProxyManager\GeneratorStrategy\EvaluatingGeneratorStrategy`](https://github.com/Ocramius/ProxyManager/blob/master/src/ProxyManager/GeneratorStrategy/EvaluatingGeneratorStrategy.php),
   which calls `eval()` upon the generated class code before returning it. This is useful in cases
   where you want to generate multiple classes at runtime
 * [`ProxyManager\GeneratorStrategy\FileWriterGeneratorStrategy`](https://github.com/Ocramius/ProxyManager/blob/master/src/ProxyManager/GeneratorStrategy/FileWriterGeneratorStrategy.php),
   which accepts a [`ProxyManager\FileLocator\FileLocatorInterface`](https://github.com/Ocramius/ProxyManager/blob/master/src/ProxyManager/FileLocator/FileLocatorInterface.php)
   instance as constructor parameter, and based on it, writes the generated class to a file before returning its code.
