<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Webkul\UVDesk\CoreFrameworkBundle\Form;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Contracts\Translation\TranslatorInterface;

class Team extends AbstractController
{
    private $userService;
    private $translator;
    
    public function __construct(UserService $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    public function listTeams(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_SUB_GROUP')){
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        return $this->render('@UVDeskCoreFramework/Teams/listSupportTeams.html.twig');
    }

    public function createTeam(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_SUB_GROUP')){
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $supportTeam = new SupportTeam();

        $errors = [];

        if($request->getMethod() == "POST") {

            $request->request->set('users', explode(',', $request->request->get('tempUsers')));
            $request->request->set('groups', explode(',', $request->request->get('tempGroups')));
            $oldUsers = ($usersList = $supportTeam->getUsers()) ? $usersList->toArray() : $usersList;
            $oldGroups = ($grpList =  $supportTeam->getSupportGroups()) ? $grpList->toArray() : $grpList;

            $allDetails = $request->request->all();

            $em = $this->getDoctrine()->getManager();
            $supportTeam->setName($allDetails['name']);
            $supportTeam->setDescription($allDetails['description']);
            $supportTeam->setIsActive((bool) isset($allDetails['isActive']));
            $em->persist($supportTeam);

            $usersList = (!empty($allDetails['users']))? $allDetails['users'] : [];
            $usersGroup  = (!empty($allDetails['groups']))? $allDetails['groups'] : [];

            if (!empty($usersList)) {
                $usersList = array_map(function ($user) { return 'user.id = ' . $user; }, $usersList);

                $userList = $em->createQueryBuilder()->select('user')
                    ->from(User::class, 'user')
                    ->where(implode(' OR ', $usersList))
                    ->getQuery()->getResult();
            }

            if (!empty($usersGroup)) {
                $usersGroup = array_map(function ($group) { return 'p.id = ' . $group; }, $usersGroup);

                $userGroup = $em->createQueryBuilder('p')->select('p')
                    ->from(SupportGroup::class, 'p')
                    ->where(implode(' OR ', $usersGroup))
                    ->getQuery()->getResult();
            }

            foreach ($userList as $user) {
                $userInstance = $user->getAgentInstance();
                $userInstance->addSupportTeam($supportTeam);
                $em->persist($userInstance);
            }

            // Add Teams to Group
            foreach ($userGroup as $supportGroup) {
                $supportGroup->addSupportTeam($supportTeam);
                $em->persist($supportGroup);
            }

            $em->persist($supportTeam);
            $em->flush();

            $this->addFlash('success', $this->translator->trans('Success ! Team information saved successfully.'));

            return $this->redirect($this->generateUrl('helpdesk_member_support_team_collection'));
        }

        return $this->render('@UVDeskCoreFramework/Teams/createSupportTeam.html.twig', [
            'team' => $supportTeam,
            'errors' => json_encode($errors)
        ]);
    }

    public function editTeam(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_SUB_GROUP')){
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        if($request->attributes->get('supportTeamId')){
            $supportTeam = $this->getDoctrine()->getRepository(SupportTeam::class)
                ->findSubGroupById(['id' => $request->attributes->get('supportTeamId')]);

            if(!$supportTeam)
                $this->noResultFound();
        }

        $errors = [];
        if($request->getMethod() == "POST") {
            $request->request->set('users', explode(',', $request->request->get('tempUsers')));
            $request->request->set('groups', explode(',', $request->request->get('tempGroups')));
            $oldUsers = ($usersList = $supportTeam->getUsers()) ? $usersList->toArray() : $usersList;
            $oldGroups = ($grpList = $supportTeam->getSupportGroups()) ? $grpList->toArray() : $grpList;

            $allDetails = $request->request->all();

            $em = $this->getDoctrine()->getManager();
            $supportTeam->setName($allDetails['name']);
            $supportTeam->setDescription($allDetails['description']);
            $supportTeam->setIsActive((bool) isset($allDetails['isActive']));

            $usersList = (!empty($allDetails['users']))? $allDetails['users'] : [];
            $usersGroup  = (!empty($allDetails['groups']))? $allDetails['groups'] : [];

            if (!empty($usersList)) {
                $usersList = array_map(function ($user) { return 'p.id = ' . $user; }, $usersList);
                $userList = $em->createQueryBuilder('p')->select('p')
                    ->from(User::class, 'p')
                    ->where(implode(' OR ', $usersList))
                    ->getQuery()->getResult();
            }

            if (!empty($usersGroup)) {
                $usersGroup = array_map(function ($group) { return 'p.id = ' . $group; }, $usersGroup);

                $userGroup = $em->createQueryBuilder('p')->select('p')
                    ->from(SupportGroup::class, 'p')
                    ->where(implode(' OR ', $usersGroup))
                    ->getQuery()->getResult();
            }

            foreach ($userList as $user) {
                $userInstance = $user->getAgentInstance();
                if(!$oldUsers || !in_array($userInstance, $oldUsers)){
                    $userInstance->addSupportTeam($supportTeam);
                    $em->persist($userInstance);
                }elseif($oldUsers && ($key = array_search($userInstance, $oldUsers)) !== false)
                    unset($oldUsers[$key]);
            }
            foreach ($oldUsers as $removeUser) {
                $removeUser->removeSupportTeam($supportTeam);
                $em->persist($removeUser);
            }

            // Add Group to team
            foreach ($userGroup as $supportGroup) {
                if(!$oldGroups || !in_array($supportGroup, $oldGroups)){
                    $supportGroup->addSupportTeam($supportTeam);
                    $em->persist($supportGroup);

                }elseif($oldGroups && ($key = array_search($supportGroup, $oldGroups)) !== false)
                    unset($oldGroups[$key]);
            }

            foreach ($oldGroups as $removeGroup) {
                $removeGroup->removeSupportTeam($supportTeam);
                $em->persist($removeGroup);
            }

            $em->persist($supportTeam);
            $em->flush();

            $this->addFlash('success', $this->translator->trans('Success ! Team information updated successfully.'));
            return $this->redirect($this->generateUrl('helpdesk_member_support_team_collection'));
        }
        return $this->render('@UVDeskCoreFramework/Teams/updateSupportTeam.html.twig', [
            'team' => $supportTeam,
            'errors' => json_encode($errors)
        ]);
    }
}
