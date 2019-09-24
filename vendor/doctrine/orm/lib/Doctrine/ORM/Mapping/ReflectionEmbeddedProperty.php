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

namespace Doctrine\ORM\Mapping;

use Doctrine\Instantiator\Instantiator;
use ReflectionProperty;

/**
 * Acts as a proxy to a nested Property structure, making it look like
 * just a single scalar property.
 *
 * This way value objects "just work" without UnitOfWork, Persisters or Hydrators
 * needing any changes.
 *
 * TODO: Move this class into Common\Reflection
 */
class ReflectionEmbeddedProperty extends ReflectionProperty
{
    /**
     * @var ReflectionProperty reflection property of the class where the embedded object has to be put
     */
    private $parentProperty;

    /**
     * @var ReflectionProperty reflection property of the embedded object
     */
    private $childProperty;

    /**
     * @var string name of the embedded class to be eventually instantiated
     */
    private $embeddedClass;

    /**
     * @var Instantiator|null
     */
    private $instantiator;

    /**
     * @param ReflectionProperty $parentProperty
     * @param ReflectionProperty $childProperty
     * @param string             $embeddedClass
     */
    public function __construct(ReflectionProperty $parentProperty, ReflectionProperty $childProperty, $embeddedClass)
    {
        $this->parentProperty  = $parentProperty;
        $this->childProperty   = $childProperty;
        $this->embeddedClass   = (string) $embeddedClass;

        parent::__construct($childProperty->getDeclaringClass()->getName(), $childProperty->getName());
    }

    /**
     * {@inheritDoc}
     */
    public function getValue($object = null)
    {
        $embeddedObject = $this->parentProperty->getValue($object);

        if (null === $embeddedObject) {
            return null;
        }

        return $this->childProperty->getValue($embeddedObject);
    }

    /**
     * {@inheritDoc}
     */
    public function setValue($object, $value = null)
    {
        $embeddedObject = $this->parentProperty->getValue($object);

        if (null === $embeddedObject) {
            $this->instantiator = $this->instantiator ?: new Instantiator();

            $embeddedObject = $this->instantiator->instantiate($this->embeddedClass);

            $this->parentProperty->setValue($object, $embeddedObject);
        }

        $this->childProperty->setValue($embeddedObject, $value);
    }
}
