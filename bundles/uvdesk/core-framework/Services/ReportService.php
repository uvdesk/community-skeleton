<?php
namespace Webkul\UVDesk\CoreFrameworkBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\AgentActivity;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\User;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Thread;

class ReportService {

    const LIMIT = 15;
    const TICKET_GLOBAL_ACCESS = 1;
    const TICKET_GROUP_ACCESS = 2;
    const TICKET_TEAM_ACCESS  = 3;
    const DEFAULT_PAGINATION_LIMIT = 15;

	private $request;
	protected $container;
    protected $em;

    protected $currentUser = null;

    public $endDate = null;
    public $startDate = null;
    public $parameters = array();
    public $safeFields = array('page','limit','sort','order','direction');

	public function __construct(EntityManagerInterface $em, RequestStack $request, ContainerInterface $container)
    {
        $this->em = $em;
        $this->request = $request;
        $this->container = $container;
    }

    public function getAgentActivity(array $agents, $from = null, $to = null)
    {
        $agentClause = array_map(function($id) { return "AgentActivity.agent = $id"; }, $agents);
        $activityQuery = $this->em->createQueryBuilder()
                        ->select('
                            AgentActivity.customerName,
                            AgentActivity.agentName,
                            agent.id as agentId,
                            AgentActivity.threadType as threadType,
                            AgentActivity.createdAt,
                            t.subject,
                            t.id as ticketId,
                            AgentActivity.id,
                            priority.colorCode as colorCode
                        ')
                        ->from(AgentActivity::class, 'AgentActivity')
                        ->leftJoin('AgentActivity.ticket', 't')
                        ->leftJoin('t.supportGroup', 'gr')
                        ->leftJoin('t.supportTeam', 'tSub')
                        ->leftJoin('AgentActivity.agent', 'agent')
                        ->leftJoin('t.priority', 'priority')
                        ->andWhere('AgentActivity.createdAt BETWEEN :startDate AND :endDate');
                        if(!empty($agentClause))
                            $activityQuery->andWhere(implode(' OR ', $agentClause));

                    $this->addPermissionFilter($activityQuery, $this->container);

                     $activityQuery->andWhere('AgentActivity.threadType =:threadType')
                        ->setParameter('threadType', 'reply')
                        ->setParameter('startDate', $from)
                        ->setParameter('endDate', $to)
                        ->orderBy('AgentActivity.createdAt', 'DESC');

        return $activityQuery;
    }

    public function addPermissionFilter($qb, $container, $haveJoin = true)
    {
        $activeUser = $this->container->get('user.service')->getSessionUser();
        $supportGroupReferences = $this->em->getRepository(User::class)->getUserSupportGroupReferences($activeUser);
        $supportTeamReferences  = $this->em->getRepository(User::class)->getUserSupportTeamReferences($activeUser);
        $userInstance = $activeUser->getAgentInstance();

        if (!empty($userInstance) && ('ROLE_AGENT' == $userInstance->getSupportRole()->getCode() && $userInstance->getTicketAccesslevel() != self::TICKET_GLOBAL_ACCESS)) {
            $qualifiedGroups = empty($this->params['group']) ? $supportGroupReferences : array_intersect($supportGroupReferences, explode(',', $this->params['group']));
            $qualifiedTeams = empty($this->params['team']) ? $supportTeamReferences : array_intersect($supportTeamReferences, explode(',', $this->params['team']));

            switch ($userInstance->getTicketAccesslevel()) {
                case self::TICKET_GROUP_ACCESS:
                    $qb
                        ->andWhere("t.agent = :agentId OR gr.id IN(:supportGroupIds) OR tSub.id IN(:supportTeamIds)")
                        ->setParameter('agentId', $activeUser->getId())
                        ->setParameter('supportGroupIds', $qualifiedGroups)
                        ->setParameter('supportTeamIds', $qualifiedTeams);
                    break;
                case self::TICKET_TEAM_ACCESS:
                    $qb
                        ->andWhere("t.agent = :agentId OR tSub.id IN(:supportTeamIds)")
                        ->setParameter('agentId', $activeUser->getId())
                        ->setParameter('supportTeamIds', $qualifiedTeams);
                    break;
                default:
                    $qb
                        ->andWhere("t.agent = :agentId")
                        ->setParameter('agentId', $activeUser->getId());
                    break;
            }
        }

        return $qb;
    }

    public function getTotalReplies($ticketIds, array $agents, $from, $to)
    {
            $agentClause = array_map(function($id) { return "thread.user = $id"; }, $agents);
            $qb = $this->em->createQueryBuilder()
                    ->select("Count(thread.id) as ticketCount, IDENTITY (thread.ticket) AS ticketId")
                    ->from(Thread::class, 'thread')
                    ->andwhere('thread.ticket IN (:ticket)')
                    ->andWhere('thread.threadType =:threadType')
                    ->andWhere('thread.createdAt BETWEEN :startDate AND :endDate');
                    if(!empty($agentClause))
                            $qb->andWhere(implode(' OR ', $agentClause));

                $qb->setParameter('threadType', 'reply')
                    ->setParameter('ticket', $ticketIds)
                    ->setParameter('startDate', $from)
                    ->setParameter('endDate', $to)
                    ->groupBy('thread.ticket');

        $threadDetails = $qb->getQuery()->getScalarResult();
        return $threadDetails;
    }

    // Convert Timestamp to day/hour/min
    function time2string($time) {
        $d = floor($time/86400);
        $_d = ($d < 10 ? '0' : '').$d;

        $h = floor(($time-$d*86400)/3600);
        $_h = ($h < 10 ? '0' : '').$h;

        $m = floor(($time-($d*86400+$h*3600))/60);
        $_m = ($m < 10 ? '0' : '').$m;

        $s = $time-($d*86400+$h*3600+$m*60);
        $_s = ($s < 10 ? '0' : '').$s;

        $time_str = "0 minutes";
        if($_d != 00)
            $time_str = $_d." ".'days';
        elseif($_h != 00)
            $time_str = $_h." ".'hours';
        elseif($_m != 00)
            $time_str = $_m." ".'minutes';


        return $time_str." "."ago";
    }

    /**
     * symfony_http_build_query Return query strinf
     * @param  Array $query Query parameters
     * @return String Query String
     */
    public function symfony_http_build_query(array $query) {
        $query['page'] = "replacePage";
        $params = array();
        if(isset($query['_locale']))
            unset($query['_locale']);
        if(isset($query['domain']))
            unset($query['domain']);
        foreach ($query as $key => $value) {
            if (!isset($value)) {
                $params[] = $key;
            } else {
                $params[] = $key . '/' . str_replace('%2F', '/', rawurlencode($value));
            }
        }
        $str = implode('/', $params);
        if(isset($query['new']))
            $str = str_replace("new/1","new",$str);
        elseif(isset($query['unassigned']))
            $str = str_replace("unassigned/1","unassigned",$str);
        elseif(isset($query['notreplied']))
            $str = str_replace("notreplied/1","notreplied",$str);
        elseif(isset($query['mine']))
            $str = str_replace("mine/1","mine",$str);
        elseif(isset($query['starred']))
            $str = str_replace("starred/1","starred",$str);
        elseif(isset($query['trashed']))
            $str = str_replace("trashed/1","trashed",$str);
        return $str;
    }
}
