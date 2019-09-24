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

namespace Doctrine\ORM\Mapping\Builder;

use Doctrine\ORM\Mapping\MappingException;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Events;

/**
 * Builder for entity listeners.
 *
 * @since       2.4
 * @author      Fabio B. Silva <fabio.bat.silva@gmail.com>
 */
class EntityListenerBuilder
{
    /**
     * @var array Hash-map to handle event names.
     */
    static private $events = [
        Events::preRemove   => true,
        Events::postRemove  => true,
        Events::prePersist  => true,
        Events::postPersist => true,
        Events::preUpdate   => true,
        Events::postUpdate  => true,
        Events::postLoad    => true,
        Events::preFlush    => true
    ];

    /**
     * Lookup the entity class to find methods that match to event lifecycle names
     *
     * @param \Doctrine\ORM\Mapping\ClassMetadata $metadata     The entity metadata.
     * @param string $className                                 The listener class name.
     *
     * @throws \Doctrine\ORM\Mapping\MappingException           When the listener class not found.
     */
    static public function bindEntityListener(ClassMetadata $metadata, $className)
    {
        $class = $metadata->fullyQualifiedClassName($className);

        if ( ! class_exists($class)) {
            throw MappingException::entityListenerClassNotFound($class, $className);
        }

        foreach (get_class_methods($class) as $method) {
            if ( ! isset(self::$events[$method])) {
                continue;
            }

            $metadata->addEntityListener($method, $class, $method);
        }
    }
}
