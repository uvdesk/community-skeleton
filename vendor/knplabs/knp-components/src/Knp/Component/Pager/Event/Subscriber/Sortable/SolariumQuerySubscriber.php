<?php

namespace Knp\Component\Pager\Event\Subscriber\Sortable;

use Knp\Component\Pager\Event\ItemsEvent;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Solarium query sorting
 *
 * @author Marek Kalnik <marekk@theodo.fr>
 */
class SolariumQuerySubscriber implements EventSubscriberInterface
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

        if (is_array($event->target) && 2 === count($event->target)) {
            $values = array_values($event->target);
            [$client, $query] = $values;

            if ($client instanceof \Solarium\Client && $query instanceof \Solarium\QueryType\Select\Query\Query) {
                $event->setCustomPaginationParameter('sorted', true);
                if ($this->request->query->has($event->options[PaginatorInterface::SORT_FIELD_PARAMETER_NAME])) {
                    if (isset($event->options[PaginatorInterface::SORT_FIELD_WHITELIST])) {
                        if (!in_array($this->request->query->get($event->options[PaginatorInterface::SORT_FIELD_PARAMETER_NAME]), $event->options[PaginatorInterface::SORT_FIELD_WHITELIST])) {
                            throw new \UnexpectedValueException("Cannot sort by: [{$this->request->query->get($event->options[PaginatorInterface::SORT_FIELD_PARAMETER_NAME])}] this field is not in whitelist");
                        }
                    }

                    $query->addSort($this->request->query->get($event->options[PaginatorInterface::SORT_FIELD_PARAMETER_NAME]), $this->getSortDirection($event));
                }
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // trigger before the pagination subscriber
            'knp_pager.items' => ['items', 1],
        ];
    }

    private function getSortDirection($event): string
    {
        return $this->request->query->has($event->options[PaginatorInterface::SORT_DIRECTION_PARAMETER_NAME]) &&
            strtolower($this->request->query->get($event->options[PaginatorInterface::SORT_DIRECTION_PARAMETER_NAME])) === 'asc' ? 'asc' : 'desc';
    }
}
