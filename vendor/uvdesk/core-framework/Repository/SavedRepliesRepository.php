<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\ParameterBag;

class SavedRepliesRepository extends EntityRepository
{
    const LIMIT = 10;
	public $safeFields = array('page','limit','sort','order','direction');

    public function getSavedReplies(ParameterBag $obj = null, $container)
    {
        $json = array();
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('DISTINCT sr.id, sr.name')->from($this->getEntityName(), 'sr');

        $data = $obj->all();
        $data = array_reverse($data);
        foreach ($data as $key => $value) {
            if(!in_array($key,$this->safeFields)) {
                if($key!='dateUpdated' AND $key!='dateAdded' AND $key!='search') {
                    $qb->andwhere('sr.'.$key.' = :'.$key);
                    $qb->setParameter($key, $value);
                } else {
                    if($key == 'search') {
                        $qb->andwhere('sr.name'.' LIKE :name');
                        $qb->setParameter('name', '%'.urldecode(trim($value)).'%');    
                    }
                }
            }
        }           

        if(!isset($data['sort']))
            $qb->orderBy('sr.id', Criteria::DESC);

        $paginator  = $container->get('knp_paginator');

        $newQb = clone $qb;
        $newQb->select('COUNT(DISTINCT sr.id)');

        $results = $paginator->paginate(
            $qb->getQuery()->setHydrationMode(Query::HYDRATE_ARRAY)->setHint('knp_paginator.count', $newQb->getQuery()->getSingleScalarResult()),
            isset($data['page']) ? $data['page'] : 1,
            self::LIMIT,
            array('distinct' => false)
        );

        $paginationData = $results->getPaginationData();
        $queryParameters = $results->getParams();
        if(isset($queryParameters['template']))
            unset($queryParameters['template']);

       $paginationData['url'] = '#'.$container->get('uvdesk.service')->buildPaginationQuery($queryParameters);

        $json['savedReplies'] = $results->getItems();
        $json['pagination_data'] = $paginationData;
       
        return $json;
    }

    public function getSavedReply($id, $container)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('sr')->from($this->getEntityName(), 'sr')
            ->andWhere('sr.id = :id')
            ->setParameter('id', $id );

        return $qb->getQuery()->getOneOrNullResult();
    }
}
