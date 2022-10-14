<?php

namespace Webkul\UVDesk\AutomationBundle\Controller\Automations;

use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\AutomationBundle\Entity;
use Webkul\UVDesk\AutomationBundle\Form\DefaultForm;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam;;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;

class PreparedResponse extends AbstractController
{
    const ROLE_REQUIRED_MANUAL = 'ROLE_AGENT_MANAGE_WORKFLOW_MANUAL';
    const LIMIT = 20;
    const WORKFLOW_MANUAL = 0;
    const WORKFLOW_AUTOMATIC = 1;
    const NAME_LENGTH = 100;
    const DESCRIPTION_LENGTH = 200;

    private $userService;
    private $translator;

    public function __construct(UserService $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    public function prepareResponseList(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_WORKFLOW_MANUAL')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        return $this->render('@UVDeskAutomation//PreparedResponse//preparedResponses.html.twig');
    }

    public function createPrepareResponse(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_WORKFLOW_MANUAL')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $error = $formData = $formerror = [];
        $entityManager = $em = $this->getDoctrine()->getManager();

        $workflowEventType = false;

        $form = $this->createForm(DefaultForm::class);

        if($request->request->all()) {
            $form->submit($request->request->all());
        }

        // Validate Form Submission
        if ($form->isSubmitted()) {
            $formData = $request->request;
            $workflowClass = 'Webkul\UVDesk\AutomationBundle\Entity\PreparedResponses';
            $workflowActionsArray = $request->request->get('actions');

            if (!trim($formData->get('name')) || (strlen($formData->get('name')) > self::NAME_LENGTH)) {
                $error['name'] = $this->translate('Warning! Please add valid Name! Length must not be greater than %length%', ['%length%' => self::NAME_LENGTH]);
            }

            if (strlen($formData->get('description')) > self::DESCRIPTION_LENGTH) {
                $error['description'] = $this->translate('Warning! Please add valid Description! Length must not be greater than %desc%', ['%desc%' => self::DESCRIPTION_LENGTH]);
            }

            if (!empty($workflowActionsArray)) {
                foreach ($workflowActionsArray as $key => $action) {
                    if (!$action['type']) {
                        unset($workflowActionsArray[$key]);
                    }
                }
            }

            if (empty($workflowActionsArray)) {
                $error['actions'] = $this->translate('Warning! Please add valid Actions!');
            }

            if (empty($error)) {
                // Check if new workflow and old one belong to the same class
                if (!empty($workflow) && $workflow instanceof $workflowClass) {
                    $newWorkflow = $workflow;
                } else {
                    $newWorkflow = new $workflowClass;
                    if (!empty($workflow)) {
                        $entityManager->remove($workflow);
                        $entityManager->flush();
                    }
                }

                if ($this->userService->isAccessAuthorized('ROLE_ADMIN')) {
                    /* groups */ 
                    $groups = explode(',', $request->request->get('tempGroups'));
                    $previousGroupIds = [];
                    if($newWorkflow->getGroups()) {
                        foreach($newWorkflow->getGroups() as $key => $group) {
                            $previousGroupIds[] = $group->getId();
                            if(!in_array($group->getId(), $groups ) ) {
                                $newWorkflow->removeGroup($group);
                                $em->persist($newWorkflow);
                            }
                        }
                    }
                    foreach($groups as $key => $groupId) {
                        if($groupId) {
                            $group = $em->getRepository(SupportGroup::class)->findOneBy([ 'id' => $groupId]);
                            if($group && (empty($previousGroupIds) || !in_array($groupId, $previousGroupIds)) ) {
                                $newWorkflow->addGroup($group);
                                $em->persist($newWorkflow);
                            }
                        }
                    }

                    /* teams */
                    $teams = explode(',', $request->request->get('tempTeams'));
                    $previousTeamIds = [];
                    if($newWorkflow->getTeams()) {
                        foreach($newWorkflow->getTeams() as $key => $team) {
                            $previousTeamIds[] = $team->getId();
                            if(!in_array($team->getId(), $teams ) ) {
                                $newWorkflow->removeTeam($team);
                                $em->persist($newWorkflow);
                            }
                        }
                    }
                    foreach($teams as $key => $teamId) {
                        if($teamId) {
                            $team = $em->getRepository(SupportTeam::class)->findOneBy([ 'id' => $teamId]);
                            if($team && (empty($previousTeamIds) || !in_array($teamId, $previousTeamIds)) ) {
                                $newWorkflow->addTeam($team);
                                $em->persist($newWorkflow);
                            }
                        }
                    }
                }

                $newWorkflow->setName($formData->get('name'));
                $newWorkflow->setDescription($formData->get('description'));
                $newWorkflow->setStatus($formData->get('status') == 'on' ? true : false);

                $userData = $this->userService->getUserDetailById($this->getUser()->getId());
                if (!$newWorkflow->getUser()) {
                    $newWorkflow->setUser($userData);
                }

                if($newWorkflow->getUser()->getId() == $userData->getId() || $this->userService->isAccessAuthorized('ROLE_ADMIN')) {
                    $newWorkflow->setActions($workflowActionsArray);
                }

                $newWorkflow->setType('');
                $entityManager->persist($newWorkflow);
                $entityManager->flush();

                $this->addFlash('success', $request->attributes->get('id')
                    ? $this->translator->trans('Success! Prepared Response has been updated successfully.')
                    :  $this->translator->trans('Success! Prepared Response has been added successfully.')
                );

                return $this->redirectToRoute('prepare_response_action');
            }

            $formData = [
                'type' => $request->request->get('type'),
                'name' => $request->request->get('name'),
                'description' => $request->request->get('description'),
                'status' => $request->request->get('status'),
                'events' => $request->request->get('events'),
                'actions' => !empty($workflow) ? $workflow->getActions() : $request->request->get('actions'),
                'conditions' => $request->request->get('conditions'),
            ];
        }

        return $this->render('@UVDeskAutomation//PreparedResponse//createPreparedResponse.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
            'formerror' => $formerror,
            'formData' => $formData,
        ));
    }


    public function editPrepareResponse(Request $request, ContainerInterface $container)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_WORKFLOW_MANUAL')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $error = $formData = $formerror = [];
        $entityManager = $em = $this->getDoctrine()->getManager();
        
        if ($request->attributes->get('id')) {

            $workflow = $entityManager->getRepository(Entity\PreparedResponses::class)->getPreparedResponse($request->attributes->get('id'), $container);

            if (!empty($workflow)) {
                $formData = [
                    'type' => self::WORKFLOW_MANUAL,
                    'name' => $workflow->getName(),
                    'description' => $workflow->getDescription(),
                    'status' => $workflow->getStatus(),
                    'actions' => $workflow->getActions(),
                    'groups' => $workflow->getGroups(),
                    'teams' => $workflow->getTeams()
                ];
            } else {
                // Workflow not found
                $this->noResultFound();
            }
        }

        $workflowEventType = false;

        $form = $this->createForm(DefaultForm::class);

        if($request->request->all()) {
            $form->submit($request->request->all());
        }

        // Validate Form Submission
        if ($form->isSubmitted()) {
            $formData = $request->request;
            $workflowClass = 'Webkul\UVDesk\AutomationBundle\Entity\PreparedResponses';
            $workflowActionsArray = $request->request->get('actions');

            if (!trim($formData->get('name')) || (strlen($formData->get('name')) > self::NAME_LENGTH)) {
                $error['name'] = $this->translate('Warning! Please add valid Name! Length must not be greater than %length%', ['%length%' => self::NAME_LENGTH]);
            }

            if (strlen($formData->get('description')) > self::DESCRIPTION_LENGTH) {
                $error['description'] = $this->translate('Warning! Please add valid Description! Length must not be greater than %desc%', ['%desc%' => self::DESCRIPTION_LENGTH]);
            }

            if (!empty($workflowActionsArray)) {
                foreach ($workflowActionsArray as $key => $action) {
                    if (!$action['type']) {
                        unset($workflowActionsArray[$key]);
                    }
                }
            }

            if (empty($workflowActionsArray)) {
                $error['actions'] = $this->translate('Warning! Please add valid Actions!');
            }

            if ($workflowEventType && array_values($workflowEventsArray)[0]['event'] != $workflowEventType) {
                $error['events'] = $this->translate('Warning! In Free Plan you can not change Events!');
            }

            if (empty($error)) {
                // Check if new workflow and old one belong to the same class
                if (!empty($workflow) && $workflow instanceof $workflowClass) {
                    $newWorkflow = $workflow;
                } else {
                    $newWorkflow = new $workflowClass;
                    if (!empty($workflow)) {
                        $entityManager->remove($workflow);
                        $entityManager->flush();
                    }
                }
                
                if ($this->userService->isAccessAuthorized('ROLE_ADMIN')) {
                    /* groups */ 
                    $groups = explode(',', $request->request->get('tempGroups'));
                    $previousGroupIds = [];
                    if($newWorkflow->getGroups()) {
                        foreach($newWorkflow->getGroups() as $key => $group) {
                            $previousGroupIds[] = $group->getId();
                            if(!in_array($group->getId(), $groups ) ) {
                                $newWorkflow->removeGroup($group);
                                $em->persist($newWorkflow);
                            }
                        }
                    }
                    foreach($groups as $key => $groupId) {
                        if($groupId) {
                            $group = $em->getRepository(SupportGroup::class)->findOneBy([ 'id' => $groupId]);
                            if($group && (empty($previousGroupIds) || !in_array($groupId, $previousGroupIds)) ) {
                                $newWorkflow->addGroup($group);
                                $em->persist($newWorkflow);
                            }
                        }
                    }

                    /* teams */
                    $teams = explode(',', $request->request->get('tempTeams'));
                    $previousTeamIds = [];
                    if($newWorkflow->getTeams()) {
                        foreach($newWorkflow->getTeams() as $key => $team) {
                            $previousTeamIds[] = $team->getId();
                            if(!in_array($team->getId(), $teams ) ) {
                                $newWorkflow->removeTeam($team);
                                $em->persist($newWorkflow);
                            }
                        }
                    }
                    foreach($teams as $key => $teamId) {
                        if($teamId) {
                            $team = $em->getRepository(SupportTeam::class)->findOneBy([ 'id' => $teamId]);
                            if($team && (empty($previousTeamIds) || !in_array($teamId, $previousTeamIds)) ) {
                                $newWorkflow->addTeam($team);
                                $em->persist($newWorkflow);
                            }
                        }
                    }
                }

                $newWorkflow->setName($formData->get('name'));
                $newWorkflow->setDescription($formData->get('description'));
                $newWorkflow->setStatus($formData->get('status') == 'on' ? true : false);

                $userData = $this->userService->getUserDetailById($this->getUser()->getId());
                if (!$newWorkflow->getUser()) {
                    $newWorkflow->setUser($userData);
                }

                if ($newWorkflow->getUser()->getId() == $userData->getId() || $this->userService->isAccessAuthorized('ROLE_ADMIN')) {
                    $newWorkflow->setActions($workflowActionsArray);
                }

                $newWorkflow->setType('');
                $entityManager->persist($newWorkflow);
                $entityManager->flush();

                $this->addFlash('success', $request->attributes->get('id')
                    ? $this->translator->trans('Success! Prepared Response has been updated successfully.')
                    :  $this->translator->trans('Success! Prepared Response has been added successfully.')
                );

                return $this->redirectToRoute('prepare_response_action');
            }

            $formData = [
                'type' => $request->request->get('type'),
                'name' => $request->request->get('name'),
                'description' => $request->request->get('description'),
                'status' => $request->request->get('status'),
                'events' => $request->request->get('events'),
                'actions' => !empty($workflow) ? $workflow->getActions() : $request->request->get('actions'),
                'conditions' => $request->request->get('conditions'),
            ];
        }

        return $this->render('@UVDeskAutomation//PreparedResponse//createPreparedResponse.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
            'formerror' => $formerror,
            'formData' => $formData,
        ));
    }

}
