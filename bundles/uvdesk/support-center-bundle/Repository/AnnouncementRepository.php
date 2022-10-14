<?php

namespace Webkul\UVDesk\SupportCenterBundle\Repository;

use Webkul\UVDesk\SupportCenterBundle\Entity\Announcement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Announcement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Announcement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Announcement[]    findAll()
 * @method Announcement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnouncementRepository extends ServiceEntityRepository
{
    public $safeFields = array('page','limit','sort','order','direction');
    const LIMIT = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Announcement::class);
    }
    

    public function getAllAnnouncements(\Symfony\Component\HttpFoundation\ParameterBag $obj = null, $container)
    {
        $json = array();
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a')->from($this->getEntityName(), 'a');

        $data = $obj->all();
        $data = array_reverse($data);
        foreach ($data as $key => $value) {
            if(!in_array($key,$this->safeFields)) {
                if($key!='dateUpdated' AND $key!='dateAdded' AND $key!='search') {
                    $qb->Andwhere('a.'.$key.' = :'.$key);
                    $qb->setParameter($key, $value);
                } else {
                    if($key == 'search') {
                        $qb->orwhere('a.title'.' LIKE :name');
                        $qb->setParameter('name', '%'.urldecode($value).'%');
                        $qb->orwhere('a.promoText'.' LIKE :promoText');
                        $qb->setParameter('promoText', '%'.urldecode($value).'%');
                    }
                }
            }
        }

        if(!isset($data['sort'])){
            $qb->orderBy('a.id',Criteria::DESC);
        }

        $paginator  = $container->get('knp_paginator');

        $results = $paginator->paginate(
            $qb,
            isset($data['page']) ? $data['page'] : 1,
            self::LIMIT,
            array('distinct' => false)
        );

        $newResult = [];
        foreach ($results as $key => $result) {
            $newResult[] = array(
                'id'        => $result->getId(),
                'title'      => $result->getTitle(),
                'promoText' => $result->getPromoText(),
                'promoTag'  => $result->getPromoTag(),
                'tagColor'  => $result->getTagColor(),
                'linkText'  => $result->getLinkText(),
                'linkUrl'   => $result->getLinkUrl(),
                'isActive'  => $result->getIsActive(),
                'createdAt' => $result->getCreatedAt(),
                'group'     => array(
                    'id'    => $result->getGroup()->getId(),
                    'name'  => $result->getGroup()->getName()
                )
            );
        }

        $paginationData = $results->getPaginationData();
        $queryParameters = $results->getParams();

        $paginationData['url'] = '#'.$container->get('uvdesk.service')->buildPaginationQuery($queryParameters);

        $json['groups'] = $newResult;
        $json['pagination_data'] = $paginationData;

        return $json;
    }
}
