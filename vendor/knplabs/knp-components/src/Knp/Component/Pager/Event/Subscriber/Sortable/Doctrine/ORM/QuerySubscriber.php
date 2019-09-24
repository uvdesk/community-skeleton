<?php

namespace Knp\Component\Pager\Event\Subscriber\Sortable\Doctrine\ORM;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Component\Pager\Event\ItemsEvent;
use Knp\Component\Pager\Event\Subscriber\Sortable\Doctrine\ORM\Query\OrderByWalker;
use Knp\Component\Pager\Event\Subscriber\Paginate\Doctrine\ORM\Query\Helper as QueryHelper;
use Doctrine\ORM\Query;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class QuerySubscriber implements EventSubscriberInterface
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

        if ($event->target instanceof Query) {
            $event->setCustomPaginationParameter('sorted', true);

            if ($this->request->query->has($event->options[PaginatorInterface::SORT_FIELD_PARAMETER_NAME])) {
                $dir = $this->request->query->has($event->options[PaginatorInterface::SORT_DIRECTION_PARAMETER_NAME]) && strtolower($this->request->query->get($event->options[PaginatorInterface::SORT_DIRECTION_PARAMETER_NAME])) === 'asc' ? 'asc' : 'desc';

                if (isset($event->options[PaginatorInterface::SORT_FIELD_WHITELIST])) {
                    if (!in_array($this->request->query->get($event->options[PaginatorInterface::SORT_FIELD_PARAMETER_NAME]), $event->options[PaginatorInterface::SORT_FIELD_WHITELIST])) {
                        throw new \UnexpectedValueException("Cannot sort by: [{$this->request->query->get($event->options[PaginatorInterface::SORT_FIELD_PARAMETER_NAME])}] this field is not in whitelist");
                    }
                }

                $sortFieldParameterNames = $this->request->query->get($event->options[PaginatorInterface::SORT_FIELD_PARAMETER_NAME]);
                $fields = [];
                $aliases = [];
                foreach (explode('+', $sortFieldParameterNames) as $sortFieldParameterName) {
                    $parts = explode('.', $sortFieldParameterName, 2);

                    // We have to prepend the field. Otherwise OrderByWalker will add
                    // the order-by items in the wrong order
                    array_unshift($fields, end($parts));
                    array_unshift($aliases, 2 <= count($parts) ? reset($parts) : false);
                }

                $event->target
                    ->setHint(OrderByWalker::HINT_PAGINATOR_SORT_DIRECTION, $dir)
                    ->setHint(OrderByWalker::HINT_PAGINATOR_SORT_FIELD, $fields)
                    ->setHint(OrderByWalker::HINT_PAGINATOR_SORT_ALIAS, $aliases)
                ;

                QueryHelper::addCustomTreeWalker($event->target, OrderByWalker::class);
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.items' => ['items', 1]
        ];
    }
}
