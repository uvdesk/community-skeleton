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
use Composer\Config\JsonConfigSource;
use Composer\Factory;
use Composer\Installer;
use Composer\Json\JsonFile;
use Composer\Package\Locker;
use Composer\Package\Version\VersionParser;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Flex\PackageResolver;
use Symfony\Flex\Unpack\Operation;
use Symfony\Flex\Unpacker;

class UnpackCommand extends BaseCommand
{
    public function __construct(PackageResolver $resolver)
    {
        $this->resolver = $resolver;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('symfony:unpack')
            ->setAliases(['unpack'])
            ->setDescription('Unpacks a Symfony pack.')
            ->setDefinition([
                new InputArgument('packages', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'Installed packages to unpack.'),
                new InputOption('sort-packages', null, InputOption::VALUE_NONE, 'Sorts packages'),
            ])
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $composer = $this->getComposer();
        $packages = $this->resolver->resolve($input->getArgument('packages'), true);
        $io = $this->getIO();
        $json = new JsonFile(Factory::getComposerFile());
        $manipulator = new JsonConfigSource($json);
        $locker = $composer->getLocker();
        $lockData = $locker->getLockData();
        $installedRepo = $composer->getRepositoryManager()->getLocalRepository();
        $versionParser = new VersionParser();

        $op = new Operation(true, $input->getOption('sort-packages') || $composer->getConfig()->get('sort-packages'));
        foreach ($versionParser->parseNameVersionPairs($packages) as $package) {
            if (null === $pkg = $installedRepo->findPackage($package['name'], '*')) {
                $io->writeError(sprintf('<error>Package %s is not installed</>', $package['name']));

                return 1;
            }

            $dev = false;
            foreach ($lockData['packages-dev'] as $p) {
                if ($package['name'] === $p['name']) {
                    $dev = true;

                    break;
                }
            }

            $op->addPackage($pkg->getName(), $pkg->getVersion(), $dev);
        }

        $unpacker = new Unpacker($composer, $this->resolver);
        $result = $unpacker->unpack($op);

        // remove the packages themselves
        if (!$result->getUnpacked()) {
            $io->writeError('<info>Nothing to unpack</>');

            return;
        }

        foreach ($result->getUnpacked() as $pkg) {
            $io->writeError(sprintf('<info>Unpacked %s dependencies</>', $pkg->getName()));
        }

        foreach ($result->getUnpacked() as $package) {
            $manipulator->removeLink('require-dev', $package->getName());
            foreach ($lockData['packages-dev'] as $i => $pkg) {
                if ($package->getName() === $pkg['name']) {
                    unset($lockData['packages-dev'][$i]);
                }
            }
            $manipulator->removeLink('require', $package->getName());
            foreach ($lockData['packages'] as $i => $pkg) {
                if ($package->getName() === $pkg['name']) {
                    unset($lockData['packages'][$i]);
                }
            }
        }
        $lockData['packages'] = array_values($lockData['packages']);
        $lockData['packages-dev'] = array_values($lockData['packages-dev']);
        $lockData['content-hash'] = $locker->getContentHash(file_get_contents($json->getPath()));
        $lockFile = new JsonFile(substr($json->getPath(), 0, -4).'lock', null, $io);
        $lockFile->write($lockData);

        // force removal of files under vendor/
        $locker = new Locker($io, $lockFile, $composer->getRepositoryManager(), $composer->getInstallationManager(), file_get_contents($json->getPath()));
        $composer->setLocker($locker);
        $install = Installer::create($io, $composer);
        $install
            ->setDevMode(true)
            ->setDumpAutoloader(false)
            ->setRunScripts(false)
            ->setSkipSuggest(true)
            ->setIgnorePlatformRequirements(true)
        ;

        return $install->run();
    }
}
