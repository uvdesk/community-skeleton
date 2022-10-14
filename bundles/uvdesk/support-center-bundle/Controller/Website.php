<?php

namespace Webkul\UVDesk\SupportCenterBundle\Controller;

use Doctrine\Common\Collections\Criteria;
use Webkul\UVDesk\SupportCenterBundle\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntites; 
use Webkul\UVDesk\SupportCenterBundle\Entity as SupportEntites;


class Website extends AbstractController
{
    private $visibility = ['public'];
    private $limit = 5;
    private $company;

    private $userService;
    private $translator;
    private $constructContainer;

    public function __construct(UserService $userService, TranslatorInterface $translator, ContainerInterface $constructContainer)
    {
        $this->userService = $userService;
        $this->translator = $translator;
        $this->constructContainer = $constructContainer;
    }

    private function isKnowledgebaseActive()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $website = $entityManager->getRepository(CoreEntites\Website::class)->findOneByCode('knowledgebase');

        if (!empty($website)) {
            $knowledgebaseWebsite = $entityManager->getRepository(SupportEntites\KnowledgebaseWebsite::class)->findOneBy(['website' => $website->getId(), 'status' => true]);

            if (!empty($knowledgebaseWebsite) && true == $knowledgebaseWebsite->getIsActive()) {
                return true;
            }
        }

        throw new NotFoundHttpException('Page Not Found');
    }

    public function home(Request $request)
    {
        $this->isKnowledgebaseActive();

        $parameterBag = [
            'visibility' => 'public',
            'sort' => 'id',
            'direction' => 'desc'
        ];

        $articleRepository = $this->getDoctrine()->getRepository(SupportEntites\Article::class);
        $solutionRepository = $this->getDoctrine()->getRepository(SupportEntites\Solutions::class);

        $twigResponse = [
            'searchDisable' => false,
            'popArticles' => $articleRepository->getPopularTranslatedArticles($request->getLocale()),
            'solutions' => $solutionRepository->getAllSolutions(new ParameterBag($parameterBag), $this->constructContainer, 'a', [1]),
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

            $article =  $articleRepository->getAllArticles(new ParameterBag($parameterBag), $this->constructContainer, 'a.id, a.name, a.slug, a.stared');
             
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
        $this->isKnowledgebaseActive();

        $solutionRepository = $this->getDoctrine()->getRepository(SupportEntites\Solutions::class);
        $categoryCollection = $solutionRepository->getAllCategories(10, 4);
        
        return $this->render('@UVDeskSupportCenter/Knowledgebase/categoryListing.html.twig', [
            'categories' => $categoryCollection,
            'categoryCount' => count($categoryCollection),
        ]);
    }

    public function viewFolder(Request $request)
    {
        $this->isKnowledgebaseActive();
        
        if(!$request->attributes->get('solution'))
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));

        $filterArray = ['id' => $request->attributes->get('solution')];

        $solution = $this->getDoctrine()
                    ->getRepository(SupportEntites\Solutions::class)
                    ->findOneBy($filterArray);

        if(!$solution)
            $this->noResultFound();

        $breadcrumbs = [
            [
                'label' => $this->translator->trans('Support Center'),
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
                ->getRepository(SupportEntites\Solutions::class)
                ->getCategoriesCountBySolution($solution->getId()),
            'categories' => $this->getDoctrine()
                ->getRepository(SupportEntites\Solutions::class)
                ->getCategoriesWithCountBySolution($solution->getId()),
            'breadcrumbs' => $breadcrumbs
        ]);
    }

    public function viewFolderArticle(Request $request)
    {
        $this->isKnowledgebaseActive();

        if(!$request->attributes->get('solution'))
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));

        $filterArray = ['id' => $request->attributes->get('solution')];

        $solution = $this->getDoctrine()
                    ->getRepository(SupportEntites\Solutions::class)
                    ->findOneBy($filterArray);

        if(!$solution)
            $this->noResultFound();

        $breadcrumbs = [
            [
                'label' => $this->translator->trans('Support Center'),
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
                ->getRepository(SupportEntites\Solutions::class)
                ->getArticlesCountBySolution($solution->getId(), [1]),
            'articles' => $this->getDoctrine()
                ->getRepository(SupportEntites\Article::class)
                ->getAllArticles(new ParameterBag($parameterBag), $this->constructContainer, 'a.id, a.name, a.slug, a.stared'),
            'breadcrumbs' => $breadcrumbs,
        ];

        return $this->render('@UVDeskSupportCenter/Knowledgebase/folderArticle.html.twig', $article_data);
    }

    public function viewCategory(Request $request)
    {
        $this->isKnowledgebaseActive();

        if(!$request->attributes->get('category'))
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));

        $filterArray = array(
                            'id' => $request->attributes->get('category'),
                            'status' => 1,
                        );
       
        $category = $this->getDoctrine()
                    ->getRepository(SupportEntites\SolutionCategory::class)
                    ->findOneBy($filterArray);
    
        if(!$category)
            $this->noResultFound();

        $breadcrumbs = [
            [ 'label' => $this->translator->trans('Support Center'),'url' => $this->generateUrl('helpdesk_knowledgebase') ],
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
                            ->getRepository(SupportEntites\SolutionCategory::class)
                            ->getArticlesCountByCategory($category->getId(), [1]),
            'articles' => $this->getDoctrine()
                        ->getRepository(SupportEntites\Article::class)
                        ->getAllArticles(new ParameterBag($parameterBag), $this->constructContainer, 'a.id, a.name, a.slug, a.stared'),
            'breadcrumbs' => $breadcrumbs
        );

        return $this->render('@UVDeskSupportCenter/Knowledgebase/category.html.twig',$category_data);
    }
   
    public function viewArticle(Request $request)
    {
        $this->isKnowledgebaseActive();
       
        if (!$request->attributes->get('article') && !$request->attributes->get('slug')) {
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));
        }

        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->userService->getCurrentUser();
        $articleRepository = $entityManager->getRepository(SupportEntites\Article::class);

        if ($request->attributes->get('article')) {
            $article = $articleRepository->findOneBy(['status' => 1, 'id' => $request->attributes->get('article')]);
        } else {
            $article = $articleRepository->findOneBy(['status' => 1,'slug' => $request->attributes->get('slug')]);
        }
       
        if (empty($article)) {
            $this->noResultFound();
        }
        $stringReplace = str_replace("<ol>","<ul>",$article->getContent());
        $stringReplace = str_replace("</ol>","</ul>",$stringReplace);

        $article->setContent($stringReplace);
        $article->setViewed((int) $article->getViewed() + 1);
        
        // Log article view
        $articleViewLog = new SupportEntites\ArticleViewLog();
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
                ['label' => $this->translator->trans('Support Center'), 'url' => $this->generateUrl('helpdesk_knowledgebase')],
                ['label' => $article->getName(), 'url' => '#']
            ],
            'dateAdded' => $this->userService->convertToTimezone($article->getDateAdded()),
            'articleTags' => $articleRepository->getTagsByArticle($article->getId()),
            'articleAuthor' => $articleRepository->getArticleAuthorDetails($article->getId()),
            'relatedArticles' => $articleRepository->getAllRelatedyByArticle(['locale' => $request->getLocale(), 'articleId' => $article->getId()], [1]),
            'popArticles'  => $articleRepository->getPopularTranslatedArticles($request->getLocale())
        ];

        return $this->render('@UVDeskSupportCenter/Knowledgebase/article.html.twig',$article_details);
    }

    public function searchKnowledgebase(Request $request)
    {
        $this->isKnowledgebaseActive();

        $searchQuery = $request->query->get('s');
        if (empty($searchQuery)) {
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));
        }

        $articleCollection = $this->getDoctrine()->getRepository(SupportEntites\Article::class)->getArticleBySearch($request);

        return $this->render('@UVDeskSupportCenter/Knowledgebase/search.html.twig', [
            'search' => $searchQuery,
            'articles' => $articleCollection,
        ]);
    }

    public function viewTaggedResources(Request $request)
    {
        $this->isKnowledgebaseActive();

        $tagQuery = $request->attributes->get('tag');
        if (empty($tagQuery)) {
            return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));
        }

        $tagLabel = $request->attributes->get('name');
        $articleCollection = $this->getDoctrine()->getRepository(SupportEntites\Article::class)->getArticleByTags([$tagLabel]);

        return $this->render('@UVDeskSupportCenter/Knowledgebase/search.html.twig', [
            'articles' => $articleCollection,
            'search' => $tagLabel,
            'breadcrumbs' => [
                ['label' => $this->translator->trans('Support Center'), 'url' => $this->generateUrl('helpdesk_knowledgebase')],
                ['label' => $tagLabel, 'url' => '#'],
            ],
        ]);
    }

    public function rateArticle($articleId, Request $request)
    {
        $this->isKnowledgebaseActive();

        // @TODO: Refactor
            
        // if ($request->getMethod() != 'POST') {
        //     return $this->redirect($this->generateUrl('helpdesk_knowledgebase'));
        // }

        // $company = $this->getCompany();
        // $user = $this->userService->getCurrentUser();
        $response = ['code' => 404, 'content' => ['alertClass' => 'danger', 'alertMessage' => 'An unexpected error occurred. Please try again later.']];

        // if (!empty($user) && $user != 'anon.') {
        //     $entityManager = $this->getDoctrine()->getEntityManager();
        //     $article = $entityManager->getRepository('WebkulSupportCenterBundle:Article')->findOneBy(['id' => $articleId, 'companyId' => $company->getId()]);

        //     if (!empty($article)) {
        //         $providedFeedback = $request->request->get('feedback');

        //         if (!empty($providedFeedback) && in_array(strtolower($providedFeedback), ['positive', 'neagtive'])) {
        //             $isArticleHelpful = ('positive' == strtolower($providedFeedback)) ? true : false;
        //             $articleFeedback = $entityManager->getRepository('WebkulSupportCenterBundle:ArticleFeedback')->findOneBy(['article' => $article, 'ratedCustomer' => $user]);

        //             $response = ['code' => 200, 'content' => ['alertClass' => 'success', 'alertMessage' => 'Feedback saved successfully.']];

        //             if (empty($articleFeedback)) {
        //                 $articleFeedback = new \Webkul\SupportCenterBundle\Entity\ArticleFeedback();

        //                 // $articleBadge->setDescription('');
        //                 $articleFeedback->setIsHelpful($isArticleHelpful);
        //                 $articleFeedback->setArticle($article);
        //                 $articleFeedback->setRatedCustomer($user);
        //                 $articleFeedback->setCreatedAt(new \DateTime('now'));
        //             } else {
        //                 $articleFeedback->setIsHelpful($isArticleHelpful);
        //                 $response['content']['alertMessage'] = 'Feedback updated successfully.';
        //             }

        //             $entityManager->persist($articleFeedback);
        //             $entityManager->flush();
        //         } else {
        //             $response['content']['alertMessage'] = 'Invalid feedback provided.';
        //         }
        //     } else {
        //         $response['content']['alertMessage'] = 'Article not found.';
        //     }
        // } else {
        //     $response['content']['alertMessage'] = 'You need to login to your account before can perform this action.';
        // }

        return new Response(json_encode($response['content']), $response['code'], ['Content-Type: application/json']);
    }

    /**
     * If customer is playing with url and no result is found then what will happen
     * @return 
     */
    protected function noResultFound()
    {
        throw new NotFoundHttpException('Not Found!');
    }
}
