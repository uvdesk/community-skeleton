<?php

namespace Webkul\UVDesk\SupportCenterBundle\UIComponents\Dashboard\Navigation;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\NavigationInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class Knowledgebase implements NavigationInterface
{
    CONST SVG = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="18px">
    <path fill-rule="evenodd" fill="rgb(158, 158, 158)" d="M14.000,0.000 L2.000,0.000 C0.969,0.000 0.000,0.901 0.000,2.000 L0.000,18.000 C0.000,19.099 0.969,20.000 2.000,20.000 L14.000,20.000 C15.031,20.000 16.000,19.099 16.000,18.000 L16.000,2.000 C16.000,0.901 15.031,0.000 14.000,0.000 ZM3.000,3.000 L9.000,3.000 L9.000,11.000 L6.000,9.000 L3.000,11.000 L3.000,3.000 Z"></path>
</svg>
SVG;

    public static function getIcon() : string
    {
        return self::SVG;
    }

    public static function getTitle() : string
    {
        return self::dynamicTranslation("Knowledgebase");
    }

    public static function getRouteName() : string
    {
        return 'helpdesk_member_knowledgebase_folders_collection';
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
