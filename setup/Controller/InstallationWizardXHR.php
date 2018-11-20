<?php

namespace Webkul\UVDesk\Setup\Controller;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InstallationWizardXHR extends Controller
{
    private static $defaultResponseHeaders = [
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
                $requirementsResponse = [
                    'status' => version_compare(phpversion(), '7.0.0', '<') ? false : true,
                    'version' => sprintf('%s.%s.%s', PHP_MAJOR_VERSION, PHP_MINOR_VERSION, PHP_RELEASE_VERSION),
                ];
                break;
            case 'php-extensions':
                $missingExtensions = array_filter(self::$requiredExtensions, function ($extension) {
                    return !extension_loaded($extension['name']);
                });

                $requirementsResponse = [
                    'status' => !empty($missingExtensions) ? false : true,
                    'extensions' => $missingExtensions,
                ];
                break;
            default:
                $responseCode = 404;
                break;
        }
        
        return new Response(json_encode($requirementsResponse ?? []), $responseCode ?? 200, self::$defaultResponseHeaders);
    }

    public function verifyDatabaseCredentials(Request $request)
    {
        $session = $request->getSession();
        $session->remove('DB_CONFIG');

        // Get entity manager
        $entityManager = EntityManager::create([
            'driver' => 'pdo_mysql',
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
                $session->set('DB_CONFIG', [
                    'username' => $request->request->get('username'),
                    'password' => $request->request->get('password'),
                    'database' => $request->request->get('database'),
                ]);
            } catch (\Doctrine\DBAL\DBALException $e) {
                // Unable to connect with the database - Invalid Credentials.
            }
        }
        
        return new Response(json_encode($connectionResponse), 200, self::$defaultResponseHeaders);
    }
}
