<?php

declare(strict_types=1);

namespace Doctrine\Migrations\Tools\Console\Command;

use Doctrine\Migrations\Generator\DiffGenerator;
use Doctrine\Migrations\Provider\OrmSchemaProvider;
use Doctrine\Migrations\Provider\SchemaProviderInterface;
use Doctrine\Migrations\Tools\Console\Exception\InvalidOptionUsage;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use const FILTER_VALIDATE_BOOLEAN;
use function class_exists;
use function filter_var;
use function sprintf;

/**
 * The DiffCommand class is responsible for generating a migration by comparing your current database schema to
 * your mapping information.
 */
class DiffCommand extends AbstractCommand
{
    /** @var SchemaProviderInterface|null */
    protected $schemaProvider;

    public function __construct(?SchemaProviderInterface $schemaProvider = null)
    {
        $this->schemaProvider = $schemaProvider;

        parent::__construct();
    }

    protected function configure() : void
    {
        parent::configure();

        $this
            ->setName('migrations:diff')
            ->setAliases(['diff'])
            ->setDescription('Generate a migration by comparing your current database to your mapping information.')
            ->setHelp(<<<EOT
The <info>%command.name%</info> command generates a migration by comparing your current database to your mapping information:

    <info>%command.full_name%</info>

You can optionally specify a <comment>--editor-cmd</comment> option to open the generated file in your favorite editor:

    <info>%command.full_name% --editor-cmd=mate</info>
EOT
            )
            ->addOption(
                'editor-cmd',
                null,
                InputOption::VALUE_OPTIONAL,
                'Open file with this command upon creation.'
            )
            ->addOption(
                'filter-expression',
                null,
                InputOption::VALUE_OPTIONAL,
                'Tables which are filtered by Regular Expression.'
            )
            ->addOption(
                'formatted',
                null,
                InputOption::VALUE_NONE,
                'Format the generated SQL.'
            )
            ->addOption(
                'line-length',
                null,
                InputOption::VALUE_OPTIONAL,
                'Max line length of unformatted lines.',
                120
            )
            ->addOption(
                'check-database-platform',
                null,
                InputOption::VALUE_OPTIONAL,
                'Check Database Platform to the generated code.',
                true
            );
    }

    /**
     * @throws InvalidOptionUsage
     */
    public function execute(
        InputInterface $input,
        OutputInterface $output
    ) : ?int {
        $filterExpression = $input->getOption('filter-expression') ?? null;
        $formatted        = (bool) $input->getOption('formatted');
        $lineLength       = (int) $input->getOption('line-length');
        $checkDbPlatform  = filter_var($input->getOption('check-database-platform'), FILTER_VALIDATE_BOOLEAN);

        if ($formatted) {
            if (! class_exists('SqlFormatter')) {
                throw InvalidOptionUsage::new(
                    'The "--formatted" option can only be used if the sql formatter is installed. Please run "composer require jdorn/sql-formatter".'
                );
            }
        }

        $versionNumber = $this->configuration->generateVersionNumber();

        $path = $this->createMigrationDiffGenerator()->generate(
            $versionNumber,
            $filterExpression,
            $formatted,
            $lineLength,
            $checkDbPlatform
        );

        $editorCommand = $input->getOption('editor-cmd');

        if ($editorCommand !== null) {
            $this->procOpen($editorCommand, $path);
        }

        $output->writeln([
            sprintf('Generated new migration class to "<info>%s</info>"', $path),
            '',
            sprintf(
                'To run just this migration for testing purposes, you can use <info>migrations:execute --up %s</info>',
                $versionNumber
            ),
            '',
            sprintf(
                'To revert the migration you can use <info>migrations:execute --down %s</info>',
                $versionNumber
            ),
        ]);

        return 0;
    }

    protected function createMigrationDiffGenerator() : DiffGenerator
    {
        return new DiffGenerator(
            $this->connection->getConfiguration(),
            $this->connection->getSchemaManager(),
            $this->getSchemaProvider(),
            $this->connection->getDatabasePlatform(),
            $this->dependencyFactory->getMigrationGenerator(),
            $this->dependencyFactory->getMigrationSqlGenerator()
        );
    }

    private function getSchemaProvider() : SchemaProviderInterface
    {
        if ($this->schemaProvider === null) {
            $this->schemaProvider = new OrmSchemaProvider(
                $this->getHelper('entityManager')->getEntityManager()
            );
        }

        return $this->schemaProvider;
    }
}
