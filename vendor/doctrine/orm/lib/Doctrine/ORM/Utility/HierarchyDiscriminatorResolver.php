<?php

namespace Doctrine\ORM\Utility;

use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @internal This class exists only to avoid code duplication, do not reuse it externally
 */
final class HierarchyDiscriminatorResolver
{
    private function __construct()
    {
    }

    /**
     * This method is needed to make INSTANCEOF work correctly with inheritance: if the class at hand has inheritance,
     * it extracts all the discriminators from the child classes and returns them
     */
    public static function resolveDiscriminatorsForClass(
        ClassMetadata $rootClassMetadata,
        EntityManagerInterface $entityManager
    ): array {
        $hierarchyClasses = $rootClassMetadata->subClasses;
        $hierarchyClasses[] = $rootClassMetadata->name;

        $discriminators = [];

        foreach ($hierarchyClasses as $class) {
            $currentMetadata = $entityManager->getClassMetadata($class);
            $currentDiscriminator = $currentMetadata->discriminatorValue;

            if (null !== $currentDiscriminator) {
                $discriminators[$currentDiscriminator] = null;
            }
        }

        return $discriminators;
    }
}
