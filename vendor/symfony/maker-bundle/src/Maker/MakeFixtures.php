<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Maker;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Mapping\Column;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

/**
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Ryan Weaver <weaverryan@gmail.com>
 */
final class MakeFixtures extends AbstractMaker
{
    public static function getCommandName(): string
    {
        return 'make:fixtures';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConf)
    {
        $command
            ->setDescription('Creates a new class to load Doctrine fixtures')
            ->addArgument('fixtures-class', InputArgument::OPTIONAL, 'The class name of the fixtures to create (e.g. <fg=yellow>AppFixtures</>)')
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeFixture.txt'))
        ;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $fixturesClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('fixtures-class'),
            'DataFixtures\\'
        );

        $generator->generateClass(
            $fixturesClassNameDetails->getFullName(),
            'doctrine/Fixtures.tpl.php',
            []
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $io->text([
            'Next: Open your new fixtures class and start customizing it.',
            sprintf('Load your fixtures by running: <comment>php %s doctrine:fixtures:load</comment>', $_SERVER['PHP_SELF']),
            'Docs: <fg=yellow>https://symfony.com/doc/master/bundles/DoctrineFixturesBundle/index.html</>',
        ]);
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        $dependencies->addClassDependency(
            Column::class,
            'doctrine'
        );
        $dependencies->addClassDependency(
            Fixture::class,
            'orm-fixtures',
            true,
            true
        );
    }
}
