<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Criteria;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportRole;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportPrivilege;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup;    
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SavedReplies;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Website;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Workflow\Events as CoreWorkflowEvents;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Twig\Environment as TwigEnvironment;
use Symfony\Component\Filesystem\Filesystem as Fileservice;
use Webkul\UVDesk\SupportCenterBundle\Entity\KnowledgebaseWebsite;

class UserService
{
    protected $container;
	protected $requestStack;
    protected $entityManager;
    protected $twig;

    public function __construct(ContainerInterface $container, RequestStack $requestStack, EntityManagerInterface $entityManager, TwigEnvironment $twig)
    {
        $this->container = $container;
		$this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    public function getCustomFieldTemplateCustomer()
    {
        $request = $this->requestStack->getCurrentRequest();
        //get the ticket
        $ticket = $this->entityManager->getRepository(Ticket::class)->findOneById($request->attributes->get('id'));
        $getCustomerCustomFieldSnippet = $this->container->get('custom.field.service')->getCustomerCustomFieldSnippet($ticket);

        if (sizeof($getCustomerCustomFieldSnippet["customFieldCollection"]) > 0 ) {
            return $this->twig->render('@_uvdesk_extension_uvdesk_form_component/widgets/CustomFields/customFieldSnippetCustomer.html.twig', 
                $getCustomerCustomFieldSnippet);
        }

        return ;
    }

    public function isGranted($role) {
        $securityContext = $this->container->get('security.token_storage');
       
        try {
            return (bool) ($role == $securityContext->getToken()->getRoles()[0]->getRole());
        } catch (AuthenticationCredentialsNotFoundException $e) {
            // @TODO: Handle Authentication Failure
        }

        return false;
    }
    
    public function getSessionUser()
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        return $user instanceof User ? $user : null;
    }

    public function getCurrentUser()
    {
        if ($this->container->get('security.token_storage')->getToken()) {
            return $this->container->get('security.token_storage')->getToken()->getUser();
        } else {
            return false;
        }
    }
    
    public function isAccessAuthorized($scope, User $user = null)
    {
        // Return false if no user is provided
        if (empty($user) && !($user = $this->getSessionUser())) {
            return false;
        }

        try {
            $userRole = $user->getCurrentInstance()->getSupportRole()->getCode();
        } catch (\Exception $error) {
            $userRole = '';
        }

        switch ($userRole) {
            case 'ROLE_SUPER_ADMIN':
            case 'ROLE_ADMIN':
                return true;
            case 'ROLE_AGENT':
                $agentPrivileges = $this->getUserPrivileges($this->getCurrentUser()->getId());
                $agentPrivileges = array_merge($agentPrivileges, ['saved_filters_action', 'saved_replies']);
                
                return in_array($scope, $agentPrivileges) ? true : false;
            case 'ROLE_CUSTOMER':
            default:
                break;
        }

        return true;
    }

    public function getUserPrivileges($userId)
    {
        static $agentPrivilege = [];
        
        if (isset($agentPrivilege[$userId])) {
            return $agentPrivilege[$userId];
        }
        
        $userPrivileges = array();
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        $privileges = $user->getAgentInstance()->getSupportPrivileges();  
      
        if ($privileges) {
            foreach ($privileges as $privilege) {
                $userPrivileges = array_merge($userPrivileges, $privilege->getPrivileges());
            }
        }
        
        $agentPrivilege[$userId] = $this->agentPrivilege[$userId] = $userPrivileges;  

        return $userPrivileges;
    }

    public function getSupportPrivileges()
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("supportPrivilege")->from(SupportPrivilege::class, 'supportPrivilege');
        
        return $qb->getQuery()->getArrayResult();
    }

    public function getSupportGroups(Request $request = null)
    {
        static $results;
        if(null !== $results)
            return $results;
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('supportGroup.id, supportGroup.name')->from(SupportGroup::class, 'supportGroup')
                ->andwhere('supportGroup.isActive = 1');
        if($request) {
            $qb->andwhere("supportGroup.name LIKE :groupName");
            $qb->setParameter('groupName', '%'.urldecode($request->query->get('query')).'%');
            $qb->andwhere("supportGroup.id NOT IN (:ids)");
            $qb->setParameter('ids', explode(',',urldecode($request->query->get('not'))));
        }
        return $results = $qb->getQuery()->getArrayResult();
    }

    public function getSupportTeams(Request $request = null)
    {
        static $results;
        if(null !== $results)
            return $results;
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select("user.id, user.email, CONCAT(user.firstName, ' ', user.lastName) as name, userInstance.profileImagePath as smallThumbnail")
            ->from(User::class, 'user')
            ->leftJoin('user.userInstance', 'userInstance')
            ->leftJoin('userInstance.supportRole', 'supportRole')
            ->where('supportRole.code != :customerRole')->setParameter('customerRole', 'ROLE_CUSTOMER')
            ->andWhere('userInstance.isActive = :isUserActive')->setParameter('isUserActive', true)
            ->orderBy('name', Criteria::ASC);

        if ($request && null != $request->query->get('query')) {
            $queryBuilder
                ->andWhere("CONCAT(dt.firstName,' ', dt.lastName) LIKE :customerName")
                ->setParameter('customerName', '%'.urldecode($request->query->get('query')).'%');
        }

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('supportTeam.id, supportTeam.name')
           ->from(SupportTeam::class, 'supportTeam');
        $qb->andwhere('supportTeam.isActive = 1');
        
        if($request) {
            $qb->andwhere("supportTeam.name LIKE :subGroupName");
            $qb->setParameter('subGroupName', '%'.urldecode($request->query->get('query')).'%');
            $qb->andwhere("supportTeam.id NOT IN (:ids)");
            $qb->setParameter('ids', explode(',',urldecode($request->query->get('not'))));
        }

        return $results = $qb->getQuery()->getResult();
    }

    public function createUserInstance($email, $name, SupportRole $role, array $extras = [])
    {
        $user = $this->entityManager->getRepository(User::class)->findOneByEmail($email) ?: new User();
        
        $website = $this->entityManager->getRepository(Website::class)->findOneBy(['code' => 'knowledgebase']);
        $timeZone = $website->getTimezone();
        $timeFormat = $website->getTimeformat();

        if (null == $user->getId()) {
            $name = explode(' ', trim($name));
            
            $user->setEmail($email);
            $user->setFirstName(isset($extras['firstName']) ? $extras['firstName'] : array_shift($name));
            $user->setLastName(trim(implode(' ', $name)));
            $user->setIsEnabled($extras['active']);
            $user->setTimeZone($timeZone);
            $user->setTimeFormat($timeFormat);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        }
        
        $userInstance = 'ROLE_CUSTOMER' == $role->getCode() ? $user->getCustomerInstance() : $user->getAgentInstance();
        
        if (empty($userInstance)) {
            $userInstance = new UserInstance();
                
            $userInstance->setUser($user);
            $userInstance->setSupportRole($role);
            $userInstance->setContactNumber(!empty($extras['contact']) ? $extras['contact'] : null);
            $userInstance->setSkypeId(!empty($extras['skype']) ? $extras['skype'] : null);
            $userInstance->setDesignation(!empty($extras['designation']) ? $extras['designation'] : null);
            $userInstance->setSignature(!empty($extras['signature']) ? $extras['signature'] : null);

            $userInstance->setSource(!empty($extras['source']) ? $extras['source'] : 'website');
            $userInstance->setIsActive(!empty($extras['active']) ? (bool) $extras['active'] : false);
            $userInstance->setIsVerified(!empty($extras['verified']) ? (bool) $extras['verified'] : false);
            $userInstance->setIsStarred(!empty($extras['starred']) ? (bool) $extras['starred'] : false);

            if (!empty($extras['image'])) {
                $assetDetails = $this->container->get('uvdesk.core.file_system.service')->getUploadManager()->uploadFile($extras['image'], 'profile');

                if (!empty($assetDetails)) {
                    $userInstance->setProfileImagePath($assetDetails['path']);
                }
            }

            $this->entityManager->persist($userInstance);
            $this->entityManager->flush();

            $user->addUserInstance($userInstance);

            // Trigger user created event
            $eventId = 'ROLE_CUSTOMER' == $role->getCode() ? CoreWorkflowEvents\Customer\Create::getId() : CoreWorkflowEvents\Agent\Create::getId();
            $event = new GenericEvent($eventId, ['entity' => $user]);

            $this->container->get('event_dispatcher')->dispatch($event, 'uvdesk.automation.workflow.execute');
        }

        return $user;
    }

    public function getAgentPartialDataCollection(Request $request = null)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select("user.id, user.email, CONCAT(user.firstName, ' ', COALESCE(user.lastName, '')) as name, userInstance.profileImagePath as smallThumbnail")
            ->from(User::class, 'user')
            ->leftJoin('user.userInstance', 'userInstance')
            ->leftJoin('userInstance.supportRole', 'supportRole')
            ->where('supportRole.code != :customerRole')->setParameter('customerRole', 'ROLE_CUSTOMER')
            ->andWhere('userInstance.isActive = :isUserActive')->setParameter('isUserActive', true)
            ->orderBy('name', Criteria::ASC);

        if ($request && null != $request->query->get('query')) {
            $queryBuilder
                ->andWhere("CONCAT(user.firstName,' ', user.lastName) LIKE :customerName")
                ->setParameter('customerName', '%'.urldecode($request->query->get('query')).'%');
        }

        if ($request && null != $request->query->get('not')) {
            $queryBuilder
                ->andwhere("u.id NOT IN (:ids)")
                ->setParameter('ids', explode(',', urldecode($request->query->get('not'))));
        }

        return $queryBuilder->getQuery()->getArrayResult();
    }

    public function getAgentsPartialDetails(Request $request = null) {
        static $agents;
        if (null !== $agents)
            return $agents;

        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("u.id, userInstance.id as udId,u.email,CONCAT(u.firstName,' ', u.lastName) AS name,userInstance.profileImagePath as smallThumbnail")->from(User::class, 'u')
                ->leftJoin('u.userInstance', 'userInstance')
                ->andwhere('userInstance.supportRole != :roles')
                ->setParameter('roles', 4)
                ->andwhere('userInstance.isActive = 1')
                ->orderBy('name','ASC');

        if($request) {
            $qb->andwhere("CONCAT(u.firstName,' ', u.lastName) LIKE :customerName");
            $qb->setParameter('customerName', '%'.urldecode($request->query->get('query')).'%');
            $qb->andwhere("u.id NOT IN (:ids)");
            $qb->setParameter('ids', explode(',',urldecode($request->query->get('not'))));
        }

        $data = $agents = $qb->getQuery()->getArrayResult();
        return $data;
    }

    public function getAgentDetailById($agentId) {
        if(!$agentId) return;
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("DISTINCT u.id,u.email,CONCAT(u.firstName,' ', COALESCE(u.lastName,'')) AS name,u.firstName,u.lastName,u.isEnabled,userInstance.profileImagePath,userInstance.profileImagePath as smallThumbnail,userInstance.isActive, userInstance.isVerified, userInstance.designation, userInstance.contactNumber,userInstance.signature,userInstance.ticketAccessLevel")
            ->from(User::class, 'u')
            ->leftJoin('u.userInstance', 'userInstance')
            ->andwhere('userInstance.supportRole != :roles')
            ->andwhere('u.id = :agentId')
            ->setParameter('roles', 4)
            ->setParameter('agentId', $agentId);

        $result = $qb->getQuery()->getResult();

        return isset($result[0]) ? $result[0] : null;
    }

    public function getUsersByGroupId($groupId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("DISTINCT user.id, user.email, CONCAT(user.firstName, ' ', user.lastName) AS name, userInstance.profileImagePath as smallThumbnail")
            ->from(User::class, 'user')
            ->leftJoin('user.userInstance', 'userInstance')
                ->leftJoin('userInstance.supportGroups', 'supportGroup')
                ->andWhere('userInstance.supportRole != :roles')->setParameter('roles', 4)
                ->andwhere('supportGroup.id = :groupId')->setParameter('groupId', $groupId)
                ->andwhere('userInstance.isActive = 1');

        $data = $qb->getQuery()->getArrayResult();
        return $data;
    }

    public function getUsersBySubGroupId($subGroupId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("DISTINCT user.id, supportTeam.id as udId,user.email,CONCAT(user.firstName,' ', user.lastName) AS name,userInstance.profileImagePath as smallThumbnail")
                ->from(User::class, 'user')
                ->leftJoin('user.userInstance', 'userInstance')
                ->leftJoin('userInstance.supportTeams', 'supportTeam')
                ->andwhere('userInstance.supportRole != :roles')
                ->andwhere('supportTeam.id = :subGroupId')
                ->setParameter('roles', 4)
                ->setParameter('subGroupId', $subGroupId)
                ->andwhere('supportTeam.isActive = 1')
                ->andwhere('userInstance.isActive = 1');

        $data = $qb->getQuery()->getArrayResult();
        return $data;
    }

    public function getCustomerDetailsById($customerId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("user.id,user.email,CONCAT(user.firstName,' ', COALESCE(user.lastName,'')) AS name,user.firstName,user.lastName,user.isEnabled,userInstance.contactNumber,userInstance.profileImagePath,userInstance.profileImagePath as smallThumbnail,userInstance.isActive, userInstance.isVerified")->from(User::class, 'user')
                ->leftJoin('user.userInstance', 'userInstance')
                ->andwhere('userInstance.supportRole = :roles')
                ->andwhere('user.id = :customerId')
                ->setParameter('roles', 4)
                ->setParameter('customerId', $customerId);

        $result = $qb->getQuery()->getResult();
        return ($result ? $result[0] : null);
    }

    public function getCustomerPartialDetailById($customerId)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select("u.id,u.email,CONCAT(u.firstName,' ', COALESCE(u.lastName,'')) AS name,u.firstName,u.lastName,userInstance.contactNumber,userInstance.profileImagePath,userInstance.profileImagePath as smallThumbnail")->from(User::class, 'u')
            ->leftJoin('u.userInstance', 'userInstance')
            ->andwhere('userInstance.supportRole = :roles')
            ->andwhere('u.id = :customerId')
            ->setParameter('roles', 4)
            ->setParameter('customerId', $customerId);

        $result = $qb->getQuery()->getResult();

        return $result ? $result[0] : null;
    }

    public function getCustomersPartial(Request $request = null)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->from(User::class, 'u');

        $qb->select("DISTINCT u.id,CONCAT(u.firstName,' ', COALESCE(u.lastName,'')) AS name, userInstance.profileImagePath as smallThumbnail ")
            ->leftJoin('u.userInstance', 'userInstance')
            ->andwhere('userInstance.supportRole = :roles')
            ->setParameter('roles', 4)
            ->orderBy('name','ASC');
        
        if ($request) {
            if ($request->query->get('query')) {
                $qb->andwhere("CONCAT(u.firstName,' ', u.lastName) LIKE :customerName OR u.email LIKE :customerName");
            } else {
                $qb->andwhere("CONCAT(u.firstName,' ', u.lastName) LIKE :customerName");
            }
            
            $qb->setParameter('customerName', '%'.urldecode($request->query->get('query')).'%')
                ->andwhere("u.id NOT IN (:ids)")
                ->setParameter('ids', explode(',',urldecode($request->query->get('not'))));
        }

        $query = $qb->getQuery();
        // $query->useResultCache(true, 3600, 'customer_list_'.$this->getCompany()->getId());

        return $query->getScalarResult();
    }

    public function getCustomersCount()
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select($qb->expr()->countDistinct('c.id')."as customerCount")->from(Ticket::class, 't')
                ->leftJoin('t.customer', 'c');

        $this->entityManager->getRepository(Ticket::class)->addPermissionFilter($qb, $this->container, false);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getUserSubGroupIds($userId) {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('supportTeams.id')->from(User::class, 'user')
                ->leftJoin('user.userInstance','userInstance')
                ->leftJoin('userInstance.supportTeams','supportTeams')
                ->andwhere('user.id = :userId')
                ->andwhere('userInstance.supportRole != :agentRole')
                ->andwhere('supportTeams.isActive = 1')
                ->setParameter('userId', $userId)
                ->setParameter('agentRole', '4'); 

        return array_column($qb->getQuery()->getArrayResult(), 'id');
    }

    public function getUserGroupIds($userId) {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('supportGroup.id')->from(User::class, 'user')
                ->leftJoin('user.userInstance','userInstance')
                ->leftJoin('userInstance.supportGroups','supportGroup')
                ->andwhere('user.id = :userId')
                ->andwhere('supportGroup.isActive = 1')
                ->setParameter('userId', $userId);

        return array_column($qb->getQuery()->getArrayResult(), 'id');
    }

    public function createUser($data)
    {
        $user = new User();
        $user->setEmail($data['from']);
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setIsEnabled($data['isActive']);
        $this->entityManager->persist($user);
        // $this->entityManager->flush();
        $role = $this->entityManager->getRepository(SupportRole::class)->find($data['role']);
    
        $userInstance = new UserInstance();
        $userInstance->setSupportRole($role);
        $userInstance->setUser($user);
        $userInstance->setIsActive($data['isActive']);
        $userInstance->setIsVerified(0);
        if(isset($data['source']))
            $userInstance->setSource($data['source']);
        else
            $userInstance->setSource('website');
        if(isset($data['contactNumber'])) {
            $userInstance->setContactNumber($data['contactNumber']);
        }
        if(isset($data['profileImage']) && $data['profileImage']) {
                $userInstance->setProfileImagePath($data['profileImage']);
        }
        $this->entityManager->persist($userInstance);
        $this->entityManager->flush();

        $user->addUserInstance($userInstance);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        //$user->setUserName($userInstance->getName());
        return $user;
    }

    public function getWebsiteConfiguration($code)
    {
        $enabled_bundles = $this->container->getParameter('kernel.bundles');
        
        if (!in_array('UVDeskSupportCenterBundle', array_keys($enabled_bundles))) {
            return [
                'id' =>  1,
                'website' =>  1,
                'status' =>  1,
                'brandColor' => '#7E91F0',
                'pageBackgroundColor' => '#FFFFFF',
                'headerBackgroundColor' => '#FFFFFF',
                'bannerBackgroundColor' => '#7085F4',
                'navTextColor' =>  '#7085F4',
                'navActiveColor' => '#7085F4',
                'linkColor' => '#7085F4',
                'linkHoverColor' => '#7085F4',
                'headerLinks' => null,
                'footerLinks' => null,
                'articleTextColor' => '#7085F4',
                'whiteList' => null,
                'blackList' => null,
                'siteDescritption' => 'Hi! how can i help you.',
                'metaDescription' => null,
                'metaKeywords' => null,
                'homepageContent' => null,
                'ticketCreateOption' =>  1,
                'createdAt' =>  '2018-09-21 16:20:01',
                'updatedat' =>  '2018-09-21 16:20:01',
                'broadcastMessage' => null,
                'removeCustomerLoginButton' => null,
                'disableCustomerlogin' =>  0,
                'removeBrandingContent' => null,
                'loginRequiredToCreate' => null,
                'script' => null,
                'customCss' => null,
                'isActive' => 1,
            ];
        }
        
        $website = $this->entityManager->getRepository(Website::class)->findOneByCode($code);

        if ($website) {
            $configuration = $this->entityManager->getRepository(KnowledgebaseWebsite::class)->findOneBy([
                'website' => $website->getId(), 
                'isActive' => 1
            ]);
        }

        return !empty($configuration) ? $configuration : false;
    }

    public function getWebsiteDetails($code)
    {
        $website = $this->entityManager->getRepository(Website::class)->findOneByCode($code);

        return !empty($website) ? $website : false;
    }

    public function convertToTimezone($date, $format = "d-m-Y H:ia")
    {
        if(!$date)
            return "N/A";
        $currentUser = $this->getCurrentUser();
        $date = date_format($date,$format);
        $dateTime = date('Y-m-d H:i:s',strtotime($date));
        $scheduleDate = new \DateTime($dateTime, new \DateTimeZone(date_default_timezone_get()));
        $this->domain = $this->container->get('router')->getContext()->getHost();

        $scheduleDate->setTimeZone(new \DateTimeZone('Asia/Kolkata'));

        return $scheduleDate->format($format);
    }

    public function convertToDatetimeTimezoneTimestamp($date, $format = "d-m-Y h:ia")
    {
        if(!$date)
            return "N/A";
        $currentUser = $this->getCurrentUser();
        $date = date_format($date, $format);
        $dateTime = date('Y-m-d H:i:s',strtotime($date));
        $scheduleDate = new \DateTime($dateTime, new \DateTimeZone(date_default_timezone_get()));
        $this->domain = $this->container->get('router')->getContext()->getHost();

        $scheduleDate->setTimeZone(new \DateTimeZone('Asia/Kolkata'));

        return $scheduleDate->getTimestamp();
    }

    public function removeCustomer($customer)
    {
        $userData = $this->entityManager->getRepository(UserInstance::class)->findBy(array('user' => $customer->getId()));

        $count = count($userData);
        $ticketData = $this->entityManager->getRepository(Ticket::class)->findBy(array('customer' => $customer->getId()));

        $fileService = new Fileservice();
        // Delete all tickets attachments.
        if($ticketData) {
            foreach($ticketData as $ticket) {
                $threads = $ticket->getThreads();
                if (count($threads) > 0) {
                    foreach($threads as $thread) {
                        if (!empty($thread)) {
                            $fileService->remove($this->container->getParameter('kernel.project_dir').'/public/assets/threads/'.$thread->getId());

                        }
                    }
                }
            }
        }

        // Remove profile.
        foreach($userData as $user) {
            if($user->getSupportRole()->getId() == 4 && $user->getProfileImagePath()) {
                $fileService->remove($this->container->getParameter('kernel.project_dir').'/public'.$user->getProfileImagePath());
            }
        }

        // getCustomerTickets
        $qb = $this->entityManager->createQueryBuilder();
        $query = $qb->delete(Ticket::class, 't')
                    ->andwhere('t.customer = :customerId')
                    ->setParameter('customerId', $customer->getId())
                    ->getQuery();

        $query->execute();

        $qb = $this->entityManager->createQueryBuilder();
        $query = $qb->delete(UserInstance::class, 'userInstance')
                    ->andwhere('userInstance.user = :customerId')
                    ->andwhere('userInstance.supportRole = :roleId')
                    ->setParameter('customerId', $customer->getId())
                    ->setParameter('roleId', 4)
                    ->getQuery();

        $query->execute();

        if($count == 1) {
            $this->entityManager->remove($customer);
            $this->entityManager->flush();
        }
    }
    
    public function removeAgent($user)
    {
        $userData = $this->entityManager->getRepository(UserInstance::class)->findBy(array('user' => $user->getId()));
        $count = count($userData);

        $qb = $this->entityManager->createQueryBuilder();
        $query = $qb->delete(UserInstance::class, 'ud')
                    ->andwhere('ud.user = :userId')
                    ->andwhere('ud.supportRole = :roleId')
                    ->setParameter('userId', $user->getId())
                    ->setParameter('roleId', 3)
                    ->getQuery();

        $query->execute();
        
        foreach ($user->getAgentInstance()->getSupportGroups() as $group) {
                $user->getAgentInstance()->removeSupportGroup($group);
                $this->entityManager->persist($group);
                $this->entityManager->flush();
            
        }

        $qb = $this->entityManager->createQueryBuilder();
        $query = $qb->update(Ticket::class, 't')
                    ->set('t.agent', ':nullAgent')
                    ->andwhere('t.agent = :agentId')
                    ->setParameter('agentId', $user->getId())
                    ->setParameter('nullAgent', null)
                    ->getQuery();

        $query->execute();

       
        if($count == 1) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }
    }

    public function getWebsiteView()
    {
        $website = $this->entityManager->getRepository(Website::class)->findOneBy(['code'=>'knowledgebase']);
        $layout  = $this->entityManager->getRepository(KnowledgebaseWebsite::class)->findOneBy(['website'=>$website->getId()]);
      
        $homepageContent = $layout->getHomepageContent();
        return (!empty($homepageContent)) ? $homepageContent . 'View' : 'masonryView';
    }

    public function getUserDetailById($userId) {
        $user = $this->entityManager->getRepository(User::class)->find($userId);
        foreach ($user->getUserInstance() as $row) {
            if($row->getSupportRole()->getId() != 4)
                return $row;
        }
        return null;
    }

    public function getUserPrivilegeIds($userId) 
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('supportPrivileges.id')->from(User::class, 'user')
                ->leftJoin('user.userInstance','userInstance')
                ->leftJoin('userInstance.supportPrivileges','supportPrivileges')
                ->andwhere('user.id = :userId')
                ->setParameter('userId', $userId);

        return array_column($qb->getQuery()->getArrayResult(), 'id');
    }

    public function getWebsiteSpamDetails($websiteSpam) 
    {
        $blackList = str_replace("\n", ',', str_replace("\r\n", ',', $websiteSpam->getBlackList()));
        $whiteList = str_replace("\n", ',', str_replace("\r\n", ',', $websiteSpam->getWhiteList()));

        return [
            'blackList' => $this->filterBlockSpam($blackList),
            'whiteList' => $this->filterBlockSpam($whiteList),
        ];
    }

    public function filterBlockSpam($str) 
    {
        $list = array();
        foreach (explode(',', $str) as $value) {
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                if (!isset($list['email'])) {
                    $list['email'] = array();
                }

                array_push($list['email'], strtolower($value));
            } else if (filter_var($value, FILTER_VALIDATE_IP)) {
                if (!isset($list['ip'])) {
                    $list['ip'] = array();
                }
                
                array_push($list['ip'], $value);
            } else if (isset($value[0]) && $value[0] == '@') {
                if (!isset($list['domain'])) {
                    $list['domain'] = array();
                }

                array_push($list['domain'], strtolower($value));
            }
        }
        
        return $list;
    }

    // @TODO: Refactor this - We can instead just use \DateTimeZone::listIdentifiers() wherever need be.
    public function getTimezones()
    {
        return \DateTimeZone::listIdentifiers();
    }

    public function getUserSavedReplyReferenceIds()
    {
        // @TODO: Refactor this function
        $savedReplyIds = [];
        $groupIds = [];
        $teamIds = []; 
        $userId = $this->getCurrentUser()->getAgentInstance()->getId();

        // Get all the saved reply the current user has created.
        $savedReplyRepo = $this->entityManager->getRepository(SavedReplies::class)->findAll();

        foreach ($savedReplyRepo as $sr) {
            if ($userId == $sr->getUser()->getId()) {
                //Save the ids of the saved reply.
                array_push($savedReplyIds, (int)$sr->getId());
            }
        }

        // Get the ids of the Group(s) the current user is associated with.
        $query = "select * from uv_user_support_groups where userInstanceId =".$userId;
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            array_push($groupIds, $row['supportGroupId']);
        }

        // Get all the saved reply's ids that is associated with the user's group(s).
        $query = "select * from uv_saved_replies_groups";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            if (in_array($row['group_id'], $groupIds)) {
                array_push($savedReplyIds, (int) $row['savedReply_id']);
            }
        }

        // Get the ids of the Team(s) the current user is associated with.
        $query = "select * from uv_user_support_teams";
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach($result as $row) {
            if ($row['userInstanceId'] == $userId) {
                array_push($teamIds, $row['supportTeamId']);
            }
        }

        $query = "select * from uv_saved_replies_teams";
        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            if (in_array($row['subgroup_id'], $teamIds)) {
                array_push($savedReplyIds, (int)$row['savedReply_id']);
            }
        }

        return $savedReplyIds;
    }
	
    // Return formatted time on user preference basis
    public function getLocalizedFormattedTime(\DateTime $timestamp, $user = null, $format = 'm-d-y h:i A')
    {
        $activeUserTimeZone = $this->entityManager->getRepository(Website::class)->findOneBy(['code' => 'Knowledgebase']);
        if (!empty($user) && $user != 'anon.' && $user->getTimezone() != null) {
            $timestamp = clone $timestamp;
            
            $timestamp->setTimeZone(new \DateTimeZone($user->getTimeZone()));
            $format = $user->getTimeFormat();
        }elseif (!empty($activeUserTimeZone) && $activeUserTimeZone != 'anon.' && $activeUserTimeZone->getTimezone() != null) {
            $timestamp = clone $timestamp;
            
            $timestamp->setTimeZone(new \DateTimeZone($activeUserTimeZone->getTimeZone()));
            $format = $activeUserTimeZone->getTimeFormat();
        }
        
        return $timestamp->format($format);
    }

    public function isfileExists($filePath)
    {
        $dir = $this->container->get('kernel')->getProjectDir();
        // $dirSplit = explode('vendor', $dir);
        $file = str_replace("\\",'/', $dir."/".$filePath);

        if (is_dir($file)) { 
            return true;
        }
        
        return false;
    }

    public function getCustomersCountForKudos($container)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select($qb->expr()->countDistinct('c.id')."as customerCount")->from(Ticket::class, 't')
                ->leftJoin('t.customer', 'c');

        $container->get('report.service')->addPermissionFilter($qb, $this->container, false);

        return $qb->getQuery()->getSingleScalarResult();
    }
}
