<?php

namespace Webkul\UVDesk\Setup\Controller;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DBALException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InstallationWizardXHR extends Controller
{
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

    public function evaluateSystemRequirements($criteria)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();

        if (true === $request->isXmlHttpRequest()) {
            switch ($criteria) {
                case 'php-version':
                    $responseCode = 200;
                    $responseContent = [
                        'status' => version_compare(phpversion(), '7.0.0', '<') ? false : true,
                        'version' => sprintf('%s.%s.%s', PHP_MAJOR_VERSION, PHP_MINOR_VERSION, PHP_RELEASE_VERSION),
                    ];

                    break;
                case 'php-extensions':
                    $missingExtensions = array_filter(self::$requiredExtensions, function ($extension) {
                        return !extension_loaded($extension['name']);
                    });

                    $responseCode = 200;
                    $responseContent = [
                        'status' => empty($missingExtensions),
                        'extensions' => $missingExtensions,
                    ];
                    break;
                default:
                    break;
            }
        }
        
        return new Response(json_encode($responseContent ?? []), $responseCode ?? 404, [
            'Content-Type' => 'application/json'
        ]);
    }

    public function verifyDatabaseCredentials(Request $request)
    {
        if (true === $request->isXmlHttpRequest()) {
            $entityManager = EntityManager::create([
                'driver' => 'pdo_mysql',
                'user' => $request->request->get('username'),
                'password' => $request->request->get('password'),
                'dbname' => $request->request->get('database'),
            ], Setup::createAnnotationMetadataConfiguration(['src/Entity'], false));
    
            $databaseConnection = $entityManager->getConnection();
    
            $responseCode = 200;
            $responseContent = ['status' => true];

            if (false === $databaseConnection->isConnected()) {
                try {    
                    $databaseConnection->connect();
                } catch (DBALException $e) {
                    $responseContent['status'] = false;
                }
            }
        }

        return new Response(json_encode($responseContent ?? []), $responseCode ?? 404, [
            'Content-Type' => 'application/json'
        ]);
    }
}
