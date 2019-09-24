<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Providers;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserProvider implements UserProviderInterface
{
    private $firewall;
    private $container;
    private $requestStack;
    private $entityManager;

    public function __construct(FirewallMap $firewall, ContainerInterface $container, RequestStack $requestStack, EntityManagerInterface $entityManager)
    {
        $this->firewall = $firewall;
        $this->container = $container;
        $this->requestStack = $requestStack; 
        $this->entityManager = $entityManager;
    }

    public function loadUserByUsername($username)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('user, userInstance')
            ->from('UVDeskCoreFrameworkBundle:User', 'user')
            ->leftJoin('UVDeskCoreFrameworkBundle:UserInstance', 'userInstance', 'WITH', 'user.id = userInstance.user')
            ->leftJoin('userInstance.supportRole', 'supportRole')
            ->where('user.email = :email')->setParameter('email', trim($username))
            ->setMaxResults(1);

        // Retrieve user instances based on active firewall
        $activeFirewall = $this->firewall->getFirewallConfig($this->requestStack->getCurrentRequest())->getName();
        switch (strtolower($activeFirewall)) {
            case 'member':
            case 'back_support':
                $queryBuilder->andWhere('supportRole.id = :roleOwner OR supportRole.id = :roleAdmin OR supportRole.id = :roleAgent')
                    ->setParameter('roleOwner', 1)
                    ->setParameter('roleAdmin', 2)
                    ->setParameter('roleAgent', 3);
                break;
            case 'customer':
            case 'front_support':
                $queryBuilder->andWhere('supportRole.id = :roleCustomer')->setParameter('roleCustomer', 4);
                break;
            default:
                throw new UsernameNotFoundException('Firewall not supported.');
                break;
        }
        
        $queryResponse = $queryBuilder->getQuery()->getResult();
        if (empty($queryResponse) || false == is_array($queryResponse)) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }
        
        list($user, $userInstance) = $queryBuilder->getQuery()->getResult();

        // Set currently active instance
        $user->setCurrentInstance($userInstance);
        $user->setRoles((array) $userInstance->getSupportRole()->getCode());


        return $user;
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
