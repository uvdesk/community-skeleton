<?php

namespace Webkul\UVDesk\SupportCenterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Filesystem\Filesystem as Fileservice;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\SupportCenterBundle\Entity as SupportEntites;

class KnowledgebaseXHR extends AbstractController
{
    private $userService;
    private $translator;

    public function __construct(UserService $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    public function listFoldersXHR(Request $request, ContainerInterface $container)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $response = new Response();
        $folderCollection = $this->getDoctrine()->getRepository(SupportEntites\Solutions::class)->getAllSolutions($request->query, $container);

        $response->setContent(json_encode($folderCollection));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function updateFolderXHR(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $json = array();

        $entityManager = $this->getDoctrine()->getManager();
        switch($request->getMethod())
        {
            case "PATCH":
                $content = json_decode($request->getContent(), true);
                $solutionId = $content['id'];
                $solution = $entityManager->getRepository(SupportEntites\Solutions::class)->find($solutionId);
                if($solution) {
                    switch($content['editType']){
                        case 'status':
                            $solution->setVisibility($content['value']);
                            $entityManager->persist($solution);
                            $entityManager->flush();
                            $json['alertClass'] = 'success';
                            $json['alertMessage'] = $this->translator->trans('Success ! Folder status updated successfully.');
                            break;
                        default:
                            break;
                    }
                } else {
                    $json['alertClass'] = 'danger';
                    $json['alertMessage'] = $this->translator->trans('Error ! Folder is not exist.');
                }
                break;
            case "PUT":

                $content = json_decode($request->getContent(), true);
                $solutionId = $content['id'];
                $solution = $entityManager->getRepository(SupportEntites\Solutions::class)->find($solutionId);
                if($solution) {

                    $solution->setName($content['name']);
                    $solution->setDescription($content['description']);
                    $entityManager->persist($solution);
                    $entityManager->flush();

                    $json['alertClass'] = 'success';
                    $json['alertMessage'] = $this->translator->trans('Success ! Folder updated successfully.');


                } else {
                    $json['alertClass'] = 'danger';
                    $json['alertMessage'] = $this->translator->trans('Error ! Folder does not exist.');
                }
                break;
            case "DELETE":
                $solutionId = $request->attributes->get('folderId');
                $solutionBase = $entityManager->getRepository(SupportEntites\Solutions::class)->find($solutionId);

                $fileService = new Fileservice();

                if ($solutionBase->getSolutionImage()) {
                    $fileService->remove($this->getParameter('kernel.project_dir')."/public/".$solutionBase->getSolutionImage());
                }

                if($solutionBase){
                    $entityManager->getRepository(SupportEntites\Solutions::class)->removeEntryBySolution($solutionId);

                    $entityManager->remove($solutionBase);
                    $entityManager->flush();

                    $json['alertClass'] = 'success';
                    $json['alertMessage'] = $this->translator->trans('Success ! Folder deleted successfully.');
                }else{

                    $json['alertClass'] = 'error';
                    $json['alertMessage'] = $this->translator->trans('Warning ! Folder does not exists.');
                }
                break;
            default:
                $json['alertClass'] = 'error';
                $json['alertMessage'] = "Warning ! Bad request !";
                break;

        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
