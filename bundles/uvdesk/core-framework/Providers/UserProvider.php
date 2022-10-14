<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Providers;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Webkul\UVDesk\CoreFrameworkBundle\Services\ReCaptchaService;

class UserProvider implements UserProviderInterface
{
    private $firewall;
    private $container;
    private $requestStack;
    private $entityManager;
    private $session;
    private $recaptchaService;

    public function __construct(FirewallMap $firewall, ContainerInterface $container, RequestStack $requestStack, EntityManagerInterface $entityManager, SessionInterface $session, ReCaptchaService $recaptchaService)
    {
        $this->firewall = $firewall;
        $this->container = $container;
        $this->requestStack = $requestStack; 
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->recaptchaService = $recaptchaService;
    }

    public function loadUserByUsername($username)
    {
        $request = $this->requestStack->getCurrentRequest();
        $recaptchaDetails = $this->recaptchaService->getRecaptchaDetails();

        if (
            $request->getMethod() == 'POST' &&  $recaptchaDetails && $recaptchaDetails->getIsActive() == true 
            && ($request->attributes->get('_route') == 'helpdesk_member_handle_login' || $request->attributes->get('_route') == 'helpdesk_customer_login') 
            && $this->recaptchaService->getReCaptchaResponse($request->request->get('g-recaptcha-response'))
        ) {
            $this->session->getFlashBag()->add('warning',"Warning ! Please select correct CAPTCHA or login again with correct CAPTCHA !");

            throw new UsernameNotFoundException('Please select correct CAPTCHA for'.$username);
        } else {
            $queryBuilder = $this->entityManager->createQueryBuilder()
                ->select('user, userInstance')
                ->from(User::class, 'user')
                ->leftJoin(UserInstance::class, 'userInstance', 'WITH', 'user.id = userInstance.user')
                ->leftJoin('userInstance.supportRole', 'supportRole')
                ->where('user.email = :email')->setParameter('email', trim($username))
                ->andWhere('userInstance.isActive = :isActive')->setParameter('isActive', true)
                ->setMaxResults(1)
            ;

            // Retrieve user instances based on active firewall
            $activeFirewall = $this->firewall->getFirewallConfig($this->requestStack->getCurrentRequest())->getName();

            switch (strtolower($activeFirewall)) {
                case 'member':
                case 'back_support':
                    $queryBuilder
                        ->andWhere('supportRole.code = :roleOwner OR supportRole.code = :roleAdmin OR supportRole.code = :roleAgent')
                        ->setParameter('roleOwner', 'ROLE_SUPER_ADMIN')
                        ->setParameter('roleAdmin', 'ROLE_ADMIN')
                        ->setParameter('roleAgent', 'ROLE_AGENT')
                    ;
                    break;
                case 'customer':
                case 'front_support':
                    $queryBuilder
                        ->andWhere('supportRole.code = :roleCustomer')
                        ->setParameter('roleCustomer', 'ROLE_CUSTOMER')
                    ;
                    break;
                default:
                    throw new UsernameNotFoundException('Firewall not supported.');
                    break;
            }
        
            $response = $queryBuilder->getQuery()->getResult();

            try {
                if (!empty($response) && is_array($response)) {
                    list($user, $userInstance) = $response;

                    // Set currently active instance
                    $user->setCurrentInstance($userInstance);
                    $user->setRoles((array) $userInstance->getSupportRole()->getCode());

                    return $user;
                }
            } catch (\Exception $e) {
                // Do nothing...
            }

            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
    }

    public function refreshUser(UserInterface $user)
    {
        
        if ($this->supportsClass(get_class($user))) {
            return $this->loadUserByUsername($user->getEmail());
        }

        throw new UnsupportedUserException('Invalid user type');
    }

    public function supportsClass($class)
    {
        return User::class === $class;
    }
}
