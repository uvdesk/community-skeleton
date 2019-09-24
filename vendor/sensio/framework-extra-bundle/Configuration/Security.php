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
 * The Security class handles the Security annotation.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @Annotation
 */
class Security extends ConfigurationAnnotation
{
    /**
     * The expression evaluated to allow or deny access.
     *
     * @var string
     */
    private $expression;

    /**
     * If set, will throw Symfony\Component\HttpKernel\Exception\HttpException
     * with the given $statusCode.
     * If null, Symfony\Component\Security\Core\Exception\AccessDeniedException.
     * will be used.
     *
     * @var int|null
     */
    protected $statusCode;

    /**
     * The message of the exception.
     *
     * @var string
     */
    protected $message = 'Access denied.';

    public function getExpression()
    {
        return $this->expression;
    }

    public function setExpression($expression)
    {
        $this->expression = $expression;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setValue($expression)
    {
        $this->setExpression($expression);
    }

    public function getAliasName()
    {
        return 'security';
    }

    public function allowArray()
    {
        return true;
    }
}
