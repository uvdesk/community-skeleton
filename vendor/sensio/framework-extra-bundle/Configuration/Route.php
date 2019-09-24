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

use Symfony\Component\Routing\Annotation\Route as BaseRoute;

@trigger_error(sprintf('The "%s" annotation is deprecated since version 5.2. Use "%s" instead.', Route::class, BaseRoute::class), E_USER_DEPRECATED);

/**
 * @author Kris Wallsmith <kris@symfony.com>
 * @Annotation
 *
 * @deprecated since version 5.2
 */
class Route extends BaseRoute
{
    private $service;

    public function setService($service)
    {
        // avoid a BC notice in case of @Route(service="") with sf ^2.7
        if (null === $this->getPath()) {
            $this->setPath('');
        }
        $this->service = $service;
    }

    public function getService()
    {
        return $this->service;
    }

    /**
     * Multiple route annotations are allowed.
     *
     * @return bool
     *
     * @see ConfigurationInterface
     */
    public function allowArray()
    {
        return true;
    }
}
