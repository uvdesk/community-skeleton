<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\SwiftmailerBundle\DependencyInjection;

use Symfony\Component\Routing\RequestContext;

class SmtpTransportConfigurator
{
    private $localDomain;
    private $requestContext;

    public function __construct($localDomain, RequestContext $requestContext = null)
    {
        $this->localDomain = $localDomain;
        $this->requestContext = $requestContext;
    }

    /**
     * Sets the local domain based on the current request context.
     */
    public function configure(\Swift_Transport_AbstractSmtpTransport $transport)
    {
        if ($this->localDomain) {
            $transport->setLocalDomain($this->localDomain);
        } elseif ($this->requestContext) {
            $transport->setLocalDomain($this->requestContext->getHost());
        }
    }
}
