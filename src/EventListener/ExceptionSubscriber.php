<?php

namespace App\EventListener;

use Twig\Environment;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionSubscriber implements EventSubscriberInterface
{
	private $container;

	public function __construct(ContainerInterface $container, Environment $twig)
	{
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
		$exception = $event->getException();

		if ($this->container->get('kernel')->getEnvironment() === 'prod') {
			if ($exception->getCode() == 403) {
				$notFoundTemplate = $this->twig->render('errors/error.html.twig', [
					'code' => 403,
					'message' => 'Access Forbidden',
					'description' => 'You are not authorized to access this page.',
				]);

				$notFoundResponse = new Response($notFoundTemplate, 403);
			} elseif ($exception instanceof NotFoundHttpException) {
				$notFoundTemplate = $this->twig->render('errors/error.html.twig', [
					'code' => 404,
					'message' => 'Page not Found',
					'description' => 'We were not able to find the page you are looking for.',
				]);

				$notFoundResponse = new Response($notFoundTemplate, 404);
			} else {
				$notFoundTemplate = $this->twig->render('errors/error.html.twig', [
					'message' => 'Internal Server Error',
					'code' => 500,
					'description' => 'Something has gone wrong on the server. Please try again later.',
				]);

				$notFoundResponse = new Response($notFoundTemplate, 500);
			}

			$event->setResponse($notFoundResponse);
		}
	}
}