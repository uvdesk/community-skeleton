<?php

namespace App\Controller\Wizard\Setup;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DatabaseConfiguration extends Controller
{
    public function verifyDatabaseCredentials(Request $request)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // unset($_SESSION['DB_CONFIG']);

        // Get entity manager
        $entityManager = EntityManager::create([
            'driver' => 'pdo_mysql',
            "host" => $request->request->get('serverName'),
            "port" => $request->request->get('port'),
            'user' => $request->request->get('username'),
            'password' => $request->request->get('password'),
            'dbname' => $request->request->get('database'),
        ], Setup::createAnnotationMetadataConfiguration(['src/Entity'], false));
        
        $databaseConnection = $entityManager->getConnection();
        $connectionResponse = [
            'status' => $databaseConnection->isConnected(),
        ];

        // Try connecting with the database if the connection is not active.
        if (false == $connectionResponse['status']) {
            try {    
                $databaseConnection->connect();

                $connectionResponse['status'] = true;

                $port = $request->request->get('port') ? ':' . $request->request->get('port') : '';
                $_SESSION['DB_CONFIG'] = [
                    'host' => $request->request->get('serverName') . $port,
                    'username' => $request->request->get('username'),
                    'password' => $request->request->get('password'),
                    'database' => $request->request->get('database'),
                ];
            } catch (\Doctrine\DBAL\DBALException $e) {
                // Unable to connect with the database - Invalid Credentials.
            }
        }
        
        return new Response(json_encode($connectionResponse), 200, self::DEFAULT_JSON_HEADERS);
    }

    public function prepareSuperUserDetailsXHR(Request $request)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // unset($_SESSION['USER_DETAILS']);

        $_SESSION['USER_DETAILS'] = [
            'name' => $request->request->get('name'),
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
        ];

        return new Response(json_encode(['status' => true]), 200, self::DEFAULT_JSON_HEADERS);
    }

    public function updateConfigurationsXHR(Request $request, KernelInterface $kernel)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $application = new Application($kernel);
        $application->setAutoExit(false);

        $database_host = $_SESSION['DB_CONFIG']['server'];
        $database_user = $_SESSION['DB_CONFIG']['username'];
        $database_pass = $_SESSION['DB_CONFIG']['password'];
        $database_name = $_SESSION['DB_CONFIG']['database'];

        $exit_code = $application->run(new ArrayInput([
            'command' => 'uvdesk-wizard:envvars:update', 
            'name' => 'DATABASE_URL', 
            'value' => sprintf("mysql://%s:%s@%s/%s", $database_user, $database_pass, $database_host, $database_name)
        ]), new NullOutput());

        if (0 === $exit_code) {
            return new JsonResponse(['success' => true]);
        }

        return new JsonResponse(['success' => false], 500);
    }

    public function migrateDatabaseSchemaXHR(Request $request, KernelInterface $kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $resultCode = $application->run(new ArrayInput([
            'command' => 'uvdesk-wizard:migrate-database'
        ]), new NullOutput());
        
        return new Response(json_encode([]), 200, self::DEFAULT_JSON_HEADERS);
    }

    public function populateDatabaseEntitiesXHR(Request $request, KernelInterface $kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $resultCode = $application->run(new ArrayInput([
            'command' => 'uvdesk-wizard:populate-database'
        ]), new NullOutput());

        return new Response(json_encode([]), 200, self::DEFAULT_JSON_HEADERS);
    }
}
