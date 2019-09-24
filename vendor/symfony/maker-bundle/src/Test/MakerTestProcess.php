<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Test;

use Symfony\Component\Process\Process;

/**
 * @author Sadicov Vladimir <sadikoff@gmail.com>
 *
 * @internal
 */
final class MakerTestProcess
{
    private $process;

    private function __construct($commandLine, $cwd, array $envVars, $timeout)
    {
        $this->process = method_exists(Process::class, 'fromShellCommandline')
            ? Process::fromShellCommandline($commandLine, $cwd, null, null, $timeout)
            : new Process($commandLine, $cwd, null, null, $timeout);

        $this->process->setEnv($envVars);
    }

    public static function create($commandLine, $cwd, array $envVars = [], $timeout = null): self
    {
        return new self($commandLine, $cwd, $envVars, $timeout);
    }

    public function setInput($input): self
    {
        $this->process->setInput($input);

        return $this;
    }

    public function run($allowToFail = false, array $envVars = []): self
    {
        $this->process->run(null, $envVars);

        if (!$allowToFail && !$this->process->isSuccessful()) {
            throw new \Exception(sprintf(
                'Error running command: "%s". Output: "%s". Error: "%s"',
                $this->process->getCommandLine(),
                $this->process->getOutput(),
                $this->process->getErrorOutput()
            ));
        }

        return $this;
    }

    public function isSuccessful()
    {
        return $this->process->isSuccessful();
    }

    public function getOutput()
    {
        return $this->process->getOutput();
    }

    public function getErrorOutput()
    {
        return $this->process->getErrorOutput();
    }
}
