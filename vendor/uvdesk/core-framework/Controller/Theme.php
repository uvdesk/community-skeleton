<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Theme extends Controller
{
    public function updateHelpdeskTheme(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $values = $request->request->all();
            $entityManager = $this->getDoctrine()->getManager();
            $website = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneByCode('helpdesk');

            $website->setName($values['helpdeskName']);
            $website->setThemeColor($values['themeColor']);

            $entityManager->persist($website);
            $entityManager->flush();
        }

        return $this->render('@UVDeskCoreFramework/theme.html.twig');
    }
}