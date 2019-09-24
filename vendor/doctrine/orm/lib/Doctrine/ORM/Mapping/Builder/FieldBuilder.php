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
 * Field Builder
 *
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 * @link        www.doctrine-project.com
 * @since       2.2
 * @author      Benjamin Eberlei <kontakt@beberlei.de>
 */
class FieldBuilder
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
     * @var bool
     */
    private $version;

    /**
     * @var string
     */
    private $generatedValue;

    /**
     * @var array
     */
    private $sequenceDef;

    /**
     * @var string|null
     */
    private $customIdGenerator;

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
     * Sets length.
     *
     * @param int $length
     *
     * @return FieldBuilder
     */
    public function length($length)
    {
        $this->mapping['length'] = $length;

        return $this;
    }

    /**
     * Sets nullable.
     *
     * @param bool $flag
     *
     * @return FieldBuilder
     */
    public function nullable($flag = true)
    {
        $this->mapping['nullable'] = (bool) $flag;

        return $this;
    }

    /**
     * Sets Unique.
     *
     * @param bool $flag
     *
     * @return FieldBuilder
     */
    public function unique($flag = true)
    {
        $this->mapping['unique'] = (bool) $flag;

        return $this;
    }

    /**
     * Sets column name.
     *
     * @param string $name
     *
     * @return FieldBuilder
     */
    public function columnName($name)
    {
        $this->mapping['columnName'] = $name;

        return $this;
    }

    /**
     * Sets Precision.
     *
     * @param int $p
     *
     * @return FieldBuilder
     */
    public function precision($p)
    {
        $this->mapping['precision'] = $p;

        return $this;
    }

    /**
     * Sets scale.
     *
     * @param int $s
     *
     * @return FieldBuilder
     */
    public function scale($s)
    {
        $this->mapping['scale'] = $s;

        return $this;
    }

    /**
     * Sets field as primary key.
     *
     * @deprecated Use makePrimaryKey() instead
     * @return FieldBuilder
     */
    public function isPrimaryKey()
    {
        return $this->makePrimaryKey();
    }

    /**
     * Sets field as primary key.
     *
     * @return FieldBuilder
     */
    public function makePrimaryKey()
    {
        $this->mapping['id'] = true;

        return $this;
    }

    /**
     * Sets an option.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return FieldBuilder
     */
    public function option($name, $value)
    {
        $this->mapping['options'][$name] = $value;

        return $this;
    }

    /**
     * @param string $strategy
     *
     * @return FieldBuilder
     */
    public function generatedValue($strategy = 'AUTO')
    {
        $this->generatedValue = $strategy;

        return $this;
    }

    /**
     * Sets field versioned.
     *
     * @return FieldBuilder
     */
    public function isVersionField()
    {
        $this->version = true;

        return $this;
    }

    /**
     * Sets Sequence Generator.
     *
     * @param string $sequenceName
     * @param int    $allocationSize
     * @param int    $initialValue
     *
     * @return FieldBuilder
     */
    public function setSequenceGenerator($sequenceName, $allocationSize = 1, $initialValue = 1)
    {
        $this->sequenceDef = [
            'sequenceName' => $sequenceName,
            'allocationSize' => $allocationSize,
            'initialValue' => $initialValue,
        ];

        return $this;
    }

    /**
     * Sets column definition.
     *
     * @param string $def
     *
     * @return FieldBuilder
     */
    public function columnDefinition($def)
    {
        $this->mapping['columnDefinition'] = $def;

        return $this;
    }

    /**
     * Set the FQCN of the custom ID generator.
     * This class must extend \Doctrine\ORM\Id\AbstractIdGenerator.
     *
     * @param string $customIdGenerator
     *
     * @return $this
     */
    public function setCustomIdGenerator($customIdGenerator)
    {
        $this->customIdGenerator = (string) $customIdGenerator;

        return $this;
    }

    /**
     * Finalizes this field and attach it to the ClassMetadata.
     *
     * Without this call a FieldBuilder has no effect on the ClassMetadata.
     *
     * @return ClassMetadataBuilder
     */
    public function build()
    {
        $cm = $this->builder->getClassMetadata();
        if ($this->generatedValue) {
            $cm->setIdGeneratorType(constant('Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_' . $this->generatedValue));
        }

        if ($this->version) {
            $cm->setVersionMapping($this->mapping);
        }

        $cm->mapField($this->mapping);
        if ($this->sequenceDef) {
            $cm->setSequenceGeneratorDefinition($this->sequenceDef);
        }

        if ($this->customIdGenerator) {
            $cm->setCustomGeneratorDefinition(['class' => $this->customIdGenerator]);
        }

        return $this->builder;
    }
}
