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

use Composer\Command\RequireCommand as BaseRequireCommand;
use Composer\Package\Version\VersionParser;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Flex\PackageResolver;
use Symfony\Flex\Unpack\Operation;
use Symfony\Flex\Unpacker;

class RequireCommand extends BaseRequireCommand
{
    private $resolver;

    public function __construct(PackageResolver $resolver)
    {
        $this->resolver = $resolver;

        parent::__construct();
    }

    protected function configure()
    {
        parent::configure();
        $this->addOption('unpack', null, InputOption::VALUE_NONE, 'Unpack Symfony packs in composer.json.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $packages = $this->resolver->resolve($input->getArgument('packages'), true);
        if ($packages) {
            $versionParser = new VersionParser();
            $op = new Operation($input->getOption('unpack'), $input->getOption('sort-packages') || $this->getComposer()->getConfig()->get('sort-packages'));
            foreach ($versionParser->parseNameVersionPairs($packages) as $package) {
                $op->addPackage($package['name'], $package['version'] ?? '', $input->getOption('dev'));
            }

            $unpacker = new Unpacker($this->getComposer(), $this->resolver);
            $result = $unpacker->unpack($op);
            $io = $this->getIO();
            foreach ($result->getUnpacked() as $pkg) {
                $io->writeError(sprintf('<info>Unpacked %s dependencies</>', $pkg->getName()));
            }

            $input->setArgument('packages', $result->getRequired());
        } elseif ($input->getOption('unpack')) {
            $this->getIO()->writeError('<error>--unpack is incompatible with the interactive mode.</error>');

            return 1;
        }

        if ($input->hasOption('no-suggest')) {
            $input->setOption('no-suggest', true);
        }

        return parent::execute($input, $output);
    }
}
