<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ThreadXHR extends Controller
{
    public function listTicketThreadCollectionXHR($ticketId)
    {
       
        $entityManager = $this->getDoctrine()->getManager();
        $request = $this->container->get('request_stack')->getCurrentRequest();

        if (true === $request->isXmlHttpRequest()) {
            $ticket = $entityManager->getRepository('UVDeskCoreFrameworkBundle:Ticket')->findOneById($ticketId);

            if (!empty($ticket)) {
                $paginationResponse = $this->get('ticket.service')->paginateMembersTicketThreadCollection($ticket, $request);
    
                return new Response(json_encode($paginationResponse), 200, ['Content-Type' => 'application/json']);
            }
        }
        
        return new Response(json_encode([]), 404, ['Content-Type' => 'application/json']);
    }
    
}
