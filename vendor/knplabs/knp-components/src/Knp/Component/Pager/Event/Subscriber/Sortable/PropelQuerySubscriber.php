<?php

namespace Knp\Component\Pager\Event\Subscriber\Sortable;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Component\Pager\Event\ItemsEvent;
use Symfony\Component\HttpFoundation\Request;

class PropelQuerySubscriber implements EventSubscriberInterface
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function items(ItemsEvent $event): void
    {
        // Check if the result has already been sorted by an other sort subscriber
        $customPaginationParameters = $event->getCustomPaginationParameters();
        if (!empty($customPaginationParameters['sorted']) ) {
            return;
        }

        $query = $event->target;
        if ($query instanceof \ModelCriteria) {
            $event->setCustomPaginationParameter('sorted', true);

            if ($this->request->query->has($event->options[PaginatorInterface::SORT_FIELD_PARAMETER_NAME])) {
                $part = $this->request->query->get($event->options[PaginatorInterface::SORT_FIELD_PARAMETER_NAME]);
                $directionParam = $event->options[PaginatorInterface::SORT_DIRECTION_PARAMETER_NAME];

                $direction = ($this->request->query->has($directionParam) && strtolower($this->request->query->get($directionParam)) === 'asc')
                                ? 'asc' : 'desc';

                if (isset($event->options[PaginatorInterface::SORT_FIELD_WHITELIST])) {
                    if (!in_array($this->request->query->get($event->options[PaginatorInterface::SORT_FIELD_PARAMETER_NAME]), $event->options[PaginatorInterface::SORT_FIELD_WHITELIST])) {
                        throw new \UnexpectedValueException("Cannot sort by: [{$this->request->query->get($event->options[PaginatorInterface::SORT_FIELD_PARAMETER_NAME])}] this field is not in whitelist");
                    }
                }

                $query->orderBy($part, $direction);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'knp_pager.items' => ['items', 1]
        ];
    }
}
