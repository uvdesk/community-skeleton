<?php
namespace Webkul\UVDesk\CoreFrameworkBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\Entity\Recaptcha;

class ReCaptchaService {

	private $request;
	protected $container;
    protected $em;

	public function __construct(EntityManagerInterface $em, RequestStack $request, ContainerInterface $container)
    {
        $this->em = $em;
        $this->request = $request;
        $this->container = $container;
    }

    /**
     * Get ReCaptcha Response
     * //g-recaptcha-response
     * @return /Serialize Obj
     */
    public function getReCaptchaResponse($gRecaptchaResponse)
    {  
        $recaptcha = new \ReCaptcha\ReCaptcha($this->getSecretKeyRecaptcha());
        $resp = $recaptcha->verify($gRecaptchaResponse, $this->request->getCurrentRequest()->headers->get('host'));
        if ($resp->isSuccess()) {
            // verified!
            return false;
        } else {
            return $resp->getErrorCodes();
        }
    }

    public function getSecretKeyRecaptcha()
    {   
        $recaptchaDetail = $this->getRecaptchaDetails();
        return $recaptchaDetail->getSecretKey();
    }

    public function getRecaptchaDetails()
    {   
        // find Recaptcha details
        $em = $this->em;
        $recaptchaRepo = $em->getRepository(Recaptcha::class);
        $recaptcha = $recaptchaRepo->findOneById(1);

        return $recaptcha ? $recaptcha : '';
    }
}
