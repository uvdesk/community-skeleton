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
 * @author Ryan Weaver <ryan@knpuniversity.com>
 * @Annotation
 */
class IsGranted extends ConfigurationAnnotation
{
    /**
     * Sets the first argument that will be passed to isGranted().
     *
     * @var mixed
     */
    private $attributes;

    /**
     * Sets the second argument passed to isGranted().
     *
     * @var mixed
     */
    private $subject;

    /**
     * The message of the exception - has a nice default if not set.
     *
     * @var string
     */
    private $message;

    /**
     * If set, will throw Symfony\Component\HttpKernel\Exception\HttpException
     * with the given $statusCode.
     * If null, Symfony\Component\Security\Core\Exception\AccessDeniedException.
     * will be used.
     *
     * @var int|null
     */
    private $statusCode;

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function setValue($value)
    {
        $this->setAttributes($value);
    }

    public function getAliasName()
    {
        return 'is_granted';
    }

    public function allowArray()
    {
        return true;
    }
}
