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

namespace Doctrine\ORM\Persisters\Entity;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\DBAL\Types\Type;

/**
 * Base class for entity persisters that implement a certain inheritance mapping strategy.
 * All these persisters are assumed to use a discriminator column to discriminate entity
 * types in the hierarchy.
 *
 * @author Roman Borschel <roman@code-factory.org>
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 * @since 2.0
 */
abstract class AbstractEntityInheritancePersister extends BasicEntityPersister
{
    /**
     * {@inheritdoc}
     */
    protected function prepareInsertData($entity)
    {
        $data = parent::prepareInsertData($entity);

        // Populate the discriminator column
        $discColumn = $this->class->discriminatorColumn;
        $this->columnTypes[$discColumn['name']] = $discColumn['type'];
        $data[$this->getDiscriminatorColumnTableName()][$discColumn['name']] = $this->class->discriminatorValue;

        return $data;
    }

    /**
     * Gets the name of the table that contains the discriminator column.
     *
     * @return string The table name.
     */
    abstract protected function getDiscriminatorColumnTableName();

    /**
     * {@inheritdoc}
     */
    protected function getSelectColumnSQL($field, ClassMetadata $class, $alias = 'r')
    {
        $tableAlias   = $alias == 'r' ? '' : $alias;
        $fieldMapping = $class->fieldMappings[$field];
        $columnAlias  = $this->getSQLColumnAlias($fieldMapping['columnName']);
        $sql          = sprintf(
            '%s.%s',
            $this->getSQLTableAlias($class->name, $tableAlias),
            $this->quoteStrategy->getColumnName($field, $class, $this->platform)
        );

        $this->currentPersisterContext->rsm->addFieldResult($alias, $columnAlias, $field, $class->name);

        if (isset($fieldMapping['requireSQLConversion'])) {
            $type   = Type::getType($fieldMapping['type']);
            $sql    = $type->convertToPHPValueSQL($sql, $this->platform);
        }

        return $sql . ' AS ' . $columnAlias;
    }

    /**
     * @param string $tableAlias
     * @param string $joinColumnName
     * @param string $quotedColumnName
     *
     * @param string $type
     *
     * @return string
     */
    protected function getSelectJoinColumnSQL($tableAlias, $joinColumnName, $quotedColumnName, $type)
    {
        $columnAlias = $this->getSQLColumnAlias($joinColumnName);

        $this->currentPersisterContext->rsm->addMetaResult('r', $columnAlias, $joinColumnName, false, $type);

        return $tableAlias . '.' . $quotedColumnName . ' AS ' . $columnAlias;
    }
}
