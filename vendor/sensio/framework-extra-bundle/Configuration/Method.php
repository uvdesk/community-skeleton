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

@trigger_error(sprintf('The "%s" annotation is deprecated since version 5.2. Use "%s" instead.', Method::class, \Symfony\Component\Routing\Annotation\Route::class), E_USER_DEPRECATED);

/**
 * The Method class handles the Method annotation parts.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @Annotation
 *
 * @deprecated since version 5.2
 */
class Method extends ConfigurationAnnotation
{
    /**
     * An array of restricted HTTP methods.
     *
     * @var array
     */
    private $methods = [];

    /**
     * Returns the array of HTTP methods.
     *
     * @return array
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * Sets the HTTP methods.
     *
     * @param array|string $methods An HTTP method or an array of HTTP methods
     */
    public function setMethods($methods)
    {
        $this->methods = \is_array($methods) ? $methods : [$methods];
    }

    /**
     * Sets the HTTP methods.
     *
     * @param array|string $methods An HTTP method or an array of HTTP methods
     */
    public function setValue($methods)
    {
        $this->setMethods($methods);
    }

    /**
     * Returns the annotation alias name.
     *
     * @return string
     *
     * @see ConfigurationInterface
     */
    public function getAliasName()
    {
        return 'method';
    }

    /**
     * Only one method directive is allowed.
     *
     * @return bool
     *
     * @see ConfigurationInterface
     */
    public function allowArray()
    {
        return false;
    }
}
