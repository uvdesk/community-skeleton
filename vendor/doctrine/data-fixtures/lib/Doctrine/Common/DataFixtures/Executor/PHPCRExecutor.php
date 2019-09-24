<?php

namespace Doctrine\Common\DataFixtures\Executor;

use Doctrine\ODM\PHPCR\DocumentManagerInterface;
use Doctrine\Common\DataFixtures\Purger\PHPCRPurger;

/**
 * Class responsible for executing data fixtures.
 *
 * @author Jonathan H. Wage <jonwage@gmail.com>
 * @author Daniel Barsotti <daniel.barsotti@liip.ch>
 */
class PHPCRExecutor extends AbstractExecutor
{
    /**
     * @var DocumentManagerInterface
     */
    private $dm;

    /**
     * @param DocumentManagerInterface $dm     manager instance used for persisting the fixtures
     * @param PHPCRPurger              $purger to remove the current data if append is false
     */
    public function __construct(DocumentManagerInterface $dm, PHPCRPurger $purger = null)
    {
        parent::__construct($dm);

        $this->dm = $dm;
        if ($purger !== null) {
            $purger->setDocumentManager($dm);
            $this->setPurger($purger);
        }
    }

    public function getObjectManager()
    {
        return $this->dm;
    }

    /** @inheritDoc */
    public function execute(array $fixtures, $append = false)
    {
        $that = $this;

        $function = function ($dm) use ($append, $that, $fixtures) {
            if ($append === false) {
                $that->purge();
            }

            foreach ($fixtures as $fixture) {
                $that->load($dm, $fixture);
            }
        };

        if (method_exists($this->dm, 'transactional')) {
            $this->dm->transactional($function);
        } else {
            $function($this->dm);
        }
    }
}

