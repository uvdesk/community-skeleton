<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Event;

use Symfony\Bundle\MakerBundle\Exception\RuntimeCommandException;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Prints certain exceptions in a pretty way and silences normal exception handling.
 *
 * @author Ryan Weaver <ryan@knpuniversity.com>
 */
final class ConsoleErrorSubscriber implements EventSubscriberInterface
{
    private $setExitCode = false;

    public function onConsoleError(ConsoleErrorEvent $event)
    {
        if (!$event->getError() instanceof RuntimeCommandException) {
            return;
        }

        // prevent any visual logging from appearing
        $event->stopPropagation();
        // prevent the exception from actually being thrown
        $event->setExitCode(0);
        $this->setExitCode = true;

        $io = new SymfonyStyle($event->getInput(), $event->getOutput());
        $io->error($event->getError()->getMessage());
    }

    public function onConsoleTerminate(ConsoleTerminateEvent $event)
    {
        if (!$this->setExitCode) {
            return;
        }

        // finally set a non-zero exit code
        $event->setExitCode(1);
    }

    public static function getSubscribedEvents()
    {
        return [
            ConsoleEvents::ERROR => 'onConsoleError',
            ConsoleEvents::TERMINATE => 'onConsoleTerminate',
        ];
    }
}
