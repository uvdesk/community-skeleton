<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Webkul\UVDesk\CoreFrameworkBundle\Services\ValidationService;
use Webkul\UVDesk\CoreFrameworkBundle\Services\UserService;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Ticket;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\TicketType;
use UVDesk\CommunityPackages\UVDesk\FormComponent\Entity as CommunityPackageEntities;

class CustomFieldsService {

    private $entityManager = null;
    private $container = null;
    private $validationService = null;
    private $translatorService = null;
    private $userService;

    public function __construct(
        EntityManagerInterface $entityManager, 
        ContainerInterface $container, 
        ValidationService $validationService,
        TranslatorInterface $translatorService,
        UserService $userService)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
        $this->validationService = $validationService;
        $this->translatorService = $translatorService;
        $this->userService = $userService;
    }

    /**
    * customFieldValidation for Ticket, used in 1.TicketBundle, 2. SupportCenterBundle 3.ApiBundle
    *
    * @param Request $request
    * @param String $userType (optional) (like for user, customer, both)
    *
    * @return Array with keys: 'errorMain', 'formErrors', 'errorFlashMessage'
    */
    public function customFieldsValidation(Request $request, $userType = 'both')
    {
        $errorMain = false;
        $formErrors = [];
        $errorFlashMessage = null;

        $data = $request->request->all() ? : json_decode($request->getContent(), true);
        
        $isFolderExist  =  $this->userService->isfileExists('apps/uvdesk/form-component');
        if ($isFolderExist) { 
            if(!$this->validateAttachmentsSize($request->files->get('customFields')) || !$this->validateAttachmentsSize($request->files->get('attachments'))) {
                $errorMain = true;
                $errorFlashMessage =  $this->translator->trans("Warning ! Files size can not exceed %size% MB", [
                                            "%size%" => $this->container->getParameter('max_upload_size')
                                        ]);
            } elseif($companyCustomFields = $this->getCustomFieldsArray($userType)) {
                foreach ($companyCustomFields as $customField) {
                    if('file' == $customField['fieldType']) {
                        $fileCf = $request->files->get('customFields');
                        $customFieldValue = isset($fileCf[$customField['id']]) ? $fileCf[$customField['id']] : null;
                    } else {
                        $customFieldValue = isset($data['customFields'][$customField['id']]) ? $data['customFields'][$customField['id']] : null;
                    }
                    $customField['validation']['required'] = $customField['required'];
                    $customField['validation']['fieldtype'] = $customField['fieldType'] ? : $customField['validation']['fieldtype'] ;
                    if(count($customField['customFieldsDependency'])) {
                        $ticketType = $this->entityManager->getRepository(TicketType::class)->findOneById(isset($data['type']) ? $data['type'] : '' );
                        if($ticketType) {
                            $typeId = $ticketType->getId();
                            $flag = 0;
                            foreach($customField['customFieldsDependency'] as $dependency) {
                                if($dependency['id'] == $typeId) {
                                    $flag = 1; break;
                                }
                            }
                        }
                        if(empty($flag)) {
                            continue;
                        }
                    } elseif(in_array($customField['fieldType'], ['checkbox', 'radio', 'select']) && empty($customField['customFieldValues'])) {
                        continue;
                    }

                    $errorMessage = $this->validationService->messageValidate($customField['validation'], $customFieldValue);
                    if($errorMessage) {
                        $formErrors["customFields[".$customField['id']."]"] = $errorMessage;
                    }
                }
            }
        }    

        return ['errorMain' => $errorMain, 'formErrors' => $formErrors, 'errorFlashMessage' => $errorFlashMessage];
    }

    public function customFieldsValidationWithoutRequired(Request $request, $userType = 'both')
    {
        $errorMain = false;
        $formErrors = [];
        $errorFlashMessage = null;

        $data = $request->request->all() ? : json_decode($request->getContent(), true);

        if(!$this->validateAttachmentsSize($request->files->get('customFields')) || !$this->validateAttachmentsSize($request->files->get('attachments'))) {
            $errorMain = true;
            $errorFlashMessage =  $this->translator->trans("Warning ! Files size can not exceed %size% MB", [
                                        "%size%" => $this->container->getParameter('max_upload_size')]);                                        
        } elseif($companyCustomFields = $this->getCustomFieldsArray($userType)) {
            foreach ($companyCustomFields as $customField) {
                $customField['validation']['required'] = false;
                $customField['validation']['fieldtype'] = $customField['fieldType'] ? : $customField['validation']['fieldtype'] ;
                if('file' == $customField['fieldType']) {
                    $fileCf = $request->files->get('customFields');
                    $customFieldValue = isset($fileCf[$customField['id']]) ? $fileCf[$customField['id']] : null;
                } else {
                    $customFieldValue = isset($data['customFields'][$customField['id']]) ? $data['customFields'][$customField['id']] : null;
                }
                if(count($customField['customFieldsDependency'])) {
                    $ticketType = $this->entityManager->getRepository(TicketType::class)->findOneById(isset($data['type']) ? $data['type'] : '' );
                    if($ticketType) {
                        $typeId = $ticketType->getId();
                        $flag = 0;
                        foreach($customField['customFieldsDependency'] as $dependency) {
                            if($dependency['id'] == $typeId) {
                                $flag = 1; break;
                            }
                        }
                    }
                    if(empty($flag)) {
                        continue;
                    }
                } elseif(in_array($customField['fieldType'], ['checkbox', 'radio', 'select']) && empty($customField['customFieldValues'])) {
                    continue;
                }

                $errorMessage = $this->validationService->messageValidate($customField['validation'],  $customFieldValue);
                if($errorMessage) {
                    $formErrors["customFields[".$customField['id']."]"] = $errorMessage;
                }
            }
        }

        return ['errorMain' => $errorMain, 'formErrors' => $formErrors, 'errorFlashMessage' => $errorFlashMessage];
    }

    /**
    * customFieldValidation for some field
    *
    * @param Request $request
    * @param Array $customFields , validate against these customFields
    *
    * @return Array with keys: 'errorMain', 'formErrors', 'errorFlashMessage'
    */
    public function partialCustomFieldsValidation(Request $request, Array $customFields, $prefix = '')
    {
        $errorMain = false;
        $formErrors = [];
        $errorFlashMessage = null;

        $data = $request->request->all() ? : json_decode($request->getContent(), true);

        if(!$this->validateAttachmentsSize($request->files->get('customFields')) || !$this->validateAttachmentsSize($request->files->get('attachments'))) {
            $errorMain = true;
            $errorFlashMessage =  $this->translator->trans("Warning ! Files size can not exceed %size% MB", [
                                        "%size%" => $this->container->getParameter('max_upload_size')]);
        } else {
            foreach ($customFields as $customField) {
                if('file' == $customField['fieldType']) {
                    $fileCf = $request->files->get('customFields');
                    $customFieldValue = isset($fileCf[$customField['id']]) ? $fileCf[$customField['id']] : null;
                } else {
                    $customFieldValue = isset($data['customFields'][$customField['id']]) ? $data['customFields'][$customField['id']] : null;
                }
                $customField['validation']['required'] = $customField['required'];
                $customField['validation']['fieldtype'] = $customField['fieldType'] ? : $customField['validation']['fieldtype'];
                if(count($customField['customFieldsDependency'])) {
                    $ticketType = $this->entityManager->getRepository(TicketType::class)->findOneById(isset($data['type']) ? $data['type'] : '' );
                    if($ticketType) {
                        $typeId = $ticketType->getId();
                        $flag = 0;
                        foreach($customField['customFieldsDependency'] as $dependency) {
                            if($dependency['id'] == $typeId) {
                                $flag = 1; break;
                            }
                        }
                    }
                    if(empty($flag)) {
                        continue;
                    }
                } elseif(in_array($customField['fieldType'], ['checkbox', 'radio', 'select']) && empty($customField['customFieldValues'])) {
                    continue;
                }

                $errorMessage = $this->validationService->messageValidate($customField['validation'],  $customFieldValue);
                if($errorMessage) {
                    $formErrors["customFields[".$customField['id']."]"] = $errorMessage;
                }
            }
        }

        return ['errorMain' => $errorMain, 'formErrors' => $formErrors, 'errorFlashMessage' => $errorFlashMessage];
    }

    public function partialCustomFieldsValidationBinaka(Request $request, Array $customFields, $prefix = '')
    {
        $errorMain = false;
        $formErrors = [];
        $errorFlashMessage = null;

        $data = $request->request->all() ? : json_decode($request->getContent(), true);

        if(!$this->validateAttachmentsSize($request->files->get('customFields')) || !$this->validateAttachmentsSize($request->files->get('attachments'))) {
            $errorMain = true;
            $errorFlashMessage =  $this->translator->trans("Warning ! Files size can not exceed %size% MB", [
                                        "%size%" => $this->container->getParameter('max_upload_size')
                                    ]);
        } else {
            foreach ($customFields as $customField) {
                if(isset($customField['attr']['required']))
                    $customField['validation']['required'] = $customField['attr']['required'];
                else
                    $customField['validation']['required'] = false;
                
                if (!empty($customField['attr']['type']) && 'file' == $customField['attr']['type']) {
                    $fileCf = $request->files->get('customFields');
                    $customFieldValue = isset($fileCf[$customField['id']]) ? $fileCf[$customField['id']] : null;
                } else {
                    $customFieldValue = isset($data['customFields'][$customField['id']]) ? $data['customFields'][$customField['id']] : null;
                }

                if(count($customField['dependency'])) {
                    $ticketType = $this->entityManager->getRepository(TicketType::class)->findOneById(isset($data['type']) ? $data['type'] : '' );
                    if($ticketType) {
                        $typeId = $ticketType->getId();
                        $flag = 0;
                        foreach($customField['dependency'] as $dependency) {
                            if($dependency['id'] == $typeId) {
                                $flag = 1; break;
                            }
                        }
                    }
                    if(empty($flag)) {
                        continue;
                    }
                } elseif(isset($customField['fieldType']) && in_array($customField['fieldType'], ['checkbox', 'radio', 'select']) && empty($customField['customFieldValues'])) {
                    continue;
                }

                $errorMessage = $validationService->messageValidate($customField['validation'],  $customFieldValue);
                if($errorMessage) {
                    $formErrors["customFields[".$customField['id']."]"] = $errorMessage;
                }
            }
        }

        return ['errorMain' => $errorMain, 'formErrors' => $formErrors, 'errorFlashMessage' => $errorFlashMessage];
    }

    /**
    * finds active custom fields by company and userType(agentType) , (included customFields for agentType:both)
    *
    * @param string $agentType
    */
	public function getCustomFieldsArray($agentType)
	{
        if('string' !== gettype($agentType)) {
            throw new \Exception('getCustomFieldsArray() expects parameter 1 to be string.');
        }
        $qb = $this->entityManager->createQueryBuilder()
        			->from(CommunityPackageEntities\CustomFields::class, 'c')
                    ->leftJoin("c.customFieldsDependency",'cfd')
        			->select('c,cfv,cfd')
                    ->leftJoin("c.customFieldValues",'cfv')
        			->andWhere('c.status = 1')
        			->orderBy('c.sortOrder');

        if($agentType && 'both' != $agentType) {
                $qb->andWhere('c.agentType = :both or c.agentType = :agentType')
                ->setParameter('agentType',$agentType)
                ->setParameter('both', 'both');
        }

        $results =  $qb->getQuery()->getArrayResult();
        foreach ($results as $key => $result) {
            $results[$key]['validation'] = ($result['validation']) ? json_decode($result['validation'],true) : $result['validation'];
        }

        return $results;
	}

    /**
    * get customFields from db using customField Ids
    *
    * @param Array $array (customFieldIds array)
    * @param String $resultType ('array' for array Result, 'object' for object result)
    *
    * @return Array customFieldsCollection with Array/object results
    */
    public function getCustomFieldsByIds(Array $array, $resultType = 'array')
    {
        if(!in_array($resultType, ['array', 'object'])) {
            throw new \Exception('getCustomFieldsByIds() expects parameter 3 to be either "array" or "object".');
        }

        $queryBuilder = $this->entityManager->createQueryBuilder()
                            ->from(CommunityPackageEntities\CustomFields::class, 's')
                            ->leftJoin("s.customFieldValues",'cfv')
                            ->leftJoin('s.customFieldsDependency','cfd')
                            ->select('s, cfv, cfd')
                            ->andWhere('s.status= 1')
                            ->andWhere('s.id in (:array)')
                            ->orderBy(
                                    's.sortOrder'
                                )
                             ->setParameters(
                                array(
                                        'array' => $array,
                                    )
                                )
                              ->getQuery()
                            ;
        if($resultType == 'array') {
            $results = $queryBuilder->getArrayResult();
            foreach ($results as $key => $result) {
                $results[$key]['validation'] = ($result['validation']) ? json_decode($result['validation'],true) : $result['validation'];
            }
        } else {
            $results = $queryBuilder->getResult();
        }

        return $results;
    }

    public function validateAttachmentsSize($attachments)
    {
        $filesize = 0;
        if($attachments) {
            foreach ($attachments as $attachment) {
                if(is_array($attachment)){
                    foreach ($attachment as $attach) {
                        if($attach)
                            $filesize += $attach->getSize() / 1048576;
                    }
                }elseif($attachment)
                    $filesize += $attachment->getSize() / 1048576;
            }
        }
        return $filesize > $this->container->getParameter('max_upload_size') ? false : true;
    }

    public function addFilesEntryToAttachmentTable($fileNames, $thread = null)
    {
        $newFilesNames = [];
        foreach ($fileNames as $file) {
            $attachment = new \Webkul\UVDesk\CoreFrameworkBundle\Entity\Attachment();
            $attachment->setName($file['name']);
            $attachment->setPath($file['path']);
            $attachment->setContentType($file['content-type']);
            $attachment->setSize($file['size']);
            $attachment->setThread($thread);
            if(isset($file['contentId']))
                $attachment->setContentId($file['contentId']);
            
            $this->entityManager->persist($attachment);
            $this->entityManager->flush();

            $newFilesNames[] =  [
                                    'id' => $attachment->getId(),
                                    'name' => $attachment->getName(),
                                    'path' => $attachment->getPath(),
                                ];
        }
        return $newFilesNames;
    }

    	
    /**
	* returns custom field snippet containing html, js for ticket view
	*/
	public function getCustomFieldSnippet(Ticket $ticket): array
	{
        $customFieldCollection = $this->getCustomFieldsArray('both');
		
        if (!empty($customFieldCollection)) {
	        $ticketCustomFieldArrayCollection = [];
	        $ticketCustomFieldCollection = $this->entityManager->getRepository(CommunityPackageEntities\TicketCustomFieldsValues::class)->findBy(['ticket' => $ticket]);

	        if (!empty($ticketCustomFieldCollection)) {
	        	foreach ($ticketCustomFieldCollection as $ticketCustomField) {
	        		$ticketCustomFieldArrayCollection[$ticketCustomField->getTicketCustomFieldsValues()->getId()] = [
	        			'id' => $ticketCustomField->getId(),
	        			'encrypted' => $ticketCustomField->getEncrypted() ? true : false,
	        			'targetCustomField' => $ticketCustomField->getTicketCustomFieldsValues()->getId(),
	        		];

	        		switch ($ticketCustomField->getTicketCustomFieldsValues()->getFieldType()) {
	        			case 'select':
	        			case 'radio':
		        		case 'checkbox':
	        				$fieldId = [];
	        				$fieldValue = [];

	        				if ($ticketCustomField->getEncrypted()) {
	        					$ticketCustomField->decryptEntity();
	        				}

	        				$fieldOptions = json_decode($ticketCustomField->getValue(), true);

	        				if (empty($fieldOptions)) {
		        				$fieldOptions = explode(',', $ticketCustomField->getValue());
	        				} else {
	        					if (!is_array($fieldOptions)) {
	        						$fieldOptions = [$fieldOptions];
	        					}
	        				}

	        				foreach ($ticketCustomField->getTicketCustomFieldsValues()->getCustomFieldValues() as $multipleFieldValue) {
	        					if (in_array($multipleFieldValue->getId(), $fieldOptions)) {
	        						$fieldId[] = $multipleFieldValue->getId();
	        						$fieldValue[] = $multipleFieldValue->getName();
	        					}
	        				}

	        				$ticketCustomFieldArrayCollection[$ticketCustomField->getTicketCustomFieldsValues()->getId()]['valueId'] = $fieldId;
	        				$ticketCustomFieldArrayCollection[$ticketCustomField->getTicketCustomFieldsValues()->getId()]['value'] = $ticketCustomField->getEncrypted() ? null: implode('</br>', $fieldValue);
		        			break;
                        case 'file':
                            $ticketCustomFieldArrayCollection[$ticketCustomField->getTicketCustomFieldsValues()->getId()]['value'] = $ticketCustomField->getEncrypted() ? null : strip_tags(trim($ticketCustomField->getValue(), '"'));
                            break;
		        		default:
		        			$ticketCustomFieldArrayCollection[$ticketCustomField->getTicketCustomFieldsValues()->getId()]['value'] = (!$ticketCustomField->getEncrypted()
		        				? (is_array(trim($ticketCustomField->getValue(), '"'))
		        					? json_encode(trim($ticketCustomField->getValue(), '"'))
		        					: strip_tags(htmlentities(trim($ticketCustomField->getValue(), '"')))
		        				)
		        				: null
		        			);
		        			break;
	        		}
	        	}
			}
			return [
				'ticket' => $ticket,
				'customFieldCollection' => $customFieldCollection,
				'ticketCustomFieldCollection' => $ticketCustomFieldArrayCollection
			];
        }

        return [
			'ticket' => $ticket,
			'customFieldCollection' => [],
			'ticketCustomFieldCollection' => []
		];
	}

	public function getCustomerCustomFieldSnippet(Ticket $ticket): array
	{   
        $customFieldCollection = $this->getCustomFieldsArray('customer');
		$ticketCustomFieldArrayCollection = [];
		$ticketCustomFieldCollection = $this->entityManager->getRepository(CommunityPackageEntities\TicketCustomFieldsValues::class)->findBy(['ticket' => $ticket]);

		/* load custom fields whose value is already present in ticket */ 
		$existingCfIds = array_column($customFieldCollection, 'id');
		$cfIds = [];
		foreach($ticketCustomFieldCollection as $cfValue) {
			$id = $cfValue->getTicketCustomFieldsValues()->getId();
			if($cfValue->getTicketCustomFieldsValues()->getStatus() && !in_array($id, $existingCfIds)) {
				$cfIds[] = $id;
			}
		}
		$ticketCfs = $this->getCustomFieldsByIds($cfIds);
		$customFieldCollection = array_merge($customFieldCollection, $ticketCfs);

		/* format data */ 
		if (!empty($customFieldCollection)) {
			foreach ($ticketCustomFieldCollection as $ticketCustomField) {
				$ticketCustomFieldArrayCollection[$ticketCustomField->getTicketCustomFieldsValues()->getId()] = [
					'id' => $ticketCustomField->getId(),
					'encrypted' => $ticketCustomField->getEncrypted() ? true : false,
					'targetCustomField' => $ticketCustomField->getTicketCustomFieldsValues()->getId(),
					'targetCustomFieldName' => $ticketCustomField->getTicketCustomFieldsValues()->getId(),
				];

				switch ($ticketCustomField->getTicketCustomFieldsValues()->getFieldType()) {
					case 'select':
					case 'radio':
					case 'checkbox':
						$fieldId = [];
						$fieldValue = [];

						if ($ticketCustomField->getEncrypted()) {
							$ticketCustomField->decryptEntity();
						}

						$fieldOptions = json_decode($ticketCustomField->getValue(), true);

						if (empty($fieldOptions)) {
							$fieldOptions = explode(',', $ticketCustomField->getValue());
						} else {
							if (!is_array($fieldOptions)) {
								$fieldOptions = [$fieldOptions];
							}
						}
						foreach ($ticketCustomField->getTicketCustomFieldsValues()->getCustomFieldValues() as $multipleFieldValue) {
							if (in_array($multipleFieldValue->getId(), $fieldOptions)) {
								$fieldId[] = $multipleFieldValue->getId();
								$fieldValue[] = $multipleFieldValue->getName();
							}
						}
						$ticketCustomFieldArrayCollection[$ticketCustomField->getTicketCustomFieldsValues()->getId()]['valueId'] = $fieldId;
						$ticketCustomFieldArrayCollection[$ticketCustomField->getTicketCustomFieldsValues()->getId()]['value'] = $ticketCustomField->getEncrypted() ? null: implode('</br>', $fieldValue);
						break;
					default:
						$ticketCustomFieldArrayCollection[$ticketCustomField->getTicketCustomFieldsValues()->getId()]['value'] = (!$ticketCustomField->getEncrypted()
							? (is_array(trim($ticketCustomField->getValue(), '"'))
								? json_encode(trim($ticketCustomField->getValue(), '"'))
								: strip_tags(htmlentities(trim($ticketCustomField->getValue(), '"')))
							)
							: null
						);
						break;
				}
			}
			return ['ticket' => $ticket,
				'customFieldCollection' => $customFieldCollection,
				'ticketCustomFieldCollection' => $ticketCustomFieldArrayCollection
			];
		}
		return [
            'ticket' => $ticket,
            'customFieldCollection' => [],
			'ticketCustomFieldCollection' => []
        ];
	}
}