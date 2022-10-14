<?php

namespace Webkul\UVDesk\AutomationBundle\Controller\Automations;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\AutomationBundle\Form\DefaultForm;
use Webkul\UVDesk\AutomationBundle\Entity;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Webkul\UVDesk\AutomationBundle\EventListener\WorkflowListener;
use Symfony\Contracts\Translation\TranslatorInterface;

class Workflow extends AbstractController
{

    const ROLE_REQUIRED_AUTO = 'ROLE_AGENT_MANAGE_WORKFLOW_AUTOMATIC';
    const ROLE_REQUIRED_MANUAL = 'ROLE_AGENT_MANAGE_WORKFLOW_MANUAL';
    const LIMIT = 20;
    const WORKFLOW_MANUAL = 0;
    const WORKFLOW_AUTOMATIC = 1;
    const NAME_LENGTH = 100;
    const DESCRIPTION_LENGTH = 200;
    
    private $userService;
    private $translator;
    private $workflowListnerService;
    
    public function __construct(UserService $userService, WorkflowListener $workflowListnerService,TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->workflowListnerService = $workflowListnerService;
        $this->translator = $translator;
    }

    public function listWorkflowCollection(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_WORKFLOW_AUTOMATIC')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        return $this->render('@UVDeskAutomation//Workflow//workflowList.html.twig');
    }

    // Creating workflow
    public function createWorkflow(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_WORKFLOW_AUTOMATIC')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $error = $formData = $formerror = [];
        $entityManager = $this->getDoctrine()->getManager();

        $workflowEventType = (!empty($workflow) && $workflow->getWorkflowEvents()[0]) ? current(explode('.', $workflow->getWorkflowEvents()[0]->getEvent())) : false;

        $form = $this->createForm(DefaultForm::class);

        if($request->request->all()) {
            $form->submit($request->request->all());
        }

        if ($form->isSubmitted()) {
            $formData = $request->request;
            $workflowClass = 'Webkul\UVDesk\AutomationBundle\Entity\Workflow';
            $workflowActionsArray = $request->request->get('actions');

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

            // Remove blank values from arrays
            $workflowEventsArray = $request->request->get('events');
            if (!empty($workflowEventsArray)) {
                foreach ($workflowEventsArray as $key => $event) {
                    if (!$event['event']) {
                        unset($workflowEventsArray[$key]);
                    }
                }
            }

            if (empty($workflowEventsArray)) {
                $error['events'] = $this->translate('Warning! Please add valid Events!');
            }

            $workflowConditionsArray = $request->request->get('conditions');
            if ($workflowConditionsArray) {
                foreach ($workflowConditionsArray as $key => $condition) {
                    if (!$condition['type']) {
                        unset($workflowConditionsArray[$key]);
                    }
                }
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

                $newWorkflow->setName($formData->get('name'));
                $newWorkflow->setDescription($formData->get('description'));
                $newWorkflow->setStatus($formData->get('status') == 'on' ? true : false);
                $newWorkflow->setActions($workflowActionsArray);
                $newWorkflow->setDateAdded(new \Datetime);
                $newWorkflow->setDateUpdated(new \Datetime);
                

                $formDataGetEvents = array_unique($formData->get('events'), SORT_REGULAR);
                if ($newWorkflow->getWorkflowEvents()) {
                    foreach ($newWorkflow->getWorkflowEvents() as $newWorkflowEvent) {
                        if ($thisKey = array_search(['event' => current($exNewEventEvent = explode('.', $newWorkflowEvent->getEvent())), 'trigger' => end($exNewEventEvent)], $formDataGetEvents)) {
                            unset($formDataGetEvents[$thisKey]);
                        } else {
                            $entityManager->remove($newWorkflowEvent);
                            $entityManager->flush();
                        }
                    }
                }

                $newWorkflow->setConditions($workflowConditionsArray);

                $entityManager->persist($newWorkflow);
                $entityManager->flush();

                foreach ($formDataGetEvents as $eventEvents) {
                    $event = new Entity\WorkflowEvents;
                    $event->setEvent($eventEvents['trigger']);
                    $event->setWorkflow($newWorkflow);
                    $event->setEventId($newWorkflow->getId());
                    $entityManager->persist($event);
                    $entityManager->flush();
                }

                $this->addFlash('success', $request->attributes->get('id')
                    ? $this->translator->trans('Success! Workflow has been updated successfully.')
                    :  $this->translator->trans('Success! Workflow has been added successfully.')
                );

                return $this->redirectToRoute('helpdesk_member_workflow_collection');
            }

            $formData = [
                'type' => $request->request->get('type'),
                'name' => $request->request->get('name'),
                'description' => $request->request->get('description'),
                'status' => $request->request->get('status'),
                'events' => $request->request->get('events'),
                'actions' => $request->request->get('actions'),
                'conditions' => $request->request->get('conditions'),
            ];
        }
      
        return $this->render('@UVDeskAutomation//Workflow//createWorkflow.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
            'formerror' => $formerror,
            'formData' => $formData,
        ));
    }

    public function editWorkflow(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_WORKFLOW_AUTOMATIC')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $error = $formData = $formerror = [];
        $entityManager = $this->getDoctrine()->getManager();

        if ($request->attributes->get('id')) {
            $workflow = $entityManager->getRepository(Entity\Workflow::class)->findOneById($request->attributes->get('id'));

            if (!empty($workflow)) {
                $formData = [
                    'type' => self::WORKFLOW_AUTOMATIC,
                    'name' => $workflow->getName(),
                    'description' => $workflow->getDescription(),
                    'status' => $workflow->getStatus(),
                    'actions' => $workflow->getActions(),
                    'conditions' => $workflow->getConditions(),
                    'events' => [],
                ];

                foreach ($workflow->getWorkflowEvents() as $event) {
                    $eventDefinition = $this->workflowListnerService->getRegisteredWorkflowEvent($event->getEvent());

                    if (!empty($eventDefinition)) {
                        $formData['events'][] = [
                            'event' => $eventDefinition->getFunctionalGroup(),
                            'trigger' => $eventDefinition->getId(),
                        ];
                    }
                }
            } else {
                // Workflow not found
                $this->noResultFound();
            }
        }

        $workflowEventType = (!empty($workflow) && $workflow->getWorkflowEvents()[0]) ? current(explode('.', $workflow->getWorkflowEvents()[0]->getEvent())) : false;

        $form = $this->createForm(DefaultForm::class);

        if($request->request->all()) {
            $form->submit($request->request->all());
        }

        if ($form->isSubmitted()) {
            $formData = $request->request;
            
            $workflowClass = 'Webkul\UVDesk\AutomationBundle\Entity\Workflow';
            $workflowActionsArray = $request->request->get('actions');

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

            // Check Authorization for Automatic Workflow
            // $this->isAuthorized(self::ROLE_REQUIRED_AUTO);

            // Remove blank values from arrays
            $workflowEventsArray = $request->request->get('events');
            if (!empty($workflowEventsArray)) {
                foreach ($workflowEventsArray as $key => $event) {
                    if (!$event['event']) {
                        unset($workflowEventsArray[$key]);
                    }
                }
            }

            if (empty($workflowEventsArray)) {
                $error['events'][] = $this->translate('Warning! Please add valid Events!');
            }

            /*
                @NOTICE: Events 'uvdesk.agent.forgot_password', 'uvdesk.customer.forgot_password' will be deprecated 
                onwards uvdesk/automation-bundle:1.0.2 and uvdesk/core-framework:1.0.3 releases and will be 
                completely removed with the next major release.
            */
            foreach ($workflowEventsArray as $eventAttributes) {
                if ($eventAttributes['event'] == 'agent' && $eventAttributes['trigger'] == 'uvdesk.user.forgot_password') {
                    $error['events'][] = $this->translate('"Agent Forgot Password" has been deprecated. Please use the "User Forgot Password" event instead.');
                } else if ($eventAttributes['event'] == 'customer' && $eventAttributes['trigger'] == 'uvdesk.user.forgot_password') {
                    $error['events'][] = $this->translate('"Customer Forgot Password" has been deprecated. Please use the "User Forgot Password" event instead.');
                }
            }

            $workflowConditionsArray = $request->request->get('conditions');
            if ($workflowConditionsArray) {
                foreach ($workflowConditionsArray as $key => $condition) {
                    if (!$condition['type']) {
                        unset($workflowConditionsArray[$key]);
                    }
                }
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

                $newWorkflow->setName($formData->get('name'));
                $newWorkflow->setDescription($formData->get('description'));
                $newWorkflow->setStatus($formData->get('status') == 'on' ? true : false);
                $newWorkflow->setActions($workflowActionsArray);
                $newWorkflow->setDateAdded(new \Datetime);
                $newWorkflow->setDateUpdated(new \Datetime);

                $formDataGetEvents = array_unique($formData->get('events'), SORT_REGULAR);

                if ($newWorkflow->getWorkflowEvents()) {
                    foreach ($newWorkflow->getWorkflowEvents() as $newWorkflowEvent) {
                        if ($thisKey = array_search([
                            'event' => current($exNewEventEvent = explode('.', $newWorkflowEvent->getEvent())), 
                            'trigger' => end($exNewEventEvent)
                        ], $formDataGetEvents)) {
                            unset($formDataGetEvents[$thisKey]);
                        } else {
                            $entityManager->remove($newWorkflowEvent);
                            $entityManager->flush();
                        }
                    }
                }

                $newWorkflow->setConditions($workflowConditionsArray);

                $entityManager->persist($newWorkflow);
                $entityManager->flush();

                foreach ($formDataGetEvents as $eventEvents) {
                    $event = new Entity\WorkflowEvents;
                    $event->setEvent($eventEvents['trigger']);
                    $event->setWorkflow($newWorkflow);
                    $event->setEventId($newWorkflow->getId());

                    $entityManager->persist($event);
                    $entityManager->flush();
                }

                $this->addFlash('success', $request->attributes->get('id')
                    ? $this->translator->trans('Success! Workflow has been updated successfully.')
                    :  $this->translator->trans('Success! Workflow has been added successfully.')
                );

                return $this->redirectToRoute('helpdesk_member_workflow_collection');
            } else {
                if (!empty($error['events'])) {
                    foreach ($error['events'] as $message) {
                        $this->addFlash('warning', $this->translator->trans("Events: " . $message));
                    }
                }
            }

            $formData = [
                'type' => $request->request->get('type'),
                'name' => $request->request->get('name'),
                'description' => $request->request->get('description'),
                'status' => $request->request->get('status'),
                'events' => $request->request->get('events'),
                'actions' => $request->request->get('actions'),
                'conditions' => $request->request->get('conditions'),
            ];
        }
      
        return $this->render('@UVDeskAutomation//Workflow//editWorkflow.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
            'formerror' => $formerror,
            'formData' => $formData,
        ));
    }

    //Remove Workflow
    public function deleteWorkflow(Request $request)
    {

    } 
    public function translate($string,$params = array())
    {
        return $this->translator->trans($string,$params);
    }
}
