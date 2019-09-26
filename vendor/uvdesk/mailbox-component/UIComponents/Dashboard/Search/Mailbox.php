<?php

namespace Webkul\UVDesk\MailboxBundle\UIComponents\Dashboard\Search;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\SearchItemInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class Mailbox implements SearchItemInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30px" height="30px" viewBox="0 0 60 60">
    <path fill-rule="evenodd" d="M30,33L6,18V12L30,27,54,12v6ZM5.9,5.992A5.589,5.589,0,0,0,1.745,7.817,5.882,5.882,0,0,0-.016,12.027v35.93a5.875,5.875,0,0,0,1.761,4.211A5.581,5.581,0,0,0,5.9,53.992H54.069a5.588,5.588,0,0,0,4.155-1.825A5.8,5.8,0,0,0,60,48V12a5.847,5.847,0,0,0-1.776-4.183,5.6,5.6,0,0,0-4.155-1.825H5.9Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return self::dynamicTranslation("Mailbox");
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_mailbox_settings';
    }

    public function getChildrenRoutes() : array
    {
        return [];
    }

    public  static function dynamicTranslation($data) : string
    {

        $request = Request::createFromGlobals(); 
        $path = $request->getPathInfo(); 
        $locale = explode("/", $path);
        $translator = new Translator($locale[1]);

        switch($locale[1])
        {
            case 'en':
      
                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../translations/messages.en.yml", 'en');
             
                break;
            
            case 'es':

                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../translations/messages.es.yml", 'es');
            
                break;

            case 'fr':

                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../translations/messages.fr.yml", 'fr');
               
                break;
            
            case 'da':
      
                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../translations/messages.da.yml", 'da');
               
                break;
                
            case 'de':
       
                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../translations/messages.de.yml", 'de');
   
                break;

            case 'it':
    
                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../translations/messages.it.yml", 'it');
             
                break;

            case 'ar':
        
                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../translations/messages.ar.yml", 'ar');
              
                break;

            case 'tr':
      
                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../translations/messages.tr.yml", 'tr');
               
                break;

        }
        return $translator->trans($data); 
        
    }
}