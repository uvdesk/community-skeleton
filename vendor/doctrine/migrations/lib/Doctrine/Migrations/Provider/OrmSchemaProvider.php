<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Provider;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\Provider\Exception\NoMappingFound;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use function count;

/**
 * The OrmSchemaProvider class is responsible for creating a Doctrine\DBAL\Schema\Schema instance from the mapping
 * information provided by the Doctrine ORM. This is then used to diff against your current database schema to produce
 * a migration to bring your database in sync with the ORM mapping information.
 *
 * @internal
 */
final class OrmSchemaProvider implements SchemaProviderInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @throws NoMappingFound
     */
    public function createSchema() : Schema
    {
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        if (count($metadata) === 0) {
            throw NoMappingFound::new();
        }

        $tool = new SchemaTool($this->entityManager);

        return $tool->getSchemaFromMetadata($metadata);
    }
}
