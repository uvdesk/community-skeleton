<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\FrameworkExtraBundle\Configuration;

/**
 * Doctrine-specific ParamConverter with an easier syntax.
 *
 * @author Ryan Weaver <ryan@knpuniversity.com>
 * @Annotation
 */
class Entity extends ParamConverter
{
    public function setExpr($expr)
    {
        $options = $this->getOptions();
        $options['expr'] = $expr;

        $this->setOptions($options);
    }
}
