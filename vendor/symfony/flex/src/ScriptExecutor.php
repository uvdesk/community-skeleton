<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex;

use Composer\Composer;
use Composer\EventDispatcher\ScriptExecutionException;
use Composer\IO\IOInterface;
use Composer\Semver\Constraint\EmptyConstraint;
use Composer\Util\ProcessExecutor;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Process\PhpExecutableFinder;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ScriptExecutor
{
    private $composer;
    private $io;
    private $options;
    private $executor;

    public function __construct(Composer $composer, IOInterface $io, Options $options, ProcessExecutor $executor = null)
    {
        $this->composer = $composer;
        $this->io = $io;
        $this->options = $options;
        $this->executor = $executor ?: new ProcessExecutor();
    }

    /**
     * @throws ScriptExecutionException if the executed command returns a non-0 exit code
     */
    public function execute(string $type, string $cmd)
    {
        $parsedCmd = $this->options->expandTargetDir($cmd);
        if (null === $expandedCmd = $this->expandCmd($type, $parsedCmd)) {
            return;
        }

        $cmdOutput = new StreamOutput(fopen('php://temp', 'rw'), OutputInterface::VERBOSITY_VERBOSE, $this->io->isDecorated());
        $outputHandler = function ($type, $buffer) use ($cmdOutput) {
            $cmdOutput->write($buffer, false, OutputInterface::OUTPUT_RAW);
        };

        $this->io->writeError(sprintf('Executing script %s', $parsedCmd), $this->io->isVerbose());
        $exitCode = $this->executor->execute($expandedCmd, $outputHandler);

        $code = 0 === $exitCode ? ' <info>[OK]</info>' : ' <error>[KO]</error>';

        if ($this->io->isVerbose()) {
            $this->io->writeError(sprintf('Executed script %s %s', $cmd, $code));
        } else {
            $this->io->writeError($code);
        }

        if (0 !== $exitCode) {
            $this->io->writeError(' <error>[KO]</error>');
            $this->io->writeError(sprintf('<error>Script %s returned with error code %s</error>', $cmd, $exitCode));
            fseek($cmdOutput->getStream(), 0);
            foreach (explode("\n", stream_get_contents($cmdOutput->getStream())) as $line) {
                $this->io->writeError('!!  '.$line);
            }

            throw new ScriptExecutionException($cmd, $exitCode);
        }
    }

    private function expandCmd(string $type, string $cmd)
    {
        switch ($type) {
            case 'symfony-cmd':
                return $this->expandSymfonyCmd($cmd);
            case 'php-script':
                return $this->expandPhpScript($cmd);
            case 'script':
                return $cmd;
            default:
                throw new \InvalidArgumentException(sprintf('Invalid symfony/flex auto-script in composer.json: "%s" is not a valid type of command.', $type));
        }
    }

    private function expandSymfonyCmd(string $cmd)
    {
        $repo = $this->composer->getRepositoryManager()->getLocalRepository();
        if (!$repo->findPackage('symfony/console', new EmptyConstraint())) {
            $this->io->writeError(sprintf('<warning>Skipping "%s" (needs symfony/console to run).</warning>', $cmd));

            return null;
        }

        $console = ProcessExecutor::escape($this->options->get('root-dir').'/'.$this->options->get('bin-dir').'/console');
        if ($this->io->isDecorated()) {
            $console .= ' --ansi';
        }

        return $this->expandPhpScript($console.' '.$cmd);
    }

    private function expandPhpScript(string $cmd): string
    {
        $phpFinder = new PhpExecutableFinder();
        if (!$php = $phpFinder->find(false)) {
            throw new \RuntimeException('The PHP executable could not be found, add it to your PATH and try again.');
        }

        $arguments = $phpFinder->findArguments();

        if ($env = (string) (getenv('COMPOSER_ORIGINAL_INIS'))) {
            $paths = explode(PATH_SEPARATOR, $env);
            $ini = array_shift($paths);
        } else {
            $ini = php_ini_loaded_file();
        }

        if ($ini) {
            $arguments[] = '--php-ini='.$ini;
        }

        $phpArgs = implode(' ', array_map([ProcessExecutor::class, 'escape'], $arguments));

        return ProcessExecutor::escape($php).($phpArgs ? ' '.$phpArgs : '').' '.$cmd;
    }
}
