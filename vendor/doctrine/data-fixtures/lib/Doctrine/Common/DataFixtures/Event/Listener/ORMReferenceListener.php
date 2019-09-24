<?php


namespace Doctrine\Common\DataFixtures\Event\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Reference Listener populates identities for
 * stored references
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 */
final class ORMReferenceListener implements EventSubscriber
{
    /**
     * @var ReferenceRepository
     */
    private $referenceRepository;

    /**
     * Initialize listener
     *
     * @param ReferenceRepository $referenceRepository
     */
    public function __construct(ReferenceRepository $referenceRepository)
    {
        $this->referenceRepository = $referenceRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            'postPersist' // would be better to use onClear, but it is supported only in 2.1
        ];
    }

    /**
     * Populates identities for stored references
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $object = $args->getEntity();

        if (($names = $this->referenceRepository->getReferenceNames($object)) !== false) {
            foreach ($names as $name) {
                $identity = $args->getEntityManager()
                    ->getUnitOfWork()
                    ->getEntityIdentifier($object);

                $this->referenceRepository->setReferenceIdentity($name, $identity);
            }
        }
    }
}
