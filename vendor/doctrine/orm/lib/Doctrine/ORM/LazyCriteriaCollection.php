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

namespace Doctrine\ORM;

use Doctrine\Common\Collections\AbstractLazyCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Selectable;
use Doctrine\ORM\Persisters\Entity\BasicEntityPersister;
use Doctrine\ORM\Persisters\Entity\EntityPersister;

/**
 * A lazy collection that allow a fast count when using criteria object
 * Once count gets executed once without collection being initialized, result
 * is cached and returned on subsequent calls until collection gets loaded,
 * then returning the number of loaded results.
 *
 * @since   2.5
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Michaël Gallego <mic.gallego@gmail.com>
 */
class LazyCriteriaCollection extends AbstractLazyCollection implements Selectable
{
    /**
     * @var BasicEntityPersister
     */
    protected $entityPersister;

    /**
     * @var Criteria
     */
    protected $criteria;

    /**
     * @var integer|null
     */
    private $count;

    /**
     * @param EntityPersister $entityPersister
     * @param Criteria        $criteria
     */
    public function __construct(EntityPersister $entityPersister, Criteria $criteria)
    {
        $this->entityPersister = $entityPersister;
        $this->criteria        = $criteria;
    }

    /**
     * Do an efficient count on the collection
     *
     * @return integer
     */
    public function count()
    {
        if ($this->isInitialized()) {
            return $this->collection->count();
        }

        // Return cached result in case count query was already executed
        if ($this->count !== null) {
            return $this->count;
        }

        return $this->count = $this->entityPersister->count($this->criteria);
    }

    /**
     * check if collection is empty without loading it
     *
     * @return boolean TRUE if the collection is empty, FALSE otherwise.
     */
    public function isEmpty()
    {
        if ($this->isInitialized()) {
            return $this->collection->isEmpty();
        }

        return !$this->count();
    }

    /**
     * Do an optimized search of an element
     *
     * @param object $element
     *
     * @return bool
     */
    public function contains($element)
    {
        if ($this->isInitialized()) {
            return $this->collection->contains($element);
        }

        return $this->entityPersister->exists($element, $this->criteria);
    }

    /**
     * {@inheritDoc}
     */
    public function matching(Criteria $criteria)
    {
        $this->initialize();

        return $this->collection->matching($criteria);
    }

    /**
     * {@inheritDoc}
     */
    protected function doInitialize()
    {
        $elements         = $this->entityPersister->loadCriteria($this->criteria);
        $this->collection = new ArrayCollection($elements);
    }
}
