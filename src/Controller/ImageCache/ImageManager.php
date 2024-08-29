<?php

namespace App\Controller\ImageCache;

use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManager as BaseImageManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ImageManager extends BaseImageManager
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function make($data)
    {
        $driver = $this->createDriver();

        $domain = $data['siteUrl'];
        $imageUrl = $data['imageUrl'];

        if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            return $this->initFromUrl($driver, $imageUrl, $domain);
        }

        return $driver->init($data);
    }

    /**
     * This method hit the tracker image url and create a live instance
     *
     * @param mixed $driver
     * @param mixed $imageUrl
     * @param mixed $domain
     * @throws \Intervention\Image\Exception\NotReadableException
     * @return mixed
     */
    public function initFromUrl($driver, $imageUrl, $domain)
    {
        $options = [
            'http' => [
                'method'           => 'GET',
                'protocol_version' => 1.1,
                'header'           => "Accept-language: en\r\n" .
                    "Domain: $domain\r\n" .
                    "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36\r\n",
            ],
        ];

        $context = stream_context_create($options);
        $data = @file_get_contents($imageUrl, false, $context);

        if ($data) {
            return $driver->decoder->initFromBinary($data);
        }

        throw new NotReadableException('Unable to init from given URL (' . $imageUrl . ').');
    }

    private function createDriver()
    {
        $driverName = ucfirst($this->config['driver']);
        $driverClass = sprintf('Intervention\\Image\\%s\\Driver', $driverName);

        if (class_exists($driverClass)) {
            return new $driverClass;
        }

        throw new \Exception("Driver ({$driverName}) could not be instantiated.");
    }
}
