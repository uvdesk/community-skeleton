<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Flex\Command;

use Composer\Command\BaseCommand;
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\Factory;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Flex\Event\UpdateEvent;
use Symfony\Flex\Lock;

class SyncRecipesCommand extends BaseCommand
{
    private $flex;
    private $rootDir;

    public function __construct(/* cannot be type-hinted */ $flex, string $rootDir)
    {
        $this->flex = $flex;
        $this->rootDir = $rootDir;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('symfony:sync-recipes')
            ->setAliases(['sync-recipes', 'fix-recipes'])
            ->setDescription('Installs or reinstalls recipes for already installed packages.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Ignore the "symfony.lock" file and overwrite existing files')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $win = '\\' === \DIRECTORY_SEPARATOR;
        $force = $input->getOption('force');

        if ($force && !@is_executable(strtok(exec($win ? 'where git' : 'command -v git'), PHP_EOL))) {
            throw new RuntimeException('Cannot run "sync-recipes --force": git not found.');
        }

        $symfonyLock = new Lock(getenv('SYMFONY_LOCKFILE') ?: str_replace('composer.json', 'symfony.lock', Factory::getComposerFile()));
        $composer = $this->getComposer();
        $locker = $composer->getLocker();
        $lockData = $locker->getLockData();

        $packages = [];
        foreach ($lockData['packages'] as $pkg) {
            if ($force || !$symfonyLock->has($pkg['name'])) {
                $packages[] = $pkg['name'];
            }
        }
        foreach ($lockData['packages-dev'] as $pkg) {
            if ($force || !$symfonyLock->has($pkg['name'])) {
                $packages[] = $pkg['name'];
            }
        }

        if (!$packages) {
            return;
        }

        $composer = $this->getComposer();
        $installedRepo = $composer->getRepositoryManager()->getLocalRepository();
        $io = $this->getIO();

        $operations = [];
        foreach ($packages as $package) {
            if (null === $pkg = $installedRepo->findPackage($package, '*')) {
                $io->writeError(sprintf('<error>Package %s is not installed</>', $package));

                return 1;
            }

            $operations[] = new InstallOperation($pkg);
        }

        if ($createEnvLocal = $force && file_exists($this->rootDir.'/.env') && file_exists($this->rootDir.'/.env.dist') && !file_exists($this->rootDir.'/.env.local')) {
            rename($this->rootDir.'/.env', $this->rootDir.'/.env.local');
            $pipes = [];
            proc_close(proc_open(sprintf('git mv .env.dist .env > %s 2>&1 || %s .env.dist .env', $win ? 'NUL' : '/dev/null', $win ? 'rename' : 'mv'), $pipes, $pipes, $this->rootDir));
            if (file_exists($this->rootDir.'/phpunit.xml.dist')) {
                touch($this->rootDir.'/.env.test');
            }
        }

        $this->flex->update(new UpdateEvent($force), $operations);

        if ($force) {
            $output = [
                '',
                '<bg=blue;fg=white>                                                    </>',
                '<bg=blue;fg=white> Config files are now reset to their initial state. </>',
                '<bg=blue;fg=white>                                                    </>',
                '',
                '  * Use <comment>git diff</comment> to inspect the changes.',
                '',
                '    Not all of the changes will be relevant to your app: you now',
                '    need to selectively add or revert them using e.g. a combination',
                '    of <comment>git add -p</> and <comment>git checkout -p</>',
                '',
            ];

            if ($createEnvLocal) {
                $output[] = '    Dotenv files have been renamed: .env -> .env.local and .env.dist -> .env';
                $output[] = '    See https://symfony.com/doc/current/configuration/dot-env-changes.html';
                $output[] = '';
            }

            $output[] = '  * Use <comment>git checkout .</> to revert the changes.';
            $output[] = '';

            if ($createEnvLocal) {
                $output[] = '    To revert the changes made to .env files, run';
                $output[] = sprintf('    <comment>git mv %s.env %1$s.env.dist</> && <comment>%s %1$s.env.local %1$s.env</>', '.' !== $this->rootDir ? $this->rootDir.'/' : '', $win ? 'rename' : 'mv');
                $output[] = '';
            }

            $output[] = '    New (untracked) files can be inspected using <comment>git clean --dry-run</>';
            $output[] = '    Add the new files you want to keep using <comment>git add</>';
            $output[] = '    then delete the rest using <comment>git clean --force</>';
            $output[] = '';

            $io->write($output);
        }
    }
}
