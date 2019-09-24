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

/**
 * Embedded Builder
 *
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 * @link        www.doctrine-project.com
 * @since       2.5
 * @author      Guido Contreras Woda <guiwoda@gmail.com>
 */
class EmbeddedBuilder
{
    /**
     * @var ClassMetadataBuilder
     */
    private $builder;

    /**
     * @var array
     */
    private $mapping;

    /**
     * @param ClassMetadataBuilder $builder
     * @param array                $mapping
     */
    public function __construct(ClassMetadataBuilder $builder, array $mapping)
    {
        $this->builder = $builder;
        $this->mapping = $mapping;
    }

    /**
     * Sets the column prefix for all of the embedded columns.
     *
     * @param string $columnPrefix
     * @return $this
     */
    public function setColumnPrefix($columnPrefix)
    {
        $this->mapping['columnPrefix'] = $columnPrefix;

        return $this;
    }

    /**
     * Finalizes this embeddable and attach it to the ClassMetadata.
     *
     * Without this call an EmbeddedBuilder has no effect on the ClassMetadata.
     *
     * @return ClassMetadataBuilder
     */
    public function build()
    {
        $cm = $this->builder->getClassMetadata();

        $cm->mapEmbedded($this->mapping);

        return $this->builder;
    }
}
