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
 * The Cache class handles the Cache annotation parts.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @Annotation
 */
class Cache extends ConfigurationAnnotation
{
    /**
     * The expiration date as a valid date for the strtotime() function.
     *
     * @var string
     */
    private $expires;

    /**
     * The number of seconds that the response is considered fresh by a private
     * cache like a web browser.
     *
     * @var int
     */
    private $maxage;

    /**
     * The number of seconds that the response is considered fresh by a public
     * cache like a reverse proxy cache.
     *
     * @var int
     */
    private $smaxage;

    /**
     * Whether the response is public or not.
     *
     * @var bool
     */
    private $public;

    /**
     * Whether or not the response must be revalidated.
     *
     * @var bool
     */
    private $mustRevalidate;

    /**
     * Additional "Vary:"-headers.
     *
     * @var array
     */
    private $vary;

    /**
     * An expression to compute the Last-Modified HTTP header.
     *
     * @var string
     */
    private $lastModified;

    /**
     * An expression to compute the ETag HTTP header.
     *
     * @var string
     */
    private $etag;

    /**
     * max-stale Cache-Control header
     * It can be expressed in seconds or with a relative time format (1 day, 2 weeks, ...).
     *
     * @var int|string
     */
    private $maxStale;

    /**
     * Returns the expiration date for the Expires header field.
     *
     * @return string
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Sets the expiration date for the Expires header field.
     *
     * @param string $expires A valid php date
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;
    }

    /**
     * Sets the number of seconds for the max-age cache-control header field.
     *
     * @param int $maxage A number of seconds
     */
    public function setMaxAge($maxage)
    {
        $this->maxage = $maxage;
    }

    /**
     * Returns the number of seconds the response is considered fresh by a
     * private cache.
     *
     * @return int
     */
    public function getMaxAge()
    {
        return $this->maxage;
    }

    /**
     * Sets the number of seconds for the s-maxage cache-control header field.
     *
     * @param int $smaxage A number of seconds
     */
    public function setSMaxAge($smaxage)
    {
        $this->smaxage = $smaxage;
    }

    /**
     * Returns the number of seconds the response is considered fresh by a
     * public cache.
     *
     * @return int
     */
    public function getSMaxAge()
    {
        return $this->smaxage;
    }

    /**
     * Returns whether or not a response is public.
     *
     * @return bool
     */
    public function isPublic()
    {
        return true === $this->public;
    }

    /**
     * @return bool
     */
    public function mustRevalidate()
    {
        return true === $this->mustRevalidate;
    }

    /**
     * Forces a response to be revalidated.
     *
     * @param bool $mustRevalidate
     */
    public function setMustRevalidate($mustRevalidate)
    {
        $this->mustRevalidate = (bool) $mustRevalidate;
    }

    /**
     * Returns whether or not a response is private.
     *
     * @return bool
     */
    public function isPrivate()
    {
        return false === $this->public;
    }

    /**
     * Sets a response public.
     *
     * @param bool $public A boolean value
     */
    public function setPublic($public)
    {
        $this->public = (bool) $public;
    }

    /**
     * Returns the custom "Vary"-headers.
     *
     * @return array
     */
    public function getVary()
    {
        return $this->vary;
    }

    /**
     * Add additional "Vary:"-headers.
     *
     * @param array $vary
     */
    public function setVary($vary)
    {
        $this->vary = $vary;
    }

    /**
     * Sets the "Last-Modified"-header expression.
     *
     * @param string $expression
     */
    public function setLastModified($expression)
    {
        $this->lastModified = $expression;
    }

    /**
     * Returns the "Last-Modified"-header expression.
     *
     * @return string
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Sets the "ETag"-header expression.
     *
     * @param string $expression
     */
    public function setEtag($expression)
    {
        $this->etag = $expression;
    }

    /**
     * Returns the "ETag"-header expression.
     *
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * @return int|string
     */
    public function getMaxStale()
    {
        return $this->maxStale;
    }

    /**
     * Sets the number of seconds for the max-stale cache-control header field.
     *
     * @param int|string $maxStale A number of seconds
     */
    public function setMaxStale($maxStale)
    {
        $this->maxStale = $maxStale;
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
        return 'cache';
    }

    /**
     * Only one cache directive is allowed.
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
