<?php

namespace Symfony\Bundle\SwiftmailerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Ensures that autoloading of Swiftmailer classes is not optimized by the hot path optimization.
 *
 * Swiftmailer has a special autoloader triggering the initialization of the library lazily.
 * Bypassing the autoloader would thus break the library.
 * This logic allows to keep applying the autoloading optimization on the container, forcing an
 * opt-out only for the Swiftmailer classes, which is better than disabling the optimization
 * entirely.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class EnsureNoHotPathPass extends AbstractRecursivePass
{
    protected function processValue($value, $isRoot = false)
    {
        if ($value instanceof Definition && 0 === strpos($value->getClass(), 'Swift_')) {
            $value->clearTag('container.hot_path');
        }

        return parent::processValue($value, $isRoot);
    }
}
