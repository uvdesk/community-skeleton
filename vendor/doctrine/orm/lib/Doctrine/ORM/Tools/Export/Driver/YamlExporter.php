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

namespace Doctrine\ORM\Tools\Export\Driver;

use Symfony\Component\Yaml\Yaml;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

/**
 * ClassMetadata exporter for Doctrine YAML mapping files.
 *
 * @link    www.doctrine-project.org
 * @since   2.0
 * @author  Jonathan Wage <jonwage@gmail.com>
 */
class YamlExporter extends AbstractExporter
{
    /**
     * @var string
     */
    protected $_extension = '.dcm.yml';

    /**
     * {@inheritdoc}
     */
    public function exportClassMetadata(ClassMetadataInfo $metadata)
    {
        $array = [];

        if ($metadata->isMappedSuperclass) {
            $array['type'] = 'mappedSuperclass';
        } else {
            $array['type'] = 'entity';
        }

        $array['table'] = $metadata->table['name'];

        if (isset($metadata->table['schema'])) {
            $array['schema'] = $metadata->table['schema'];
        }

        $inheritanceType = $metadata->inheritanceType;

        if ($inheritanceType !== ClassMetadataInfo::INHERITANCE_TYPE_NONE) {
            $array['inheritanceType'] = $this->_getInheritanceTypeString($inheritanceType);
        }

        if ($column = $metadata->discriminatorColumn) {
            $array['discriminatorColumn'] = $column;
        }

        if ($map = $metadata->discriminatorMap) {
            $array['discriminatorMap'] = $map;
        }

        if ($metadata->changeTrackingPolicy !== ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT) {
            $array['changeTrackingPolicy'] = $this->_getChangeTrackingPolicyString($metadata->changeTrackingPolicy);
        }

        if (isset($metadata->table['indexes'])) {
            $array['indexes'] = $metadata->table['indexes'];
        }

        if ($metadata->customRepositoryClassName) {
            $array['repositoryClass'] = $metadata->customRepositoryClassName;
        }

        if (isset($metadata->table['uniqueConstraints'])) {
            $array['uniqueConstraints'] = $metadata->table['uniqueConstraints'];
        }

        if (isset($metadata->table['options'])) {
            $array['options'] = $metadata->table['options'];
        }

        $fieldMappings = $metadata->fieldMappings;

        $ids = [];
        foreach ($fieldMappings as $name => $fieldMapping) {
            $fieldMapping['column'] = $fieldMapping['columnName'];

            unset($fieldMapping['columnName'], $fieldMapping['fieldName']);

            if ($fieldMapping['column'] == $name) {
                unset($fieldMapping['column']);
            }

            if (isset($fieldMapping['id']) && $fieldMapping['id']) {
                $ids[$name] = $fieldMapping;
                unset($fieldMappings[$name]);
                continue;
            }

            $fieldMappings[$name] = $fieldMapping;
        }

        if ( ! $metadata->isIdentifierComposite && $idGeneratorType = $this->_getIdGeneratorTypeString($metadata->generatorType)) {
            $ids[$metadata->getSingleIdentifierFieldName()]['generator']['strategy'] = $idGeneratorType;
        }

        $array['id'] = $ids;

        if ($fieldMappings) {
            if ( ! isset($array['fields'])) {
                $array['fields'] = [];
            }
            $array['fields'] = array_merge($array['fields'], $fieldMappings);
        }

        foreach ($metadata->associationMappings as $name => $associationMapping) {
            $cascade = [];

            if ($associationMapping['isCascadeRemove']) {
                $cascade[] = 'remove';
            }

            if ($associationMapping['isCascadePersist']) {
                $cascade[] = 'persist';
            }

            if ($associationMapping['isCascadeRefresh']) {
                $cascade[] = 'refresh';
            }

            if ($associationMapping['isCascadeMerge']) {
                $cascade[] = 'merge';
            }

            if ($associationMapping['isCascadeDetach']) {
                $cascade[] = 'detach';
            }
            if (count($cascade) === 5) {
                $cascade = ['all'];
            }

            $associationMappingArray = [
                'targetEntity' => $associationMapping['targetEntity'],
                'cascade'     => $cascade,
            ];

            if (isset($associationMapping['fetch'])) {
                $associationMappingArray['fetch'] = $this->_getFetchModeString($associationMapping['fetch']);
            }

            if (isset($associationMapping['id']) && $associationMapping['id'] === true) {
                $array['id'][$name]['associationKey'] = true;
            }

            if ($associationMapping['type'] & ClassMetadataInfo::TO_ONE) {
                $joinColumns = $associationMapping['isOwningSide'] ? $associationMapping['joinColumns'] : [];
                $newJoinColumns = [];

                foreach ($joinColumns as $joinColumn) {
                    $newJoinColumns[$joinColumn['name']]['referencedColumnName'] = $joinColumn['referencedColumnName'];

                    if (isset($joinColumn['onDelete'])) {
                        $newJoinColumns[$joinColumn['name']]['onDelete'] = $joinColumn['onDelete'];
                    }
                }

                $oneToOneMappingArray = [
                    'mappedBy'      => $associationMapping['mappedBy'],
                    'inversedBy'    => $associationMapping['inversedBy'],
                    'joinColumns'   => $newJoinColumns,
                    'orphanRemoval' => $associationMapping['orphanRemoval'],
                ];

                $associationMappingArray = array_merge($associationMappingArray, $oneToOneMappingArray);

                if ($associationMapping['type'] & ClassMetadataInfo::ONE_TO_ONE) {
                    $array['oneToOne'][$name] = $associationMappingArray;
                } else {
                    $array['manyToOne'][$name] = $associationMappingArray;
                }
            } elseif ($associationMapping['type'] == ClassMetadataInfo::ONE_TO_MANY) {
                $oneToManyMappingArray = [
                    'mappedBy'      => $associationMapping['mappedBy'],
                    'inversedBy'    => $associationMapping['inversedBy'],
                    'orphanRemoval' => $associationMapping['orphanRemoval'],
                    'orderBy'       => $associationMapping['orderBy'] ?? null
                ];

                $associationMappingArray = array_merge($associationMappingArray, $oneToManyMappingArray);
                $array['oneToMany'][$name] = $associationMappingArray;
            } elseif ($associationMapping['type'] == ClassMetadataInfo::MANY_TO_MANY) {
                $manyToManyMappingArray = [
                    'mappedBy'   => $associationMapping['mappedBy'],
                    'inversedBy' => $associationMapping['inversedBy'],
                    'joinTable'  => $associationMapping['joinTable'] ?? null,
                    'orderBy'    => $associationMapping['orderBy'] ?? null
                ];

                $associationMappingArray = array_merge($associationMappingArray, $manyToManyMappingArray);
                $array['manyToMany'][$name] = $associationMappingArray;
            }
        }
        if (isset($metadata->lifecycleCallbacks)) {
            $array['lifecycleCallbacks'] = $metadata->lifecycleCallbacks;
        }

        $array = $this->processEntityListeners($metadata, $array);

        return $this->yamlDump([$metadata->name => $array], 10);
    }

    /**
     * Dumps a PHP array to a YAML string.
     *
     * The yamlDump method, when supplied with an array, will do its best
     * to convert the array into friendly YAML.
     *
     * @param array   $array  PHP array
     * @param integer $inline [optional] The level where you switch to inline YAML
     *
     * @return string A YAML string representing the original PHP array
     */
    protected function yamlDump($array, $inline = 2)
    {
        return Yaml::dump($array, $inline);
    }

    private function processEntityListeners(ClassMetadataInfo $metadata, array $array) : array
    {
        if (0 === \count($metadata->entityListeners)) {
            return $array;
        }

        $array['entityListeners'] = [];

        foreach ($metadata->entityListeners as $event => $entityListenerConfig) {
            $array = $this->processEntityListenerConfig($array, $entityListenerConfig, $event);
        }

        return $array;
    }

    private function processEntityListenerConfig(array $array, array $entityListenerConfig, string $event) : array
    {
        foreach ($entityListenerConfig as $entityListener) {
            if (! isset($array['entityListeners'][$entityListener['class']])) {
                $array['entityListeners'][$entityListener['class']] = [];
            }

            $array['entityListeners'][$entityListener['class']][$event] = [$entityListener['method']];
        }

        return $array;
    }
}
