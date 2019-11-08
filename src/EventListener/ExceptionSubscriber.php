<?php

namespace App\EventListener;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionSubscriber implements EventSubscriberInterface
{
	private $user;
	private $twig;
	private $container;

	public function __construct(Environment $twig, ContainerInterface $container, UserInterface $user = null)
	{
		$this->user = $user;
		$this->twig = $twig;
		$this->container = $container;
	}

	public static function getSubscribedEvents()
	{
		return [
			KernelEvents::EXCEPTION => [
				['onKernelException', 10]
			]
		];
	}

	public function onKernelException(ExceptionEvent $event)
	{
		// We only need to suppress errors in production environment
		if ($this->container->get('kernel')->getEnvironment() != 'prod') {
			return;
		}

		// @TODO: We need to take into account the response type as well (html, xml, json)
		$exception = $event->getException();

		if ($exception->getCode() == 403) {
			// On forbidden exception, we need to either:
			// 		a) If user session is set, display forbidden page
			// 		b) If user session is not set, redirect to login page

			if (!empty($this->user)) {
				$template = $this->twig->render('errors/error.html.twig', [
					'code' => 403,
					'message' => 'Access Forbidden',
					'description' => 'You are not authorized to access this page.',
				]);
	
				$event->setResponse(new Response($template, 403));
			}
		} else {
			if ($exception instanceof NotFoundHttpException) {
				$template = $this->twig->render('errors/error.html.twig', [
					'code' => 404,
					'message' => 'Page not Found',
					'description' => 'We were not able to find the page you are looking for.',
				]);
	
				$event->setResponse(new Response($template, 404));
			} else {
				$template = $this->twig->render('errors/error.html.twig', [
					'message' => 'Internal Server Error',
					'code' => 500,
					'description' => 'Something has gone wrong on the server. Please try again later.',
				]);
	
				$event->setResponse(new Response($template, 500));
			}
		}
	}
}