<?php

namespace Webkul\UVDesk\Setup\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InstallationWizard extends Controller
{
    const HELPDESK_VERSION = '0.2.0 DEV';

    public function loadWizard($_locale)
    {
        return $this->render('installation-wizard/index.html.twig', [
            'version' => self::HELPDESK_VERSION,
        ]);
    }
}
