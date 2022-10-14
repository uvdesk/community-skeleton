<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Website;

class Theme extends AbstractController
{
    private $translator;
    
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function updateHelpdeskTheme(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $values = $request->request->all();
            $entityManager = $this->getDoctrine()->getManager();
            $website = $entityManager->getRepository(Website::class)->findOneByCode('helpdesk');

            $website->setName($values['helpdeskName']);
            $website->setThemeColor($values['themeColor']);

            $entityManager->persist($website);
            $entityManager->flush();

            $this->addFlash('success', $this->translator->trans('Success ! Helpdesk details saved successfully'));
        }

        return $this->render('@UVDeskCoreFramework/theme.html.twig');
    }
}