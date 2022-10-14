<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\TokenGenerator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\SupportCenterBundle\Entity\KnowledgebaseWebsite;

class UVDeskService
{
	protected $container;
	protected $requestStack;
    protected $entityManager;
    private $avoidArray = [
        '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '-', '=', '/', '\\', ':', '{', '}', '[', ']', '<', '>', '.', '?', ';', '"', '\'', ',', '|',
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
        ' true ', ' false ',
        ' do ', ' did ',
        ' is ', ' are ', ' am ', ' was ', ' were ',
        ' has ', ' have ', ' had ',
        ' will ', ' would ', ' shall ', ' should ', ' must ', ' can ', ' could ',
        ' not ', ' never ',
        ' neither ', ' either ',
        ' the ', ' a ', ' an ', ' this ', ' that ',
        ' here ', ' there ',
        ' then ', ' when ', ' since ',
        ' he ', ' him ', ' himself ', ' she ', ' her ', ' herself ', ' i ', ' me ', ' myself ', ' mine ', ' you ', ' your ' ,' yourself ', ' ur ', ' we ', ' ourself ', ' it ', ' its ',
        ' for ', ' from ', ' on ', ' and ', ' in ', ' be ', ' to ', ' or ', ' of ', ' with ',
        ' what ', ' why ', ' where ', ' who ', ' whom ', ' which ',
        ' a ', ' b ', ' c ', ' d ', ' e ' , ' f ' , ' g ' , ' h ' , ' i ' , ' j ' , ' k ' , ' l ' , ' m ' , ' n ' , ' o ' , ' p ' , ' q ' , ' r ' , ' s ' , ' t ' , ' u ' , ' v ' , ' w ' , ' x ' , ' y ' , ' z ' ,
        '  ',
    ];

	public function __construct(ContainerInterface $container, RequestStack $requestStack, EntityManagerInterface $entityManager)
	{
		$this->container = $container;
		$this->requestStack = $requestStack;
		$this->entityManager = $entityManager;
	}

    public function updatesLocales($locales)
    {  
        $fileTranslation = $this->container->get('kernel')->getProjectDir() . '/config/packages/translation.yaml';
        $fileServices = $this->container->get('kernel')->getProjectDir() . '/config/services.yaml';

        // get file content and index
        $fileTrans = file($fileTranslation);
        $fileServs = file($fileServices);

        foreach ($fileTrans as $index => $content) {
            if (false !== strpos($content, 'default_locale')) {
                list($helpdesk_panel_locales, $helpdesk_panel_text) = array($index, $content);
            }

            if (false !== strpos($content, '- ')) {
                list($helpdesk_panel_locales_fallback, $helpdesk_panel_text_fallback) = array($index, $content);
            }
        }

        foreach ($fileServs as $indexs => $contents) {
            if (false !== strpos($contents, 'locale')) {
                list($helpdesk_services_locales, $helpdesk_services_text) = array($indexs, $contents);
            }
        }


        // save updated data in a variable ($updatedFileContent)
        $updatedFileContent = $fileTrans;
        $updatedServicesFileContent = $fileServs;

        $updatedlocales = (null !== $helpdesk_panel_locales) ? substr($helpdesk_panel_text, 0, strpos($helpdesk_panel_text, 'default_locale') + strlen('default_locale: ')) . $locales . PHP_EOL: '';
        $updatedlocales_fallback = (null !== $helpdesk_panel_locales_fallback) ? substr($helpdesk_panel_text_fallback, 0, strpos($helpdesk_panel_text_fallback, '- ') + strlen('- ')) . $locales . PHP_EOL: '';
        $updatedServiceslocales = (null !== $helpdesk_services_locales) ? substr($helpdesk_services_text, 0, strpos($helpdesk_services_text, 'locale') + strlen('locale: ')) . $locales . PHP_EOL: '';

        $updatedFileContent[$helpdesk_panel_locales] = $updatedlocales;
        $updatedFileContent[$helpdesk_panel_locales_fallback] = $updatedlocales_fallback;

        $updatedServicesFileContent[$helpdesk_services_locales] = $updatedServiceslocales;

        // flush updated content in file
        $status = file_put_contents($fileTranslation, $updatedFileContent);
        $status1 = file_put_contents($fileServices, $updatedServicesFileContent);

        return true;
    }

    public function getLocalesList() 
    {
        $translator = $this->container->get('translator');
        return  [
            'en' => $translator->trans("English"),
            'fr' => $translator->trans("French"),
            'it' => $translator->trans("Italian"),
            'ar' => $translator->trans("Arabic"),
            'de' => $translator->trans("German"),
            'es' => $translator->trans("Spanish"),
            'tr' => $translator->trans("Turkish"),
            'da' => $translator->trans("Danish"),
            'zh' => $translator->trans("Chinese"),
            'pl' => $translator->trans("Polish"),
        ];
    }

    public function getActiveLocales() 
    {
        $localesList = $this->getLocalesList();
        $activeLocales = $this->container->getParameter("app_locales");
        $explodeActiveLocales = explode("|",$activeLocales);

        return $explodeActiveLocales;
    }

    public function getLocales()
    {
        $localesList = $this->getLocalesList();
        $explodeActiveLocales = $this->getActiveLocales();

        $listingActiveLocales = array();

        foreach ($explodeActiveLocales as $key => $value) {
            $listingActiveLocales[$value] = $localesList[$value];
        }

        return $listingActiveLocales;
    }

    public function getDefaultLangauge() 
    {
        return $this->container->getParameter("kernel.default_locale");  
    }
    
    public function getTimezones()
    {
        return \DateTimeZone::listIdentifiers();
    }

    public function getPrivileges() {
        $agentPrivilegeCollection = [];
        // $agentPrivilegeCollection = $this->entityManager->getRepository('UserBundle:AgentPrivilege')->findAll();

        return $agentPrivilegeCollection;
    }

	public function getLocaleUrl($locale)
	{
		$request = $this->requestStack->getCurrentRequest();

		return str_replace('/' . $request->getLocale() . '/', '/' . $locale . '/', $request->getRequestUri());
    }
    
    public function buildPaginationQuery(array $query = [])
    {
        $params = array();
        $query['page'] = "replacePage";

        if (isset($query['domain'])) unset($query['domain']);
        if (isset($query['_locale'])) unset($query['_locale']);
        
        foreach ($query as $key => $value) {
            $params[] = !isset($value) ? $key : $key . '/' . str_replace('%2F', '/', rawurlencode($value));
        }

        $http_query = implode('/', $params);
        
        if (isset($query['new'])) {
            $http_query = str_replace('new/1', 'new', $http_query);
        } else if (isset($query['unassigned'])) {
            $http_query = str_replace('unassigned/1', 'unassigned', $http_query);
        } else if (isset($query['notreplied'])) {
            $http_query = str_replace('notreplied/1', 'notreplied', $http_query);
        } else if (isset($query['mine'])) {
            $http_query = str_replace('mine/1', 'mine', $http_query);
        } else if (isset($query['starred'])) {
            $http_query = str_replace('starred/1', 'starred', $http_query);
        } else if (isset($query['trashed'])) {
            $http_query = str_replace('trashed/1', 'trashed', $http_query);
        }
        
        return $http_query;
    }

    public function getEntityManagerResult($entity, $callFunction, $args = false, $extraPrams = false)
    {
        if($extraPrams)
            return $this->entityManager->getRepository($entity)
                        ->$callFunction($args, $extraPrams);
        else
            return $this->entityManager->getRepository($entity)
                        ->$callFunction($args);
    }

    public function getValidBroadcastMessage($msg, $format = 'Y-m-d H:i:s')
    {
        $broadcastMessage = !empty($msg) ? json_decode($msg, true) : false;

        if(!empty($broadcastMessage) && isset($broadcastMessage['isActive']) && $broadcastMessage['isActive']) {
            $timezone = new \DateTimeZone('Asia/Kolkata');
            $nowTimestamp = date('U');
            if(array_key_exists('from', $broadcastMessage) && ($fromDateTime = \DateTime::createFromFormat($format, $broadcastMessage['from'], $timezone))) {
                $fromTimeStamp = $fromDateTime->format('U');
                if($nowTimestamp < $fromTimeStamp) {
                    return false;
                }
            }
            if(array_key_exists('to', $broadcastMessage) && ($toDateTime = \DateTime::createFromFormat($format, $broadcastMessage['to'], $timezone))) {
                $toTimeStamp = $toDateTime->format('U');;
                if($nowTimestamp > $toTimeStamp) {
                    return false;
                }
            }
        } else {
            return false;
        }

        // return valid broadcast message Array
        return $broadcastMessage;
    }

    public function getConfigParameter($param)
	{
		if($param && $this->container->hasParameter($param)) {
			return $this->container->getParameter($param);
		} else {
			return false;
		}
    }
    
    public function isDarkSkin($brandColor) {
        $brandColor = str_replace('#', '', $brandColor);
        if(strlen($brandColor) == 3)
            $brandColor .= $brandColor;

        $chars = str_split($brandColor);

        $a2fCount = 0;
        foreach ($chars as $key => $char) {
            if(in_array($key, [0, 2, 4]) && in_array(strtoupper($char), ['A', 'B', 'C', 'D', 'E', 'F'])) {
                $a2fCount++;
            }
        }

        if($a2fCount >= 2)
            return true;
        else
            return false;
    }

    public function getActiveConfiguration($websiteId)
    {
        $configurationRepo = $this->entityManager->getRepository(KnowledgebaseWebsite::class);
        $configuration = $configurationRepo->findOneBy(['website' => $websiteId, 'isActive' => 1]);

        return $configuration;
    }

    public function getSupportPrivelegesResources()
    {
        $translator = $this->container->get('translator');
        return [
            'ticket' => [
                'ROLE_AGENT_CREATE_TICKET' => $translator->trans('Can create ticket'),
                'ROLE_AGENT_EDIT_TICKET' => $translator->trans('Can edit ticket'),
                'ROLE_AGENT_DELETE_TICKET' => $translator->trans('Can delete ticket'),
                'ROLE_AGENT_RESTORE_TICKET' => $translator->trans('Can restore trashed ticket'),
                'ROLE_AGENT_ASSIGN_TICKET' => $translator->trans('Can assign ticket'),
                'ROLE_AGENT_ASSIGN_TICKET_GROUP' => $translator->trans('Can assign ticket group'),
                'ROLE_AGENT_UPDATE_TICKET_STATUS' => $translator->trans('Can update ticket status'),
                'ROLE_AGENT_UPDATE_TICKET_PRIORITY' => $translator->trans('Can update ticket priority'),
                'ROLE_AGENT_UPDATE_TICKET_TYPE' => $translator->trans('Can update ticket type'),
                'ROLE_AGENT_ADD_NOTE' => $translator->trans('Can add internal notes to ticket'),
                'ROLE_AGENT_EDIT_THREAD_NOTE' => $translator->trans('Can edit thread/notes'),
                'ROLE_AGENT_MANAGE_LOCK_AND_UNLOCK_THREAD' => $translator->trans('Can lock/unlock thread'),
                'ROLE_AGENT_ADD_COLLABORATOR_TO_TICKET' => $translator->trans('Can add collaborator to ticket'),
                'ROLE_AGENT_DELETE_COLLABORATOR_FROM_TICKET' => $translator->trans('Can delete collaborator from ticket'),
                'ROLE_AGENT_DELETE_THREAD_NOTE' => $translator->trans('Can delete thread/notes'),
                'ROLE_AGENT_APPLY_WORKFLOW' => $translator->trans('Can apply prepared response on ticket'),
                'ROLE_AGENT_ADD_TAG' => $translator->trans('Can add ticket tags'),
                'ROLE_AGENT_DELETE_TAG' => $translator->trans('Can delete ticket tags')
            ],
            'advanced' => [
                'ROLE_AGENT_MANAGE_EMAIL_TEMPLATE' => $translator->trans('Can manage email templates'),
                'ROLE_AGENT_MANAGE_GROUP' => $translator->trans('Can manage groups'),
                'ROLE_AGENT_MANAGE_SUB_GROUP' => $translator->trans('Can manage Sub-Groups/ Teams'),
                'ROLE_AGENT_MANAGE_AGENT' => $translator->trans('Can manage agents'),
                'ROLE_AGENT_MANAGE_AGENT_PRIVILEGE' => $translator->trans('Can manage agent privileges'),
                'ROLE_AGENT_MANAGE_TICKET_TYPE' => $translator->trans('Can manage ticket types'),
                'ROLE_AGENT_MANAGE_CUSTOMER' => $translator->trans('Can manage customers'),
                'ROLE_AGENT_MANAGE_WORKFLOW_MANUAL' => $translator->trans('Can manage Prepared Responses'),
                'ROLE_AGENT_MANAGE_WORKFLOW_AUTOMATIC' => $translator->trans('Can manage Automatic workflow'),
                'ROLE_AGENT_MANAGE_TAG' => $translator->trans('Can manage tags'),
                'ROLE_AGENT_MANAGE_KNOWLEDGEBASE' => $translator->trans('Can manage knowledgebase'),
                'ROLE_AGENT_MANAGE_AGENT_ACTIVITY'  => $translator->trans("Can manage agent activity"),
                'ROLE_AGENT_MANAGE_MARKETING_ANNOUNCEMENT' => $translator->trans("Can manage marketing announcement"),
            ]
        ];
    }

    public function generateCsrfToken($intention)
    {
        $csrf = $this->container->get('security.csrf.token_manager');

        return $csrf->getToken($intention)->getValue();
    }

    /**
     * This function will create content text from recived text, which we can use in meta content and as well in searching save like elastic
     * @param  string $text String text
     * @param  no. $lenght max return lenght string (which will convert to array)
     * @param  boolean $returnArray what return type required
     * @return string/ array comma seperated/ []
     */
    public function createConentToKeywords($text, $lenght = 255, $returnArray = false)
    {
        //to remove all tags from text, if any tags are in encoded form
        $newText = preg_replace('/[\s]+/', ' ', str_replace($this->avoidArray, ' ', strtolower(strip_tags(html_entity_decode(strip_tags($text))))));
        if($lenght)
            $newText = substr($newText, 0, $lenght);
        return ($returnArray ? explode(' ', $newText) : str_replace(' ', ',', $newText));
    }

    public function requestHeadersSent()
    {
        return headers_sent() ? true : false;
    }

    /**
     * get current prefixes of member panel and knowledgebase
     */
    public function getCurrentWebsitePrefixes()
    {
        $filePath = $this->container->get('kernel')->getProjectDir() . '/config/packages/uvdesk.yaml';
        
        // get file content and index
        $file = file($filePath);
        foreach ($file as $index => $content) {
            if (false !== strpos($content, 'uvdesk_site_path.member_prefix')) {
                list($member_panel_line, $member_panel_text) = array($index, $content);
            }

            if (false !== strpos($content, 'uvdesk_site_path.knowledgebase_customer_prefix')) {
                list($customer_panel_line, $customer_panel_text) = array($index, $content);
            }
        }

        $memberPrefix = substr($member_panel_text, strpos($member_panel_text, 'uvdesk_site_path.member_prefix') + strlen('uvdesk_site_path.member_prefix: '));
        $knowledgebasePrefix = substr($customer_panel_text, strpos($customer_panel_text, 'uvdesk_site_path.knowledgebase_customer_prefix') + strlen('uvdesk_site_path.knowledgebase_customer_prefix: '));

        return [
            'memberPrefix' => trim(preg_replace('/\s\s+/', ' ', $memberPrefix)),
            'knowledgebasePrefix' => trim(preg_replace('/\s\s+/', ' ', $knowledgebasePrefix)),
        ];
    }

    /**
     * update your website prefixes
     */
    public function updateWebsitePrefixes($member_panel_prefix, $knowledgebase_prefix)
    {
        $filePath = $this->container->get('kernel')->getProjectDir() . '/config/packages/uvdesk.yaml';

        $website_prefixes = [
            'member_prefix' => $member_panel_prefix,
            'customer_prefix' => $knowledgebase_prefix,
        ];
        
        // get file content and index
        $file = file($filePath);
        foreach ($file as $index => $content) {
            if (false !== strpos($content, 'uvdesk_site_path.member_prefix')) {
                list($member_panel_line, $member_panel_text) = array($index, $content);
            }

            if (false !== strpos($content, 'uvdesk_site_path.knowledgebase_customer_prefix')) {
                list($customer_panel_line, $customer_panel_text) = array($index, $content);
            }
        }

        // save updated data in a variable ($updatedFileContent)
        $updatedFileContent = $file;

        // get old member-prefix
        $oldMemberPrefix = substr($member_panel_text, strpos($member_panel_text, 'uvdesk_site_path.member_prefix') + strlen('uvdesk_site_path.member_prefix: '));
        $oldMemberPrefix = preg_replace('/([\r\n\t])/','', $oldMemberPrefix);

        $updatedPrefixForMember = (null !== $member_panel_line) ? substr($member_panel_text, 0, strpos($member_panel_text, 'uvdesk_site_path.member_prefix') + strlen('uvdesk_site_path.member_prefix: ')) . $website_prefixes['member_prefix'] . PHP_EOL: '';
        $updatedPrefixForCustomer = (null !== $customer_panel_line) ? substr($customer_panel_text, 0, strpos($customer_panel_text, 'uvdesk_site_path.knowledgebase_customer_prefix') + strlen('uvdesk_site_path.knowledgebase_customer_prefix: ')) . $website_prefixes['customer_prefix'] . PHP_EOL : '';

        $updatedFileContent[$member_panel_line] = $updatedPrefixForMember;
        $updatedFileContent[$customer_panel_line] = $updatedPrefixForCustomer;

        // flush updated content in file
        file_put_contents($filePath, $updatedFileContent);

        $router = $this->container->get('router');
        $knowledgebaseURL = $router->generate('helpdesk_knowledgebase');
        $memberLoginURL = $router->generate('helpdesk_member_handle_login');
        $memberLoginURL = str_replace($oldMemberPrefix, $website_prefixes['member_prefix'], $memberLoginURL);

        return $collectionURL = [
            'memberLogin' => $memberLoginURL,
            'knowledgebase' => $knowledgebaseURL,
        ];
    }

    public static function getTimeFormats()
    {
        return array(
            'm-d-y G:i' => 'm-d-y G:i (01-15-1991 13:00)',
            'm-d-y h:ia' => 'm-d-y h:ia (01-15-1991 01:00pm)',
            'd-m-y G:i' => 'd-m-y G:i (15-01-1991 13:00)',
            'd-m-y h:ia' => 'd-m-y h:ia (15-01-1991 01:00pm)',
            'd-m G:i' => 'd-m G:i (15-01 13:00)',
            'd-m h:ia' => 'd-m h:ia (15-01 01:00pm)',
            'd-M G:i' => 'd-M G:i (15-Jan 13:00)',
            'd-M h:ia' => 'd-M h:ia (15-Jan 01:00pm)',
            'D-m G:i' => 'D-m G:i (Mon-01 13:00)',
            'D-m h:ia' => 'D-m h:ia (Mon-01 01:00pm)',
            'Y-m-d H:i:sa' => 'Y-m-d H:i:s (1991-01-15 01:00:30pm)',
        );
    }
}
