<?php

namespace App\Console\Wizard;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ConfigureHelpdesk extends Command
{
    /**
     * Api endpoint
     *
     * @var string
     */
    protected const API_ENDPOINT = 'https://updates.uvdesk.com/api/updates';

    CONST CLS = "\033[H"; // Clear screen
    CONST CLL = "\033[K"; // Clear line
    CONST MCH = "\033[2J"; // Move cursor home
    CONST MCA = "\033[1A"; // Move cursor up one point

    private $container;
    private $entityManager;
    private $questionHelper;

    private $userName;
    private $userEmail;
    private $userInstance;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('uvdesk:configure-helpdesk')
            ->setDescription('Scans through your helpdesk setup to check for any mis-configurations.')
        ;
        
        $this
            ->addOption('no-interaction', 'n', \Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Do not ask any interactive questions')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->consoleInput = $input;
        $this->consoleOutput = $output;
        $this->questionHelper = $this->getHelper('question');
        $this->projectDirectory = $this->container->getParameter('kernel.project_dir');
        
        $env = $this->projectDirectory.'/.env';
        $var = $this->projectDirectory.'/var';
        $config = $this->projectDirectory.'/config';
        $public = $this->projectDirectory.'/public';
        $migrations = $this->projectDirectory.'/migrations';

        $noInteraction = $input->getOption('no-interaction');

        $files = [
            'env'        => $env,
            'var'        => $var,
            'config'     => $config,
            'public'     => $public,
            'migrations' => $migrations,
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                chmod($file, 0775);
            }
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write([self::MCH, self::CLS]);
        $output->writeln("\n<comment>  Examining helpdesk setup for any configuration issues:</comment>\n");
        list($db_host, $db_port, $db_name, $db_user, $db_password) = $this->getUpdatedDatabaseCredentials();
        

        // Check 1: Verify database connection
        $output->writeln("  [-] Establishing a connection with database server");

        if (extension_loaded('redis')) {
            $output->writeln("\n<fg=red;>  [x] Redis extension is loaded");
            $output->writeln("\n     Please check this <href=https://github.com/uvdesk/community-skeleton/issues/364#issuecomment-780486976>link</> for Redis configuration instructions, in case there is an issue <comment>(connection refused) </comment>while connecting to database.
     You can add your Redis server host details in the Setup.php file instead of the default port as mentioned in the link.If there are no issues, you can simply 
     ignore this message.</>\n\n");
        }

        list($isServerAccessible, $isDatabaseAccessible) = $this->refreshDatabaseConnection($db_host, $db_port, $db_name, $db_user, $db_password);

        if (false == $isServerAccessible || false == $isDatabaseAccessible) {
            $output->writeln("<fg=red;>  [x]</> Unable to establish a connection with database server</>");

            

            if (!$noInteraction) {

                // Interactively prompt user to re-configure their database
                $interactiveQuestion = new Question("\n      <comment>Proceed with re-configuring your database credentials? [Y/N]</comment> ", 'Y');

                if ('Y' === strtoupper($this->questionHelper->ask($input, $output, $interactiveQuestion))) {
                    $continue = false;
                    $output->write([self::MCA, self::CLL, self::MCA, self::CLL]);

                    do {
                        $continue = false;
                        $output->writeln("\n      <comment>Please enter the following details:</comment>\n");

                        $db_host = $this->askInteractiveQuestion("<info>Database Host</info>: ", '127.0.0.1', 6, false, false, "Please enter a host address");
                        $db_port = $this->askInteractiveQuestion("<info>Database Port</info>: ", '3306', 6, false, false, "Please enter a host port number");
                        $db_name = $this->askInteractiveQuestion("<info>Database Name</info>: ", null, 6, false, false, "Please enter name of the database you wish to connect with");
                        $db_user = $this->askInteractiveQuestion("<info>Database User Name</info>: ", null, 6, false, false, "Please enter your user name to connect with the database");
                        $db_password = $this->askInteractiveQuestion("<info>Database User Password</info>: ", null, 6, false, true, "Please enter your user password to connect with the database");

                        $output->write([self::MCA, self::CLL, self::MCA, self::CLL, self::MCA, self::CLL]);

                        list($isServerAccessible, $isDatabaseAccessible) = $this->refreshDatabaseConnection($db_host, $db_port, $db_name, $db_user, $db_password);

                        if (false == $isServerAccessible) {
                            $interactiveQuestion = new Question("\n      <comment>Unable to connect with your database server, please check the details provided.\n      Do you wish to try again? [Y/N]</comment> ", 'Y');

                            if ('Y' === strtoupper($this->questionHelper->ask($input, $output, $interactiveQuestion))) {
                                $continue = true;
                            }

                            $output->write([self::MCA, self::CLL, self::MCA, self::CLL, self::MCA, self::CLL]);
                        } else if (false == $isDatabaseAccessible) {
                            $interactiveQuestion = new Question("\n      <comment>Database <comment>$db_name</comment> does not exist. Proceed with creating database? [Y/N]</comment> ", 'Y');

                            if ('Y' === strtoupper($this->questionHelper->ask($input, $output, $interactiveQuestion))) {
                                $output->write([self::MCA, self::CLL, self::MCA, self::CLL]);

                                // Create Database
                                if (false == $this->createDatabase($db_host, $db_port, $db_name, $db_user, $db_password)) {
                                    $output->writeln([
                                        "<fg=red;>  [x]</> An unexpected error occurred while trying to create database <comment>$db_name</comment>.</>",
                                        "\n  Exiting evaluation process.\n"
                                    ]);
                                }
                            } else {
                                $output->write([self::MCA, self::CLL, self::MCA, self::CLL]);

                                $interactiveQuestion = new Question("\n      <comment>Unable to connect with your database server, please check the details provided.\n      Do you wish to try again? [Y/N]</comment> ", 'Y');

                                if ('Y' === strtoupper($this->questionHelper->ask($input, $output, $interactiveQuestion))) {
                                    $continue = true;
                                }

                                $output->write([self::MCA, self::CLL, self::MCA, self::CLL, self::MCA, self::CLL]);
                            }
                        }
                    } while (true == $continue);

                    list($isServerAccessible, $isDatabaseAccessible) = $this->refreshDatabaseConnection($db_host, $db_port, $db_name, $db_user, $db_password);

                    if (true == $isServerAccessible && true == $isDatabaseAccessible) {
                        $databaseUrl = sprintf("mysql://%s:%s@%s:%s/%s", $db_user, $db_password, $db_host, $db_port, $db_name);

                        $output->writeln("\n  [-] Switching to database <info>$db_name</info>");

                        try {
                            $process = new Process(["php", "bin/console", "uvdesk_wizard:env:update", "DATABASE_URL", $databaseUrl]);
                            $process->setWorkingDirectory($this->projectDirectory);
                            $process->mustRun();

                            $output->writeln("  <info>[v]</info> Successfully switched to database <info>$db_name</info>\n");
                        } catch (\Exception $e) {
                            $output->writeln([
                                "<fg=red;>  [x]</> Failed to update .env with updated database credentials.</>",
                                "\n  Exiting evaluation process.\n"
                            ]);

                            return 1;
                        }
                    } else {
                        $output->writeln("\n  Exiting evaluation process.\n");

                        return 1;
                    }
                } else {
                    $output->write(["\033[1A", "\033[K", "\033[1A", "\033[K"]);
                    $output->writeln("\n  Exiting evaluation process.\n");

                    return 1;
                }
            } else {
                throw new \RuntimeException("Unable to establish a connection with the database server. Please provide a working database connection or use the interactive mode");
            }
        } else {
            $output->writeln("  <info>[v]</info> Successfully established a connection with database <info>$db_name</info>\n");
        }
        
        // Check 2: Ensure entities have been loaded
        $output->writeln("  [-] Comparing the <info>$db_name</info> database schema with the current mapping metadata.");
        
        try {
            // Get the current database migration version
            $currentMigrationVersion = $this->getLatestMigrationVersion(new BufferedOutput());

            // Version migrations
            $process = new Process(["php", "bin/console", "doctrine:migrations:version", "--add", "--all", "--no-interaction"]);
            $process->setWorkingDirectory($this->projectDirectory);
            $process->run();

            // Compare the current database migration version against database and create a new migration version accordingly.
            $process = new Process(["php", "bin/console", "doctrine:migrations:diff", "--quiet"]);
            $process->setWorkingDirectory($this->projectDirectory);
            $process->mustRun();

            $process = new Process(["php", "bin/console", "doctrine:migrations:status", "--quiet"]);
            $process->setWorkingDirectory($this->projectDirectory);
            $process->run();

            // Get the latest database migration version
            $latestMigrationVersion = $this->getLatestMigrationVersion(new BufferedOutput());

            if ($currentMigrationVersion != $latestMigrationVersion) {
                $output->writeln("  <comment>[!]</comment> The current database schema is not up-to-date with the current mapping metadata.");

                if (!$noInteraction) {

                    $interactiveQuestion = new Question("\n      <comment>Update your database schema to the current mapping metadata? [Y/N]</comment> ", 'Y');

                    if ('Y' !== strtoupper($this->questionHelper->ask($input, $output, $interactiveQuestion))) {
                        $output->writeln([
                            "\n  <comment>[!]</comment> Skipping database schema migration.",
                            "\n  Exiting evaluation process.\n"
                        ]);

                        return 1;
                    }
                }

                $output->writeln([
                    "",
                    "      Please wait while your database is being migrated from version <comment>$currentMigrationVersion</comment> to <info>$latestMigrationVersion</info>.",
                    "      This could take up to a few minutes.\n",
                ]);

                try {
                    // Migrate database to latest schematic version
                    $process = new Process(["php", "bin/console", "doctrine:migrations:migrate", "--no-interaction", "--quiet"]);
                    $process->setTimeout(900);
                    $process->setWorkingDirectory($this->projectDirectory);
                    $process->mustRun();

                    // Load database fixtures to populate initial dataset
                    $process = new Process(["php", "bin/console", "doctrine:fixtures:load", "--append"]);
                    $process->setTimeout(120);
                    $process->setWorkingDirectory($this->projectDirectory);
                    $process->run();

                    $output->writeln("  <info>[v]</info> Database successfully migrated from version <comment>$currentMigrationVersion</comment> to <info>$latestMigrationVersion</info>.\n");
                } catch (\Exception $e) {
                    $output->writeln([
                        "\n  <fg=red;>[x]</> Unable to successfully migrate to latest database schematic version.",
                        "\n  Exiting evaluation process.\n"
                    ]);

                    return 1;
                }
            } else {
                $output->writeln([
                    "\n  <fg=red;>[x]</> Unable to correctly determine database schema version.",
                    "\n  Exiting evaluation process.\n"
                ]);

                return 1;
            }
        } catch (\Exception $e) {
            // Database is up-to-date. Do nothing.
            $output->writeln("  <info>[v]</info> The current database schema is up-to-date with the current mapping metdata.\n");
        }

        // Check 3: Check if super admin account exists
        $output->writeln("  [-] Checking if an active super admin account exists");

        $database = new \PDO("mysql:host=$db_host:$db_port;dbname=$db_name", $db_user, $db_password);

        $supportRoleQuery = $database->query("SELECT * FROM uv_support_role WHERE code = 'ROLE_SUPER_ADMIN'");
        $supportRole = $supportRoleQuery->fetch(\PDO::FETCH_ASSOC);

        $userInstanceQuery = $database->query("SELECT * FROM uv_user_instance WHERE supportRole_id = " . $supportRole['id']);
        $userInstance = $userInstanceQuery->fetch(\PDO::FETCH_ASSOC);

        // Get user based on the user instance
        if ($userInstance) {
            $userQuery = $database->query("SELECT * FROM uv_user WHERE id = " . $userInstance['user_id']);
            $user = $userQuery->fetch(\PDO::FETCH_ASSOC);
            $this->userInstance = $user;
        }

        if (empty($userInstance)) {
            $output->writeln("  <comment>[!]</comment> No active user account found with super admin privileges.");

            if (!$noInteraction) {
                $interactiveQuestion = new Question("\n      <comment>Create a new user account with super admin privileges? [Y/N]</comment> ", 'Y');

                if ('Y' === strtoupper($this->questionHelper->ask($input, $output, $interactiveQuestion))) {
                    $output->write(["\033[1A", "\033[K", "\033[1A", "\033[K"]);
                    $output->writeln("\n      <comment>Please enter the following details:</comment>\n");

                    $warningFlag = false;

                    do {
                        $u_email = $this->askInteractiveQuestion("<info>Email</info>: ", null, 6, false, false, "Please enter a valid email address");
                        $u_email = filter_var($u_email, FILTER_SANITIZE_EMAIL);
                        $this->userEmail = $u_email;

                        if ($warningFlag) {
                            $output->write([self::MCA, self::CLL]);
                        }

                        if (false == filter_var($u_email, FILTER_VALIDATE_EMAIL)) {
                            $output->writeln("      <comment>Warning</comment>: <comment>$u_email</comment> is not a valid email address");
                            $warningFlag = true;
                        }
                    } while (false == filter_var($u_email, FILTER_VALIDATE_EMAIL));

                    $u_name = $this->askInteractiveQuestion("<info>Name</info>: ", null, 6, false, false, "Please enter your name");

                    $warningFlag = false;
                    $this->userName = $u_name;

                    do {
                        $u_password = $this->askInteractiveQuestion("<info>Password</info>: ", null, 6, false, true, "Please enter your password");
                        $u_cpassword = $this->askInteractiveQuestion("<info>Confirm Password</info>: ", null, 6, false, true, "Please enter your password");

                        if ($warningFlag) {
                            $output->write([self::MCA, self::CLL]);
                        }

                        if ($u_password != $u_cpassword) {
                            $output->writeln("      <comment>Warning</comment>: Passwords do not match");
                            $warningFlag = true;
                        }
                    } while ($u_password != $u_cpassword);

                    $output->write([self::MCA, self::CLL, self::MCA, self::CLL, self::MCA, self::CLL]);

                } else {
                    $output->writeln("\n  <comment>[!]</comment> Skipping creation of a super admin account.");
                    return 1;
                }
            } else {
                // Default admin credentials
                $u_email = getenv('SUPERUSER_EMAIL') ?? $_ENV['SUPERUSER_EMAIL'] ?? ($_SERVER['SUPERUSER_EMAIL'] ?? $env['SUPERUSER_EMAIL'] ?? "admin@example.com");
                $u_name = getenv('SUPERUSER_NAME') ?? $_ENV['SUPERUSER_NAME'] ?? ($_SERVER['SUPERUSER_NAME'] ?? $env['SUPERUSER_NAME'] ?? "UVdesk Admin");
                $u_password = getenv('SUPERUSER_PASSWORD') ?? $_ENV['SUPERUSER_PASSWORD'] ?? ($_SERVER['SUPERUSER_PASSWORD'] ?? $env['SUPERUSER_PASSWORD'] ?? "password");

                $this->userEmail = $u_email;
                $this->userName = $u_name;
            }

            $output->writeln("\n      <comment>Creating a new user account with super admin privileges...</comment>\n");

            try {
                $process = new Process(["php", "bin/console", "uvdesk_wizard:defaults:create-user", "ROLE_SUPER_ADMIN",  trim($u_name), $u_email, $u_password, '--no-interaction']);

                $process->setWorkingDirectory($this->projectDirectory);
                $process->mustRun();

                $output->writeln("  <info>[v]</info> User account created successfully.\n");
            } catch (ProcessFailedException $e) {
                // Do nothing ...
                $output->writeln([
                    "  <fg=red;>[x]</> An unexpected error occurred while creating the user account.\n",
                    "\n  Exiting evaluation process.\n"
                ]);

                return 1;
            }
        } else {
            $output->writeln("  <info>[v]</info> An account with support role <comment>SUPER_ADMIN</comment> exists.\n");
        }

        $output->writeln("  Exiting evaluation process.\n");

        if (
            ! $this->userEmail
            && ! $this->userName
        ) {
            $this->userEmail = $this->userInstance['email'];
            $this->userName = $this->userInstance['first_name'] . ' ' . $this->userInstance['last_name'];
        }

        $userDetails =[
            'name'   => $this->userName,
            'email'  => $this->userEmail,
            'domain' => $this->container->getParameter('uvdesk.site_url'),
        ];

        // uvdesk tracker
        $this->addUserDetailsInTracker($userDetails);

        return Command::SUCCESS;
    }

    /**
     * This method create a record in the uvdesk tracker during installation of the project via terminal or    widget installer 
     * 
     * @param array $userDetails
     * @throws \Exception
     * @return void
     */
    public static function addUserDetailsInTracker($userDetails = [])
    {
        try {
            // Initialize cURL session
            $ch = curl_init(self::API_ENDPOINT);

            // Set the headers
            $headers = [
                'Accept: application/json',
                'Content-Type: application/json',
            ];

            // Prepare the data to be sent in JSON format
            $data = [
                'domain'       => $userDetails['domain'],
                'email'        => $userDetails['email'],
                'name'         => $userDetails['name'],
                'country_code' => null,
            ];

            // Convert data to JSON
            $jsonData = json_encode($data);

            // Set cURL options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

            // Execute cURL request
            $response = curl_exec($ch);

            // Check if any error occurred
            if ($response === false) {
                $error = curl_error($ch);
                $errorCode = curl_errno($ch);
                throw new \Exception("cURL Error: $error (Code: $errorCode)");
            }

            // Close cURL session
            curl_close($ch);
        } catch (\Exception $e) {
        }
    }

    /**
     * Checks whether the given database params are valid or not.
     *
     * @param string $host
     * @param string $port
     * @param string $name
     * @param string $user
     * @param string $password
     * 
     * @return boolean
     */
    private function refreshDatabaseConnection($host, $port, $name, $user, $password)
    {
        $response = [
            'isServerAccessible'   => true,
            'isDatabaseAccessible' => true,
        ];

        $entityManager = EntityManager::create([
            'driver'   => 'pdo_mysql',
            "host"     => $host,
            "port"     => $port,
            'user'     => $user,
            'password' => $password,
        ], Setup::createAnnotationMetadataConfiguration(['src/Entity'], false));
        
        $databaseConnection = $entityManager->getConnection();

        if (false == $databaseConnection->isConnected()) {
            try {
                $databaseConnection->connect();
                $response['isServerAccessible'] = true;

            } catch (\Doctrine\DBAL\DBALException $e) {
                return false;
            }
        }

        if (! in_array($name, $databaseConnection->getSchemaManager()->listDatabases())) {
            $response['isDatabaseAccessible'] = false;
        }

        return [$response['isServerAccessible'], $response['isDatabaseAccessible']];
    }

    /**
     * Creates a database if not found.
     *
     * @param string $host
     * @param string $port
     * @param string $name
     * @param string $user
     * @param string $password
     * 
     * @return boolean
     */
    private function createDatabase($host, $port, $name, $user, $password)
    {
        $entityManager = EntityManager::create([
            'driver'   => 'pdo_mysql',
            "host"     => $host,
            "port"     => $port,
            'user'     => $user,
            'password' => $password,
        ], Setup::createAnnotationMetadataConfiguration(['src/Entity'], false));
        
        $databaseConnection = $entityManager->getConnection();

        if (false == $databaseConnection->isConnected()) {
            try {
                $databaseConnection->connect();
            } catch (\Doctrine\DBAL\DBALException $e) {
                return false;
            }
        }

        if (! in_array($name, $databaseConnection->getSchemaManager()->listDatabases())) {
            try {
                // Create database
                $databaseConnection->getSchemaManager()->createDatabase($databaseConnection->getDatabasePlatform()->quoteSingleIdentifier($name));
            } catch (\Exception $e) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get updated database credentials as given in .env located in project root.
     * 
     * @return array
    */
    private function getUpdatedDatabaseCredentials()
    {
        $env = (new Dotenv())
            ->parse(file_get_contents($this->container->getParameter('kernel.project_dir') . '/.env'));
        
        $dbUrl = getenv('DATABASE_URL') ?? $_ENV['DATABASE_URL'] ?? ($_SERVER['DATABASE_URL'] ?? $env['DATABASE_URL']); // get from propper ENV before trying for .env
        $it = explode('@', substr($dbUrl, strpos($dbUrl, "://") + 3));
        
        $name = substr($it[1], strpos($it[1], "/") + 1);
        list($user, $password) = explode(':', $it[0]);
        list($host, $port) = explode(':', substr($it[1], 0, strpos($it[1], "/")));

        return [$host, $port, $name, $user, $password];
    }

    /**
     * Retrieve the latest migration version.
     * 
     * @param OutputInterface   $bufferedOutput
     * 
     * @return string
    */
    private function getLatestMigrationVersion(OutputInterface $bufferedOutput)
    {
        try {
            $process = new Process(["php", "bin/console", "doctrine:migrations:latest"]);
            $process->setWorkingDirectory($this->projectDirectory);
            $process->mustRun();

            return trim($process->getOutput());
        } catch (ProcessFailedException $e) {
            // Do nothing ...
        }

        return 0;
    }

    /**
     * Generic prompt to ask for an input from user
     *
     * @param string $question
     * @param string $default
     * @param integer $indentLength
     * @param boolean $nullable
     * @param boolean $secure
     * @param string $warningMessage
     * 
     * @return string
     */
    private function askInteractiveQuestion($question, $default, int $indentLength = 6, bool $nullable = true, bool $secure = false, $warningMessage = "")
    {
        $flag = false;
        $indent = str_repeat(' ', $indentLength);

        do {
            $prompt = new Question($indent . $question, $default);

            // Hide user input
            if (true == $secure) {
                $prompt->setHidden(true);
                $prompt->setHiddenFallback(false);
            }

            $input = $this->questionHelper->ask($this->consoleInput, $this->consoleOutput, $prompt);
            $this->consoleOutput->write(false == $flag ? [self::MCA, self::CLL] : [self::MCA, self::CLL, self::MCA, self::CLL]);

            if (empty($input) && false == $nullable && empty($default)) {
                if (! empty($default)) {
                    $input = $default;
                } else if (false == $nullable) {
                    $flag = true;
                    $this->consoleOutput->writeln("$indent<comment>Warning</comment>: " . ($warningMessage ?? "Please enter a valid value"));
                }
            }
        } while (empty($input) && false == $nullable);

        return $input ?? null;
    }
}
