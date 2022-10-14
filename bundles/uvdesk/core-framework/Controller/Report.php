<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Webkul\UVDesk\CoreFrameworkBundle\Entity;
use Webkul\UVDesk\CoreFrameworkBundle\Form;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportGroup;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\SupportTeam;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\UserInstance;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UVDeskService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\ReportService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\Query;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketRating;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;

class Report extends AbstractController
{
    private $userService;
    private $reportService;
    private $uvdeskService;
    private $paginator;
    private $translator;

    public function __construct(UserService $userService, UVDeskService $uvdeskService,ReportService $reportService, PaginatorInterface $paginator, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->reportService = $reportService;
        $this->uvdeskService = $uvdeskService;
        $this->paginator = $paginator;
        $this->translator = $translator;
    }

    public function listAgentActivity(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_AGENT_ACTIVITY')){
            return $this->redirect($this->generateUrl('helpdesk_member_dashboard'));
        }

        return $this->render('@UVDeskCoreFramework/Reports/listAgentActivities.html.twig', [
            'agents' => $this->userService->getAgentsPartialDetails(),
        ]);
    }

    public function agentActivityXHR(Request $request)
    {
        $json = [];

        if ($request->isXmlHttpRequest()) {
            $json = $this->agentActivityData($request);
        }

        return new Response(json_encode($json), 200, ['Content-Type' => 'application/json']);
    }

    public function agentActivityData(Request $request)
    {
        if (!$this->userService->isAccessAuthorized('ROLE_AGENT_MANAGE_AGENT_ACTIVITY')){
            throw new \Exception('Access Denied', 403);
        }
        
        $data = [];
        $reportService = $this->reportService;
        $reportService->parameters = $request->query->all();
        $startDate = $reportService->parameters['after'];
        $endDate = $reportService->parameters['before'];

        $agentIds = [];
        if(isset($reportService->parameters['agent']))
            $agentIds = explode(',', $reportService->parameters['agent']);

        $userService = $this->userService;
        $from = $startDate." 00:00:01";
        $to = $endDate." 23:59:59";
        $reportService->parameters = $request->query->all();
        $qb = $reportService->getAgentActivity($agentIds, $from, $to);
        $paginator  = $this->paginator;

        $newQb = clone $qb;
        $results = $paginator->paginate(
            $qb->getQuery()->setHydrationMode(Query::HYDRATE_ARRAY)->setHint('knp_paginator.count', count($newQb->getQuery()->getResult())),
            $request->query->get('page') ?: 1,
            20,
            array('distinct' => true)
        );

        $paginationData = $results->getPaginationData();
        $queryParameters = $results->getParams();
        $queryParameters['page'] = "replacePage";
        $paginationData['url'] = '#'.$this->uvdeskService->buildPaginationQuery($queryParameters);

        $data = array();
        $ticketIds = [];
        $agentActivity = [];
        $agentIds = [];
        foreach ($results as $key => $activity) {
            $ticket = $this->getDoctrine()->getManager()->getRepository(Ticket::class)->findOneById($activity['id']);
            $currentDateTime  = new \DateTime('now');
            $activityDateTime = $activity['createdAt'];
            $difference = $currentDateTime->getTimeStamp() - $activityDateTime->getTimeStamp();
            $lastReply = $reportService->time2string($difference);

            $ticketViewURL = $this->get('router')->generate('helpdesk_member_ticket', ['ticketId' => $activity['ticketId']], UrlGeneratorInterface::ABSOLUTE_URL);

            $data[] =   [
                'id' => $activity['id'],
                'ticketURL' => $ticketViewURL,
                'ticketId' => $activity['ticketId'],
                'subject' => $activity['subject'],
                'color'   => $activity['colorCode'],
                'customerName'=> $activity['customerName'],
                'threadType' => $activity['threadType'],
                'lastReply'  => $lastReply,
                'agentName'  => $activity['agentName']
            ];

            array_push($ticketIds, $activity['ticketId']);
            array_push($agentIds, $activity['agentId']);
        }

        $threadDetails = $reportService->getTotalReplies(array_unique($ticketIds), $agentIds, $from, $to);

        foreach ($data as $index => $ticketDetail) {
            foreach ($threadDetails as $detail) {
                if ($detail['ticketId'] == $ticketDetail['ticketId']) {
                    $data[$index]['totalReply'] = $detail['ticketCount'];
                }
            }
        }

        $agentActivity = [];
        $agentActivity['data'] = $data;
        $agentActivity['pagination_data'] = $paginationData;

        return $agentActivity;
    }

    public function achievementInsightsAction()
    {
        $this->userService->forceFormat = true;
        $startDate = $this->userService->convertToTimezone(new \DateTime("-7 days"), 'Y-m-d');
        $endDate = $this->userService->convertToTimezone(new \DateTime("now"), 'Y-m-d');
        $this->userService->forceFormat = false;

        return $this->render('@UVDeskCoreFramework/Reports/kudos-insights.html.twig',array(
                'startDate' => $startDate,
                'endDate' => $endDate
            )
        );
    }

    public function getAchievementsXhr(Request $request, ContainerInterface $container)
    {
        $json = array();

        if( $request->isXmlHttpRequest()) {
            $repository = $this->getDoctrine()->getRepository(TicketRating::class);
            $json =  $repository->getRatedTicketList($request->query, $container);

            $json['data'] = $this->getAchievementsData($request, $container);
        }
        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getAchievementsData($request, $container)
    {
        $data = array();
        $reportService = $this->reportService;
        $reportService->parameters = $request->query->all();
        $startDate = $reportService->parameters['start'];
        $endDate = $reportService->parameters['end'];

        $reportService->startDate = $this->userService->convertToTimezone(new \DateTime($startDate),'Y-m-d H:i:s');
        $reportService->endDate = $this->userService->convertToTimezone(new \DateTime($endDate),'Y-m-d H:i:s');

        $repository = $this->getDoctrine()->getRepository(TicketRating::class);
        $data =  $repository->getRatingData($request->query, $container);
        for ($i = 1; $i <= 5; $i++) {
            $data['ratings'][$i] = $repository->getRatingByStarCount($request->query, $i, $container);
        }

        return $data;
    }
}
