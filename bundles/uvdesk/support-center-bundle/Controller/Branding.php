<?php

namespace Webkul\UVDesk\SupportCenterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webkul\UVDesk\SupportCenterBundle\Entity as SupportEntites;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntites;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UVDeskService;
use Webkul\UVDesk\CoreFrameworkBundle\FileSystem\FileSystem;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Filesystem\Filesystem as SymfonyFileservice;

class Branding extends AbstractController
{
    private $userService;
    private $translator;
    private $fileSystem;
    private $uvdeskService;

    public function __construct(UserService $userService, TranslatorInterface $translator, FileSystem $fileSystem, UVDeskService $uvdeskService)
    {
        $this->userService = $userService;
        $this->translator = $translator;
        $this->fileSystem = $fileSystem;
        $this->uvdeskService = $uvdeskService;
    }

    public function theme(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $errors = [];
        $entityManager = $this->getDoctrine()->getManager();
        $settingType = $request->attributes->get('type');
        $userService = $this->userService;
        $website = $entityManager->getRepository(CoreEntites\Website::class)->findOneBy(['code'=>"knowledgebase"]);
        $configuration = $entityManager->getRepository(SupportEntites\KnowledgebaseWebsite::class)->findOneBy(['website' => $website->getId(),'isActive' => 1]);
        $currentLocales = $this->uvdeskService->getDefaultLangauge();

        if ($request->getMethod() == 'POST') {
            $isValid = 0;
            $params = $request->request->all();
            $parmsFile = ($request->files->get('website'));
            $selectedLocale = isset($params['defaultLocale']) ? $params['defaultLocale'] : null;

            switch($settingType) {
                case "general":
                    $website->setName($params['website']['name']);
                    $status = array_key_exists("status",$params['website']) ? 1 : 0;
                    $logo = $website->getLogo();

                    if ($logo != null && isset($parmsFile['logo'])) {
                        $fileService = new SymfonyFileservice;
                        $fileService->remove($this->getParameter('kernel.project_dir').'/public'.$logo);
                    }

                    if (isset($parmsFile['logo'])) {
                        $assetDetails = $this->fileSystem->getUploadManager()->uploadFile($parmsFile['logo'], 'website');
                        $website->setLogo($assetDetails['path']);
                    }

                    $configuration->setStatus($status);
                    $configuration->setBrandColor($params['website']['brandColor']);

                    $entityManager->persist($website);
                    $entityManager->persist($configuration);
                    $entityManager->flush();

                    if (!empty($selectedLocale)) {
                        if (false == $this->uvdeskService->updatesLocales($selectedLocale)) {
                            $this->addFlash('danger', $this->translator->trans('Warning! Locales could not be updated successfully.'));
                        } else {
                            $currentLocales = $selectedLocale;
                        }
                    }

                    $this->addFlash('success', $this->translator->trans('Success ! Branding details saved successfully.'));

                    break;
                case "knowledgebase":
                    $configuration->setPageBackgroundColor($params['website']['pageBackgroundColor']);
                    $configuration->setHeaderBackgroundColor($params['website']['headerBackgroundColor']);

                    $configuration->setLinkColor($params['website']['linkColor']);
                    $configuration->setLinkHoverColor($params['website']['linkHoverColor']);
                    $configuration->setArticleTextColor($params['website']['articleTextColor']);
                    $configuration->setSiteDescription($params['website']['siteDescription']);
                    $configuration->setBannerBackgroundColor($params['website']['bannerBackgroundColor']);
                    $configuration->setHomepageContent($params['website']['homepageContent']);


                    $removeCustomerLoginButton = array_key_exists("removeCustomerLoginButton",$params['website']) ? $params['website']['removeCustomerLoginButton'] : 0;
                    $removeBrandingContent = array_key_exists("removeBrandingContent",$params['website']) ? $params['website']['removeBrandingContent'] : 0;
                    $disableCustomerLogin = array_key_exists("disableCustomerLogin",$params['website']) ? $params['website']['disableCustomerLogin'] : 0;


                    $configuration->setRemoveCustomerLoginButton($removeCustomerLoginButton);
                    $configuration->setRemoveBrandingContent($removeBrandingContent);
                    $configuration->setDisableCustomerLogin($disableCustomerLogin);

                    $ticketCreateOption = array_key_exists('ticketCreateOption', $params['website']) ? 1 : 0;
                    $loginRequiredToCreate = array_key_exists('loginRequiredToCreate', $params['website']) ? 1 : 0;
                    $configuration->setTicketCreateOption($ticketCreateOption);
                    $configuration->setLoginRequiredToCreate($loginRequiredToCreate);
                    $configuration->setUpdatedAt(new \DateTime());
                    $entityManager->persist($configuration);
                    $entityManager->flush();

                    $this->addFlash('success', $this->translator->trans('Success ! Branding details saved successfully.'));
                    break;
                case "seo":
                    $configuration->setMetaDescription($params['metaDescription']);
                    $configuration->setMetaKeywords($params['metaKeywords']);
                    $configuration->setUpdatedAt(new \DateTime());
                    $entityManager->persist($configuration);
                    $entityManager->flush();

                    $this->addFlash('success', $this->translator->trans('Success ! Branding details saved successfully.'));
                    break;
                case "links":
                    $footerLinks=[];
                    $headerLinks=[];
                    $headerLinks = isset($params['headerLinks'])? $params['headerLinks']: '';
                    $footerLinks = isset($params['footerLinks']) ? $params['footerLinks']: 0;

                    if (!empty($headerLinks)) {
                        foreach ($headerLinks as $key => $link) {
                            if($link['label'] == '' || $link['url'] == '' || !filter_var($link['url'], FILTER_VALIDATE_URL)) {

                                unset($headerLinks[$key]);
                            }
                        }
                    }

                    if (!empty($footerLinks)) {
                        foreach ($footerLinks as $key => $link) {
                            if($link['label'] == '' || $link['url'] == '' || !filter_var($link['url'], FILTER_VALIDATE_URL)) {
                                unset($footerLinks[$key]);
                            }
                        }
                    }

                    $configuration->setHeaderLinks($headerLinks);
                    $configuration->setFooterLinks($footerLinks);
                    $entityManager->persist($configuration);
                    $entityManager->flush();

                    $this->addFlash('success', $this->translator->trans('Success ! Branding details saved successfully.'));
                    break;
                case "broadcasting":
                    $params['broadcasting']['isActive'] = array_key_exists('isActive', $params['broadcasting']) ? true  : false;
                    $configuration->setBroadcastMessage(json_encode($params['broadcasting']));
                    $configuration->setUpdatedAt(new \DateTime());

                    $entityManager->persist($configuration);
                    $entityManager->flush();

                    $this->addFlash('success', $this->translator->trans('Success ! Branding details saved successfully.'));
                    break;
                case 'advanced':
                    $configuration->setCustomCSS($request->request->get('customCSS'));
                    $configuration->setScript($request->request->get('script'));
                    $entityManager->persist($configuration);
                    $entityManager->flush();

                    $this->addFlash('success', $this->translator->trans('Success ! Branding details saved successfully.'));
                    break;
                case 'time':
                    $configuration->getWebsite()->setTimezone($params['form']['timezone']);
                    $configuration->getWebsite()->setTimeformat($params['form']['timeFormat']);

                    $entityManager->persist($configuration);
                    $entityManager->flush();

                    $this->addFlash('success', $this->translator->trans('Success ! Time details saved successfully.'));
                    break;
                default:
                    break;
            }
        }

        return $this->render('@UVDeskSupportCenter/Staff/branding.html.twig', [
            'websiteData' => $website,
            'type' => $settingType,
            'configuration' => $configuration,
            'broadcast' => json_decode($configuration->getBroadcastMessage()),
            'locales' => $currentLocales,
        ]);
    }

    public function spam(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $website = $entityManager->getRepository(CoreEntites\Website::class)->findOneBy(['code'=>"knowledgebase"]);
        if(!$website) {
            // return not found
        }
        $configuration = $entityManager->getRepository(SupportEntites\KnowledgebaseWebsite::class)->findOneBy(['website' => $website->getId(), 'isActive' => 1]);
        $params = $request->request->all();


        if ($request->getMethod() == 'POST') {
            $configuration->setWhiteList($request->request->get('whiteList'));
            $configuration->setBlackList($request->request->get('blackList'));
            $entityManager->persist($configuration);
            $entityManager->flush();

            $this->addFlash('success', $this->translator->trans('Spam setting saved successfully.'));

            return $this->redirect($this->generateUrl('helpdesk_member_knowledgebase_spam'));
        }

        return $this->render('@UVDeskSupportCenter/Staff/spam.html.twig', [
            'whitelist'=>$configuration->getWhiteList(),
            'blacklist'=>$configuration->getBlackList(),
        ]);
    }

    public function LocalesUpdateXhr(Request $request)
    {
        $params = $request->request->all();
        $defaultLocale = isset($params['defaultLocale']) ? $params['defaultLocale'] : null;

        if (!empty($defaultLocale)) {
            $localesStatus = $this->uvdeskService->updatesLocales($defaultLocale);
            $localesStatus == true ? '' : $this->addFlash('danger', $this->translator->trans('Warning ! Locales not updates successfully.'));
        }

        $json['alertClass'] = 'success';
        $json['alertMessage'] = $this->translator->trans('Success ! Updated.');


        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}