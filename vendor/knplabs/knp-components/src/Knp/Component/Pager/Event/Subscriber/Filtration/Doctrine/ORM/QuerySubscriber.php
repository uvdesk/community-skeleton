<?php

namespace Knp\Component\Pager\Event\Subscriber\Filtration\Doctrine\ORM;

use Doctrine\ORM\Query;
use Knp\Component\Pager\Event\ItemsEvent;
use Knp\Component\Pager\Event\Subscriber\Filtration\Doctrine\ORM\Query\WhereWalker;
use Knp\Component\Pager\Event\Subscriber\Paginate\Doctrine\ORM\Query\Helper as QueryHelper;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;

class QuerySubscriber implements EventSubscriberInterface
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(?Request $request)
    {
        $this->request = $request ?? Request::createFromGlobals();
    }

    public function items(ItemsEvent $event): void
    {
        if ($event->target instanceof Query) {
            $filterValue = $this->getQueryParameter($event->options[PaginatorInterface::FILTER_VALUE_PARAMETER_NAME]);
            if (null === $filterValue || (empty($filterValue) && $filterValue !== '0')) {
                return;
            }
            $filterName = $this->getQueryParameter($event->options[PaginatorInterface::FILTER_FIELD_PARAMETER_NAME]);
            if (!empty($filterName)) {
                $columns = $filterName;
            } elseif (!empty($event->options[PaginatorInterface::DEFAULT_FILTER_FIELDS])) {
                $columns = $event->options[PaginatorInterface::DEFAULT_FILTER_FIELDS];
            } else {
                return;
            }
            $value = $this->getQueryParameter($event->options[PaginatorInterface::FILTER_VALUE_PARAMETER_NAME]);
            if (false !== strpos($value, '*')) {
                $value = str_replace('*', '%', $value);
            }
            if (is_string($columns) && false !== strpos($columns, ',')) {
                $columns = explode(',', $columns);
            }
            $columns = (array) $columns;
            if (isset($event->options[PaginatorInterface::FILTER_FIELD_WHITELIST])) {
                foreach ($columns as $column) {
                    if (!in_array($column, $event->options[PaginatorInterface::FILTER_FIELD_WHITELIST])) {
                        throw new \UnexpectedValueException("Cannot filter by: [{$column}] this field is not in whitelist");
                    }
                }
            }
            $event->target
                    ->setHint(WhereWalker::HINT_PAGINATOR_FILTER_VALUE, $value)
                    ->setHint(WhereWalker::HINT_PAGINATOR_FILTER_COLUMNS, $columns);
            QueryHelper::addCustomTreeWalker($event->target, WhereWalker::class);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.items' => ['items', 0],
        ];
    }

    private function getQueryParameter(string $name): ?string
    {
        return $this->request->query->get($name);
    }
}
