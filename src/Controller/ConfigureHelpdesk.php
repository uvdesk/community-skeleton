<?php

namespace App\Controller;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportRole;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UVDeskService;
use Predis\Client;

class ConfigureHelpdesk extends AbstractController
{
    const DB_URL_TEMPLATE = "mysql://[user]:[password]@[host]:[port]";
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

    private static $requiredConfigfiles = [
        [
            'name' => 'uvdesk',
        ],
        [
            'name' => 'swiftmailer',
        ],
        [
            'name' => 'uvdesk_mailbox',
        ],
    ];

    public function load(KernelInterface $kernel)
    {        
        return $this->render('installation-wizard/index.html.twig');
    }

    public function evaluateSystemRequirements(Request $request, KernelInterface $kernel)
    {
        $max_execution_time = ini_get('max_execution_time');
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
            case 'php-maximum-execution':
                $response['status' ] = $max_execution_time >= 30 ? true : false;

                if ($response['status']) {
                    $response['message'] = sprintf('Maximum execution time is %s', ini_get('max_execution_time').' sec');
                } else {
                    $response['message'] = sprintf('Please increase your max execution time.' );
                    $response['description'] = '</span>Issue can be resolved by simply<p><a href="https://www.simplified.guide/php/increase-max-execution-time" target="_blank"> increasing your maximum execution time</a> make it 60 or more and restart your server after making this change, refresh the browser and try again.</p>';
                }
                break;
            case 'php-envfile-permission':
                    $filename =  $kernel->getProjectDir().'/.env';
                    $response['status'] = is_writable($filename) ? true : false;
   
                    if ($response['status']) {
                        $response['message'] = sprintf('Read/Write permission enabled for .env file.');
                    } else {
                        $response['message'] = sprintf('Please enable read/write permission for <b>.env</b> file of your project.');
                        $response['description'] = '</span> Issue can be resolved by simply <a href="https://www.uvdesk.com/en/blog/open-source-helpdesk-installation-on-ubuntu-uvdesk/" target="_blank"><p> enabling your <b>.env</b> file read/write permission</a> refresh the browser and try again.</p>';
                    }
                break;
            case 'php-configfiles-permission':
                    $configfiles_status = array_map(function ($configfile) use ($kernel) {
                        return [
                            $configfile['name'] => is_writable($kernel->getProjectDir().'/config/packages/'.$configfile['name'].'.yaml') ,
                        ];
                    }, self::$requiredConfigfiles);
   
                    $response = [
                        'configfiles' => $configfiles_status,
                        'description' => '</span> <br><p> Issue can be resolved by simply <a href="https://www.uvdesk.com/en/blog/open-source-helpdesk-installation-on-ubuntu-uvdesk/" target="_blank"> enabling read/write permissions for your files under config/packages folder of your project.</a></p>',
                    ];
                break;
            case 'redis-status':
                $loadRedis = extension_loaded('redis');
                $isCacheEnabled = false;

                if ($loadRedis) {
                    try {
                        $isCacheEnabled = true;
                        $redis = new Client();

                        $redis->connect('127.0.0.1', 6379);

                        if ((bool) $redis->isConnected() == false) {
                            return new JsonResponse([
                                'status' => false,
                                'message' => "Failed to establish a connection with redis server.",
                                'description'=>'</span>Issue can be resolved by simply<p><a href="https://redis.io/docs/getting-started/installation/install-redis-on-linux/" target="_blank"> redis installation process</a> For connecting the redis-sever follow the redis installation process by clicking on link, refresh the browser and try again.</p>'
                            ]);
                        }
                    } catch (\Exception $e) {
                        return new JsonResponse([
                            'status' => false,
                            'message' => "Failed to establish a connection with redis server.",
                            'description' => '</span> Issue can be resolved by simply <p> <a href="https://redis.io/docs/getting-started/installation/install-redis-on-linux/" target="_blank"> redis installation process </a> For connecting the redis-sever follow the redis installation process by clicking on link, refresh the browser and try again. </p>'
                        ]);
                    }
                } else {
                    $phpIniFile = php_ini_loaded_file();

                    if ($phpIniFile !== false) {
                        $extensionSettings = [];
                        $enabledExtensions = [];
                        $disabledExtensions = [];
                       
                        $lines = file($phpIniFile, FILE_IGNORE_NEW_LINES);
                       
                        if (! empty($lines)) {
                            foreach ($lines as $line) {
                                $line = trim($line);
                               
                                if (preg_match('/^;?extension\s*=\s*(\S+)/i', $line, $matches)) {
                                    if (substr($line, 0, 1) === ';') {
                                        $disabledExtensions[] = $matches[1];
                                    } else {
                                        $enabledExtensions[] = $matches[1];
                                    }
                                }
                            }
                           
                            if (! empty($enabledExtensions)) {
                                if (in_array("redis",$enabledExtensions)) {
                                    return new JsonResponse([
                                        'status' => false,
                                        'message' => "Kindly disable Redis from the php.ini file.",
                                        'description' => '</span>If you want to connect with redis then follow the instruction Issue can be resolved by simply <p> <a href="https://redis.io/docs/getting-started/installation/install-redis-on-linux/ " target="_blank"> redis installation process </a> For connecting the redis-sever follow the redis installation process by clicking on link, refresh the browser and try again. </p>'
                                    ]);
                                }
                            }
                        }
                    } 
                }
                
                if ($isCacheEnabled) {
                    $response['status'] = true;
                    $response['message'] = sprintf('The connection to the Redis server has been successfully established.');
                } else {
                    $response['status'] = true;
                }
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
        
        try {
            $connectionUrl = strtr(self::DB_URL_TEMPLATE, [
                '[host]' => $request->request->get('serverName'), 
                '[port]' => $request->request->get('serverPort'), 
                '[user]' => $request->request->get('username'), 
                '[password]' => $request->request->get('password'), 
            ]);

            if ($request->request->get('serverVersion') != null) {
                $connectionUrl .= "?serverVersion=" . $request->request->get('serverVersion');
            }

            $databaseConnection = DriverManager::getConnection([
                'url' => $connectionUrl,
            ]);

            $entityManager = EntityManager::create($databaseConnection, Setup::createAnnotationMetadataConfiguration(['src/Entity'], false));
            
            // Establish a connection if not active
            if (false == $databaseConnection->isConnected()) {
                $databaseConnection->connect();
            }

            // Check if database exists
            $createDatabase = (bool) $request->request->get('createDatabase');

            if (!in_array($request->request->get('database'), $databaseConnection->getSchemaManager()->listDatabases()) && false == $createDatabase) {
                return new JsonResponse([
                    'status' => false,
                    'message' => "The requested database was not found."
                ]);
            }

            // Storing database configuration to session.
            $_SESSION['DB_CONFIG'] = [
                'host' => $request->request->get('serverName'),
                'port' => $request->request->get('serverPort'),
                'version' => $request->request->get('serverVersion'),
                'username' => $request->request->get('username'),
                'password' => $request->request->get('password'),
                'database' => $request->request->get('database'),
                'createDatabase' => $createDatabase,
            ];
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => false,
                'message' => "Failed to establish a connection with database server."
            ]);
        }
        
        return new JsonResponse(['status' => true]);
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

        $database_host = $_SESSION['DB_CONFIG']['host'];
        $database_port = $_SESSION['DB_CONFIG']['port'];
        $database_version = $_SESSION['DB_CONFIG']['version'];
        $database_user = $_SESSION['DB_CONFIG']['username'];
        $database_pass = $_SESSION['DB_CONFIG']['password'];
        $database_name = $_SESSION['DB_CONFIG']['database'];

        $create_database = $_SESSION['DB_CONFIG']['createDatabase'];

        try {
            $connectionUrl = strtr(self::DB_URL_TEMPLATE, [
                '[host]' => $database_host, 
                '[port]' => $database_port, 
                '[user]' => $database_user, 
                '[password]' => $database_pass, 
            ]);

            if (!empty($database_version)) {
                $connectionUrl .= "?serverVersion=$database_version";
            }

            $databaseConnection = DriverManager::getConnection([
                'url' => $connectionUrl,
            ]);

            $entityManager = EntityManager::create($databaseConnection, Setup::createAnnotationMetadataConfiguration(['src/Entity'], false));

            // Establish an active connection with database server
            if (false == $databaseConnection->isConnected()) {
                $databaseConnection->connect();
            }

            // Check if database exists
            if (!in_array($database_name, $databaseConnection->getSchemaManager()->listDatabases())) {
                if (false == $create_database) {
                    throw new \Exception('Database does not exist.');
                }
                
                // Create database
                $databaseConnection->getSchemaManager()->createDatabase($databaseConnection->getDatabasePlatform()->quoteSingleIdentifier($database_name));
            }

            $connectionUrl = strtr(self::DB_URL_TEMPLATE . "/[database]", [
                '[host]' => $database_host, 
                '[port]' => $database_port, 
                '[user]' => $database_user, 
                '[password]' => $database_pass, 
                '[database]' => $database_name, 
            ]);

            if (!empty($database_version)) {
                $connectionUrl .= "?serverVersion=$database_version";
            }

            // Update .env
            $application = new Application($kernel);
            $application->setAutoExit(false);

            $returnCode = $application->run(new ArrayInput([
                'command' => 'uvdesk_wizard:env:update', 
                'name' => 'DATABASE_URL', 
                'value' => $connectionUrl
            ]), new NullOutput());
    
            if (0 === $returnCode) {
                return new JsonResponse(['success' => true]);
            }
        } catch (\Exception $e) {
            return new JsonResponse([
                'status' => false,
                'message' => "An unexpected error occurred: " . $e->getMessage(), 
            ]);
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

    public function createDefaultSuperUserXHR(Request $request, UserPasswordEncoderInterface $encoder)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // $entityManager = $this->getDoctrine()->getEntityManager();
        $entityManager = $this->getDoctrine()->getManager();

        $role = $entityManager->getRepository(SupportRole::class)->findOneByCode('ROLE_SUPER_ADMIN');
        $userInstance = $entityManager->getRepository(UserInstance::class)->findOneBy([
            'isActive' => true,
            'supportRole' => $role,
        ]);
            
        if (empty($userInstance)) {
            list($name, $email, $password) = array_values($_SESSION['USER_DETAILS']);
            // Retrieve existing user or generate new empty user
            $accountExistsFlag = false;
            $user = $entityManager->getRepository(User::class)->findOneByEmail($email) ?: (new User())->setEmail($email);

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
                $encodedPassword = $encoder->encodePassword($user, $password);

                $user
                    ->setFirstName($username[0])
                    ->setLastName(!empty($username[1]) ? $username[1] : '')
                    ->setPassword($encodedPassword)
                    ->setIsEnabled(true);
                
                $entityManager->persist($user);
                $entityManager->flush();
            }
            
            if (false == $accountExistsFlag) {
                $userInstance = new UserInstance();
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

    public function websiteConfigurationXHR(Request $request, UVDeskService $uvdesk)
    {
        switch ($request->getMethod()) {
            case "GET":
                $currentWebsitePrefixCollection = $uvdesk->getCurrentWebsitePrefixes();
                
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

    public function updateWebsiteConfigurationXHR(Request $request, UVDeskService $uvdesk)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $collectionURL= $uvdesk->updateWebsitePrefixes(
            $_SESSION['PREFIXES_DETAILS']['member'],
            $_SESSION['PREFIXES_DETAILS']['customer']
        );

        return new Response(json_encode($collectionURL), 200, self::DEFAULT_JSON_HEADERS);
    }
}
