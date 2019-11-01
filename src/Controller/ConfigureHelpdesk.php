<?php

namespace App\Controller;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;

class ConfigureHelpdesk extends Controller
{
    const HELPDESK_VERSION = '1.0.0 DEV';
    const DB_ENV_PATH_TEMPLATE = "DATABASE_URL=DB_DRIVER://DB_USER:DB_PASSWORD@DB_HOST/DB_NAME\n";
    const DB_ENV_PATH_PARAM_TEMPLATE = "env(DATABASE_URL): 'DB_DRIVER://DB_USER:DB_PASSWORD@DB_HOST/DB_NAME'\n";
    const DEFAULT_JSON_HEADERS = [
        'Content-Type' => 'application/json',
    ];

    private static $requiredExtensions = [
        [
            'name' => 'imap',
        ],
        [
            'name' => 'mailparse',
        ],
        [
            'name' => 'mysqli',
        ],
    ];

    public function load()
    {
        return $this->render('installation-wizard/index.html.twig', [
            'version' => self::HELPDESK_VERSION,
        ]);
    }

    public function evaluateSystemRequirements(Request $request)
    {
        // Evaluate system specification requirements
        switch (strtolower($request->request->get('specification'))) {
            case 'php-version':
                $response = [
                    'status' => version_compare(phpversion(), '7.0.0', '<') ? false : true,
                    'version' => sprintf('%s.%s.%s', PHP_MAJOR_VERSION, PHP_MINOR_VERSION, PHP_RELEASE_VERSION),
                ];

                if ($response['status']) {
                    $response['message'] = sprintf('Using PHP v%s', $response['version']);
                } else {
                    $response['message'] = sprintf('Currently using PHP v%s. Please use PHP 7 or greater.', $response['version']);
                }
                break;
            case 'php-extensions':
                $extensions_status = array_map(function ($extension) {
                    return [
                        $extension['name'] => extension_loaded($extension['name']),
                    ];
                }, self::$requiredExtensions);

                $response = [
                    'extensions' => $extensions_status,
                ];
                break;
            default:
                $code = 404;
                break;
        }
        
        return new Response(json_encode($response ?? []), $code ?? 200, self::DEFAULT_JSON_HEADERS);
    }

    public function verifyDatabaseCredentials(Request $request)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // unset($_SESSION['DB_CONFIG']);

        try {
            $dbParams = [
                'driver' => 'pdo_mysql',
                "host" => $request->request->get('serverName'),
                "port" => $request->request->get('serverPort'),
                'user' => $request->request->get('username'),
                'password' => $request->request->get('password'),
            ];
            $ifNotExists = (bool) $request->request->get('ifNotExists');
            
            // Creating a connection without specifying database
            $databaseConnection = DriverManager::getConnection($dbParams);
            $dbname = $request->request->get('database');
            $shouldCreateDatabase = $ifNotExists && !in_array($dbname, $databaseConnection->getSchemaManager()->listDatabases());

            if ($shouldCreateDatabase) {
                $databaseConnection->getSchemaManager()->createDatabase($databaseConnection->getDatabasePlatform()->quoteSingleIdentifier($dbname));
            }
            // Closing the existing connection
            $databaseConnection->close();
            
            // Creating a new Connection (with database name)
            $dbParams = array_merge($dbParams, ['dbname' => $dbname]);
            $databaseConnection = DriverManager::getConnection($dbParams);

            if (!$databaseConnection->isConnected()) {
                // Try connecting with the database if the connection is not active.
                $databaseConnection->connect();

                $_SESSION['DB_CONFIG'] = [
                    'host' => $dbParams['host'] . $dbParams['port'],
                    'username' => $dbParams['user'],
                    'password' => $dbParams['password'],
                    'database' => $dbParams['dbname'],
                ];

                return new Response(json_encode(['status' => true]), 200, self::DEFAULT_JSON_HEADERS);
            }
        } catch (\Exception $e) {
            // Unable to create database
            // @TODO: Error reporting to user.
            return new Response(json_encode(['status' => false]), 200, self::DEFAULT_JSON_HEADERS);
        }
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

        $database_host = $_SESSION['DB_CONFIG']['host'];
        $database_user = $_SESSION['DB_CONFIG']['username'];
        $database_pass = $_SESSION['DB_CONFIG']['password'];
        $database_name = $_SESSION['DB_CONFIG']['database'];

        $exit_code = $application->run(new ArrayInput([
            'command' => 'uvdesk_wizard:env:update', 
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
            'command' => 'uvdesk_wizard:database:migrate'
        ]), new NullOutput());
        
        return new Response(json_encode([]), 200, self::DEFAULT_JSON_HEADERS);
    }

    public function populateDatabaseEntitiesXHR(Request $request, KernelInterface $kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $resultCode = $application->run(new ArrayInput([
            'command' => 'doctrine:fixtures:load',
            '--append' => true,
        ]), new NullOutput());

        return new Response(json_encode([]), 200, self::DEFAULT_JSON_HEADERS);
    }

    public function createDefaultSuperUserXHR(Request $request)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $entityManager = $this->getDoctrine()->getEntityManager();

        $role = $entityManager->getRepository('UVDeskCoreFrameworkBundle:SupportRole')->findOneByCode('ROLE_SUPER_ADMIN');
        $userInstance = $entityManager->getRepository('UVDeskCoreFrameworkBundle:UserInstance')->findOneBy([
            'isActive' => true,
            'supportRole' => $role,
        ]);
            
        if (empty($userInstance)) {
            list($name, $email, $password) = array_values($_SESSION['USER_DETAILS']);
            // Retrieve existing user or generate new empty user
            $accountExistsFlag = false;
            $user = $entityManager->getRepository('UVDeskCoreFrameworkBundle:User')->findOneByEmail($email) ?: (new CoreEntities\User())->setEmail($email);

            if ($user->getId() != null) {
                $userInstance = $user->getAgentInstance();

                if (!empty($userInstance)) {
                    $accountExistsFlag = true;

                    if ($userInstance->getSupportRole()->getId() != $role->getId()) {
                        $userInstance->setSupportRole($role);

                        $entityManager->persist($userInstance);
                        $entityManager->flush();
                    }
                }
            } else {
                $username = explode(' ', $name, 2);
                $encodedPassword = $this->get('security.password_encoder')->encodePassword($user, $password);

                $user
                    ->setFirstName($username[0])
                    ->setLastName(!empty($username[1]) ? $username[1] : '')
                    ->setPassword($encodedPassword)
                    ->setIsEnabled(true);
                
                $entityManager->persist($user);
                $entityManager->flush();
            }
            
            if (false == $accountExistsFlag) {
                $userInstance = new CoreEntities\UserInstance();
                $userInstance->setSource('website');
                $userInstance->setIsActive(true);
                $userInstance->setIsVerified(true);
                $userInstance->setUser($user);
                $userInstance->setSupportRole($role);

                $entityManager->persist($userInstance);
                $entityManager->flush();
            }
        }

        return new Response(json_encode([]), 200, self::DEFAULT_JSON_HEADERS);
    }

    public function websiteConfigurationXHR(Request $request)
    {
        switch ($request->getMethod()) {
            case "GET":
                $currentWebsitePrefixCollection = $this->get('uvdesk.service')->getCurrentWebsitePrefixes();
                
                if ($currentWebsitePrefixCollection) {
                    $result = $currentWebsitePrefixCollection;
                    $result['status'] = true;
                } else {
                    $result['status'] = false;
                }
                break;
            case "POST":
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                
                $_SESSION['PREFIXES_DETAILS'] = [
                    'member' => $request->request->get('member-prefix'),
                    'customer' => $request->request->get('customer-prefix'),
                ];

                $result = ['status' => true];
                break;
            default:
                break;
        }

        return new Response(json_encode($result ?? []), 200, self::DEFAULT_JSON_HEADERS);
    }

    public function updateWebsiteConfigurationXHR(Request $request)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $collectionURL= $this->get('uvdesk.service')->updateWebsitePrefixes(
            $_SESSION['PREFIXES_DETAILS']['member'],
            $_SESSION['PREFIXES_DETAILS']['customer']
        );

        return new Response(json_encode($collectionURL), 200, self::DEFAULT_JSON_HEADERS);
    }
}
