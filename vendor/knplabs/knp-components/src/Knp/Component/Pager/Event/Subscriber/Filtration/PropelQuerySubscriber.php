<?php

namespace Knp\Component\Pager\Event\Subscriber\Filtration;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\Event\ItemsEvent;

class PropelQuerySubscriber implements EventSubscriberInterface
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
        $query = $event->target;
        if ($query instanceof \ModelCriteria) {
            if (!$this->request->query->has($event->options[PaginatorInterface::FILTER_VALUE_PARAMETER_NAME])) {
                return;
            }
            if ($this->request->query->has($event->options[PaginatorInterface::FILTER_FIELD_PARAMETER_NAME])) {
                $columns = $this->request->query->get($event->options[PaginatorInterface::FILTER_FIELD_PARAMETER_NAME]);
            } elseif (!empty($event->options[PaginatorInterface::DEFAULT_FILTER_FIELDS])) {
                $columns = $event->options[PaginatorInterface::DEFAULT_FILTER_FIELDS];
            } else {
                return;
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
            $value = $this->request->query->get($event->options[PaginatorInterface::FILTER_VALUE_PARAMETER_NAME]);
            $criteria = \Criteria::EQUAL;
            if (false !== strpos($value, '*')) {
                $value = str_replace('*', '%', $value);
                $criteria = \Criteria::LIKE;
            }
            foreach ($columns as $column) {
                if (false !== strpos($column, '.')) {
                    $query->where($column.$criteria.'?', $value);
                } else {
                    $query->{'filterBy'.$column}($value, $criteria);
                }
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'knp_pager.items' => ['items', 0],
        ];
    }
}
