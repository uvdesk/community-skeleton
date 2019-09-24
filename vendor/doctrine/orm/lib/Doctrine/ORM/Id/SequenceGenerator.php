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

namespace Doctrine\ORM\Id;

use Doctrine\ORM\EntityManager;
use Serializable;

/**
 * Represents an ID generator that uses a database sequence.
 *
 * @since 2.0
 * @author Roman Borschel <roman@code-factory.org>
 */
class SequenceGenerator extends AbstractIdGenerator implements Serializable
{
    /**
     * The allocation size of the sequence.
     *
     * @var int
     */
    private $_allocationSize;

    /**
     * The name of the sequence.
     *
     * @var string
     */
    private $_sequenceName;

    /**
     * @var int
     */
    private $_nextValue = 0;

    /**
     * @var int|null
     */
    private $_maxValue = null;

    /**
     * Initializes a new sequence generator.
     *
     * @param string  $sequenceName   The name of the sequence.
     * @param integer $allocationSize The allocation size of the sequence.
     */
    public function __construct($sequenceName, $allocationSize)
    {
        $this->_sequenceName = $sequenceName;
        $this->_allocationSize = $allocationSize;
    }

    /**
     * {@inheritDoc}
     */
    public function generate(EntityManager $em, $entity)
    {
        if ($this->_maxValue === null || $this->_nextValue == $this->_maxValue) {
            // Allocate new values
            $conn = $em->getConnection();
            $sql  = $conn->getDatabasePlatform()->getSequenceNextValSQL($this->_sequenceName);

            // Using `query` to force usage of the master server in MasterSlaveConnection
            $this->_nextValue = (int) $conn->query($sql)->fetchColumn();
            $this->_maxValue  = $this->_nextValue + $this->_allocationSize;
        }

        return $this->_nextValue++;
    }

    /**
     * Gets the maximum value of the currently allocated bag of values.
     *
     * @return integer|null
     */
    public function getCurrentMaxValue()
    {
        return $this->_maxValue;
    }

    /**
     * Gets the next value that will be returned by generate().
     *
     * @return integer
     */
    public function getNextValue()
    {
        return $this->_nextValue;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize(
            [
            'allocationSize' => $this->_allocationSize,
            'sequenceName'   => $this->_sequenceName
            ]
        );
    }

    /**
     * @param string $serialized
     *
     * @return void
     */
    public function unserialize($serialized)
    {
        $array = unserialize($serialized);

        $this->_sequenceName = $array['sequenceName'];
        $this->_allocationSize = $array['allocationSize'];
    }
}
