<?php

namespace App\Controller\Wizard\Setup;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntities;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Requirements extends Controller
{
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
}
