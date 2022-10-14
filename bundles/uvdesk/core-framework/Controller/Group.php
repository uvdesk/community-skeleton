<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Webkul\UVDesk\CoreFrameworkBundle\Entity;
use Webkul\UVDesk\CoreFrameworkBundle\Form;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\SwiftMailer;

class Group extends AbstractController
{
    private $userService;
    private $translator;

    public function __construct(UserService $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    public function listGroups(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_GROUP')){
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        return $this->render('@UVDeskCoreFramework/Groups/listSupportGroups.html.twig');
    }

    public function editGroup(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_GROUP')){
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        if($request->attributes->get('supportGroupId')){
            $group = $this->getDoctrine()->getRepository(SupportGroup::class)
                ->findGroupById(['id' => $request->attributes->get('supportGroupId'),
                ]);

            if(!$group)
                $this->noResultFound();
        } else
            $group = new Entity\SupportGroup;

        $errors = [];
        if($request->getMethod() == "POST") {
            $data = $request->request->all() ? : json_decode($request->getContent(), true);
            $request->request->replace($data); // also for api

            if($request->request->get('tempUsers'))
                $request->request->set('users', explode(',', $request->request->get('tempUsers')));

            if($request->request->get('tempTeams'))
                $request->request->set('supportTeams', explode(',', $request->request->get('tempTeams')));

            $oldUsers = ($usersList = $group->getUsers()) ? $usersList->toArray() : [];
            $oldTeam  = ($teamList = $group->getSupportTeams()) ? $teamList->toArray() : [];


            $allDetails = $request->request->all();

            $em = $this->getDoctrine()->getManager();
            $group->setName($allDetails['name']);
            $group->setDescription($allDetails['description']);
            $group->setIsActive((bool) isset($allDetails['isActive']));

            $usersList = (!empty($allDetails['users']))? $allDetails['users'] : [];
            $userTeam  = (!empty($allDetails['supportTeams']))? $allDetails['supportTeams'] : [];

            if (!empty($usersList)) {
                $usersList = array_map(function ($user) { return 'user.id = ' . $user; }, $usersList);

                $userList = $em->createQueryBuilder()->select('user')
                    ->from(User::class, 'user')
                    ->where(implode(' OR ', $usersList))
                    ->getQuery()->getResult();
            }

            if (!empty($userTeam)) {
                $userTeam = array_map(function ($team) { return 'team.id = ' . $team; }, $userTeam);

                $userTeam = $em->createQueryBuilder()->select('team')
                    ->from(SupportTeam::class, 'team')
                    ->where(implode(' OR ', $userTeam))
                    ->getQuery()->getResult();
            }
            if(!empty($userList)){
                // Add Users to Group
                foreach ($userList as $user) {
                    $userInstance = $user->getAgentInstance();
                    if(!$oldUsers || !in_array($userInstance, $oldUsers)){
                        $userInstance->addSupportGroup($group);
                        $em->persist($userInstance);
                    }elseif($oldUsers && ($key = array_search($userInstance, $oldUsers)) !== false)
                        unset($oldUsers[$key]);
                }
                foreach ($oldUsers as $removeUser) {
                    $removeUser->removeSupportGroup($group);
                    $em->persist($removeUser);
                }
            }else{
                foreach ($oldUsers as $removeUser) {
                    $removeUser->removeSupportGroup($group);
                    $em->persist($removeUser);
                }
            }
            if(!empty($userTeam)){
                // Add Teams to Group
                foreach ($userTeam as $supportTeam) {

                    if(!$oldTeam || !in_array($supportTeam, $oldTeam)){
                        $group->addSupportTeam($supportTeam);
                    }elseif($oldTeam && ($key = array_search($supportTeam, $oldTeam)) !== false)
                        unset($oldTeam[$key]);
                }
                foreach ($oldTeam as $removeTeam) {
                    $group->removeSupportTeam($removeTeam);
                    $em->persist($group);
                }
            }else{
                foreach ($oldTeam as $removeTeam) {
                    $group->removeSupportTeam($removeTeam);
                    $em->persist($group);
                }
            }
            $em->persist($group);
            $em->flush();

            $this->addFlash('success', $this->translator->trans('Success ! Group information updated successfully.'));
            return $this->redirect($this->generateUrl('helpdesk_member_support_group_collection'));
        }

        return $this->render('@UVDeskCoreFramework/Groups/updateSupportGroup.html.twig', [
            'group' => $group,
            'errors' => json_encode($errors)
        ]);
    }

    public function createGroup(Request $request)
    {
        if(!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_GROUP')){
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $group = new SupportGroup;
        $errors = [];
        if($request->getMethod() == "POST") {
            $data = $request->request->all() ? : json_decode($request->getContent(), true);
            $request->request->replace($data); // also for api
            if($request->request->get('tempUsers'))
                $request->request->set('users', explode(',', $request->request->get('tempUsers')));

            if($request->request->get('tempTeams'))
                $request->request->set('supportTeams', explode(',', $request->request->get('tempTeams')));
            $oldUsers = ($usersList = $group->getUsers()) ? $usersList->toArray() : [];


            $allDetails = $request->request->all();

            $em = $this->getDoctrine()->getManager();
            $group->setName($allDetails['name']);
            $group->setDescription($allDetails['description']);
            $group->setIsActive((bool) isset($allDetails['isActive']));


            $usersList = (!empty($allDetails['users']))? $allDetails['users'] : [];
            $userTeam  = (!empty($allDetails['supportTeams']))? $allDetails['supportTeams'] : [];

            if (!empty($usersList)) {
                $usersList = array_map(function ($user) { return 'user.id = ' . $user; }, $usersList);

                $userList = $em->createQueryBuilder()->select('user')
                    ->from(User::class, 'user')
                    ->where(implode(' OR ', $usersList))
                    ->getQuery()->getResult();
            }

            if (!empty($userTeam)) {
                $userTeam = array_map(function ($team) { return 'team.id = ' . $team; }, $userTeam);

                $userTeam = $em->createQueryBuilder()->select('team')
                    ->from(SupportTeam::class, 'team')
                    ->where(implode(' OR ', $userTeam))
                    ->getQuery()->getResult();
            }

            if (!empty($userList)) {
                foreach ($userList as $user) {
                    $userInstance = $user->getAgentInstance();
                    $userInstance->addSupportGroup($group);
                    $em->persist($userInstance);
                }
            }

            // Add Teams to Group
            foreach ($userTeam as $supportTeam) {
                $group->addSupportTeam($supportTeam);
            }

            $em->persist($group);
            $em->flush();

            $this->addFlash('success', $this->translator->trans('Success ! Group information saved successfully.'));
            return $this->redirect($this->generateUrl('helpdesk_member_support_group_collection'));
        }

        return $this->render('@UVDeskCoreFramework/Groups/createSupportGroup.html.twig', [
            'group' => $group,
            'errors' => json_encode($errors)
        ]);
    }
}
