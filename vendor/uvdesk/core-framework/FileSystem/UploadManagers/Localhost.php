<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\FileSystem\UploadManagers;

use PhpMimeMailParser\Attachment;
use Webkul\UVDesk\CoreFrameworkBundle\Utils\TokenGenerator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webkul\UVDesk\CoreFrameworkBundle\FileSystem\FileUploadServiceInterface;

class Localhost implements FileUploadServiceInterface
{
    const UPLOAD_DIRECTORY = 'assets';

    private $container;
    private $requestStack;
    private $projectRootDirectory;
    private $documentRootDirectory;
    
    public function __construct(ContainerInterface $container, RequestStack $requestStack)
    {
        $this->container = $container;
        $this->requestStack = $requestStack;
        
        $this->projectRootDirectory = $container->get('kernel')->getProjectDir();
        $this->documentRootDirectory = str_replace('//', '/', $this->projectRootDirectory . '/public');
    }

    private function createMissingDirectories($pathToDirectory = null)
    {
        $missingDirectories = [];
        $activeDirectoryIterations = explode('/', $pathToDirectory);
        
        // Gather missing directories
        do {
            $directory_exists = true;
            $pathToActiveDirectory = implode('/', $activeDirectoryIterations);

            if (false == is_dir($pathToActiveDirectory)) {
                $directory_exists = false;
                $missingDirectories[] = array_pop($activeDirectoryIterations);
            }
        } while ($directory_exists == false);
        
        // Iteratively create missing directories
        if (!empty($missingDirectories)) {
            $missingDirectories = array_reverse($missingDirectories);

            foreach ($missingDirectories as $directory) {
                $activeDirectoryIterations[] = $directory;
                $pathToActiveDirectory = implode('/', $activeDirectoryIterations);

                if (!is_dir($pathToActiveDirectory)) {
                    mkdir($pathToActiveDirectory, 0777, true);
                }
            }
        }
    }

    private function resolvePathToAsset($fileName, $prefix = null)
    {
        $relativePathToAssetDirectory = str_replace('//', '/', sprintf('/%s/%s', self::UPLOAD_DIRECTORY, $prefix));

        if ('/' == substr($relativePathToAssetDirectory, -1)) {
            $relativePathToAssetDirectory = substr($relativePathToAssetDirectory, 0, -1);
        }
        
        $absolutePathToAssetDirectory = $this->documentRootDirectory . $relativePathToAssetDirectory;
        $this->createMissingDirectories($absolutePathToAssetDirectory);

        $relativePathToAsset = str_replace('//', '/', $relativePathToAssetDirectory . "/$fileName");
        $absolutePathToAsset = str_replace('//', '/', $absolutePathToAssetDirectory . "/$fileName");

        return array($relativePathToAsset, $absolutePathToAsset);
    }

    public function uploadFile(UploadedFile $temporaryFile, $prefix = null, bool $renameFile = true)
    {
        $fileName = $temporaryFile->getClientOriginalName();

        if (true == $renameFile) {
            $fileName = sprintf('%s%s', TokenGenerator::generateToken(16), $temporaryFile->guessExtension() ? '.' . $temporaryFile->guessExtension() : '');
        }

        list($relativePath, $absolutePath) = $this->resolvePathToAsset($fileName, $prefix);
        
        // Upload file to target directory
        $relativeTargetDirectory = substr($absolutePath, 0, strrpos($absolutePath, '/'));
        $uploadedFile = $temporaryFile->move($relativeTargetDirectory, $fileName);

        return [
            'name' => $fileName,
            'path' => $relativePath,
            'isPathRelative' => true,
            'size' => $uploadedFile->getSize(),
            'content-type' => $uploadedFile->getMimeType(),
        ];
    }

    public function uploadEmailAttachment(Attachment $attachmentStream, $prefix = null, bool $renameFile = true)
    {
        $fileName = $attachmentStream->getFilename();

        if (true == $renameFile) {
            $fileName = sprintf('%s%s', TokenGenerator::generateToken(16), strrchr($fileName, '.') ?: '');
        }

        list($relativePath, $absolutePath) = $this->resolvePathToAsset($fileName, $prefix);

        // Upload file to target directory
        file_put_contents($absolutePath, $attachmentStream->getStream());

        return [
            'name' => $fileName,
            'path' => $relativePath,
            'isPathRelative' => true,
            'size' => filesize($absolutePath),
            'content-type' => $attachmentStream->getContentType(),
        ];
    }
}