<?php

namespace App\Controller\ImageCache;

use App\Service\UrlImageCacheService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageCacheController extends AbstractController
{
    /**
     * Logo URL
     */
    const UVDESK_LOGO = 'https://updates.uvdesk.com/uvdesk-logo.png';

    protected $urlImageCacheService;
    protected $urlGenerator;

    public function __construct(
        UrlImageCacheService $urlImageCacheService
    ) {
        $this->urlImageCacheService = $urlImageCacheService;
    }

    /**
     * Get the cached image response
     * @return Response
     */
    public function getCachedImage(Request $request): Response
    {
        $response = $this->showImage(self::UVDESK_LOGO);
        
        $file = $response->getFile();
        $filePath = $file->getRealPath();

        $relativePath = str_replace($this->getParameter('kernel.project_dir') . '/public', '', $filePath);
        $imageUrl = $this->getParameter('uvdesk.site_url') . $relativePath;

        // Construct the URL to access the cached image
        $imageUrl = preg_match('/\/$/', $this->getParameter('uvdesk.site_url')) ? $this->getParameter('uvdesk.site_url') . ltrim($relativePath, '/') : $this->getParameter('uvdesk.site_url') . '/' . ltrim($relativePath, '/');

        // Return the image URL as JSON
        return new Response(json_encode($imageUrl));
    }

    public function showImage(string $url): Response
    {
        $cachedImagePath = $this->urlImageCacheService->getCachedImage($url);

        return $this->file($cachedImagePath);
    }
}
