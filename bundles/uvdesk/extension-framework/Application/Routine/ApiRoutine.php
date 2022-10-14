<?php

namespace Webkul\UVDesk\ExtensionFrameworkBundle\Application\Routine;

use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Webkul\UVDesk\ExtensionFrameworkBundle\Application\RoutineInterface;

class ApiRoutine extends Event implements RoutineInterface
{
    const NAME = 'uvdesk_extensions.application_routine.handle_api_request';

    private $request;
    private $responseCode = 200;
    private $responseData = [];

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public static function getName() : string
    {
        return self::NAME;
    }

    public function getRequest() : Request
    {
        return $this->request;
    }

    public function setResponseCode(int $responseCode)
    {
        $this->responseCode = $responseCode;

        return $this;
    }

    public function getResponseCode() : int
    {
        return $this->responseCode;
    }

    public function setResponseData(array $responseData)
    {
        $this->responseData = $responseData;

        return $this;
    }

    public function getResponseData() : array
    {
        return $this->responseData;
    }
}
