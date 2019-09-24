<?php

namespace Doctrine\DBAL\Tools\Console\Command;

use Doctrine\DBAL\Driver\PDOConnection;
use Doctrine\DBAL\Driver\PDOStatement;
use InvalidArgumentException;
use PDOException;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use const PHP_EOL;
use function assert;
use function file_exists;
use function file_get_contents;
use function is_readable;
use function realpath;
use function sprintf;

/**
 * Task for executing arbitrary SQL that can come from a file or directly from
 * the command line.
 *
 * @deprecated Use a database client application instead
 */
class ImportCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
        ->setName('dbal:import')
        ->setDescription('Import SQL file(s) directly to Database.')
        ->setDefinition([new InputArgument(
            'file',
            InputArgument::REQUIRED | InputArgument::IS_ARRAY,
            'File path(s) of SQL to be executed.'
        ),
        ])
        ->setHelp(<<<EOT
Import SQL file(s) directly to Database.
EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $conn = $this->getHelper('db')->getConnection();

        $fileNames = $input->getArgument('file');

        if ($fileNames === null) {
            return null;
        }

        foreach ((array) $fileNames as $fileName) {
            $filePath = realpath($fileName);

            // Phar compatibility.
            if ($filePath === false) {
                $filePath = $fileName;
            }

            if (! file_exists($filePath)) {
                throw new InvalidArgumentException(
                    sprintf("SQL file '<info>%s</info>' does not exist.", $filePath)
                );
            } elseif (! is_readable($filePath)) {
                throw new InvalidArgumentException(
                    sprintf("SQL file '<info>%s</info>' does not have read permissions.", $filePath)
                );
            }

            $output->write(sprintf("Processing file '<info>%s</info>'... ", $filePath));
            $sql = file_get_contents($filePath);

            if ($conn instanceof PDOConnection) {
                // PDO Drivers
                try {
                    $lines = 0;

                    $stmt = $conn->prepare($sql);
                    assert($stmt instanceof PDOStatement);

                    $stmt->execute();

                    do {
                        // Required due to "MySQL has gone away!" issue
                        $stmt->fetch();
                        $stmt->closeCursor();

                        $lines++;
                    } while ($stmt->nextRowset());

                    $output->write(sprintf('%d statements executed!', $lines) . PHP_EOL);
                } catch (PDOException $e) {
                    $output->write('error!' . PHP_EOL);

                    throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
                }
            } else {
                // Non-PDO Drivers (ie. OCI8 driver)
                $stmt = $conn->prepare($sql);
                $rs   = $stmt->execute();

                if (! $rs) {
                    $error = $stmt->errorInfo();

                    $output->write('error!' . PHP_EOL);

                    throw new RuntimeException($error[2], $error[0]);
                }

                $output->writeln('OK!' . PHP_EOL);

                $stmt->closeCursor();
            }
        }

        return null;
    }
}
