<?php

namespace Webkul\UVDesk\SupportCenterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class KnowledgebaseXHR extends Controller
{
    public function listFoldersXHR(Request $request)
    {  
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $response = new Response();
        $folderCollection = $this->getDoctrine()->getRepository('UVDeskSupportCenterBundle:Solutions')->getAllSolutions($request->query, $this->container);

        $response->setContent(json_encode($folderCollection));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function updateFolderXHR(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $json = array();

        $entityManager = $this->getDoctrine()->getManager();
        switch($request->getMethod())
        {
            case "PATCH":
                $content = json_decode($request->getContent(), true);
                $solutionId = $content['id'];
                $solution = $entityManager->getRepository('UVDeskSupportCenterBundle:Solutions')->find($solutionId);
                if($solution) {
                    switch($content['editType']){
                        case 'status':
                            $solution->setVisibility($content['value']);
                            $entityManager->persist($solution);
                            $entityManager->flush();                            
                            $json['alertClass'] = 'success';
                            $json['alertMessage'] = $this->get('translator')->trans('Success ! Folder status updated successfully.');
                            break;
                        default:
                            break;
                    }
                } else {
                    $json['alertClass'] = 'danger';
                    $json['alertMessage'] = $this->get('translator')->trans('Error ! Folder is not exist.');
                }
            break;
            case "PUT":
              
                $content = json_decode($request->getContent(), true);
                $solutionId = $content['id'];
                $solution = $entityManager->getRepository('UVDeskSupportCenterBundle:Solutions')->find($solutionId);
                if($solution) {
                    
                        $solution->setName($content['name']);
                        $solution->setDescription($content['description']);
                        $entityManager->persist($solution);
                        $entityManager->flush();
                        
                        $json['alertClass'] = 'success';
                        $json['alertMessage'] =$this->get('translator')->trans('Success ! Folder updated successfully.');
                        
                  
                } else {
                    $json['alertClass'] = 'danger';
                    $json['alertMessage'] = $this->get('translator')->trans('Error ! Folder does not exist.');
                }
            break;
            case "DELETE":
                $solutionId = $request->attributes->get('folderId');
                $solutionBase = $entityManager->getRepository('UVDeskSupportCenterBundle:Solutions')->find($solutionId);

                if($solutionBase){
                    $entityManager->getRepository('UVDeskSupportCenterBundle:Solutions')->removeEntryBySolution($solutionId);

                    $entityManager->remove($solutionBase);
                    $entityManager->flush();

                    $json['alertClass'] = 'success';
                    $json['alertMessage'] = $this->get('translator')->trans('Success ! Folder deleted successfully.');
                }else{

                    $json['alertClass'] = 'error';
                    $json['alertMessage'] = $this->get('translator')->trans("Warning ! Folder doesn't exists!");
                }
            break;
            default:
                $json['alertClass'] = 'error';
                $json['alertMessage'] = $this->get('translator')->trans("Warning ! Bad request !");
            break;

        }
      
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
