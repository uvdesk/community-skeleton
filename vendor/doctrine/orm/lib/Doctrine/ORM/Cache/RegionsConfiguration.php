<?php

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM\Cache;

/**
 * Cache regions configuration
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class RegionsConfiguration
{
    /**
     * @var array
     */
    private $lifetimes = [];

    /**
     * @var array
     */
    private $lockLifetimes = [];

    /**
     * @var integer
     */
    private $defaultLifetime;

    /**
     * @var integer
     */
    private $defaultLockLifetime;

    /**
     * @param integer $defaultLifetime
     * @param integer $defaultLockLifetime
     */
    public function __construct($defaultLifetime = 3600, $defaultLockLifetime = 60)
    {
        $this->defaultLifetime      = (integer) $defaultLifetime;
        $this->defaultLockLifetime  = (integer) $defaultLockLifetime;
    }

    /**
     * @return integer
     */
    public function getDefaultLifetime()
    {
        return $this->defaultLifetime;
    }

    /**
     * @param integer $defaultLifetime
     */
    public function setDefaultLifetime($defaultLifetime)
    {
        $this->defaultLifetime = (integer) $defaultLifetime;
    }

    /**
     * @return integer
     */
    public function getDefaultLockLifetime()
    {
        return $this->defaultLockLifetime;
    }

    /**
     * @param integer $defaultLockLifetime
     */
    public function setDefaultLockLifetime($defaultLockLifetime)
    {
        $this->defaultLockLifetime = (integer) $defaultLockLifetime;
    }

    /**
     * @param string $regionName
     *
     * @return integer
     */
    public function getLifetime($regionName)
    {
        return isset($this->lifetimes[$regionName])
            ? $this->lifetimes[$regionName]
            : $this->defaultLifetime;
    }

    /**
     * @param string  $name
     * @param integer $lifetime
     */
    public function setLifetime($name, $lifetime)
    {
        $this->lifetimes[$name] = (integer) $lifetime;
    }

    /**
     * @param string $regionName
     *
     * @return integer
     */
    public function getLockLifetime($regionName)
    {
        return isset($this->lockLifetimes[$regionName])
            ? $this->lockLifetimes[$regionName]
            : $this->defaultLockLifetime;
    }

    /**
     * @param string  $name
     * @param integer $lifetime
     */
    public function setLockLifetime($name, $lifetime)
    {
        $this->lockLifetimes[$name] = (integer) $lifetime;
    }
}
