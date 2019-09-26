<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\UIComponents\Dashboard\Homepage\Sections;

use Webkul\UVDesk\CoreFrameworkBundle\Dashboard\Segments\HomepageSection;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\HttpFoundation\Request;

class Settings extends HomepageSection
{
    public static function getTitle() : string
    {
        return SELF::dynamicTranslation("Settings");
    }

    public static function getDescription() : string
    {
        return self::dynamicTranslation("Manage your Brand Identity, Company Information and other details at a glance");
    }

    public static function getRoles() : array
    {
        return [
            'ROLE_AGENT_MANAGE_EMAIL_TEMPLATE',
        ];
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
                $translator->addResource('yaml',__DIR__."/../../../../../../../translations/messages.en.yml", 'en');
             
                break;
            
            case 'es':

                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../../translations/messages.es.yml", 'es');
            
                break;

            case 'fr':

                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../../translations/messages.fr.yml", 'fr');
               
                break;
            
            case 'da':
      
                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../../translations/messages.da.yml", 'da');
               
                break;
                
            case 'de':
       
                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../../translations/messages.de.yml", 'de');
   
                break;

            case 'it':
    
                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../../translations/messages.it.yml", 'it');
             
                break;

            case 'ar':
        
                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../../translations/messages.ar.yml", 'ar');
              
                break;

            case 'tr':
      
                $translator->addLoader('yaml', new YamlFileLoader()); 
                $translator->addResource('yaml',__DIR__."/../../../../../../../translations/messages.tr.yml", 'tr');
               
                break;

        }
        return $translator->trans($data); 
        
    }
}
