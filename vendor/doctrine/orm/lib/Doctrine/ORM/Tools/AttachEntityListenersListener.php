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

namespace Doctrine\ORM\Tools;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

/**
 * Mechanism to programmatically attach entity listeners.
 *
 * @author Fabio B. SIlva <fabio.bat.silva@gmail.com>
 *
 * @since 2.5
 */
class AttachEntityListenersListener
{
    /**
     * @var array[]
     */
    private $entityListeners = [];

    /**
     * Adds a entity listener for a specific entity.
     *
     * @param string      $entityClass      The entity to attach the listener.
     * @param string      $listenerClass    The listener class.
     * @param string      $eventName        The entity lifecycle event.
     * @param string|null $listenerCallback The listener callback method or NULL to use $eventName.
     *
     * @return void
     */
    public function addEntityListener($entityClass, $listenerClass, $eventName, $listenerCallback = null)
    {
        $this->entityListeners[ltrim($entityClass, '\\')][] = [
            'event'  => $eventName,
            'class'  => $listenerClass,
            'method' => $listenerCallback ?: $eventName
        ];
    }

    /**
     * Processes event and attach the entity listener.
     *
     * @param \Doctrine\ORM\Event\LoadClassMetadataEventArgs $event
     *
     * @return void
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $event)
    {
        /** @var $metadata \Doctrine\ORM\Mapping\ClassMetadata */
        $metadata = $event->getClassMetadata();

        if ( ! isset($this->entityListeners[$metadata->name])) {
            return;
        }

        foreach ($this->entityListeners[$metadata->name] as $listener) {
            $metadata->addEntityListener($listener['event'], $listener['class'], $listener['method']);
        }

        unset($this->entityListeners[$metadata->name]);
    }
}
