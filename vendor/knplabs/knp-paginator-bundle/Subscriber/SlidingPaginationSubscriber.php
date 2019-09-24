<?php

namespace Knp\Bundle\PaginatorBundle\Subscriber;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Event\PaginationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

final class SlidingPaginationSubscriber implements EventSubscriberInterface
{
    private $route;
    private $params = [];
    private $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

        $request = $event->getRequest();

        $this->route = $request->attributes->get('_route');
        $this->params = \array_merge($request->query->all(), $request->attributes->get('_route_params', []));
        foreach ($this->params as $key => $param) {
            if ('_' == \substr($key, 0, 1)) {
                unset($this->params[$key]);
            }
        }
    }

    public function pagination(PaginationEvent $event): void
    {
        // default sort field and order
        $eventOptions = $event->options;

        if (isset($eventOptions['defaultSortFieldName']) && !isset($this->params[$eventOptions['sortFieldParameterName']])) {
            $this->params[$eventOptions['sortFieldParameterName']] = $eventOptions['defaultSortFieldName'];
        }

        if (isset($eventOptions['defaultSortDirection']) && !isset($this->params[$eventOptions['sortDirectionParameterName']])) {
            $this->params[$eventOptions['sortDirectionParameterName']] = $eventOptions['defaultSortDirection'];
        }

        $pagination = new SlidingPagination($this->params);

        $pagination->setUsedRoute($this->route);
        $pagination->setTemplate($this->options['defaultPaginationTemplate']);
        $pagination->setSortableTemplate($this->options['defaultSortableTemplate']);
        $pagination->setFiltrationTemplate($this->options['defaultFiltrationTemplate']);
        $pagination->setPageRange($this->options['defaultPageRange']);

        $event->setPagination($pagination);
        $event->stopPropagation();
    }

    public static function getSubscribedEvents()
    {
        return [
            'knp_pager.pagination' => ['pagination', 1],
        ];
    }
}
