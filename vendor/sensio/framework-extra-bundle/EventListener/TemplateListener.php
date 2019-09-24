<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\FrameworkExtraBundle\EventListener;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Templating\TemplateGuesser;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Handles the Template annotation for actions.
 *
 * Depends on pre-processing of the ControllerListener.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class TemplateListener implements EventSubscriberInterface
{
    private $templateGuesser;
    private $twig;

    public function __construct(TemplateGuesser $templateGuesser, \Twig_Environment $twig = null)
    {
        $this->templateGuesser = $templateGuesser;
        $this->twig = $twig;
    }

    /**
     * Guesses the template name to render and its variables and adds them to
     * the request object.
     */
    public function onKernelController(KernelEvent $event)
    {
        $request = $event->getRequest();
        $template = $request->attributes->get('_template');

        if (!$template instanceof Template) {
            return;
        }

        $controller = $event->getController();
        if (!\is_array($controller) && method_exists($controller, '__invoke')) {
            $controller = [$controller, '__invoke'];
        }
        $template->setOwner($controller);

        // when no template has been given, try to resolve it based on the controller
        if (null === $template->getTemplate()) {
            $template->setTemplate($this->templateGuesser->guessTemplateName($controller, $request));
        }
    }

    /**
     * Renders the template and initializes a new response object with the
     * rendered template content.
     */
    public function onKernelView(KernelEvent $event)
    {
        /* @var Template $template */
        $request = $event->getRequest();
        $template = $request->attributes->get('_template');

        if (!$template instanceof Template) {
            return;
        }

        if (null === $this->twig) {
            throw new \LogicException('You can not use the "@Template" annotation if the Twig Bundle is not available.');
        }

        $parameters = $event->getControllerResult();
        $owner = $template->getOwner();
        list($controller, $action) = $owner;

        // when the annotation declares no default vars and the action returns
        // null, all action method arguments are used as default vars
        if (null === $parameters) {
            $parameters = $this->resolveDefaultParameters($request, $template, $controller, $action);
        }

        // attempt to render the actual response
        if ($template->isStreamable()) {
            $callback = function () use ($template, $parameters) {
                $this->twig->display($template->getTemplate(), $parameters);
            };

            $event->setResponse(new StreamedResponse($callback));
        } else {
            $event->setResponse(new Response($this->twig->render($template->getTemplate(), $parameters)));
        }

        // make sure the owner (controller+dependencies) is not cached or stored elsewhere
        $template->setOwner([]);
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', -128],
            KernelEvents::VIEW => 'onKernelView',
        ];
    }

    private function resolveDefaultParameters(Request $request, Template $template, $controller, $action)
    {
        $parameters = [];
        $arguments = $template->getVars();

        if (0 === \count($arguments)) {
            $r = new \ReflectionObject($controller);

            $arguments = [];
            foreach ($r->getMethod($action)->getParameters() as $param) {
                $arguments[] = $param;
            }
        }

        // fetch the arguments of @Template.vars or everything if desired
        // and assign them to the designated template
        foreach ($arguments as $argument) {
            if ($argument instanceof \ReflectionParameter) {
                $parameters[$name = $argument->getName()] = !$request->attributes->has($name) && $argument->isDefaultValueAvailable() ? $argument->getDefaultValue() : $request->attributes->get($name);
            } else {
                $parameters[$argument] = $request->attributes->get($argument);
            }
        }

        return $parameters;
    }
}
