<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Repository;

use Webkul\UVDesk\CoreFrameworkBundle\Entity\AgentActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AgentActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgentActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AgentActivity[]    findAll()
 * @method AgentActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AgentActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AgentActivity::class);
    }

    // /**
    //  * @return AgentActivity[] Returns an array of AgentActivity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AgentActivity
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
