<?php


namespace Doctrine\Common\DataFixtures\Event\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs;

/**
 * Reference Listener populates identities for
 * stored references
 *
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 */
final class MongoDBReferenceListener implements EventSubscriber
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
            'postPersist'
        ];
    }

    /**
     * Populates identities for stored references
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $object = $args->getDocument();

        if (($names = $this->referenceRepository->getReferenceNames($object)) !== false) {
            foreach ($names as $name) {
                $identity = $args->getDocumentManager()
                    ->getUnitOfWork()
                    ->getDocumentIdentifier($object);

                $this->referenceRepository->setReferenceIdentity($name, $identity);
            }
        }
    }
}
