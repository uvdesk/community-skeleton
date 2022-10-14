<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Controller;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\SwiftMailer\SwiftMailer;
use Symfony\Component\HttpKernel\KernelInterface;

class EmailSettingsXHR extends AbstractController
{
    private $userService;
    private $translator;
    private $swiftMailer;
    private $kernel;

    public function __construct(UserService $userService, TranslatorInterface $translator,SwiftMailer $swiftMailer, KernelInterface $kernel)
    {
        $this->userService = $userService;
        $this->translator = $translator;
        $this->swiftMailer = $swiftMailer;
        $this->kernel = $kernel;
    }

    public function updateSettingsXHR(Request $request)
    {
        $filePath = $this->kernel->getProjectDir() . '/config/packages/uvdesk.yaml';

        $memberPrefix = $this->getParameter('uvdesk_site_path.member_prefix') ?? 'member';
        $customerPrefix = $this->getParameter('uvdesk_site_path.knowledgebase_customer_prefix') ?? 'customer';

        $app_locales = 'en|fr|it'; //default app_locales values

        foreach ( file($filePath) as $val) {
            $exploded = explode(":", trim($val));
            if($exploded[0] == 'app_locales' && ($app_locales != $exploded[1]))
            {
                $app_locales = trim($exploded[1]);
            }
        }

        $supportEmailConfiguration = json_decode($request->getContent(), true);
        $mailer_id = ( $supportEmailConfiguration['mailer_id'] == 'None Selected' ? '~' : $supportEmailConfiguration['mailer_id'] );

        $file_content_array = strtr(require __DIR__ . "/../Templates/uvdesk.php", [
            '{{ SUPPORT_EMAIL_ID }}' => $supportEmailConfiguration['id'],
            '{{ SUPPORT_EMAIL_NAME }}' => $supportEmailConfiguration['name'],
            '{{ SUPPORT_EMAIL_MAILER_ID }}' => $mailer_id,
            '{{ SITE_URL }}' => $request->getHttpHost() . $request->getBasePath(),
            '{{ APP_LOCALES }}' => $app_locales,
            '{{ MEMBER_PANEL_PREFIX }}' => $memberPrefix,
            '{{ CUSTOMER_PANEL_PREFIX }}' => $customerPrefix,
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
            'alertMessage' => $this->translator->trans('Success ! Email settings are updated successfully.'),
        ];

        return new Response(json_encode($result), 200, ['Content-Type' => 'application/json']);
    }
}
