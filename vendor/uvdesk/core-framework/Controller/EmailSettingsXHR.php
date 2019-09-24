<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmailSettingsXHR extends Controller
{
    public function updateSettingsXHR(Request $request)
    {
        $filePath = $this->get('kernel')->getProjectDir() . '/config/packages/uvdesk.yaml';
        $supportEmailConfiguration = json_decode($request->getContent(), true);
        
        $mailer_id = ( $supportEmailConfiguration['mailer_id'] == 'None Selected' ? '~' : $supportEmailConfiguration['mailer_id'] );

        $file_content_array = strtr(require __DIR__ . "/../Templates/uvdesk.php", [
            '{{ SUPPORT_EMAIL_ID }}' => $supportEmailConfiguration['id'],
            '{{ SUPPORT_EMAIL_NAME }}' => $supportEmailConfiguration['name'],
            '{{ SUPPORT_EMAIL_MAILER_ID }}' => $mailer_id,
            '{{ SITE_URL }}' => $this->container->getParameter('uvdesk.site_url'),
        ]);
        
        // update uvdesk.yaml file
        file_put_contents($filePath, $file_content_array);

        $result = [
            'alertClass' => "success",
            'email_settings' => [
                'id' => $supportEmailConfiguration['id'],
                'name' => $supportEmailConfiguration['name'],
                'mailer_id' => $supportEmailConfiguration['mailer_id'],
            ],
            'alertMessage' => $this->get('translator')->trans("Success ! Email settings are updated successfully."),
        ];

        return new Response(json_encode($result), 200, ['Content-Type' => 'application/json']);
    }
}
