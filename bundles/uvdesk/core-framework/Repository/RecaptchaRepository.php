<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Repository;

use Webkul\UVDesk\CoreFrameworkBundle\Entity\Recaptcha;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Recaptcha|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recaptcha|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recaptcha[]    findAll()
 * @method Recaptcha[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecaptchaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recaptcha::class);
    }

    // /**
    //  * @return Recaptcha[] Returns an array of Recaptcha objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Racaptcha
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
