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

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use SimpleXMLElement;

/**
 * ClassMetadata exporter for Doctrine XML mapping files.
 *
 * @link    www.doctrine-project.org
 * @since   2.0
 * @author  Jonathan Wage <jonwage@gmail.com>
 */
class XmlExporter extends AbstractExporter
{
    /**
     * @var string
     */
    protected $_extension = '.dcm.xml';

    /**
     * {@inheritdoc}
     */
    public function exportClassMetadata(ClassMetadataInfo $metadata)
    {
        $xml = new SimpleXmlElement('<?xml version="1.0" encoding="utf-8"?><doctrine-mapping ' .
            'xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping" ' .
            'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ' .
            'xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd" />');

        if ($metadata->isMappedSuperclass) {
            $root = $xml->addChild('mapped-superclass');
        } else {
            $root = $xml->addChild('entity');
        }

        if ($metadata->customRepositoryClassName) {
            $root->addAttribute('repository-class', $metadata->customRepositoryClassName);
        }

        $root->addAttribute('name', $metadata->name);

        if (isset($metadata->table['name'])) {
            $root->addAttribute('table', $metadata->table['name']);
        }

        if (isset($metadata->table['schema'])) {
            $root->addAttribute('schema', $metadata->table['schema']);
        }

        if ($metadata->inheritanceType && $metadata->inheritanceType !== ClassMetadataInfo::INHERITANCE_TYPE_NONE) {
            $root->addAttribute('inheritance-type', $this->_getInheritanceTypeString($metadata->inheritanceType));
        }

        if (isset($metadata->table['options'])) {
            $optionsXml = $root->addChild('options');

            $this->exportTableOptions($optionsXml, $metadata->table['options']);
        }

        if ($metadata->discriminatorColumn) {
            $discriminatorColumnXml = $root->addChild('discriminator-column');
            $discriminatorColumnXml->addAttribute('name', $metadata->discriminatorColumn['name']);
            $discriminatorColumnXml->addAttribute('type', $metadata->discriminatorColumn['type']);

            if (isset($metadata->discriminatorColumn['length'])) {
                $discriminatorColumnXml->addAttribute('length', $metadata->discriminatorColumn['length']);
            }
        }

        if ($metadata->discriminatorMap) {
            $discriminatorMapXml = $root->addChild('discriminator-map');

            foreach ($metadata->discriminatorMap as $value => $className) {
                $discriminatorMappingXml = $discriminatorMapXml->addChild('discriminator-mapping');
                $discriminatorMappingXml->addAttribute('value', $value);
                $discriminatorMappingXml->addAttribute('class', $className);
            }
        }

        $trackingPolicy = $this->_getChangeTrackingPolicyString($metadata->changeTrackingPolicy);

        if ( $trackingPolicy != 'DEFERRED_IMPLICIT') {
            $root->addChild('change-tracking-policy', $trackingPolicy);
        }

        if (isset($metadata->table['indexes'])) {
            $indexesXml = $root->addChild('indexes');

            foreach ($metadata->table['indexes'] as $name => $index) {
                $indexXml = $indexesXml->addChild('index');
                $indexXml->addAttribute('name', $name);
                $indexXml->addAttribute('columns', implode(',', $index['columns']));
                if (isset($index['flags'])) {
                    $indexXml->addAttribute('flags', implode(',', $index['flags']));
                }
            }
        }

        if (isset($metadata->table['uniqueConstraints'])) {
            $uniqueConstraintsXml = $root->addChild('unique-constraints');

            foreach ($metadata->table['uniqueConstraints'] as $name => $unique) {
                $uniqueConstraintXml = $uniqueConstraintsXml->addChild('unique-constraint');
                $uniqueConstraintXml->addAttribute('name', $name);
                $uniqueConstraintXml->addAttribute('columns', implode(',', $unique['columns']));
            }
        }

        $fields = $metadata->fieldMappings;

        $id = [];
        foreach ($fields as $name => $field) {
            if (isset($field['id']) && $field['id']) {
                $id[$name] = $field;
                unset($fields[$name]);
            }
        }

        foreach ($metadata->associationMappings as $name => $assoc) {
            if (isset($assoc['id']) && $assoc['id']) {
                $id[$name] = [
                    'fieldName' => $name,
                    'associationKey' => true
                ];
            }
        }

        if ( ! $metadata->isIdentifierComposite && $idGeneratorType = $this->_getIdGeneratorTypeString($metadata->generatorType)) {
            $id[$metadata->getSingleIdentifierFieldName()]['generator']['strategy'] = $idGeneratorType;
        }

        if ($id) {
            foreach ($id as $field) {
                $idXml = $root->addChild('id');
                $idXml->addAttribute('name', $field['fieldName']);

                if (isset($field['type'])) {
                    $idXml->addAttribute('type', $field['type']);
                }

                if (isset($field['columnName'])) {
                    $idXml->addAttribute('column', $field['columnName']);
                }

                if (isset($field['length'])) {
                    $idXml->addAttribute('length', $field['length']);
                }

                if (isset($field['associationKey']) && $field['associationKey']) {
                    $idXml->addAttribute('association-key', 'true');
                }

                if ($idGeneratorType = $this->_getIdGeneratorTypeString($metadata->generatorType)) {
                    $generatorXml = $idXml->addChild('generator');
                    $generatorXml->addAttribute('strategy', $idGeneratorType);

                    $this->exportSequenceInformation($idXml, $metadata);
                }
            }
        }

        if ($fields) {
            foreach ($fields as $field) {
                $fieldXml = $root->addChild('field');
                $fieldXml->addAttribute('name', $field['fieldName']);
                $fieldXml->addAttribute('type', $field['type']);

                if (isset($field['columnName'])) {
                    $fieldXml->addAttribute('column', $field['columnName']);
                }

                if (isset($field['length'])) {
                    $fieldXml->addAttribute('length', $field['length']);
                }

                if (isset($field['precision'])) {
                    $fieldXml->addAttribute('precision', $field['precision']);
                }

                if (isset($field['scale'])) {
                    $fieldXml->addAttribute('scale', $field['scale']);
                }

                if (isset($field['unique']) && $field['unique']) {
                    $fieldXml->addAttribute('unique', $field['unique'] ? 'true' : 'false');
                }

                if (isset($field['options'])) {
                    $optionsXml = $fieldXml->addChild('options');
                    foreach ($field['options'] as $key => $value) {
                        $optionXml = $optionsXml->addChild('option', $value);
                        $optionXml->addAttribute('name', $key);
                    }
                }

                if (isset($field['version'])) {
                    $fieldXml->addAttribute('version', $field['version']);
                }

                if (isset($field['columnDefinition'])) {
                    $fieldXml->addAttribute('column-definition', $field['columnDefinition']);
                }

                if (isset($field['nullable'])) {
                    $fieldXml->addAttribute('nullable', $field['nullable'] ? 'true' : 'false');
                }
            }
        }

        $orderMap = [
            ClassMetadataInfo::ONE_TO_ONE,
            ClassMetadataInfo::ONE_TO_MANY,
            ClassMetadataInfo::MANY_TO_ONE,
            ClassMetadataInfo::MANY_TO_MANY,
        ];

        uasort($metadata->associationMappings, function($m1, $m2) use (&$orderMap){
            $a1 = array_search($m1['type'], $orderMap);
            $a2 = array_search($m2['type'], $orderMap);

            return strcmp($a1, $a2);
        });

        foreach ($metadata->associationMappings as $associationMapping) {
            $associationMappingXml = null;
            if ($associationMapping['type'] == ClassMetadataInfo::ONE_TO_ONE) {
                $associationMappingXml = $root->addChild('one-to-one');
            } elseif ($associationMapping['type'] == ClassMetadataInfo::MANY_TO_ONE) {
                $associationMappingXml = $root->addChild('many-to-one');
            } elseif ($associationMapping['type'] == ClassMetadataInfo::ONE_TO_MANY) {
                $associationMappingXml = $root->addChild('one-to-many');
            } elseif ($associationMapping['type'] == ClassMetadataInfo::MANY_TO_MANY) {
                $associationMappingXml = $root->addChild('many-to-many');
            }

            $associationMappingXml->addAttribute('field', $associationMapping['fieldName']);
            $associationMappingXml->addAttribute('target-entity', $associationMapping['targetEntity']);

            if (isset($associationMapping['mappedBy'])) {
                $associationMappingXml->addAttribute('mapped-by', $associationMapping['mappedBy']);
            }

            if (isset($associationMapping['inversedBy'])) {
                $associationMappingXml->addAttribute('inversed-by', $associationMapping['inversedBy']);
            }

            if (isset($associationMapping['indexBy'])) {
                $associationMappingXml->addAttribute('index-by', $associationMapping['indexBy']);
            }

            if (isset($associationMapping['orphanRemoval']) && $associationMapping['orphanRemoval'] !== false) {
                $associationMappingXml->addAttribute('orphan-removal', 'true');
            }

            if (isset($associationMapping['fetch'])) {
                $associationMappingXml->addAttribute('fetch', $this->_getFetchModeString($associationMapping['fetch']));
            }

            $cascade = [];
            if ($associationMapping['isCascadeRemove']) {
                $cascade[] = 'cascade-remove';
            }

            if ($associationMapping['isCascadePersist']) {
                $cascade[] = 'cascade-persist';
            }

            if ($associationMapping['isCascadeRefresh']) {
                $cascade[] = 'cascade-refresh';
            }

            if ($associationMapping['isCascadeMerge']) {
                $cascade[] = 'cascade-merge';
            }

            if ($associationMapping['isCascadeDetach']) {
                $cascade[] = 'cascade-detach';
            }

            if (count($cascade) === 5) {
                $cascade  = ['cascade-all'];
            }

            if ($cascade) {
                $cascadeXml = $associationMappingXml->addChild('cascade');

                foreach ($cascade as $type) {
                    $cascadeXml->addChild($type);
                }
            }

            if (isset($associationMapping['joinTable']) && $associationMapping['joinTable']) {
                $joinTableXml = $associationMappingXml->addChild('join-table');
                $joinTableXml->addAttribute('name', $associationMapping['joinTable']['name']);
                $joinColumnsXml = $joinTableXml->addChild('join-columns');

                foreach ($associationMapping['joinTable']['joinColumns'] as $joinColumn) {
                    $joinColumnXml = $joinColumnsXml->addChild('join-column');
                    $joinColumnXml->addAttribute('name', $joinColumn['name']);
                    $joinColumnXml->addAttribute('referenced-column-name', $joinColumn['referencedColumnName']);

                    if (isset($joinColumn['onDelete'])) {
                        $joinColumnXml->addAttribute('on-delete', $joinColumn['onDelete']);
                    }
                }

                $inverseJoinColumnsXml = $joinTableXml->addChild('inverse-join-columns');

                foreach ($associationMapping['joinTable']['inverseJoinColumns'] as $inverseJoinColumn) {
                    $inverseJoinColumnXml = $inverseJoinColumnsXml->addChild('join-column');
                    $inverseJoinColumnXml->addAttribute('name', $inverseJoinColumn['name']);
                    $inverseJoinColumnXml->addAttribute('referenced-column-name', $inverseJoinColumn['referencedColumnName']);

                    if (isset($inverseJoinColumn['onDelete'])) {
                        $inverseJoinColumnXml->addAttribute('on-delete', $inverseJoinColumn['onDelete']);
                    }

                    if (isset($inverseJoinColumn['columnDefinition'])) {
                        $inverseJoinColumnXml->addAttribute('column-definition', $inverseJoinColumn['columnDefinition']);
                    }

                    if (isset($inverseJoinColumn['nullable'])) {
                        $inverseJoinColumnXml->addAttribute('nullable', $inverseJoinColumn['nullable']);
                    }

                    if (isset($inverseJoinColumn['orderBy'])) {
                        $inverseJoinColumnXml->addAttribute('order-by', $inverseJoinColumn['orderBy']);
                    }
                }
            }
            if (isset($associationMapping['joinColumns'])) {
                $joinColumnsXml = $associationMappingXml->addChild('join-columns');

                foreach ($associationMapping['joinColumns'] as $joinColumn) {
                    $joinColumnXml = $joinColumnsXml->addChild('join-column');
                    $joinColumnXml->addAttribute('name', $joinColumn['name']);
                    $joinColumnXml->addAttribute('referenced-column-name', $joinColumn['referencedColumnName']);

                    if (isset($joinColumn['onDelete'])) {
                        $joinColumnXml->addAttribute('on-delete', $joinColumn['onDelete']);
                    }

                    if (isset($joinColumn['columnDefinition'])) {
                        $joinColumnXml->addAttribute('column-definition', $joinColumn['columnDefinition']);
                    }

                    if (isset($joinColumn['nullable'])) {
                        $joinColumnXml->addAttribute('nullable', $joinColumn['nullable']);
                    }
                }
            }
            if (isset($associationMapping['orderBy'])) {
                $orderByXml = $associationMappingXml->addChild('order-by');

                foreach ($associationMapping['orderBy'] as $name => $direction) {
                    $orderByFieldXml = $orderByXml->addChild('order-by-field');
                    $orderByFieldXml->addAttribute('name', $name);
                    $orderByFieldXml->addAttribute('direction', $direction);
                }
            }
        }

        if (isset($metadata->lifecycleCallbacks) && count($metadata->lifecycleCallbacks)>0) {
            $lifecycleCallbacksXml = $root->addChild('lifecycle-callbacks');

            foreach ($metadata->lifecycleCallbacks as $name => $methods) {
                foreach ($methods as $method) {
                    $lifecycleCallbackXml = $lifecycleCallbacksXml->addChild('lifecycle-callback');
                    $lifecycleCallbackXml->addAttribute('type', $name);
                    $lifecycleCallbackXml->addAttribute('method', $method);
                }
            }
        }

        $this->processEntityListeners($metadata, $root);

        return $this->_asXml($xml);
    }

    /**
     * Exports (nested) option elements.
     *
     * @param SimpleXMLElement $parentXml
     * @param array            $options
     */
    private function exportTableOptions(SimpleXMLElement $parentXml, array $options) : void
    {
        foreach ($options as $name => $option) {
            $isArray   = is_array($option);
            $optionXml = $isArray
                ? $parentXml->addChild('option')
                : $parentXml->addChild('option', (string) $option);

            $optionXml->addAttribute('name', (string) $name);

            if ($isArray) {
                $this->exportTableOptions($optionXml, $option);
            }
        }
    }

    /**
     * Export sequence information (if available/configured) into the current identifier XML node
     *
     * @param SimpleXMLElement  $identifierXmlNode
     * @param ClassMetadataInfo $metadata
     *
     * @return void
     */
    private function exportSequenceInformation(SimpleXMLElement $identifierXmlNode, ClassMetadataInfo $metadata) : void
    {
        $sequenceDefinition = $metadata->sequenceGeneratorDefinition;

        if (! ($metadata->generatorType === ClassMetadataInfo::GENERATOR_TYPE_SEQUENCE && $sequenceDefinition)) {
            return;
        }

        $sequenceGeneratorXml = $identifierXmlNode->addChild('sequence-generator');

        $sequenceGeneratorXml->addAttribute('sequence-name', $sequenceDefinition['sequenceName']);
        $sequenceGeneratorXml->addAttribute('allocation-size', $sequenceDefinition['allocationSize']);
        $sequenceGeneratorXml->addAttribute('initial-value', $sequenceDefinition['initialValue']);
    }

    private function _asXml(SimpleXMLElement $simpleXml) : string
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadXML($simpleXml->asXML());
        $dom->formatOutput = true;

        return $dom->saveXML();
    }

    private function processEntityListeners(ClassMetadataInfo $metadata, SimpleXMLElement $root): void
    {
        if (0 === \count($metadata->entityListeners)) {
            return;
        }

        $entityListenersXml = $root->addChild('entity-listeners');
        $entityListenersXmlMap = [];

        $this->generateEntityListenerXml($metadata, $entityListenersXmlMap, $entityListenersXml);
    }

    private function generateEntityListenerXml(ClassMetadataInfo $metadata, array $entityListenersXmlMap, SimpleXMLElement $entityListenersXml): void
    {
        foreach ($metadata->entityListeners as $event => $entityListenerConfig) {
            foreach ($entityListenerConfig as $entityListener) {
                $entityListenerXml = $this->addClassToMapIfExists(
                    $entityListenersXmlMap,
                    $entityListener,
                    $entityListenersXml
                );

                $entityListenerCallbackXml = $entityListenerXml->addChild('lifecycle-callback');
                $entityListenerCallbackXml->addAttribute('type', $event);
                $entityListenerCallbackXml->addAttribute('method', $entityListener['method']);
            }
        }
    }

    private function addClassToMapIfExists(array $entityListenersXmlMap, array $entityListener, SimpleXMLElement $entityListenersXml): SimpleXMLElement
    {
        if (isset($entityListenersXmlMap[$entityListener['class']])) {
            return $entityListenersXmlMap[$entityListener['class']];
        }

        $entityListenerXml = $entityListenersXml->addChild('entity-listener');
        $entityListenerXml->addAttribute('class', $entityListener['class']);
        $entityListenersXmlMap[$entityListener['class']] = $entityListenerXml;

        return $entityListenerXml;
    }
}
