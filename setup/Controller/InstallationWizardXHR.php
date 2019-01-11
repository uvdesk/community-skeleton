<?php

namespace Webkul\UVDesk\Setup\Controller;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\HttpKernel\KernelInterface;
use Webkul\UVDesk\CoreBundle\Entity as CoreEntities;

class InstallationWizardXHR extends Controller
{
    const DB_ENV_PATH_TEMPLATE = "DATABASE_URL=DB_DRIVER://DB_USER:DB_PASSWORD@DB_HOST/DB_NAME\n";
    const DB_ENV_PATH_PARAM_TEMPLATE = "env(DATABASE_URL): 'DB_DRIVER://DB_USER:DB_PASSWORD@DB_HOST/DB_NAME'\n";
    const DEFAULT_JSON_HEADERS = [
        'Content-Type' => 'application/json',
    ];

    private static $requiredExtensions = [
        [
            'name' => 'imap',
            'reason' => 'for something important i guess',
        ],
        [
            'name' => 'mailparse',
            'reason' => 'for something important i guess',
        ],
        [
            'name' => 'mysqli',
            'reason' => 'for something important i guess',
        ],
    ];

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
                $missingExtensions = array_filter(self::$requiredExtensions, function ($extension) {
                    return !extension_loaded($extension['name']);
                });

                if (empty($missingExtensions)) {
                    $response = [
                        'status' => true,
                        'message' => 'All the necessary extensions are currently enabled',
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'extensions' => $missingExtensions,
                        'message' => "There are extensions that haven't been installed or are currently disabled",
                    ];
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
                    'server' => $request->request->get('serverName') . $port,
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

    public function updateConfigurationsXHR(Request $request)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $response = new Response(json_encode([]), 200, self::DEFAULT_JSON_HEADERS);
        
        $db_params = [
            'DB_DRIVER' => 'mysql',
            'DB_HOST' => $_SESSION['DB_CONFIG']['server'],
            'DB_USER' => $_SESSION['DB_CONFIG']['username'],
            'DB_PASSWORD' => $_SESSION['DB_CONFIG']['password'],
            'DB_NAME' => $_SESSION['DB_CONFIG']['database'],
        ];

        if (file_exists('../.env')) {
            $file = file('../.env');

            foreach ($file as $index => $content) {
                if (false !== strpos($content, 'DATABASE_URL')) {
                    list($line, $text) = array($index, $content);
                    break;
                }
            }

            $updatedFile = $file;
            $databasePath = strtr(self::DB_ENV_PATH_TEMPLATE, $db_params);
            $updatedPath = (null !== $line) ? substr($text, 0, strpos($text, 'DATABASE_URL')) . $databasePath : $databasePath;

            if ($line === null) {
                $updatedFile[] = $updatedPath;
            } else {
                $updatedFile[$line] = $updatedPath;
            }

            file_put_contents('../.env', $updatedFile);
        } else if (file_exists('../config/packages/doctrine.yaml')) {
            $file = file('../config/packages/doctrine.yaml');
            
            foreach ($file as $index => $content) {
                if (false !== strpos($content, 'env(DATABASE_URL)')) {
                    list($line, $text) = array($index, $content);
                    break;
                }
            }
            
            $databasePath = strtr(self::DB_ENV_PATH_PARAM_TEMPLATE, $db_params);
            $updatedPath = !empty($line) ? substr($text, 0, strpos($text, 'env(DATABASE_URL)')) . $databasePath : $databasePath;

            if (empty($line)) {
                $updatedFile = [];

                foreach ($file as $text) {
                    $updatedFile[] = $text;

                    if (false !== strpos($text, 'parameters:')) {
                        $updatedFile[] = "\t" . $updatedPath;
                    }
                }
            } else {
                $updatedFile = $file;
                $updatedFile[$line] = $updatedPath;
            }

            file_put_contents('../config/packages/doctrine.yaml', $updatedFile);
        } else {
            $response->setStatusCode(500);
        }

        return $response;
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

    public function createDefaultSuperUserXHR(Request $request)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $entityManager = $this->getDoctrine()->getEntityManager();

        $role = $entityManager->getRepository('UVDeskCoreBundle:SupportRole')->findOneByCode('ROLE_SUPER_ADMIN');
        $userInstance = $entityManager->getRepository('UVDeskCoreBundle:UserInstance')->findOneBy([
            'isActive' => true,
            'supportRole' => $role,
        ]);
            
        if (empty($userInstance)) {
            list($name, $email, $password) = array_values($_SESSION['USER_DETAILS']);
            // Retrieve existing user or generate new empty user
            $accountExistsFlag = false;
            $user = $entityManager->getRepository('UVDeskCoreBundle:User')->findOneByEmail($email) ?: (new CoreEntities\User())->setEmail($email);

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
                $filePath = dirname(__FILE__, 3) . '/config/packages/uvdesk.yaml';
            
                // get file content and index
                $file = file($filePath);
                foreach ($file as $index => $content) {
                    if (false !== strpos($content, 'uvdesk_site_path.member_prefix')) {
                        list($member_panel_line, $member_panel_text) = array($index, $content);
                    }
        
                    if (false !== strpos($content, 'uvdesk_site_path.knowledgebase_customer_prefix')) {
                        list($customer_panel_line, $customer_panel_text) = array($index, $content);
                    }
                }

                $memberPrefix = substr($member_panel_text, strpos($member_panel_text, 'uvdesk_site_path.member_prefix') + strlen('uvdesk_site_path.member_prefix: '));
                $customerPrefix = substr($customer_panel_text, strpos($customer_panel_text, 'uvdesk_site_path.knowledgebase_customer_prefix') + strlen('uvdesk_site_path.knowledgebase_customer_prefix: '));

                $result = [
                    'status' => true,
                    'memberPrefix' => trim(preg_replace('/\s\s+/', ' ', $memberPrefix)),
                    'customerPrefix' => trim(preg_replace('/\s\s+/', ' ', $customerPrefix)),
                ];
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

        $newMemberPrefix = $_SESSION['PREFIXES_DETAILS']['member'];
        $website_prefixes = [
            'member_prefix' => $newMemberPrefix,
            'customer_prefix' => $_SESSION['PREFIXES_DETAILS']['customer'],
        ];

        $filePath = dirname(__FILE__, 3) . '/config/packages/uvdesk.yaml';
        
        // get file content and index
        $file = file($filePath);
        foreach ($file as $index => $content) {
            if (false !== strpos($content, 'uvdesk_site_path.member_prefix')) {
                list($member_panel_line, $member_panel_text) = array($index, $content);
            }

            if (false !== strpos($content, 'uvdesk_site_path.knowledgebase_customer_prefix')) {
                list($customer_panel_line, $customer_panel_text) = array($index, $content);
            }
        }

        // save updated data in a variable ($updatedFileContent)
        $updatedFileContent = $file;

        // get old member-prefix
        $oldMemberPrefix = substr($member_panel_text, strpos($member_panel_text, 'uvdesk_site_path.member_prefix') + strlen('uvdesk_site_path.member_prefix: '));
        $oldMemberPrefix = preg_replace('/([\r\n\t])/','', $oldMemberPrefix);

        $updatedPrefixForMember = (null !== $member_panel_line) ? substr($member_panel_text, 0, strpos($member_panel_text, 'uvdesk_site_path.member_prefix') + strlen('uvdesk_site_path.member_prefix: ')) . $website_prefixes['member_prefix'] . PHP_EOL: '';
        $updatedPrefixForCustomer = (null !== $customer_panel_line) ? substr($customer_panel_text, 0, strpos($customer_panel_text, 'uvdesk_site_path.knowledgebase_customer_prefix') + strlen('uvdesk_site_path.knowledgebase_customer_prefix: ')) . $website_prefixes['customer_prefix'] . PHP_EOL : '';

        $updatedFileContent[$member_panel_line] = $updatedPrefixForMember;
        $updatedFileContent[$customer_panel_line] = $updatedPrefixForCustomer;

        // flush updated content in file
        file_put_contents($filePath, $updatedFileContent);

        $router = $this->container->get('router');
        $knowledgebaseURL = $router->generate('helpdesk_knowledgebase');
        $memberLoginURL = $router->generate('helpdesk_member_handle_login');
        $memberLoginURL = str_replace($oldMemberPrefix, $newMemberPrefix, $memberLoginURL);

        $collectionURL = [
            'task' => 'updateURL',
            'memberLogin' => $memberLoginURL,
            'knowledgebase' => $knowledgebaseURL,
        ];

        return new Response(json_encode($collectionURL), 200, self::DEFAULT_JSON_HEADERS);
    }
}
