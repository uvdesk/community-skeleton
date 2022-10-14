<?php

namespace Webkul\UVDesk\SupportCenterBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Webkul\UVDesk\SupportCenterBundle\Entity as SupportEntites;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\FileUploadService;
use Webkul\UVDesk\CoreFrameworkBundle\FileSystem\FileSystem;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Filesystem\Filesystem as Fileservice;

class Folder extends AbstractController
{
    private $userService;
    private $translator;
    private $fileSystem;
    private $fileUploadService;

    public function __construct(UserService $userService, TranslatorInterface $translator, FileSystem $fileSystem, FileUploadService $fileUploadService)
    {
        $this->userService = $userService;
        $this->translator = $translator;
        $this->fileSystem = $fileSystem;
        $this->fileUploadService = $fileUploadService;
    }

    public function listFolders(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $totalKnowledgebaseFolders = count($entityManager->getRepository(SupportEntites\Solutions::class)->findAll());
        $totalKnowledgebaseCategories = count($entityManager->getRepository(SupportEntites\SolutionCategory::class)->findAll());
        $totalKnowledgebaseArticles = count($entityManager->getRepository(SupportEntites\Article::class)->findAll());

        return $this->render('@UVDeskSupportCenter/Staff/Folders/listFolders.html.twig', [
            'articleCount' => $totalKnowledgebaseArticles,
            'categoryCount' => $totalKnowledgebaseCategories,
            'solutionCount' => $totalKnowledgebaseFolders,
        ]);
    }

    public function createFolder(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $folder = new SupportEntites\Solutions();
        $errors = [];

        if ($request->getMethod() == "POST") {
            $entityManager = $this->getDoctrine()->getManager();
            $solutionImage = $request->files->get('solutionImage');

            if ($imageFile = $request->files->get('solutionImage')) { 
                if ($imageFile->getMimeType() == "image/svg+xml" || $imageFile->getMimeType() == "image/svg") {
                    if (!$this->fileUploadService->svgFileCheck($imageFile)){
                        $message = $this->translator->trans('Warning! Not a vaild svg. (Recommened: PNG, JPG or GIF Format).');
                        $this->addFlash('warning', $message);
    
                        return $this->redirect($this->generateUrl('helpdesk_member_knowledgebase_create_folder'));
                    }
                }

                if (!preg_match('#^(image/)(?!(tif)|(svg) )#', $imageFile->getMimeType()) && !preg_match('#^(image/)(?!(tif)|(svg))#', $imageFile->getClientMimeType())) {

                    $message = $this->translator->trans('Warning! Provide valid image file. (Recommened: PNG, JPG or GIF Format).');
                    $this->addFlash('warning', $message);

                    return $this->redirect($this->generateUrl('helpdesk_member_knowledgebase_create_folder'));
                }
            }

            $data = $request->request->all();
            $folder->setName($data['name']);
            $folder->setDescription($data['description']);
            $folder->setvisibility($data['visibility']);
            if(isset($solutionImage)){
                $assetDetails = $this->fileSystem->getUploadManager()->uploadFile($solutionImage, 'knowledgebase');
                $folder->setSolutionImage($assetDetails['path']);
            }
            $folder->setDateAdded( new \DateTime());
            $folder->setDateUpdated( new \DateTime());
            $folder->setSortOrder(1);
            $entityManager->persist($folder);
            $entityManager->flush();
            $message = $this->translator->trans('Success! Folder has been added successfully.');

            $this->addFlash('success', $message);

            return $this->redirect($this->generateUrl('helpdesk_member_knowledgebase_folders_collection'));
        }

        return $this->render('@UVDeskSupportCenter/Staff/Folders/createFolder.html.twig', [
            'folder' => $folder,
            'errors' => json_encode($errors)
        ]);
    }

    public function updateFolder($folderId)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $knowledgebaseFolder = $entityManager->getRepository(SupportEntites\Solutions::class)->findSolutionById(['id' => $folderId]);

        if (empty($knowledgebaseFolder)) {
            $this->noResultFound();
        }

        if ($request->getMethod() == "POST") {
            $formData = $request->request->all();
            $solutionImage = $request->files->get('solutionImage');

            if ($imageFile = $request->files->get('solutionImage')) {

                if ($imageFile->getMimeType() == "image/svg+xml" || $imageFile->getMimeType() == "image/svg") {
                    if (!$this->fileUploadService->svgFileCheck($imageFile)){
                        $message = $this->translator->trans('Warning! Not a vaild svg. (Recommened: PNG, JPG or GIF Format).');
                        $this->addFlash('warning', $message);
    
                        return $this->redirect($this->generateUrl('helpdesk_member_knowledgebase_create_folder'));
                    }
                }
                
                if (!preg_match('#^(image/)(?!(tif)|(svg) )#', $imageFile->getMimeType()) && !preg_match('#^(image/)(?!(tif)|(svg))#', $imageFile->getClientMimeType())) {
                    $message = $this->translator->trans('Warning! Provide valid image file. (Recommened: PNG, JPG or GIF Format).');
                    $this->addFlash('warning', $message);

                    return $this->render('@UVDeskSupportCenter/Staff/Folders/updateFolder.html.twig', [
                        'folder' => $folder
                    ]);
                }
            }
            $formData = $request->request->all();
            if (isset($solutionImage)) {
                // Removing old image from physical path is new image uploaded
                $fileService = new Fileservice();
                if ($knowledgebaseFolder->getSolutionImage()) {
                    $fileService->remove($this->getParameter('kernel.project_dir')."/public/".$knowledgebaseFolder->getSolutionImage());
                }

                $assetDetails = $this->fileSystem->getUploadManager()->uploadFile($solutionImage, 'knowledgebase');
                $knowledgebaseFolder->setSolutionImage($assetDetails['path']);
            }

            $knowledgebaseFolder
                ->setName($formData['name'])
                ->setDescription($formData['description'])
                ->setvisibility($formData['visibility'])
                ->setDateUpdated( new \DateTime())
                ->setSortOrder(1);

            $entityManager->persist($knowledgebaseFolder);
            $entityManager->flush();

            $this->addFlash('success', $this->translator->trans('Folder updated successfully.'));
            
            return $this->redirect($this->generateUrl('helpdesk_member_knowledgebase_folders_collection'));
        }

        return $this->render('@UVDeskSupportCenter/Staff/Folders/updateFolder.html.twig', [
            'folder' => $knowledgebaseFolder,
            'errors' => json_encode(!empty($errors) ? $errors : [])
        ]);
    }

    /**
     * If customer is playing with url and no result is found then what will happen
     * @return 
     */
    protected function noResultFound()
    {
        throw new NotFoundHttpException('Not Found!');
    }
}
