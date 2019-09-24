<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Common\Collections\Criteria;

class SupportGroupRepository extends \Doctrine\ORM\EntityRepository
{
    public $safeFields = array('page','limit','sort','order','direction');
    const LIMIT = 10;

    public function getAllGroups(\Symfony\Component\HttpFoundation\ParameterBag $obj = null, $container) {
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
                        $qb->orwhere('a.name'.' LIKE :name');
                        $qb->setParameter('name', '%'.urldecode($value).'%');    
                        $qb->orwhere('a.description'.' LIKE :description');
                        $qb->setParameter('description', '%'.urldecode(trim($value)).'%');
                    }
                }
            }
        }   
        
        if(!isset($data['sort'])){
            $qb->orderBy('a.createdAt',Criteria::DESC);
        }

        $paginator  = $container->get('knp_paginator');

        $results = $paginator->paginate(
            $qb,
            isset($data['page']) ? $data['page'] : 1,
            self::LIMIT,
            array('distinct' => false)
        );

        $parsedCollection = array_map(function($group) {
            return [
                'id'          => $group->getId(),
                'name'        => $group->getName(),
                'description' => $group->getDescription(),
                'isActive'    => $group->getIsActive(),
            ];
        }, $results->getItems()); 

        $paginationData = $results->getPaginationData();
        $queryParameters = $results->getParams();

        $paginationData['url'] = '#'.$container->get('uvdesk.service')->buildPaginationQuery($queryParameters);

        $json['groups'] = $parsedCollection;
        $json['pagination_data'] = $paginationData;
        
        return $json;
    }

    public function findGroupById($filterArray = [])
    {
        $json = array();
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a')->from($this->getEntityName(), 'a');

        foreach ($filterArray as $key => $value) {
            $qb->Andwhere('a.'.$key.' = :'.$key);
            $qb->setParameter($key, $value);
        }   

        $result = $qb->getQuery()->getOneOrNullResult();

        return($result);
    }

}
