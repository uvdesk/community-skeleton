<?php

namespace Webkul\UVDesk\Setup\Controller;

use Doctrine\DBAL\DBALException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InstallationWizard extends Controller
{
    const HELPDESK_VERSION = '0.1.0-DEV';

    public function wizard($_locale)
    {
        return $this->render('helpdesk-installation-wizard/index.html.twig', [
            'version' => self::HELPDESK_VERSION,
        ]);
    }
}
