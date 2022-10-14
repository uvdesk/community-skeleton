<?php
namespace Webkul\UVDesk\CoreFrameworkBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Inbuilt {

    public function whatIsElement($type){
        return $type == 'textarea' ? 'textarea' : ($type == 'select' ? 'select' : ('input'));
    }

    public function sanitize($text){
        return $text
            .replace('/&/g', '&amp;')
            .replace('/"/g', '&quot;')
            .replace('/\'/g', '&#39;')
            .replace('/</g', '&lt;')
            .replace('/>/g', '&gt;');
    }

    public function desensitize($text){
        return $text
            .replace('/&quot;/g', '"')
            .replace('/&#39;/g', "'")
            .replace('/&lt;/g', '<')
            .replace('/&gt;/g', '>')
            .replace('/&amp;/g', '&');
    }

    public function getMatchRegex($expression, $value) {
		try {
        	return preg_match($expression, $value);
		} catch(\Exception $e) {
			return false;
		}
    }
}

class ValidationService {

    private static $inbuilt;
    private $entityManager = null;
    private $requestStack = null;
	private $container = null;
    private $translator = null;

    private $timeRegex = '#^([0-1]*[0-9]|2[1-3]):([0-5][0-9])(\s)(AM|PM)|([0-1]*[0-9]|2[1-3]):([0-5][0-9])$#';
    private $dateRegex = '#^(\d{4})-(\d{1,2})-(\d{1,2})$#';
    private $datetimeRegex = '#([0-1]*[0-9]|2[1-3]):([0-5]*[0-9])(:[0-5]*[0-9])*$#';
    private $urlRegex = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
    
    private $emailRegex = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';


	public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, ContainerInterface $container, TranslatorInterface $translator) 
	{   
        self::$inbuilt = new Inbuilt();
		$this->container = $container;
        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->translator = $translator;
	}

    public function getInbuilt(){
        return self::$inbuilt;
    }

    public function isEmpty($data){
        return ($data ? true : false);
    }

    public function isNumber($value){
        return is_numeric($value) ? true : false;
    }

    public function isMin($min, $value){
        return ($min && is_numeric($min) && (float)$value < (float)$min) ? false : true;
    }

    public function isMax($max, $value){
        return ($max && is_numeric($max) && (float)$value > (float)$max) ? false : true;
    }

    public function isTime($value) {
        if($this->getInbuilt()->getMatchRegex($this->timeRegex, $value)) {
            return true;
        }
    }

    public function isDate($value){
        if($this->getInbuilt()->getMatchRegex($this->dateRegex, $value)) {
            return true;
        }
    }

    public function isdatetime($value){
        if($this->getInbuilt()->getMatchRegex($this->datetimeRegex, $value)) {
            return true;
        }
    }
    
    public function isUrl($value){
        if($this->getInbuilt()->getMatchRegex($this->urlRegex, $value)) {
            return true;
        }
    }

    public function isEmail($value){
        if($this->getInbuilt()->getMatchRegex($this->emailRegex, $value)) {
            return true;
        }
    }

	/**
	 * Compare values
	 *
	 * is
	 * isNot
	 * contains
	 * notContains
	 * startWith
	 * endWith
	 * before
	 * beforeOn
	 * after
	 * afterOn
	 * 
	 */
    
	public function isEqual($first, $second){
		return $first == $second ? true : false;
	}

	public function isNotEqual($first, $second){
		return $first != $second ? true : false;
	}

	public function contains($first, $second){
		return strstr(strtolower($first), strtolower($second)) ? true : false;
	}

	public function notContains($first, $second){
		return !strstr(strtolower($first), strtolower($second)) ? true : false;
	}

	public function startWith($first, $second){
		return (substr(strtolower($first), 0, strlen($second)) == strtolower($second)) ? true : false;
	}

	public function endWith($first, $second){
		return (substr(strtolower($first), -strlen($second)) == strtolower($second)) ? true : false;
	}

	public function before($first, $second){
		return ($first < $second) ? true : false;
	}

	public function beforeOn($first, $second){
		return ($first <= $second) ? true : false;
	}

	public function after($first, $second){
		return ($first > $second) ? true : false;
	}

	public function afterOn($first, $second){
		return ($first >= $second) ? true : false;
	}

	public function messageValidate(Array $validation, $valueField)
	{          
		if($validation['required']) {
			if($valueField) {
			} else {
				return $this->getTranslatedMessage('required_empty');
			}
		}

		$error = false;
		$fieldtype = !empty($validation['fieldtype']) ? $validation['fieldtype'] : 'text';
		
		foreach($validation as $keyValidation => $valueValidation) {
			if($valueField && $valueValidation) {
				switch($keyValidation) {
					case 'fieldtype':
						switch($valueValidation) {
							case 'number':
								if(!$this->isNumber($valueField))
									$error .= $this->getTranslatedMessage('number');
								break;
							case 'url':
								if(!$this->isUrl($valueField))
									$error .= $this->getTranslatedMessage('url');
								break;
							case 'email':
								if(!$this->isEmail($valueField))
									$error .= $this->getTranslatedMessage('email');
								break;
							case 'date':
								if(!$this->isDate($valueField))
									$error .= $this->getTranslatedMessage('date');
								break;
							case 'time':
								if(!$this->isTime($valueField))
									$error .= $this->getTranslatedMessage('time');
								break;
							case 'datetime':
								if(!$this->isdatetime($valueField))
									$error .= $this->getTranslatedMessage('datetime');
								break;
							case 'text':
							case 'password':
							default:
								break;
						}
						break;
					case 'maxFileSize':
						if($fieldtype == 'file' && $valueField && $valueField instanceof UploadedFile) {
						if($this->isMin($valueValidation*1024, $valueField->getSize()))
							$error .= $this->getTranslatedMessage('maxFileSize');
						}
						break;
					case 'maxNo':					
						if($fieldtype == 'number' && !$this->isMax($valueValidation, $valueField))
							$error .= $this->getTranslatedMessage('maxNo');
						break;
					case 'minNo':
						if($fieldtype == 'number' && !$this->isMin($valueValidation, $valueField))
							$error .= $this->getTranslatedMessage('minNo');
						break;
					case 'regex':
						try {
							if(!in_array($fieldtype, ['select', 'checkbox', 'radio']) && !preg_match('/'.$valueValidation.'/', $valueField))
								$error .= $this->getTranslatedMessage('regex');
						} catch(\Exception $e) {
						}
						break;
					case 'allowedDomain':
						if ($fieldtype == 'email' && strpos($valueField, $valueValidation) === false) {
							$error .= $this->getTranslatedMessage('allowedDomain');
						}
						break;
					case 'restrictedDomain':
						if ($fieldtype == 'email' && strpos($valueField, $valueValidation) !== false)
							$error .= $this->getTranslatedMessage('restrictedDomain');
						break;
					default:
						break;
				}
			}
		}
		return $error;
	}

	protected function getTranslatedMessage($message)
	{
		switch($message) {
            case 'required_empty': 
                $translatedMessage = $this->translator->trans('This field is mandatory');
                break;
            case 'allowedDomain': 
                $translatedMessage = $this->translator->trans('Error! email domain is not a allowed Domain!');
                break;
            case 'maxNo':
                $translatedMessage = $this->translator->trans('Error! Value should not be exceed max no!');
                break;
            case 'minNo':
                $translatedMessage = $this->translator->trans('Error! Value should not be less than min no!');
                break;
            case 'regex':
                $translatedMessage = $this->translator->trans('Error! Provide a valid field!');
                break;
            case 'restrictedDomain':
                $translatedMessage = $this->translator->trans('Error! email domain is a Restricted domain!');
                break;
            case 'time':
                $translatedMessage = $this->translator->trans('Error! time value is not valid!');
                break;
			case 'date':
                $translatedMessage = $this->translator->trans('Error! date value is not valid!');
                break;			
			case 'datetime':
                $translatedMessage = $this->translator->trans('Error! datetime value is not valid!');
                break;
			case 'maxFileSize':
                $translatedMessage = $this->translator->trans('Error! file size exceeded!');
                break;
			case 'email':
                $translatedMessage = $this->translator->trans('Error! invalid email value!');
                break;			
			case 'url':
                $translatedMessage = $this->translator->trans('Error! invalid url!');
                break;						
			case 'number':
                $translatedMessage = $this->translator->trans('Error! invalid number!');
                break;							
            default:
                $translatedMessage = $message;    
        }

        return $translatedMessage;
	}
}
