<?php

namespace Doctrine\Bundle\DoctrineBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Mapping\DisconnectedMetadataFactory;
use Doctrine\ORM\Tools\EntityRepositoryGenerator;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Generate entity classes from mapping information
 *
 * @final
 */
class GenerateEntitiesDoctrineCommand extends DoctrineCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('doctrine:generate:entities')
            ->setAliases(['generate:doctrine:entities'])
            ->setDescription('Generates entity classes and method stubs from your mapping information')
            ->addArgument('name', InputArgument::REQUIRED, 'A bundle name, a namespace, or a class name')
            ->addOption('path', null, InputOption::VALUE_REQUIRED, 'The path where to generate entities when it cannot be guessed')
            ->addOption('no-backup', null, InputOption::VALUE_NONE, 'Do not backup existing entities files.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command generates entity classes
and method stubs from your mapping information:

You have to limit generation of entities:

* To a bundle:

  <info>php %command.full_name% MyCustomBundle</info>

* To a single entity:

  <info>php %command.full_name% MyCustomBundle:User</info>
  <info>php %command.full_name% MyCustomBundle/Entity/User</info>

* To a namespace

  <info>php %command.full_name% MyCustomBundle/Entity</info>

If the entities are not stored in a bundle, and if the classes do not exist,
the command has no way to guess where they should be generated. In this case,
you must provide the <comment>--path</comment> option:

  <info>php %command.full_name% Blog/Entity --path=src/</info>

By default, the unmodified version of each entity is backed up and saved
(e.g. Product.php~). To prevent this task from creating the backup file,
pass the <comment>--no-backup</comment> option:

  <info>php %command.full_name% Blog/Entity --no-backup</info>

<error>Important:</error> Even if you specified Inheritance options in your
XML or YAML Mapping files the generator cannot generate the base and
child classes for you correctly, because it doesn't know which
class is supposed to extend which. You have to adjust the entity
code manually for inheritance to work!

EOT
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        trigger_error('The doctrine:generate:entity command has been deprecated.', E_USER_DEPRECATED);
        $output->writeln([
            ' <comment>NOTE:</comment> The <info>doctrine:generate:entities</info> command has been deprecated.',
            '       To read more about the differences between anemic and rich models go here <info>http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/getting-started.html#adding-behavior-to-entities</info>.',
            '       If you wish to generate your entities, use <info>make:entity --regenerate</info> from MakerBundle instead.',
        ]);

        $manager = new DisconnectedMetadataFactory($this->getDoctrine());

        try {
            $bundle = $this->getApplication()->getKernel()->getBundle($input->getArgument('name'));

            $output->writeln(sprintf('Generating entities for bundle "<info>%s</info>"', $bundle->getName()));
            $metadata = $manager->getBundleMetadata($bundle);
        } catch (InvalidArgumentException $e) {
            $name = strtr($input->getArgument('name'), '/', '\\');
            $pos  = strpos($name, ':');

            if ($pos !== false) {
                $name = $this->getDoctrine()->getAliasNamespace(substr($name, 0, $pos)) . '\\' . substr($name, $pos + 1);
            }

            if (class_exists($name)) {
                $output->writeln(sprintf('Generating entity "<info>%s</info>"', $name));
                $metadata = $manager->getClassMetadata($name, $input->getOption('path'));
            } else {
                $output->writeln(sprintf('Generating entities for namespace "<info>%s</info>"', $name));
                $metadata = $manager->getNamespaceMetadata($name, $input->getOption('path'));
            }
        }

        $generator = $this->getEntityGenerator();

        $backupExisting = ! $input->getOption('no-backup');
        $generator->setBackupExisting($backupExisting);

        $repoGenerator = new EntityRepositoryGenerator();
        foreach ($metadata->getMetadata() as $m) {
            if ($backupExisting) {
                $basename = substr($m->name, strrpos($m->name, '\\') + 1);
                $output->writeln(sprintf('  > backing up <comment>%s.php</comment> to <comment>%s.php~</comment>', $basename, $basename));
            }
            // Getting the metadata for the entity class once more to get the correct path if the namespace has multiple occurrences
            try {
                $entityMetadata = $manager->getClassMetadata($m->getName(), $input->getOption('path'));
            } catch (RuntimeException $e) {
                // fall back to the bundle metadata when no entity class could be found
                $entityMetadata = $metadata;
            }

            $output->writeln(sprintf('  > generating <comment>%s</comment>', $m->name));
            $generator->generate([$m], $entityMetadata->getPath());

            if (! $m->customRepositoryClassName || strpos($m->customRepositoryClassName, $metadata->getNamespace()) === false) {
                continue;
            }

            $repoGenerator->writeEntityRepositoryClass($m->customRepositoryClassName, $metadata->getPath());
        }
    }
}
