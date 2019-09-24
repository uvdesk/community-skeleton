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

use Doctrine\ORM\ORMException;

/**
 * Exception for cache.
 *
 * @since   2.5
 * @author  Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class CacheException extends ORMException
{
    /**
     * @param string $sourceEntity
     * @param string $fieldName
     *
     * @return \Doctrine\ORM\Cache\CacheException
     */
    public static function updateReadOnlyCollection($sourceEntity, $fieldName)
    {
        return new self(sprintf('Cannot update a readonly collection "%s#%s"', $sourceEntity, $fieldName));
    }

    /**
     * @param string $entityName
     *
     * @return \Doctrine\ORM\Cache\CacheException
     */
    public static function updateReadOnlyEntity($entityName)
    {
        return new self(sprintf('Cannot update a readonly entity "%s"', $entityName));
    }

    /**
     * @param string $entityName
     *
     * @return \Doctrine\ORM\Cache\CacheException
     */
    public static function nonCacheableEntity($entityName)
    {
        return new self(sprintf('Entity "%s" not configured as part of the second-level cache.', $entityName));
    }

    /**
     * @param string $entityName
     * @param string $field
     *
     * @return CacheException
     */
    public static function nonCacheableEntityAssociation($entityName, $field)
    {
        return new self(sprintf('Entity association field "%s#%s" not configured as part of the second-level cache.', $entityName, $field));
    }
}
