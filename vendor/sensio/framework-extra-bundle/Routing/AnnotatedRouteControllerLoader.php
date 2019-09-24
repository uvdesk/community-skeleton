<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\FrameworkExtraBundle\Routing;

use Symfony\Component\Routing\Loader\AnnotationClassLoader;
use Symfony\Component\Routing\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as FrameworkExtraBundleRoute;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

@trigger_error(sprintf('The "%s" class is deprecated since version 5.2. Use "%s" instead.', AnnotatedRouteControllerLoader::class, \Symfony\Bundle\FrameworkBundle\Routing\AnnotatedRouteControllerLoader::class), E_USER_DEPRECATED);

/**
 * AnnotatedRouteControllerLoader is an implementation of AnnotationClassLoader
 * that sets the '_controller' default based on the class and method names.
 *
 * It also parse the @Method annotation.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @deprecated since version 5.2
 */
class AnnotatedRouteControllerLoader extends AnnotationClassLoader
{
    /**
     * Configures the _controller default parameter and eventually the HTTP method
     * requirement of a given Route instance.
     *
     * @param mixed $annot The annotation class instance
     *
     * @throws \LogicException When the service option is specified on a method
     */
    protected function configureRoute(Route $route, \ReflectionClass $class, \ReflectionMethod $method, $annot)
    {
        // controller
        $classAnnot = $this->reader->getClassAnnotation($class, $this->routeAnnotationClass);
        if ($classAnnot instanceof FrameworkExtraBundleRoute && $service = $classAnnot->getService()) {
            $route->setDefault('_controller', $service.':'.$method->getName());
        } elseif ('__invoke' === $method->getName()) {
            $route->setDefault('_controller', $class->getName());
        } else {
            $route->setDefault('_controller', $class->getName().'::'.$method->getName());
        }

        // requirements (@Method)
        foreach ($this->reader->getMethodAnnotations($method) as $configuration) {
            if ($configuration instanceof Method) {
                $route->setMethods($configuration->getMethods());
            } elseif ($configuration instanceof FrameworkExtraBundleRoute && $configuration->getService()) {
                throw new \LogicException('The service option can only be specified at class level.');
            }
        }
    }

    protected function getGlobals(\ReflectionClass $class)
    {
        $globals = parent::getGlobals($class);

        foreach ($this->reader->getClassAnnotations($class) as $configuration) {
            if ($configuration instanceof Method) {
                $globals['methods'] = array_merge($globals['methods'], $configuration->getMethods());
            }
        }

        return $globals;
    }

    /**
     * Makes the default route name more sane by removing common keywords.
     *
     * @return string The default route name
     */
    protected function getDefaultRouteName(\ReflectionClass $class, \ReflectionMethod $method)
    {
        $routeName = parent::getDefaultRouteName($class, $method);

        return preg_replace(
            ['/(bundle|controller)_/', '/action(_\d+)?$/', '/__/'],
            ['_', '\\1', '_'],
            $routeName
        );
    }
}
