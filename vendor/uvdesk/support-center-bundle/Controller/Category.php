<?php

namespace Webkul\UVDesk\SupportCenterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\Criteria;

use Webkul\UVDesk\SupportCenterBundle\Entity\SolutionCategory;
use Webkul\UVDesk\SupportCenterBundle\Entity\SolutionCategoryMapping;
use Webkul\UVDesk\SupportCenterBundle\Form\Category as CategoryForm;

class Category extends Controller
{
    const LIMIT = 10;

    public function categoryList(Request $request)    
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }
        
        $solutions = $this->getDoctrine()
                           ->getRepository('UVDeskSupportCenterBundle:Solutions')
                           ->getAllSolutions(null, $this->container, 'a.id, a.name');

        $solutions = array_map(function($solution){
            return [
                'id'=>$solution['id'],
                'name'=>$solution['name'],
                'categoriesCount'=>$this->getDoctrine()
                                        ->getRepository('UVDeskSupportCenterBundle:Solutions')
                                        ->getCategoriesCountBySolution($solution['id'])
                ];
        },$solutions);
        return $this->render('@UVDeskSupportCenter/Staff/Category/categoryList.html.twig', [
            'solutions' => $solutions
        ]);
    }

    public function categoryListBySolution(Request $request)    
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $solution = $this->getDoctrine()
                            ->getRepository('UVDeskSupportCenterBundle:Solutions')
                            ->findSolutionById(['id' => $request->attributes->get('solution')]);
        if($solution){
            $solution_category = [
                'solution' => $solution,
                'solutionArticleCount' => $this->getDoctrine()
                            ->getRepository('UVDeskSupportCenterBundle:Solutions')
                            ->getArticlesCountBySolution($request->attributes->get('solution')),
                'solutionCategoryCount' => $this->getDoctrine()
                            ->getRepository('UVDeskSupportCenterBundle:Solutions')
                            ->getCategoriesCountBySolution($request->attributes->get('solution')),
            ];
            return $this->render('@UVDeskSupportCenter/Staff/Category/categoryListBySolution.html.twig',$solution_category);
        }else
            $this->noResultFound();
    }

    public function categoryListXhr(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {          
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $json = array();
        $repository = $this->getDoctrine()->getRepository('UVDeskSupportCenterBundle:SolutionCategory');

        if($request->attributes->get('solution'))
            $request->query->set('solutionId', $request->attributes->get('solution'));
        else
            $request->query->set('limit', self::LIMIT);        
        $json =  $repository->getAllCategories($request->query, $this->container);
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function category(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        if ($request->attributes->get('id')) { 
            $category = $this->getDoctrine()->getRepository('UVDeskSupportCenterBundle:SolutionCategory')->findOneById($request->attributes->get('id'));
            
            if (!$category) {
                $this->noResultFound();
            }
        } else {
            $category = new SolutionCategory;
        }

        $categorySolutions = [];
        if($category->getId())
            $categorySolutions = $this->getDoctrine()
                            ->getRepository('UVDeskSupportCenterBundle:SolutionCategory')
                            ->getSolutionsByCategory($category->getId());

        $errors = [];
        if($request->getMethod() == "POST") {
                $data = $request->request->all();
                $em = $this->getDoctrine()->getManager();
                $category->setName($data['name']);
                $category->setDescription($data['description']);
                $category->setSortOrder($data['sortOrder']);
                $category->setDateAdded(new \DateTime());
                $category->setDateUpdated(new \DateTime());
                $category->setSorting($data['sorting']);
                $category->setStatus($data['status']);
                $em->persist($category);
                $em->flush();

                $tempSolutions = explode(',', $request->request->get('tempSolutions'));                
                $em = $this->getDoctrine()->getManager();

                $oldSolutions = [];
                if($categorySolutions)
                {
                    foreach ($categorySolutions as $solution) {
                        if($key = array_search($solution['id'], $tempSolutions))
                            unset($tempSolutions[$key]);
                        else
                            $oldSolutions[] = $solution['id'];
                    }
                
                    if($oldSolutions){
                        $this->getDoctrine()
                            ->getRepository('UVDeskSupportCenterBundle:SolutionCategory')
                            ->removeSolutionsByCategory($category->getId(), $oldSolutions);
                    }
                }
                
                if($tempSolutions){
                    foreach($tempSolutions as $solution){
                        if($solution) {
                            $solutionCategoryMapping = new SolutionCategoryMapping();
                            $solutionCategoryMapping->setSolutionId($solution);
                            $solutionCategoryMapping->setCategoryId($category->getId());
                            $em->persist($solutionCategoryMapping);
                        }
                    }
                }

                $em->flush();
                $message = 'Success! Category has been added successfully.';

                $this->addFlash('success', $message);

                return $this->redirect($this->generateUrl('helpdesk_member_knowledgebase_category_collection'));
        }

        $solutions = $this->getDoctrine()
                           ->getRepository('UVDeskSupportCenterBundle:Solutions')
                           ->getAllSolutions(null, $this->container, 'a.id, a.name');

        return $this->render('@UVDeskSupportCenter/Staff/Category/categoryForm.html.twig', [
                                'category' => $category,
                                'categorySolutions' => $categorySolutions,
                                'solutions' => $solutions,
                                'errors' => json_encode($errors)
                            ]);
    }

    public function categoryXhr(Request $request)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $json = array();
      
        if($request->getMethod() == "POST") {
            $em = $this->getDoctrine()->getManager();

            $data = $request->request->get("data");
            $dataIds = array_map('intval', $data['ids']);

            switch($data['actionType']){
                case 'sortUpdate':
                    foreach($dataIds as $sort => $id){
                        $em->getRepository('UVDeskSupportCenterBundle:SolutionCategory')->categorySortingUpdate($id, $sort);
                    }
                    $json['alertClass'] = 'success';
                    $json['alertMessage'] = $this->get('translator')->trans('Success ! Category sort  order updated successfully.');
                    break;
                case 'status':
                    $em->getRepository('UVDeskSupportCenterBundle:SolutionCategory')->bulkCategoryStatusUpdate($dataIds, $data['targetId']);
                    $json['alertClass'] = 'success';
                    $json['alertMessage'] = $this->get('translator')->trans('Success ! Category status updated successfully.');
                    break;
                case 'solutionUpdate':
                    if($data['action'] == 'remove'){
                        $this->getDoctrine()
                            ->getRepository('UVDeskSupportCenterBundle:SolutionCategory')
                            ->removeSolutionsByCategory($data['ids'][0], [$data['solutionId']]);

                    }elseif($data['action'] == 'add'){
                        $company = $this->container->get('user.service')->getCurrentCompany();
                        
                        $solutionCategoryMapping = new SolutionCategoryMapping();
                        $solutionCategoryMapping->setSolutionId($data['solutionId']);
                        $solutionCategoryMapping->setCategoryId($data['ids'][0]);
                        $solutionCategoryMapping->setCompanyId($company->getId());
                        $em->persist($solutionCategoryMapping);
                        $em->flush();
                    }
                    $json['alertClass'] = 'success';
                    $json['alertMessage'] = $this->get('translator')->trans('Success ! Folders updated successfully.');
                    break;
                case 'delete':
                    if($dataIds){
                        foreach($dataIds as $id){
                            $category = $em->getRepository('UVDeskSupportCenterBundle:SolutionCategory')->find($id);
                            if($category){
                                // $this->get('event.manager')->trigger([
                                //         'event' => 'category.deleted',
                                //         'entity' => $category
                                //     ]);
                                $em->remove($category);
                                $em->flush();
                            }                           
                        }

                        $this->removeCategory($dataIds);

                        $json['alertClass'] = 'success';
                        $json['alertMessage'] = $this->get('translator')->trans('Success ! Categories removed successfully.');
                     
                    }
                    break;
            }
        }elseif($request->getMethod() == "PUT") {
            $em = $this->getDoctrine()->getManager();
            $content = json_decode($request->getContent(), true);
            $id = $content['id'];
            $category = $em->getRepository('UVDeskSupportCenterBundle:SolutionCategory')->find($id);
            if($category) {
                    $form = $this->createFormBuilder($category, [ 
                            'data_class' => 'Webkul\UVDeskSupportCenterBundle\Entity\SolutionCategory',
                            'csrf_protection' => false,
                            'allow_extra_fields' => true
                        ])
                        ->add('name', 'text')
                        ->add('description', 'textarea')
                        ->getForm();
                    
                $form->submit($content);
                $form->handleRequest($request);
                if ($form->isValid()) {
                    $em->persist($category);
                    $em->flush();
                    
                    $json['alertClass'] = 'success';
                    $json['alertMessage'] =$this->get('translator')->trans('Success ! Category updated successfully.');
                } else {
                    $json['alertClass'] = 'danger';
                    $json['errors'] = json_encode($this->getFormErrors($form));
                }
            } else {
                $json['alertClass'] = 'danger';
                $json['alertMessage'] = $this->translate('Error ! Category does not exist.');
            }
        } elseif($request->getMethod() == "PATCH") { //UPDATE STATUS
            $em = $this->getDoctrine()->getManager();
            $content = json_decode($request->getContent(), true);
            $id = $content['id'];
            $category = $em->getRepository('UVDeskSupportCenterBundle:SolutionCategory')->find($id);
            if($category) {
                switch($content['editType']){
                    case 'status':
                        $category->setStatus($content['value']);
                        $em->persist($category);
                        $em->flush();
                        
                        $json['alertClass'] = 'success';
                        $json['alertMessage'] =$this->get('translator')->trans('Success ! Category status updated successfully.');
                        break;
                    default:
                        break;
                }
            } else {
                $json['alertClass'] = 'danger';
                $json['alertMessage'] = $this->get('translator')->trans('Error ! Category is not exist.');
            }
        }

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    private function removeCategory($category)
    {
        if (!$this->get('user.service')->isAccessAuthorized('ROLE_AGENT_MANAGE_KNOWLEDGEBASE')) {
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        $this->getDoctrine()
            ->getRepository('UVDeskSupportCenterBundle:SolutionCategory')
            ->removeEntryByCategory($category);
    }
}
