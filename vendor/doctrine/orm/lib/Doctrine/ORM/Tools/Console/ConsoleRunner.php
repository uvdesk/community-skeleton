<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM\Tools\Console;

use Doctrine\DBAL\Tools\Console as DBALConsole;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\Version;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * Handles running the Console Tools inside Symfony Console context.
 */
final class ConsoleRunner
{
    /**
     * Create a Symfony Console HelperSet
     *
     * @param EntityManagerInterface $entityManager
     *
     * @return HelperSet
     */
    public static function createHelperSet(EntityManagerInterface $entityManager) : HelperSet
    {
        return new HelperSet(
            [
                'db' => new DBALConsole\Helper\ConnectionHelper($entityManager->getConnection()),
                'em' => new EntityManagerHelper($entityManager),
            ]
        );
    }

    /**
     * Runs console with the given helper set.
     *
     * @param \Symfony\Component\Console\Helper\HelperSet  $helperSet
     * @param \Symfony\Component\Console\Command\Command[] $commands
     *
     * @return void
     */
    public static function run(HelperSet $helperSet, array $commands = []) : void
    {
        $cli = self::createApplication($helperSet, $commands);
        $cli->run();
    }

    /**
     * Creates a console application with the given helperset and
     * optional commands.
     *
     * @param \Symfony\Component\Console\Helper\HelperSet $helperSet
     * @param array                                       $commands
     *
     * @return \Symfony\Component\Console\Application
     */
    public static function createApplication(HelperSet $helperSet, array $commands = []) : Application
    {
        $cli = new Application('Doctrine Command Line Interface', Version::VERSION);
        $cli->setCatchExceptions(true);
        $cli->setHelperSet($helperSet);
        self::addCommands($cli);
        $cli->addCommands($commands);

        return $cli;
    }

    /**
     * @param Application $cli
     *
     * @return void
     */
    public static function addCommands(Application $cli) : void
    {
        $cli->addCommands(
            [
                // DBAL Commands
                new DBALConsole\Command\ImportCommand(),
                new DBALConsole\Command\ReservedWordsCommand(),
                new DBALConsole\Command\RunSqlCommand(),

                // ORM Commands
                new Command\ClearCache\CollectionRegionCommand(),
                new Command\ClearCache\EntityRegionCommand(),
                new Command\ClearCache\MetadataCommand(),
                new Command\ClearCache\QueryCommand(),
                new Command\ClearCache\QueryRegionCommand(),
                new Command\ClearCache\ResultCommand(),
                new Command\SchemaTool\CreateCommand(),
                new Command\SchemaTool\UpdateCommand(),
                new Command\SchemaTool\DropCommand(),
                new Command\EnsureProductionSettingsCommand(),
                new Command\ConvertDoctrine1SchemaCommand(),
                new Command\GenerateRepositoriesCommand(),
                new Command\GenerateEntitiesCommand(),
                new Command\GenerateProxiesCommand(),
                new Command\ConvertMappingCommand(),
                new Command\RunDqlCommand(),
                new Command\ValidateSchemaCommand(),
                new Command\InfoCommand(),
                new Command\MappingDescribeCommand(),
            ]
        );
    }

    public static function printCliConfigTemplate() : void
    {
        echo <<<'HELP'
You are missing a "cli-config.php" or "config/cli-config.php" file in your
project, which is required to get the Doctrine Console working. You can use the
following sample as a template:

<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once 'bootstrap.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = GetEntityManager();

return ConsoleRunner::createHelperSet($entityManager);

HELP;
    }
}
