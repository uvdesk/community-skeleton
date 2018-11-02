<?php

namespace App\Controller;

use Doctrine\DBAL\DBALException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    const HELPDESK_VERSION = '0.1.0-DEV';

    /**
     * @Route(
     *      "/",
     *      defaults = {
     *          "_locale": "en"
     *      },
     *      name = "welcome_uvdesk_community"
     * )
     */
    public function welcome($_locale)
    {
        $isDatabaseConfigured = true;
        $databaseConnection = $this->getDoctrine()->getEntityManager()->getConnection();
        
        if (false === $databaseConnection->isConnected()) {
            try {    
                $databaseConnection->connect();
            } catch (DBALException $e) {
                $isDatabaseConfigured = false;
            }
        }

        $pathToHelpdeskPanel = $isDatabaseConfigured ? 'helpdesk_member_handle_login' : null;
        $pathToSupportCenterPanel = ($isDatabaseConfigured && array_key_exists('UVDeskSupportCenterBundle', $this->getParameter('kernel.bundles'))) ? 'helpdesk_knowledgebase' : null;

        return $this->render('uvdesk-community-edition.html.twig', [
            'version' => self::HELPDESK_VERSION,
            'isDatabaseConfigured' => $isDatabaseConfigured,
            'pathToHelpdeskPanel' => $pathToHelpdeskPanel,
            'pathToSupportCenterPanel' => $pathToSupportCenterPanel,
        ]);
    }
}
