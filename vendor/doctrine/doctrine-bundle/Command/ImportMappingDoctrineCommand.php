<?php

namespace Doctrine\Bundle\DoctrineBundle\Command;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Mapping\Driver\DatabaseDriver;
use Doctrine\ORM\Tools\Console\MetadataFilter;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Doctrine\ORM\Tools\Export\ClassMetadataExporter;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Import Doctrine ORM metadata mapping information from an existing database.
 *
 * @final
 */
class ImportMappingDoctrineCommand extends DoctrineCommand
{
    /** @var string[] */
    private $bundles;

    /**
     * @param string[] $bundles
     */
    public function __construct(ManagerRegistry $doctrine, array $bundles)
    {
        parent::__construct($doctrine);

        $this->bundles = $bundles;
    }

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('doctrine:mapping:import')
            ->addArgument('name', InputArgument::REQUIRED, 'The bundle or namespace to import the mapping information to')
            ->addArgument('mapping-type', InputArgument::OPTIONAL, 'The mapping type to export the imported mapping information to')
            ->addOption('em', null, InputOption::VALUE_OPTIONAL, 'The entity manager to use for this command')
            ->addOption('shard', null, InputOption::VALUE_REQUIRED, 'The shard connection to use for this command')
            ->addOption('filter', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'A string pattern used to match entities that should be mapped.')
            ->addOption('force', null, InputOption::VALUE_NONE, 'Force to overwrite existing mapping files.')
            ->addOption('path', null, InputOption::VALUE_REQUIRED, 'The path where the files would be generated (not used when a bundle is passed).')
            ->setDescription('Imports mapping information from an existing database')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command imports mapping information
from an existing database:

Generate annotation mappings into the src/ directory using App as the namespace:
<info>php %command.full_name% App\\\Entity annotation --path=src/Entity</info>

Generate xml mappings into the config/doctrine/ directory using App as the namespace:
<info>php %command.full_name% App\\\Entity xml --path=config/doctrine</info>

Generate XML mappings into a bundle:
<info>php %command.full_name% "MyCustomBundle" xml</info>

You can also optionally specify which entity manager to import from with the
<info>--em</info> option:

<info>php %command.full_name% "MyCustomBundle" xml --em=default</info>

If you don't want to map every entity that can be found in the database, use the
<info>--filter</info> option. It will try to match the targeted mapped entity with the
provided pattern string.

<info>php %command.full_name% "MyCustomBundle" xml --filter=MyMatchedEntity</info>

Use the <info>--force</info> option, if you want to override existing mapping files:

<info>php %command.full_name% "MyCustomBundle" xml --force</info>
EOT
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $type = $input->getArgument('mapping-type') ?: 'xml';
        if ($type === 'yaml') {
            $type = 'yml';
        }

        $namespaceOrBundle = $input->getArgument('name');
        if (isset($this->bundles[$namespaceOrBundle])) {
            $bundle    = $this->getApplication()->getKernel()->getBundle($namespaceOrBundle);
            $namespace = $bundle->getNamespace() . '\Entity';

            $destPath = $bundle->getPath();
            if ($type === 'annotation') {
                $destPath .= '/Entity';
            } else {
                $destPath .= '/Resources/config/doctrine';
            }
        } else {
            // assume a namespace has been passed
            $namespace = $namespaceOrBundle;
            $destPath  = $input->getOption('path');
            if ($destPath === null) {
                throw new InvalidArgumentException('The --path option is required when passing a namespace (e.g. --path=src). If you intended to pass a bundle name, check your spelling.');
            }
        }

        $cme      = new ClassMetadataExporter();
        $exporter = $cme->getExporter($type);
        $exporter->setOverwriteExistingFiles($input->getOption('force'));

        if ($type === 'annotation') {
            $entityGenerator = $this->getEntityGenerator();
            $exporter->setEntityGenerator($entityGenerator);
        }

        $em = $this->getEntityManager($input->getOption('em'), $input->getOption('shard'));

        $databaseDriver = new DatabaseDriver($em->getConnection()->getSchemaManager());
        $em->getConfiguration()->setMetadataDriverImpl($databaseDriver);

        $emName = $input->getOption('em');
        $emName = $emName ? $emName : 'default';

        $cmf = new DisconnectedClassMetadataFactory();
        $cmf->setEntityManager($em);
        $metadata = $cmf->getAllMetadata();
        $metadata = MetadataFilter::filter($metadata, $input->getOption('filter'));
        if ($metadata) {
            $output->writeln(sprintf('Importing mapping information from "<info>%s</info>" entity manager', $emName));
            foreach ($metadata as $class) {
                $className   = $class->name;
                $class->name = $namespace . '\\' . $className;
                if ($type === 'annotation') {
                    $path = $destPath . '/' . str_replace('\\', '.', $className) . '.php';
                } else {
                    $path = $destPath . '/' . str_replace('\\', '.', $className) . '.orm.' . $type;
                }
                $output->writeln(sprintf('  > writing <comment>%s</comment>', $path));
                $code = $exporter->exportClassMetadata($class);
                $dir  = dirname($path);
                if (! is_dir($dir)) {
                    mkdir($dir, 0775, true);
                }
                file_put_contents($path, $code);
                chmod($path, 0664);
            }

            return 0;
        }

        $output->writeln('Database does not have any mapping information.');
        $output->writeln('');

        return 1;
    }
}
