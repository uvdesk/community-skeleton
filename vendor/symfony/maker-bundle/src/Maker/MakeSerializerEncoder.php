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

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Serializer\Serializer;

/**
 * @author Piotr Grabski-Gradzinski <piotr.gradzinski@gmail.com>
 */
final class MakeSerializerEncoder extends AbstractMaker
{
    public static function getCommandName(): string
    {
        return 'make:serializer:encoder';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConf)
    {
        $command
            ->setDescription('Creates a new serializer encoder class')
            ->addArgument('name', InputArgument::OPTIONAL, 'Choose a class name for your encoder (e.g. <fg=yellow>YamlEncoder</>)')
            ->addArgument('format', InputArgument::OPTIONAL, 'Pick your format name (e.g. <fg=yellow>yaml</>)')
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeSerializerEncoder.txt'))
        ;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $encoderClassNameDetails = $generator->createClassNameDetails(
            $input->getArgument('name'),
            'Serializer\\',
            'Encoder'
        );
        $format = $input->getArgument('format');

        $generator->generateClass(
            $encoderClassNameDetails->getFullName(),
            'serializer/Encoder.tpl.php',
            [
                'format' => $format,
            ]
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $io->text([
            'Next: Open your new serializer encoder class and start customizing it.',
            'Find the documentation at <fg=yellow>http://symfony.com/doc/current/serializer/custom_encoders.html</>',
        ]);
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
        $dependencies->addClassDependency(
            Serializer::class,
            'serializer'
        );
    }
}
