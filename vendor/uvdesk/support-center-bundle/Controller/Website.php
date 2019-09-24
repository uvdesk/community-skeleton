<?php

namespace Webkul\UVDesk\SupportCenterBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Webkul\UVDesk\SupportCenterBundle\Entity\Article;
use Webkul\UVDesk\SupportCenterBundle\Entity\SolutionCategory;
use Webkul\UVDesk\SupportCenterBundle\Entity\Solutions;
use Webkul\UVDesk\SupportCenterBundle\Form;
use Webkul\UVDesk\SupportCenterBundle\Entity\ArticleViewLog;

class Website extends Controller
{
    private $visibility = ['public'];
    private $limit = 5;
    private $company;

    protected function isWebsiteActive()
    {
       $em = $this->getDoctrine()->getManager();
       $frontWebsite = $em->getRepository('UVDeskCoreFrameworkBundle:Website')->findOneBy(['code' => 'customer']);

       return $frontWebsite ? $frontWebsite->getIsActive() : false;
    }

    protected function noResultFound()
    {
        throw new NotFoundHttpException('Permission Denied !');
    }

    public function home(Request $request)
    {
        $this->isWebsiteActive();

        $parameterBag = [
            'visibility' => 'public',
            'sort' => 'id',
            'direction' => 'desc'
        ];

        $articleRepository = $this->getDoctrine()->getRepository('UVDeskSupportCenterBundle:Article');
        $solutionRepository = $this->getDoctrine()->getRepository('UVDeskSupportCenterBundle:Solutions');

        $twigResponse = [
            'searchDisable' => false,
            'popArticles' => $articleRepository->getPopularTranslatedArticles($request->getLocale()),
            'solutions' => $solutionRepository->getAllSolutions(new ParameterBag($parameterBag), $this->container, 'a', [1]),
        ];

        $newResult = [];
       
        foreach ($twigResponse['solutions'] as $key => $result) {
            $newResult[] = [
                'id' => $result->getId(),
                'name' => $result->getName(),
                'description' => $result->getDescription(),
                'visibility' => $result->getVisibility(),
                'solutionImage' => ($result->getSolutionImage() == null) ? '' : $result->getSolutionImage(),
                'categoriesCount' => $solutionRepository->getCategoriesCountBySolution($result->getId()),
                'categories' => $solutionRepository->getCategoriesWithCountBySolution($result->getId()),
                'articleCount' => $solutionRepository->getArticlesCountBySolution($result->getId()),
            ];
        }

        $twigResponse['solutions']['results'] = $newResult;
        $twigResponse['solutions']['categories'] = array_map(function($category) use ($articleRepository) {
            $parameterBag = [
                'categoryId' => $category['id'],
                'status' => 1,
                'sort' => 'id',
                'limit'=>10,
                'direction' => 'desc'
            ];

            $article =  $articleRepository->getAllArticles(new ParameterBag($parameterBag), $this->container, 'a.id, a.name, a.slug, a.stared');
             
            return [
                'id' => $category['id'],
                'name' => $category['name'],
                'description' => $category['description'],
                'articles' => $article
            ];
        }, $solutionRepository->getAllCategories(10, 2));

        return $this->render('@UVDeskSupportCenter//Knowledgebase//index.html.twig', $twigResponse);
    }

    public function listCategories(Request $request)
    {
        $this->isWebsiteActive();

        $solutionRepository = $this->getDoctrine()->getRepository('UVDeskSupportCenterBundle:Solutions');
        $categoryCollection = $solutionRepository->getAllCategories(10, 4);
        
        return $this->render('@UVDeskSupportCenter/Knowledgebase/categoryListing.html.twig', [
            'categories' => $categoryCollection,
            'categoryCount' => count($categoryCollection),
        ]);
    }

    public function viewFolder(Request $request)
    {
        $this->isWebsiteActive();
        
        if(!$request->attributes->get('solution'))
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));

        $filterArray = ['id' => $request->attributes->get('solution')];

        $solution = $this->getDoctrine()
                    ->getRepository('UVDeskSupportCenterBundle:Solutions')
                    ->findOneBy($filterArray);

        if(!$solution)
            $this->noResultFound();

        $breadcrumbs = [
            [
                'label' => $this->get('translator')->trans('Support Center'),
                'url' => $this->generateUrl('helpdesk_knowledgebase')
            ],
            [
                'label' => $solution->getName(),
                'url' => '#'
            ],
        ];

        $testArray = [1, 2, 3, 4];
        foreach ($testArray as $test) {
            $categories[] = [
                'id' => $test,
                'name' => $test . " name",
                'articleCount' => $test . " articleCount",
            ];
        }

        return $this->render('@UVDeskSupportCenter//Knowledgebase//folder.html.twig', [
            'folder' => $solution,
            'categoryCount' => $this->getDoctrine()
                ->getRepository('UVDeskSupportCenterBundle:Solutions')
                ->getCategoriesCountBySolution($solution->getId()),
            'categories' => $this->getDoctrine()
                ->getRepository('UVDeskSupportCenterBundle:Solutions')
                ->getCategoriesWithCountBySolution($solution->getId()),
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function viewFolderArticle(Request $request)
    {
        $this->isWebsiteActive();

        if(!$request->attributes->get('solution'))
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));

        $filterArray = ['id' => $request->attributes->get('solution')];

        $solution = $this->getDoctrine()
                    ->getRepository('UVDeskSupportCenterBundle:Solutions')
                    ->findOneBy($filterArray);

        if(!$solution)
            $this->noResultFound();

        $breadcrumbs = [
            [
                'label' => $this->get('translator')->trans('Support Center'),
                'url' => $this->generateUrl('helpdesk_knowledgebase')
            ],
            [
                'label' => $solution->getName(),
                'url' => '#'
            ],
        ];

        $parameterBag = [
            'solutionId' => $solution->getId(),
            'status' => 1,
            'sort' => 'id',
            'direction' => 'desc'
        ];
        $article_data = [
            'folder' => $solution,
            'articlesCount' => $this->getDoctrine()
                ->getRepository('UVDeskSupportCenterBundle:Solutions')
                ->getArticlesCountBySolution($solution->getId(), [1]),
            'articles' => $this->getDoctrine()
                ->getRepository('UVDeskSupportCenterBundle:Article')
                ->getAllArticles(new ParameterBag($parameterBag), $this->container, 'a.id, a.name, a.slug, a.stared'),
            'breadcrumbs' => $breadcrumbs,
        ];

        return $this->render('@UVDeskSupportCenter/Knowledgebase/folderArticle.html.twig', $article_data);
    }

    public function viewCategory(Request $request)
    {
        $this->isWebsiteActive();

        if(!$request->attributes->get('category'))
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));

        $filterArray = array(
                            'id' => $request->attributes->get('category'),
                            'status' => 1,
                        );
       
        $category = $this->getDoctrine()
                    ->getRepository('UVDeskSupportCenterBundle:SolutionCategory')
                    ->findOneBy($filterArray);
    
        if(!$category)
            $this->noResultFound();

        $breadcrumbs = [
            [ 'label' => $this->get('translator')->trans('Support Center'),'url' => $this->generateUrl('helpdesk_knowledgebase') ],
            [ 'label' => $category->getName(),'url' => '#' ],
        ];
        
        $parameterBag = [
            'categoryId' => $category->getId(),
            'status' => 1,
            'sort' => 'id',
            'direction' => 'desc'
        ];

        $category_data=  array(
            'category' => $category,
            'articlesCount' => $this->getDoctrine()
                            ->getRepository('UVDeskSupportCenterBundle:SolutionCategory')
                            ->getArticlesCountByCategory($category->getId(), [1]),
            'articles' => $this->getDoctrine()
                        ->getRepository('UVDeskSupportCenterBundle:Article')
                        ->getAllArticles(new ParameterBag($parameterBag), $this->container, 'a.id, a.name, a.slug, a.stared'),
            'breadcrumbs' => $breadcrumbs
        );

        return $this->render('@UVDeskSupportCenter/Knowledgebase/category.html.twig',$category_data);
    }
   
    public function viewArticle(Request $request)
    {
        $this->isWebsiteActive();
       
        if (!$request->attributes->get('article') && !$request->attributes->get('slug')) {
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->get('user.service')->getCurrentUser();
        $articleRepository = $entityManager->getRepository('UVDeskSupportCenterBundle:Article');

        if ($request->attributes->get('article')) {
            $article = $articleRepository->findOneBy(['status' => 1, 'id' => $request->attributes->get('article')]);
        } else {
            $article = $articleRepository->findOneBy(['status' => 1,'slug' => $request->attributes->get('slug')]);
        }
       
        if (empty($article)) {
            $this->noResultFound();
        }
        $article->setViewed((int) $article->getViewed() + 1);
        
        // Log article view
        $articleViewLog = new ArticleViewLog();
        $articleViewLog->setUser(($user != null && $user != 'anon.') ? $user : null);
        
        $articleViewLog->setArticle($article);
        $articleViewLog->setViewedAt(new \DateTime('now'));

        $entityManager->persist($article);
        $entityManager->persist($articleViewLog);
        $entityManager->flush();
        
        // Get article feedbacks
        $feedbacks = ['enabled' => false, 'submitted' => false, 'article' => $articleRepository->getArticleFeedbacks($article)];

        if (!empty($user) && $user != 'anon.') {
            $feedbacks['enabled'] = true;

            if (!empty($feedbacks['article']['collection']) && in_array($user->getId(), array_column($feedbacks['article']['collection'], 'user'))) {
                $feedbacks['submitted'] = true;
            }
        }

        // @TODO: App popular articles
        $article_details = [
            'article' => $article,
            'breadcrumbs' => [
                ['label' => $this->get('translator')->trans('Support Center'), 'url' => $this->generateUrl('helpdesk_knowledgebase')],
                ['label' => $article->getName(), 'url' => '#']
            ],
            'dateAdded' => $this->get('user.service')->convertToTimezone($article->getDateAdded()),
            'articleTags' => $articleRepository->getTagsByArticle($article->getId()),
            'articleAuthor' => $articleRepository->getArticleAuthorDetails($article->getId()),
            'relatedArticles' => $articleRepository->getAllRelatedyByArticle(['locale' => $request->getLocale(), 'articleId' => $article->getId()], [1]),
            'popArticles'  => $articleRepository->getPopularTranslatedArticles($request->getLocale())
        ];

        return $this->render('@UVDeskSupportCenter/Knowledgebase/article.html.twig',$article_details);
    }

    public function searchKnowledgebase(Request $request)
    {
        $this->isWebsiteActive();

        $searchQuery = $request->query->get('s');
        if (empty($searchQuery)) {
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));
        }

        $articleCollection = $this->getDoctrine()->getRepository('UVDeskSupportCenterBundle:Article')->getArticleBySearch($request);

        return $this->render('@UVDeskSupportCenter/Knowledgebase/search.html.twig', [
            'search' => $searchQuery,
            'articles' => $articleCollection,
        ]);
    }

    public function viewTaggedResources(Request $request)
    {
        $this->isWebsiteActive();

        $tagQuery = $request->attributes->get('tag');
        if (empty($tagQuery)) {
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));
        }

        $tagLabel = $request->attributes->get('name');
        $articleCollection = $this->getDoctrine()->getRepository('UVDeskSupportCenterBundle:Article')->getArticleByTags([$tagLabel]);

        return $this->render('@UVDeskSupportCenter/Knowledgebase/search.html.twig', [
            'articles' => $articleCollection,
            'search' => $tagLabel,
            'breadcrumbs' => [
                ['label' => $this->get('translator')->trans('Support Center'), 'url' => $this->generateUrl('helpdesk_knowledgebase')],
                ['label' => $tagLabel, 'url' => '#'],
            ],
        ]);
    }

    public function rateArticle($articleId, Request $request)
    {
        dump("RateArticleAction called");
        die;
        $this->isWebsiteActive();
        if ($request->getMethod() != 'POST') {
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));
        }

        $company = $this->getCompany();
        $user = $this->container->get('user.service')->getCurrentUser();
        $response = ['code' => 404, 'content' => ['alertClass' => 'danger', 'alertMessage' => $this->get('translator')->trans('An unexpected error occurred. Please try again later.')]];

        if (!empty($user) && $user != 'anon.') {
            $entityManager = $this->getDoctrine()->getEntityManager();
            $article = $entityManager->getRepository('WebkulSupportCenterBundle:Article')->findOneBy(['id' => $articleId, 'companyId' => $company->getId()]);

            if (!empty($article)) {
                $providedFeedback = $request->request->get('feedback');

                if (!empty($providedFeedback) && in_array(strtolower($providedFeedback), ['positive', 'neagtive'])) {
                    $isArticleHelpful = ('positive' == strtolower($providedFeedback)) ? true : false;
                    $articleFeedback = $entityManager->getRepository('WebkulSupportCenterBundle:ArticleFeedback')->findOneBy(['article' => $article, 'ratedCustomer' => $user]);

                    $response = ['code' => 200, 'content' => ['alertClass' => 'success', 'alertMessage' => $this->get('translator')->trans('Feedback saved successfully.')]];

                    if (empty($articleFeedback)) {
                        $articleFeedback = new \Webkul\SupportCenterBundle\Entity\ArticleFeedback();

                        // $articleBadge->setDescription('');
                        $articleFeedback->setIsHelpful($isArticleHelpful);
                        $articleFeedback->setArticle($article);
                        $articleFeedback->setRatedCustomer($user);
                        $articleFeedback->setCreatedAt(new \DateTime('now'));
                    } else {
                        $articleFeedback->setIsHelpful($isArticleHelpful);
                        $response['content']['alertMessage'] = $this->get('translator')->trans('Feedback updated successfully.');
                    }

                    $entityManager->persist($articleFeedback);
                    $entityManager->flush();
                } else {
                    $response['content']['alertMessage'] = $this->get('translator')->trans('Invalid feedback provided.');
                }
            } else {
                $response['content']['alertMessage'] = $this->get('translator')->trans('Article not found.');
            }
        } else {
            $response['content']['alertMessage'] = $this->get('translator')->trans('You need to login to your account before can perform this action.');
        }

        return new Response(json_encode($response['content']), $response['code'], ['Content-Type: application/json']);
    }
}
