<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webkul\UVDesk\CoreFrameworkBundle\Form as CoreFrameworkBundleForms;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\HTMLFilter;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreFrameworkBundleEntities;

class SavedReplies extends Controller
{
    const LIMIT = 10;
    const ROLE_REQUIRED = 'saved_replies';

    public function loadSavedReplies(Request $request) 
    {        
        return $this->render('@UVDeskCoreFramework//savedRepliesList.html.twig');
    }

    public function updateSavedReplies(Request $request) 
    {
        $repository = $this->getDoctrine()->getRepository('UVDeskCoreFrameworkBundle:SavedReplies');
        if($request->attributes->get('template'))
            $template = $repository->getSavedReply($request->attributes->get('template'), $this->container);
        else
            $template = new CoreFrameworkBundleEntities\SavedReplies();

        if(!$template)
            $this->noResultFound();

        $errors = [];
        if ($request->getMethod() == 'POST') {
            if(empty($request->request->get('message'))){
                $this->addFlash('warning', $this->get('translator')->trans('Error! Saved reply body can not be blank'));
                return $this->render('@UVDeskCoreFramework//savedReplyForm.html.twig', array(
                    'template' => $template,
                    'errors' => json_encode($errors)
                ));
            }

            $em = $this->getDoctrine()->getManager();
            $template->setName($request->request->get('name'));
            //if($this->get('user.service')->checkPermission('ROLE_ADMIN')) {
            /* groups */ 
            $groups = explode(',', $request->request->get('tempGroups'));
            $previousGroupIds = [];
            if($template->getSupportGroups()) {
                foreach($template->getSupportGroups() as $key => $group) {
                    $previousGroupIds[] = $group->getId();
                    if(!in_array($group->getId(), $groups ) ) {
                        $template->removeSupportGroups($group);
                        $em->persist($template);
                    }
                }
            }
            foreach($groups as $key => $groupId) {
                if($groupId) {
                    $group = $em->getRepository('UVDeskCoreFrameworkBundle:SupportGroup')->findOneBy([ 'id' => $groupId ]);
                    if($group && (empty($previousGroupIds) || !in_array($groupId, $previousGroupIds)) ) {
                        $template->addSupportGroup($group);
                        $em->persist($template);
                    }
                }
            }

            /* teams */
            $teams = explode(',', $request->request->get('tempTeams'));
            $previousTeamIds = [];
            if($template->getSupportTeams()) {
                foreach($template->getSupportTeams() as $key => $team) {
                    $previousTeamIds[] = $team->getId();
                    if(!in_array($team->getId(), $teams ) ) {
                        $template->removeSupportTeam($team);
                        $em->persist($template);
                    }
                }
            }
            foreach($teams as $key => $teamId) {
                if($teamId) {
                    $team = $em->getRepository('UVDeskCoreFrameworkBundle:SupportTeam')->findOneBy([ 'id' => $teamId ]);
                    if($team && (empty($previousTeamIds) || !in_array($teamId, $previousTeamIds)) ) {
                        $template->addSupportTeam($team);
                        $em->persist($template);
                    }
                }
            }
            
            $htmlFilter = new HTMLFilter();      

            //htmlfilter these values
            $template->setMessage($request->request->get('message'));
            if(empty($template->getUser()))  {
                $template->setUser($this->getUser()->getAgentInstance());
            }
            $em->persist($template);
            $em->flush();

            $this->addFlash('success', $request->attributes->get('template') ? $this->get('translator')->trans('Success! Reply has been updated successfully.'): $this->get('translator')->trans('Success! Reply has been added successfully.'));
            return $this->redirectToRoute('helpdesk_member_saved_replies');
        }

        return $this->render('@UVDeskCoreFramework//savedReplyForm.html.twig', array(
            'template' => $template,
            'errors' => json_encode($errors)
        ));
    } 

    public function savedRepliesXHR(Request $request) 
    {
        if (!$request->isXmlHttpRequest()) {
            throw new \Exception(404);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $savedReplyRepository = $entityManager->getRepository('UVDeskCoreFrameworkBundle:SavedReplies');
        
        if ($request->getMethod() == 'GET') {
            $responseContent = $savedReplyRepository->getSavedReplies($request->query, $this->container);
        } else {
            $savedReplyId = $request->attributes->get('template');

            if (null == $savedReplyId || $request->getMethod() != 'DELETE') {
                throw new \Exception(404);
            } else {
                $savedReply = $savedReplyRepository->findOneBy(['id' => $savedReplyId, 'user' => $this->getUser()->getAgentInstance()]); 

                if (empty($savedReply)) {
                    throw new \Exception(404);
                }
            }

            $entityManager->remove($savedReply);
            $entityManager->flush();

            $responseContent = [
                'alertClass' => 'success',
                'alertMessage' => $this->get('translator')->trans('Success! Saved Reply has been deleted successfully.')
            ];
        }

        return new Response(json_encode($responseContent), 200, ['Content-Type' => 'application/json']);
    }

    private function getId($item)
    {
        return $item->getId();
    }
}
