<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SavedReplies as CoreBundleSavedReplies;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Form as CoreFrameworkBundleForms;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreFrameworkBundleEntities;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SavedReplies extends AbstractController
{
    const LIMIT = 10;
    const ROLE_REQUIRED = 'saved_replies';

    private $userService;
    private $translator;
    
    public function __construct(UserService $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    public function loadSavedReplies(Request $request)
    {
        $savedReplyReferenceIds = $this->userService->getUserSavedReplyReferenceIds();

        return $this->render('@UVDeskCoreFramework//savedRepliesList.html.twig', [
            'savedReplyReferenceIds' => array_unique($savedReplyReferenceIds),
        ]);
    }

    public function updateSavedReplies(Request $request, ContainerInterface $container)
    {
        $templateId = $request->attributes->get('template');
        $repository = $this->getDoctrine()->getRepository(CoreFrameworkBundleEntities\SavedReplies::class);

        if (empty($templateId)) {
            $template = new CoreFrameworkBundleEntities\SavedReplies();
        } else {
            // @TODO: Refactor: We shouldn't be passing around the container.
            $template = $repository->getSavedReply($templateId, $container);

            if (empty($template)) {
                $this->noResultFound();
            }
        }

        $errors = [];
        if ($request->getMethod() == 'POST') {
            if (empty($request->request->get('message'))) {
                $this->addFlash('warning',  $this->translator->trans('Error! Saved reply body can not be blank'));
                
                return $this->render('@UVDeskCoreFramework//savedReplyForm.html.twig', [
                    'template' => $template,
                    'errors' => json_encode($errors)
                ]);
            }

            $em = $this->getDoctrine()->getManager();
            $template->setName($request->request->get('name'));

            // Groups
            $previousGroupIds = [];
            $groups = explode(',', $request->request->get('tempGroups'));

            if ($template->getSupportGroups()) {
                foreach ($template->getSupportGroups()->toArray() as $key => $group) {
                    $previousGroupIds[] = $group->getId();
                    if (!in_array($group->getId(), $groups) && $this->getUser()->getAgentInstance()->getSupportRole()->getCode() != "ROLE_AGENT") {
                        $template->removeSupportGroups($group);
                        $em->persist($template);
                    }
                }
            }

            foreach($groups as $key => $groupId) {
                if ($groupId) {
                    $group = $em->getRepository(SupportGroup::class)->findOneBy([ 'id' => $groupId ]);

                    if ($group && (empty($previousGroupIds) || !in_array($groupId, $previousGroupIds))) {
                        $template->addSupportGroup($group);
                        $em->persist($template);
                    }
                }
            }

            // Teams
            $previousTeamIds = [];
            $teams = explode(',', $request->request->get('tempTeams'));

            if ($template->getSupportTeams()) {
                foreach ($template->getSupportTeams()->toArray() as $key => $team) {
                    $previousTeamIds[] = $team->getId();
                   
                    if (!in_array($team->getId(), $teams) && $this->getUser()->getAgentInstance()->getSupportRole()->getCode() != "ROLE_AGENT") {
                        $template->removeSupportTeam($team);
                        $em->persist($template);
                    }
                }
            }

            foreach ($teams as $key => $teamId) {
                if ($teamId) {
                    $team = $em->getRepository(SupportTeam::class)->findOneBy([ 'id' => $teamId ]);

                    if ($team && (empty($previousTeamIds) || !in_array($teamId, $previousTeamIds))) {
                        $template->addSupportTeam($team);
                        $em->persist($template);
                    }
                }
            }

            $template->setMessage($request->request->get('message'));

            if (empty($template->getUser()))  {
                $template->setUser($this->getUser()->getAgentInstance());
            }
            
            $em->persist($template);
            $em->flush();

            $this->addFlash('success', $request->attributes->get('template') ? $this->translator->trans('Success! Reply has been updated successfully.'): $this->translator->trans('Success! Reply has been added successfully.'));

            return $this->redirectToRoute('helpdesk_member_saved_replies');
        }

        return $this->render('@UVDeskCoreFramework//savedReplyForm.html.twig', array(
            'template' => $template,
            'errors' => json_encode($errors)
        ));
    }

    public function savedRepliesXHR(Request $request, ContainerInterface $container)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new \Exception(404);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $savedReplyRepository = $entityManager->getRepository(CoreBundleSavedReplies::class);

        if ($request->getMethod() == 'GET') {
            $responseContent = $savedReplyRepository->getSavedReplies($request->query, $container);
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
                'alertMessage' => $this->translator->trans('Success! Saved Reply has been deleted successfully.')
            ];
        }

        return new Response(json_encode($responseContent), 200, ['Content-Type' => 'application/json']);
    }

    private function getId($item)
    {
        return $item->getId();
    }
}
