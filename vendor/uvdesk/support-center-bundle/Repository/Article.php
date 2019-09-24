<?php

namespace Webkul\UVDesk\SupportCenterBundle\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Request;

class Article extends EntityRepository
{
    const LIMIT = 10;

    private $defaultSort = 'a.id';
    private $searchAllowed = ['tag'];
    private $direction = ['asc', 'desc'];
    private $sorting = ['a.name', 'a.dateAdded', 'a.viewed'];
	private $safeFields = ['page', 'limit', 'sort', 'order', 'direction'];
    private $allowedFormFields = ['search', 'query', 'name', 'description', 'viewed', 'status'];

    private function validateSorting($sorting)
    {
        return in_array($sorting, $this->sorting) ? $sorting : $this->defaultSort;
    }

    private function validateDirection($direction)
    {
        return in_array($direction, $this->direction) ? $direction : Criteria::DESC;
    }

    private function presetting(&$data)
    {
        $data['sort'] = $_GET['sort'] = $this->validateSorting(isset($data['sort']) ? $data['sort'] : false);
        $data['direction'] = $_GET['direction'] = $this->validateDirection(isset($data['direction']) ? $data['direction'] : false);

        $this->cleanAllData($data);
    }

    private function cleanAllData(&$data)
    {
        if(isset($data['isActive'])){
            $data['status'] = $data['isActive'];
            unset($data['isActive']);
        }
        unset($data['categoryId']);
        unset($data['solutionId']);
    }

    public function getTotalArticlesBySupportTag($supportTag)
    {
        $result = $this->getEntityManager()->createQueryBuilder()
            ->select('COUNT(articleTags) as totalArticle')
            ->from('UVDeskSupportCenterBundle:ArticleTags', 'articleTags')
            ->where('articleTags.tagId = :supportTag')->setParameter('supportTag', $supportTag)
            ->getQuery()->getResult();
        
        return !empty($result) ? $result[0]['totalArticle'] : 0;
    }

    public function getAllHistoryByArticle($params)
    {
        $qbS = $this->getEntityManager()->createQueryBuilder();

        $results = $qbS->select('a.id, a.dateAdded, a.content')
                        ->from('Webkul\UVDesk\SupportCenterBundle\Entity\ArticleHistory', 'a')
                        ->leftJoin('Webkul\UVDesk\CoreFrameworkBundle\Entity\User','u','WITH', 'a.userId = u.id')
                        ->leftJoin('u.userInstance', 'ud')
                        ->addSelect("CONCAT(u.firstName,' ',u.lastName) AS name")
                        ->andwhere('a.articleId = :articleId')
                        ->andwhere('ud.supportRole IN (:roleId)')
                        ->orderBy(
                            'a.id',
                            Criteria::DESC
                        )
                        ->setParameters([
                            'articleId' => $params['articleId'],
                            'roleId' => [1, 2, 3],
                        ])
                        ->getQuery()
                        ->getResult();


        return $results;
    }

    public function getAllRelatedyByArticle($params, $status = [0, 1])
    {
        $qbS = $this->getEntityManager()->createQueryBuilder();

        $qbS->select('DISTINCT a.id, a.relatedArticleId as articleId, aR.name, aR.stared, aR.status, aR.slug')
            ->from('Webkul\UVDesk\SupportCenterBundle\Entity\ArticleRelatedArticle', 'a')
            ->leftJoin('Webkul\UVDesk\SupportCenterBundle\Entity\Article','aR','WITH', 'a.relatedArticleId = aR.id')
            
            ->andwhere('a.articleId = :articleId')
            ->andwhere('aR.status IN (:status)')
            ->orderBy(
                'a.id',
                Criteria::DESC
            )
            ->setParameters([
                'articleId' => $params['articleId'],
                'status' => $status,
            ]);

        $results = $qbS->getQuery()->getResult();
        return $results;
    }

	public function getAllArticles(\Symfony\Component\HttpFoundation\ParameterBag $obj = null, $container, $allResult = false)
    {
        $json = array();
       
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a')->from($this->getEntityName(), 'a');

        $data = $obj ? $obj->all() : [];
        $data = array_reverse($data);

        $articles = [];

        if(isset($data['categoryId']))
        {
            $qbS = $this->getEntityManager()->createQueryBuilder();
            $qbS->select('a.articleId')->from('Webkul\UVDesk\SupportCenterBundle\Entity\ArticleCategory', 'a');
            $qbS->where('a.categoryId = :categoryId');
            $qbS->setParameter('categoryId', $data['categoryId']);

            $articles = $qbS->getQuery()->getResult();
            $articles = $articles ? $articles : [0];
        }
        
        if (isset($data['solutionId'])) {
            $qbS = $this->getEntityManager()->createQueryBuilder();
            $qbS->select('DISTINCT ac.articleId')->from('Webkul\UVDesk\SupportCenterBundle\Entity\SolutionCategoryMapping', 'scm');
            $qbS->leftJoin('Webkul\UVDesk\SupportCenterBundle\Entity\ArticleCategory', 'ac', 'with', 'scm.categoryId = ac.categoryId');
            $qbS->where('scm.solutionId = :solutionId');
            $qbS->setParameter('solutionId', $data['solutionId']);

            $articles = $qbS->getQuery()->getResult();
            $articles = $articles ? $articles : [0];
        }

        if(isset($data['search'])){
            $search = explode(':', $data['search']);

            if(isset($search[0]) && isset($search[1])){
                if(in_array($search[0], $this->searchAllowed)){
                    if($search[0] == 'tag'){
                        $qbS = $this->getEntityManager()->createQueryBuilder();
                        $qbS->select('at.articleId')->from('Webkul\UVDesk\SupportCenterBundle\Entity\ArticleTags', 'at');
                          
                        $articlesTag = $qbS->getQuery()->getResult();

                        if($articlesTag){
                            if($articles){
                                $oldArticles = $articles;
                                $articles = [0];
                                foreach($oldArticles as $article){
                                    if(in_array($article, $articlesTag)){
                                        $articles[] = $article;
                                    }
                                }
                            }else
                                $articles = $articlesTag;
                        }else
                            $articles = [0];
                    }
                    unset($data['search']);
                }
            }
        }

        $this->presetting($data);

        
        foreach ($data as $key => $value) {
            if(!in_array($key,$this->safeFields) && in_array($key, $this->allowedFormFields)) {
                if($key!='dateUpdated' AND $key!='dateAdded' AND $key!='search' AND $key!='query') {
                        $qb->Andwhere('a.'.$key.' = :'.$key);
                        $qb->setParameter($key, $value);
                } else {
                    if($key == 'search' || $key == 'query') {
                        $qb->orwhere('a.name'.' LIKE :name');
                        $qb->setParameter('name', '%'.urldecode(trim($value)).'%');
                        $qb->orwhere('a.content'.' LIKE :content'); //can use regexBundle for it so that it can\'t match html
                        $qb->setParameter('content', '%'.urldecode(trim($value)).'%');
                    }
                }
            }
        }

        if($articles){
            $qb->Andwhere('a.id IN (:articles)');
            $qb->setParameter('articles', $articles);
        }
        // dump($qb);die;
        if(!$allResult){
            $paginator  = $container->get('knp_paginator');

            $results = $paginator->paginate(
                $qb,
                isset($data['page']) ? $data['page'] : 1,
                self::LIMIT,
                array('distinct' => true)
            );
        }else{
            $qb->select($allResult);
            $results = $qb->getQuery()->getResult();
            return $results;
        }

        $newResult = [];
        // dump($results);die;
        foreach ($results as $key => $result) {
            // dump($result['id']);
            $newResult[] = array(
                'id'                   => $result->getId(),
                'name'                 => $result->getName(),
                'slug'                 => $result->getSlug(),
                'status'               => $result->getStatus(),
                'viewed'               => $result->getViewed(),
                'dateAdded'            => date_format($result->getDateAdded(),'d-M h:i A'),
                'categories'           => ($articles ? $this->getCategoryByArticle($result->getId()) : $this->getCategoryByArticle($result->getId())),
            );
        }

        // die;

        $paginationData = $results->getPaginationData();
        $queryParameters = $results->getParams();
       
        unset($queryParameters['solution']);
        if(isset($queryParameters['category']))
            unset($queryParameters['category']);

        $paginationData['url'] = '#'.$container->get('uvdesk.service')->buildPaginationQuery($queryParameters);

        $json['results'] = $newResult;
        $json['pagination_data'] = $paginationData;
        // dump($json);die;
        return $json;
    }
   
    public function getCategoryByArticle($id)
    {
        $queryBuilder = $this->createQueryBuilder('a');

        $results = $queryBuilder->select('c.id, c.name')
                 ->leftJoin('Webkul\UVDesk\SupportCenterBundle\Entity\ArticleCategory','ac','WITH', 'ac.articleId = a.id')
                 ->leftJoin('Webkul\UVDesk\SupportCenterBundle\Entity\SolutionCategory','c','WITH', 'ac.categoryId = c.id')
                 ->andwhere('ac.articleId = :articleId')
                 ->setParameters([
                     'articleId' => $id,
                 ])
                 ->getQuery()
                 ->getResult()
        ;

        return $results;
    }

    public function getTagsByArticle($id)
    {
        $queryBuilder = $this->createQueryBuilder('a');

        $results = $queryBuilder->select('DISTINCT t.id, t.name')
                ->leftJoin('Webkul\UVDesk\SupportCenterBundle\Entity\ArticleTags','at','WITH', 'at.articleId = a.id')
                ->leftJoin('Webkul\UVDesk\CoreFrameworkBundle\Entity\Tag','t','WITH', 'at.tagId = t.id')
                ->andwhere('at.articleId = :articleId')
                ->setParameters([
                    'articleId' => $id,
                ])
                ->getQuery()
                ->getResult()
        ;

        return $results;
    }

    public function removeCategoryByArticle($articleId, $categories = [])
    {
        $where = is_array($categories) ? 'ac.categoryId IN (:id)' : 'ac.categoryId = :id';

        $queryBuilder = $this->createQueryBuilder('ac');

        $queryBuilder->delete('UVDeskSupportCenterBundle:ArticleCategory','ac')
                 ->andwhere('ac.articleId = :articleId')
                 ->andwhere($where)
                 ->setParameters([
                     'articleId' => $articleId,
                     'id' => $categories ,
                 ])
                 ->getQuery()
                 ->execute()
        ;
    }

    public function removeTagByArticle($articleId, $tags = [])
    {
        $where = is_array($tags) ? 'ac.tagId IN (:id)' : 'ac.tagId = :id';

        $queryBuilder = $this->createQueryBuilder('ac');

        $queryBuilder->delete('UVDeskSupportCenterBundle:ArticleTags','ac')
            ->andwhere('ac.articleId = :articleId')
            ->andwhere($where)
            ->setParameters(['articleId' => $articleId,'id' => $tags])
            ->getQuery()
            ->execute();
    }

    public function removeRelatedByArticle($articleId, $ids = [])
    {
        $where = is_array($ids) ? 'ac.id IN (:id)' : 'ac.id = :id';

        $queryBuilder = $this->createQueryBuilder('ac');

        $queryBuilder->delete('UVDeskSupportCenterBundle:ArticleRelatedArticle','ac')
            ->andwhere('ac.articleId = :articleId')
            ->andwhere($where)
            ->setParameters(['articleId' => $articleId,'id' => $ids])
            ->getQuery()
            ->execute();
    }

    public function removeEntryByArticle($id)
    {
        $where = is_array($id) ? 'ac.articleId IN (:id)' : 'ac.articleId = :id';

        $queryBuilder = $this->createQueryBuilder('ac');

        $queryBuilder->delete('UVDeskSupportCenterBundle:ArticleCategory','ac')
                 ->andwhere($where)
                 ->setParameters([
                     'id' => $id ,
                 ])
                 ->getQuery()
                 ->execute();

    
    }

    public function bulkArticleStatusUpdate($ids, $status)
    {
        $query = 'UPDATE Webkul\UVDesk\SupportCenterBundle\Entity\Article a SET a.status = '. (int)$status .' WHERE a.id IN ('.implode(',', $ids).')';

        $this->getEntityManager()->createQuery($query)->execute();
    }

    private function getStringToOrder($string)
    {
        Switch($string){
            case 'ascending':
                return 'ASC';
                break;
            case 'decending':
            case 'popularity':
                return 'DESC';
                break;
            Default:
                return 'DESC';
                break;
        }
    }

    public function getArticlesByCategory(Request $request, $companyId)
    {
        $queryBuilder = $this->createQueryBuilder('a');

        $prams = array(
                        'solutionId' => (int)$request->attributes->get('solution'),
                        'categoryId' => (int)$request->attributes->get('category'),
                    );

        $results = $queryBuilder->select('a')
                 ->leftJoin('Webkul\SupportCenterBundle\Entity\ArticleCategory','ac','WITH', 'ac.articleId = a.id')
                 ->andwhere('a.solutionId = :solutionId')
                 ->andwhere('ac.categoryId = :categoryId')
                 ->orderBy(
                        $request->query->get('sort') ? 'a.'.$request->query->get('sort') : 'a.id',
                        $request->query->get('direction') ? $request->query->get('direction') : Criteria::DESC
                    )
                 ->setParameters($prams)
                 ->getQuery()
                 ->getResult()
        ;

        return $results;
    }

	public function getSolutionArticles(Request $request, $companyId)
    {
        $queryBuilder = $this->createQueryBuilder('a');

        $prams = array(
                        'solutionId' => (int)$request->attributes->get('solution'),
                    );

        $results = $queryBuilder->select('a')
                 ->andwhere('a.solutionId = :solutionId')
                 ->orderBy(
                        $request->query->get('sort') ? 'a.'.$request->query->get('sort') : 'a.id',
                        $request->query->get('direction') ? $request->query->get('direction') : Criteria::DESC
                    )
                 ->setParameters($prams)
                 ->getQuery()
                 ->getResult()
        ;

        return $results;
    }

    public function getArticlesByCategoryFront($category)
    {
        $queryBuilder = $this->createQueryBuilder('a');

        $prams = array(
                        'solutionId' => $category->getSolution(),
                        'categoryId' => $category->getId(),
                    );

        $results = $queryBuilder->select('a')
                 ->leftJoin('Webkul\SupportCenterBundle\Entity\ArticleCategory','ac','WITH', 'ac.articleId = a.id')
                 ->andwhere('a.solutionId = :solutionId')
                 ->andwhere('ac.categoryId = :categoryId')
                 ->andwhere('a.status = 1')
                 ->orderBy(
                        $category->getSorting() == 'popularity' ? 'a.viewed' : 'a.name',
                        $this->getStringToOrder($category->getSorting())
                    )
                 ->setParameters($prams)
                 ->getQuery()
                 ->getResult()
        ;

        return $results;
    }

    public function getArticleCategory(Request $request)
    {
        $queryBuilder = $this->createQueryBuilder('a');

        $prams = array(
                        'articleId' => (int)$request->attributes->get('article'),
                    );

        $results = $queryBuilder->select('ac')
                 ->leftJoin('Webkul\SupportCenterBundle\Entity\ArticleCategory','ac','WITH', 'ac.articleId = a.id')
                 ->andwhere('ac.articleId = :articleId')
                 ->orderBy(
                        $request->query->get('sort') ? 'a.'.$request->query->get('sort') : 'a.id',
                        $request->query->get('direction') ? $request->query->get('direction') : Criteria::DESC
                    )
                 ->setParameters($prams)
                 ->getQuery()
                 ->getResult()
        ;

        return $results;
    }

    public function getArticleBySearch(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $searchQuery = $request->query->get('s');
        $searchTagList = explode(' ', trim($searchQuery));

        $params = [
            'name' => '%' . trim($searchQuery) . '%',
            'status' => 1,
        ];

        $results = $this->createQueryBuilder('a')
                 ->select('a.id, a.name, a.slug, a.content, a.metaDescription, a.keywords, a.metaTitle, a.status, a.viewed, a.stared, a.dateAdded, a.dateUpdated')
                 ->andwhere('a.name LIKE :name OR a.content LIKE :name')
                 ->andwhere('a.status = :status')
                 ->orderBy((!empty($sort)) ? 'a.' . $sort : 'a.id', (!empty($direction)) ? $direction : Criteria::DESC)
                 ->setParameters($params)
                 ->getQuery()
                 ->getResult();
     
        return $results;
    }

    public function getArticleByTags(array $tagList = [], $sort = null, $direction = null)
    {
      
        if (empty($tagList))
            return [];

        $queryBuilder = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from('UVDeskSupportCenterBundle:Article', 'a')
            ->leftJoin('UVDeskSupportCenterBundle:ArticleTags', 'at', 'WITH', 'at.articleId = a.id')
            ->leftJoin('UVDeskCoreFrameworkBundle:Tag', 't', 'WITH', 't.id = at.tagId')
            ->andwhere('a.status = :status')->setParameter('status', 1)
            ->orderBy(
                (!empty($sort)) ? 'a.' . $sort : 'a.id',
                (!empty($direction)) ? $direction : Criteria::DESC
            );

        // Build the sub-query
        $subQuery = '';
        foreach ($tagList as $index => $tag) {
            $queryBuilder->setParameter('tag' . $index, '%' . $tag . '%');
            $subQuery .= ($index == 0) ? 't.name LIKE :tag' . $index : ' OR t.name LIKE :tag' . $index;
        }

        $queryBuilder->andWhere($subQuery);

        $articleCollection = $queryBuilder->getQuery()->getResult();

        return (!empty($articleCollection)) ? $articleCollection : [];
    }

    

    public function getArticleAuthorDetails($articleId = null, $companyId = null)
    {
        if (empty($articleId))
            throw new \Exception('Article::getArticleAuthorDetails() expects parameter 1 to be defined.');

        $queryBuilder = $this->getEntityManager()->createQueryBuilder()
            ->select('ud')
            ->from('UVDeskCoreFrameworkBundle:UserInstance', 'ud')
            ->leftJoin('UVDeskSupportCenterBundle:ArticleHistory', 'ah', 'WITH', 'ah.userId = ud.user')
            ->where('ah.articleId = :articleId')->setParameter('articleId', $articleId)
            // ->andWhere('ud.companyId = :companyId')->setParameter('companyId', $companyId)
            ->andWhere('ud.supportRole != :userRole')->setParameter('userRole', 4)
            ->orderBy('ah.dateAdded', 'ASC')
            ->setMaxResults(1);

        $articleAuthorCollection = $queryBuilder->getQuery()->getResult();
        if (!empty($articleAuthorCollection) && count($articleAuthorCollection) > 1) {
            // Parse through the collection and priorotize entity which have the designation field. This case
            // will occur when the user is mapped with more than one userData entity with differing userRoles.
            // If none is found, return the very first element in collection. It doesn't matter then.
            $defaultArticleAuthor = $articleAuthorCollection[0];
            foreach ($articleAuthorCollection as $articleAuthor) {
                if (!empty($articleAuthor->getJobTitle())) {
                    $defaultArticleAuthor = $articleAuthor;
                    break;
                }
            }
            return (!empty($defaultArticleAuthor)) ? $defaultArticleAuthor : $articleAuthorCollection[0];
        } else {
            return (!empty($articleAuthorCollection)) ? $articleAuthorCollection[0] : null;
        }
    }
    /**
    * search company articles by keyword and returns articles array
    *
    * @param string $keyword
    *
    * @return array Articles
    */
    public function SearchCompanyArticles($company, $keyword)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('a')
            ->from('SupportCenterBundle:Article', 'a')
            // ->leftJoin('SupportCenterBundle:ArticleTags', 'at', 'WITH', 'at.articleId = a.id')
            ->where('a.companyId = :companyId')->setParameter('companyId', $company->getId())
            ->andwhere('a.status = :status')->setParameter('status', 1)
            ->andWhere('a.name LIKE :keyword OR a.slug LIKE :keyword OR a.content LIKE :keyword')->setParameter('keyword', '%' . $keyword . '%')
            ->orderBy(
                'a.dateUpdated'
            );
        $articles = $qb->getQuery()->getArrayResult();

        return $articles;
    }

    public function getArticleFeedbacks($article)
    {
        $response = ['positiveFeedbacks' => 0, 'negativeFeedbacks' => 0, 'collection' => []];
        $nativeQuery = strtr('SELECT user_id, is_helpful, description FROM uv_article_feedback WHERE article_id = {ARTICLE_ID}', [
            '{ARTICLE_ID}' => $article->getId(),
        ]);

        $preparedDBStatment = $this->getEntityManager()->getConnection()->prepare($nativeQuery);
        $preparedDBStatment->execute();
        $feedbackCollection = $preparedDBStatment->fetchAll();

        if (!empty($feedbackCollection)) {
            $response['collection'] = array_map(function($feedback) {
                return ['user' => $feedback['user_id'], 'direction' => ((int) $feedback['is_helpful'] === 1) ? 'positive' : 'negative', 'feedbackMessage' => $feedback['description']];
            }, $feedbackCollection);

            $ratings = array_count_values(array_column($response['collection'], 'direction'));
            $response['positiveFeedbacks'] = !empty($ratings['positive']) ? $ratings['positive'] : 0;
            $response['negativeFeedbacks'] = !empty($ratings['negative']) ? $ratings['negative'] : 0;
        }

        return $response;
    }
	
    public function getPopularTranslatedArticles($locale)
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->select('a.id', 'a.name', 'a.slug', 'a.content', 'a.stared')
            ->from($this->getEntityName(), 'a')
            ->andwhere('a.status = :status')
            ->setParameter('status', 1)
            ->addOrderBy('a.viewed', Criteria::DESC)
            ->setMaxResults(10);
       
        return $qb->getQuery()->getArrayResult();
    }
}
