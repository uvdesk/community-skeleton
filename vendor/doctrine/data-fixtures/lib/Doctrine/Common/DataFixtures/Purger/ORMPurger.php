<?php

namespace Doctrine\Common\DataFixtures\Purger;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\DataFixtures\Sorter\TopologicalSorter;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use function array_search;
use function is_callable;
use function preg_match;

/**
 * Class responsible for purging databases of data before reloading data fixtures.
 *
 * @author Jonathan H. Wage <jonwage@gmail.com>
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 */
class ORMPurger implements PurgerInterface
{
    const PURGE_MODE_DELETE = 1;
    const PURGE_MODE_TRUNCATE = 2;

    /** EntityManagerInterface instance used for persistence. */
    private $em;

    /**
     * If the purge should be done through DELETE or TRUNCATE statements
     *
     * @var int
     */
    private $purgeMode = self::PURGE_MODE_DELETE;

    /**
    * Table/view names to be excleded from purge
    *
    * @var string[]
    */
    private $excluded;

    /**
     * Construct new purger instance.
     *
     * @param EntityManagerInterface $em EntityManagerInterface instance used for persistence.
     * @param string[] $excluded array of table/view names to be excleded from purge
     */
    public function __construct(EntityManagerInterface $em = null, array $excluded = [])
    {
        $this->em = $em;
        $this->excluded = $excluded;
    }

    /**
     * Set the purge mode
     *
     * @param $mode
     * @return void
     */
    public function setPurgeMode($mode)
    {
        $this->purgeMode = $mode;
    }

    /**
     * Get the purge mode
     *
     * @return int
     */
    public function getPurgeMode()
    {
        return $this->purgeMode;
    }

    /**
     * Set the EntityManagerInterface instance this purger instance should use.
     *
     * @param EntityManagerInterface $em
     */
    public function setEntityManager(EntityManagerInterface $em)
    {
      $this->em = $em;
    }

    /**
     * Retrieve the EntityManagerInterface instance this purger instance is using.
     *
     * @return \Doctrine\ORM\EntityManagerInterface
     */
    public function getObjectManager()
    {
        return $this->em;
    }

    /** @inheritDoc */
    public function purge()
    {
        $classes = [];

        foreach ($this->em->getMetadataFactory()->getAllMetadata() as $metadata) {
            if (! $metadata->isMappedSuperclass && ! (isset($metadata->isEmbeddedClass) && $metadata->isEmbeddedClass)) {
                $classes[] = $metadata;
            }
        }

        $commitOrder = $this->getCommitOrder($this->em, $classes);

        // Get platform parameters
        $platform = $this->em->getConnection()->getDatabasePlatform();

        // Drop association tables first
        $orderedTables = $this->getAssociationTables($commitOrder, $platform);

        // Drop tables in reverse commit order
        for ($i = count($commitOrder) - 1; $i >= 0; --$i) {
            $class = $commitOrder[$i];

            if (
                (isset($class->isEmbeddedClass) && $class->isEmbeddedClass) ||
                $class->isMappedSuperclass ||
                ($class->isInheritanceTypeSingleTable() && $class->name !== $class->rootEntityName)
            ) {
                continue;
            }

            $orderedTables[] = $this->getTableName($class, $platform);
        }

        $connection = $this->em->getConnection();
        $filterExpr = $connection->getConfiguration()->getFilterSchemaAssetsExpression();
        $emptyFilterExpression = empty($filterExpr);

        $schemaAssetsFilter = method_exists($connection->getConfiguration(), 'getSchemaAssetsFilter') ? $connection->getConfiguration()->getSchemaAssetsFilter() : null;

        foreach($orderedTables as $tbl) {
            // If we have a filter expression, check it and skip if necessary
            if (!$emptyFilterExpression && !preg_match($filterExpr, $tbl)) {
                continue;
            }

            // If the table is excluded, skip it as well
            if (array_search($tbl, $this->excluded) !== false) {
                continue;
            }

            // Support schema asset filters as presented in
            if (is_callable($schemaAssetsFilter) && !$schemaAssetsFilter($tbl)) {
                continue;
            }

            if ($this->purgeMode === self::PURGE_MODE_DELETE) {
                $connection->executeUpdate("DELETE FROM " . $tbl);
            } else {
                $connection->executeUpdate($platform->getTruncateTableSQL($tbl, true));
            }
        }
    }

    /**
     * @param EntityManagerInterface $em
     * @param ClassMetadata[]        $classes
     *
     * @return ClassMetadata[]
     */
    private function getCommitOrder(EntityManagerInterface $em, array $classes)
    {
        $sorter = new TopologicalSorter();

        foreach ($classes as $class) {
            if ( ! $sorter->hasNode($class->name)) {
                $sorter->addNode($class->name, $class);
            }

            // $class before its parents
            foreach ($class->parentClasses as $parentClass) {
                $parentClass     = $em->getClassMetadata($parentClass);
                $parentClassName = $parentClass->getName();

                if ( ! $sorter->hasNode($parentClassName)) {
                    $sorter->addNode($parentClassName, $parentClass);
                }

                $sorter->addDependency($class->name, $parentClassName);
            }

            foreach ($class->associationMappings as $assoc) {
                if ($assoc['isOwningSide']) {
                    /* @var $targetClass ClassMetadata */
                    $targetClass     = $em->getClassMetadata($assoc['targetEntity']);
                    $targetClassName = $targetClass->getName();

                    if ( ! $sorter->hasNode($targetClassName)) {
                        $sorter->addNode($targetClassName, $targetClass);
                    }

                    // add dependency ($targetClass before $class)
                    $sorter->addDependency($targetClassName, $class->name);

                    // parents of $targetClass before $class, too
                    foreach ($targetClass->parentClasses as $parentClass) {
                        $parentClass     = $em->getClassMetadata($parentClass);
                        $parentClassName = $parentClass->getName();

                        if ( ! $sorter->hasNode($parentClassName)) {
                            $sorter->addNode($parentClassName, $parentClass);
                        }

                        $sorter->addDependency($parentClassName, $class->name);
                    }
                }
            }
        }

        return array_reverse($sorter->sort());
    }

    /**
     * @param array $classes
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return array
     */
    private function getAssociationTables(array $classes, AbstractPlatform $platform)
    {
        $associationTables = [];

        foreach ($classes as $class) {
            foreach ($class->associationMappings as $assoc) {
                if ($assoc['isOwningSide'] && $assoc['type'] == ClassMetadata::MANY_TO_MANY) {
                    $associationTables[] = $this->getJoinTableName($assoc, $class, $platform);
                }
            }
        }

        return $associationTables;
    }

    /**
     *
     * @param \Doctrine\ORM\Mapping\ClassMetadata $class
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    private function getTableName($class, $platform)
    {
        if (isset($class->table['schema']) && !method_exists($class, 'getSchemaName')) {
            return $class->table['schema'].'.'.$this->em->getConfiguration()->getQuoteStrategy()->getTableName($class, $platform);
        }

        return $this->em->getConfiguration()->getQuoteStrategy()->getTableName($class, $platform);
    }

    /**
     *
     * @param array            $association
     * @param \Doctrine\ORM\Mapping\ClassMetadata    $class
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @return string
     */
    private function getJoinTableName($assoc, $class, $platform)
    {
        if (isset($assoc['joinTable']['schema']) && !method_exists($class, 'getSchemaName')) {
            return $assoc['joinTable']['schema'].'.'.$this->em->getConfiguration()->getQuoteStrategy()->getJoinTableName($assoc, $class, $platform);
        }

        return $this->em->getConfiguration()->getQuoteStrategy()->getJoinTableName($assoc, $class, $platform);
    }
}
