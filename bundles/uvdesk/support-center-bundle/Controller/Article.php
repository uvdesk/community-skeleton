<?php

namespace Webkul\UVDesk\SupportCenterBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Webkul\UVDesk\SupportCenterBundle\Form;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UVDeskService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\SupportCenterBundle\Entity as SupportEntites;
use Webkul\UVDesk\CoreFrameworkBundle\Entity as CoreEntites; 


class Article extends AbstractController
{
    private $userService;
    private $eventDispatcher;
    private $translator;
    private $uvdeskService;

    public function __construct(UserService $userService, UVDeskService $uvdeskService,EventDispatcherInterface $eventDispatcher, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->eventDispatcher = $eventDispatcher;
        $this->translator = $translator;
        $this->uvdeskService = $uvdeskService;
    }

    public function ArticleList(Request $request, ContainerInterface $container)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $solutions = $this->getDoctrine()
            ->getRepository(SupportEntites\Solutions::class)
            ->getAllSolutions(null, $container, 'a.id, a.name');
        if ($solutions) {
            foreach($solutions as $key => $solution) {
                $solutions[$key]['categories'] = $this->getDoctrine()
                    ->getRepository(SupportEntites\Solutions::class)
                    ->getCategoriesWithCountBySolution($solution['id']);
            }
        }

        return $this->render('@UVDeskSupportCenter/Staff/Articles/articleList.html.twig', [
            'solutions' => $solutions
        ]);
    }

    public function ArticleListByCategory(Request $request, ContainerInterface $container)
    {
        $category = $this->getDoctrine()
            ->getRepository(SupportEntites\SolutionCategory::class)
            ->findCategoryById(['id' => $request->attributes->get('category')]);

        if ($category) {
            return $this->render('@UVDeskSupportCenter/Staff/Articles/articleListByCategory.html.twig',[
                'category' => $category,
                'articleCount'      => $this->getDoctrine()
                    ->getRepository(SupportEntites\SolutionCategory::class)
                    ->getArticlesCountByCategory($request->attributes->get('category')),

                'categorySolutions' => $this->getDoctrine()
                    ->getRepository(SupportEntites\SolutionCategory::class)
                    ->getSolutionsByCategory($request->attributes->get('category')),

                'solutions'         => $this->getDoctrine()
                    ->getRepository(SupportEntites\Solutions::class)
                    ->getAllSolutions(null, $container, 'a.id, a.name')
            ]);
        } else {
            $this->noResultFound();
        }
    }

    public function ArticleListBySolution(Request $request)
    {
        $solution = $this->getDoctrine()
            ->getRepository(SupportEntites\Solutions::class)
            ->findSolutionById(['id' => $request->attributes->get('solution')]);

        if ($solution) {
            return $this->render('@UVDeskSupportCenter/Staff/Articles/articleListBySolution.html.twig', [
                'solution' => $solution,
                'solutionArticleCount'  => $this->getDoctrine()
                    ->getRepository(SupportEntites\Solutions::class)
                    ->getArticlesCountBySolution($request->attributes->get('solution')),

                'solutionCategoryCount' => $this->getDoctrine()
                    ->getRepository(SupportEntites\Solutions::class)
                    ->getCategoriesCountBySolution($request->attributes->get('solution')),
            ]);
        } else {
            $this->noResultFound();
        }
    }

    public function ArticleListXhr(Request $request, ContainerInterface $container)
    {
        $json = array();
        $repository = $this->getDoctrine()->getRepository(SupportEntites\Article::class);

        if($request->attributes->get('category'))
            $request->query->set('categoryId', $request->attributes->get('category'));

        if($request->attributes->get('solution'))
            $request->query->set('solutionId', $request->attributes->get('solution'));

        $json = $repository->getAllArticles($request->query, $container);

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function articleHistoryXhr(Request $request)
    {
        $json = array();
        $repository = $this->getDoctrine()->getRepository(SupportEntites\Article::class);

        $params = ['articleId' => $request->attributes->get('id')];
        $json = $repository->getAllHistoryByArticle($params);

        if ($json) {
            foreach($json as $key => $js) {
                $json[$key]['dateAdded'] = [
                    'format' => $this->userService->convertToTimezone($js['dateAdded']),
                    'timestamp' => $this->userService->convertToDatetimeTimezoneTimestamp($js['dateAdded']),
                ];
            }
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function articleRelatedXhr(Request $request)
    {
        $json = array();
        $repository = $this->getDoctrine()->getRepository(SupportEntites\Article::class);

        $params = ['articleId' => $request->attributes->get('id')];
        $json = $repository->getAllRelatedyByArticle($params);

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    protected function getArticle($filterArray = array())
    {
        if ($filterArray) {
            return $this->getDoctrine()
                ->getRepository(SupportEntites\Article::class)
                ->findOneBy($filterArray);
        }

        return false;
    }

    public function article(Request $request, ContainerInterface $container)
    {
        if ($request->attributes->get('id')) {
            $article = $this->getArticle(['id' => $request->attributes->get('id')]);

            if(!$article)
                $this->noResultFound();
        } else {
            $article = new SupportEntites\Article;
        }

        $articleCategory = $articleTags = [];
        if ($article->getId()) {
            $articleCategory = $this->getDoctrine()
                ->getRepository(SupportEntites\Article::class)
                ->getCategoryByArticle($article->getId());

            $articleTags = $this->getDoctrine()
                ->getRepository(SupportEntites\Article::class)
                ->getTagsByArticle($article->getId());
        }

        $categories = $this->getDoctrine()
            ->getRepository(SupportEntites\SolutionCategory::class)
            ->getAllCategories(null, $container, 'a.id, a.name');

        if ($request->attributes->get('id')) {
            return  $this->render('@UVDeskSupportCenter/Staff/Articles/articleForm.html.twig', [
                'article' => $article,
                'articleCategory' => $articleCategory,
                'articleTags' => $articleTags,
                'categories' => $categories
            ]);
        }

        return $this->render( '@UVDeskSupportCenter/Staff/Articles/articleAddForm.html.twig', [ 'article' => $article ] );
    }
    public function articleXhr(Request $request)
    {
        // Proceed only if user has access to the resource        
        if( (!$this->userService->getSessionUser()) || (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) )
        {
            throw new \Exception('Access Denied', 403); 
        }

        $json = array();

        if ($request->getMethod() == "POST") {
            $data = $request->request->get("data");
            $entityManager = $this->getDoctrine()->getManager();

            if (isset($data['actionType'])) {
                switch ($data['actionType']) {
                    case 'articleUpdate':
                        if ('articleSave' == $data['actionType']  && !empty($resources['articles']['showAlert']) ) {
                            $json['alertClass'] = 'danger';

                            return new JsonResponse($json);
                        }

                        if ($data['ids'][0]) {
                            $article = $this->getArticle(['id' => $data['ids'][0]]);
                        } else {
                            $article = new SupportEntites\Article;
                        }

                        $json['errors'] = [];

                        if ($article) {

                            if (strlen($data['name']) > 200) {
                                $json['errors']['name'] = $this->translator->trans('Name length must not be greater than 200 !!');
                            }

                            if (!$json['errors']) {
                                unset($json['errors']);
                                $article->setName($data['name']);
                                $article->setSlug($data['slug']);
                                $article->setMetaTitle($data['metaTitle']);
                                $article->setKeywords($data['keywords']);
                                $article->setMetaDescription($data['metaDescription']);

                                $updateRevisionHistory = false;

                                if ($article->getContent() == null || trim($article->getContent()) != trim($data['content'])) {

                                    $updateRevisionHistory = true;
                                    $article->setContent($data['content']);
                                }

                                $entityManager->persist($article);
                                $entityManager->flush();

                                $json['alertClass'] = 'success';
                                $json['alertMessage'] = $this->translator->trans('Success! Article updated successfully');

                                if (!$data['ids'][0]) {
                                    $json['redirect'] = $this->generateUrl('helpdesk_member_knowledgebase_update_article', array('id' => $article->getId()));
                                }

                            } else {
                                $json['alertClass'] = 'danger';
                                $json['alertMessage'] = $this->translator->trans('Warning! Correct all field values first!');
                            }
                        } else {
                            $json['alertClass'] = 'danger';
                            $json['alertMessage'] = $this->translator->trans('Warning ! This is not a valid request');
                        }
                        break;
                    case 'articleSave':
                        if ('articleSave' == $data['actionType']  && !empty($resources['articles']['showAlert']) ) {
                            $json['alertClass'] = 'danger';

                            return new JsonResponse($json);
                        }

                        if ($data['ids'][0]) {
                            $article = $this->getArticle(['id' => $data['ids'][0]]);
                        } else {
                            $article = new SupportEntites\Article;
                        }

                        $json['errors'] = [];

                        if ($article) {

                            if (strlen($data['name']) > 200) {
                                $json['errors']['name'] = $this->translator->trans('Name length must not be greater than 200 !!');
                            }

                            $slug = $entityManager->getRepository(SupportEntites\Article::class)->findOneBy(['slug' => $data['slug']]);
                            
                            if (!empty($slug)) {
                                $json['errors']['slug'] = $this->translator->trans('Warning! Article slug is not available.');
                            }

                            if (!$json['errors']) {
                                unset($json['errors']);
                                $article->setName($data['name']);
                                $article->setSlug($data['slug']);
                                $article->setMetaTitle($data['metaTitle']);
                                $article->setKeywords($data['keywords']);
                                $article->setMetaDescription($data['metaDescription']);

                                $updateRevisionHistory = false;

                                if ($article->getContent() == null || trim($article->getContent()) != trim($data['content'])) {

                                    $updateRevisionHistory = true;
                                    $article->setContent($data['content']);
                                }

                                $entityManager->persist($article);
                                $entityManager->flush();

                                $json['alertClass'] = 'success';
                                $json['alertMessage'] = $this->translator->trans('Success! Article updated successfully');

                                if (!$data['ids'][0]) {
                                    $json['redirect'] = $this->generateUrl('helpdesk_member_knowledgebase_update_article', array('id' => $article->getId()));
                                }

                            } else {
                                $json['alertClass'] = 'danger';
                                $json['alertMessage'] = $this->translator->trans('Warning! Correct all field values first!');
                            }
                        } else {
                            $json['alertClass'] = 'danger';
                            $json['alertMessage'] = $this->translator->trans('Warning ! This is not a valid request');
                        }
                        break;
                    case 'status':
                        $entityManager->getRepository(SupportEntites\Article::class)->bulkArticleStatusUpdate($data['ids'], $data['targetId']);
                        $json['alertClass'] = 'success';
                        $json['alertMessage'] = $this->translator->trans('Success ! Article updated successfully.');
                        break;
                    case 'tagUpdate':
                        if ($data['action'] == 'remove') {
                            $entityManager->getRepository(SupportEntites\Article::class)->removeTagByArticle($data['ids'][0], [$data['entityId']]);

                            $json['alertClass'] = 'success';
                            $json['alertMessage'] = $this->translator->trans('Success ! Tag removed successfully.');
                            break;
                        } elseif ($data['action'] == 'add') {
                            $articleTagMapping = new SupportEntites\ArticleTags();
                            $articleTagMapping->setArticleId($data['ids'][0]);
                            $articleTagMapping->setTagId($data['entityId']);

                            $entityManager->persist($articleTagMapping);
                            $entityManager->flush();
                        } elseif ($data['action'] == 'create') {
                            $tag = $entityManager->getRepository(CoreEntites\Tag::class)->findOneBy(['name' => $data['name']]);

                            if (!$tag) {
                                $tag = new CoreEntites\Tag();
                                $tag->setName($data['name']);
                                $entityManager->persist($tag);
                                $entityManager->flush();
                            }

                            $articleTagMapping = new SupportEntites\ArticleTags();
                            $articleTagMapping->setArticleId($data['ids'][0]);
                            $articleTagMapping->setTagId($tag->getId());
                            $entityManager->persist($tag);
                            $entityManager->persist($articleTagMapping);
                            $entityManager->flush();

                            $json['tagId'] = $tag->getId();
                            $json['tagName'] = $tag->getName();
                        }

                        $json['alertClass'] = 'success';
                        $json['alertMessage'] = $this->translator->trans('Success ! Tags Saved successfully.');
                        break;
                    case 'contentUpdate':
                        $article = $this->getArticle(['id' => $data['ids'][0]]);

                        if ($article) {
                            if (trim($article->getContent()) != trim($data['content']))
                                $this->updateContent($article, $data['content']);
                            $json['alertClass'] = 'success';
                            $json['alertMessage'] = $this->translator->trans('Success ! Revision restored successfully.');
                        } else {
                            $json['alertClass'] = 'danger';
                            $json['alertMessage'] = $this->translator->trans('Warning ! This is not a valid request');
                        }

                        break;
                    case 'categoryUpdate':
                        if ($data['action'] == 'remove') {
                            $this->getDoctrine()
                                ->getRepository(SupportEntites\Article::class)
                                ->removeCategoryByArticle($data['ids'][0], [$data['entityId']]);

                        } else if ($data['action'] == 'add') {
                            $articleCategoryMapping = new SupportEntites\ArticleCategory();
                            $articleCategoryMapping->setArticleId($data['ids'][0]);
                            $articleCategoryMapping->setCategoryId($data['entityId']);

                            $entityManager->persist($articleCategoryMapping);
                            $entityManager->flush();
                        }

                        $json['alertClass'] = 'success';
                        $json['alertMessage'] = $this->translator->trans('Success ! Categories updated successfully.');
                        break;
                    case 'relatedUpdate':
                        if ($data['action'] == 'remove') {
                            $entityManager->getRepository(SupportEntites\Article::class)->removeRelatedByArticle($data['ids'][0], [$data['entityId']]);

                            $json['alertClass'] = 'success';
                            $json['alertMessage'] = $this->translator->trans('Success ! Article Related removed successfully.');
                        } else if($data['action'] == 'add') {
                            $relatedArticles = $entityManager->getRepository(SupportEntites\ArticleRelatedArticle::class)->findBy([
                                'articleId' => $data['ids'][0],
                                'relatedArticleId' => $data['entityId'],
                            ]);

                            if (count($relatedArticles)) {
                                $json['alertClass'] = 'success';
                                $json['alertMessage'] = $this->translator->trans('Success ! Article Related is already added.');

                            } elseif ($data['ids'][0] == $data['entityId']) {
                                $json['alertClass'] = 'danger';
                                $json['alertMessage'] = $this->translator->trans('Success ! Cannot add self as relative article.');

                            } else {
                                $articleRelatedMapping = new SupportEntites\ArticleRelatedArticle();
                                $articleRelatedMapping->setArticleId($data['ids'][0]);
                                $articleRelatedMapping->setRelatedArticleId($data['entityId']);
                                $entityManager->persist($articleRelatedMapping);
                                $entityManager->flush();

                                $json['alertClass'] = 'success';
                                $json['alertMessage'] = $this->translator->trans('Success ! Article Related updated successfully.');
                            }
                        }

                        break;

                    case 'delete':
                        if ($data['ids']) {
                            foreach ($data['ids'] as $id) {
                                $article = $entityManager->getRepository(SupportEntites\Article::class)->find($id);
                                if ($article) {
                                    $entityManager->remove($article);
                                    $entityManager->flush();
                                }
                            }
                            $this->removeArticle($article);
                        }

                        $json['alertClass'] = 'success';
                        $json['alertMessage'] = $this->translator->trans('Success ! Articles removed successfully.');
                        break;
                    default:
                        $json['alertClass'] = 'danger';
                        $json['alertMessage'] = $this->translator->trans('Warning ! This is not a valid request');
                }
            }
        } elseif ($request->getMethod() == "PATCH") {
            $entityManager = $this->getDoctrine()->getManager();

            $data = json_decode($request->getContent(), true);

            if (isset($data['editType']))
                switch($data['editType']) {
                    case 'status':
                        $entityManager->getRepository(SupportEntites\Article::class)->bulkArticleStatusUpdate([$data['id']], $data['value']);
                        $json['alertClass'] = 'success';
                        $json['alertMessage'] = $this->translator->trans('Success ! Article status updated successfully.');

                        break;
                    case "stared":
                        $article = $entityManager->getRepository(SupportEntites\Article::class)->findOneBy(['id' => $data['id']]);
                        if ($article) {
                            $article->setStared( (isset($data['value']) && $data['value'] == 1) ? 1 : 0 );
                            $entityManager->persist($article);
                            $entityManager->flush();
                        }
                        $json['alertClass'] = 'success';
                        $json['alertMessage'] = $this->translator->trans('Success ! Article star updated successfully.');
                        break;
                    case "update":
                        $articleBase = $this->getDoctrine()
                            ->getRepository(SupportEntites\SolutionCategory::class)
                            ->find($data['id']);

                        if ($articleBase) {
                            if (isset($data['name']) && strlen($data['name']) > 200) {
                                $json['alertClass'] = 'danger';
                                $json['alertMessage'] = $this->translator->trans('Name length must not be greater than 200 !!');

                            } else {
                                $articleBase->setName($this->uvdeskService->htmlfilter($data['name']));

                                if(trim($articleBase->getContent()) != trim($data['content']))
                                    $this->updateContent($request, $articleBase, $data['content']);

                                $json['alertClass'] = 'success';
                                $json['alertMessage'] = $this->translator->trans('Success! Article updated successfully');
                            }
                        }

                    case 'status':
                        $entityManager->getRepository(SupportEntites\Article::class)->bulkArticleStatusUpdate([$data['id']], $data['value']);
                        $json['alertClass'] = 'success';
                        $json['alertMessage'] =  $this->translator->trans('Success ! Article status updated successfully.');
                        break;

                    default:
                        $json['alertClass'] = 'danger';
                        $json['alertMessage'] =  $this->translator->trans('Warning ! This is not a valid request');
                }
        }
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    private function updateContent($articleBase, $content, $updateArticle = true)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $articleHistory = new SupportEntites\ArticleHistory;
        $articleHistory->setUserId($this->getUser()->getId());
        $articleHistory->setArticleId($articleBase->getId());
        $articleHistory->setContent($articleBase->getContent());

        if ($updateArticle) {
            $articleBase->setContent($content);
            $entityManager->persist($articleBase);
        }

        $entityManager->persist($articleHistory);
        $entityManager->flush();
    }

    private function removeArticle($article)
    {
        $this->getDoctrine()
            ->getRepository(SupportEntites\Article::class)
            ->removeEntryByArticle($article->getId());
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
