<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\FileSystem;

use Webkul\UVDesk\CoreFrameworkBundle\Entity\Attachment;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Webkul\UVDesk\CoreFrameworkBundle\FileSystem\UploadManagers\Localhost as DefaultFileUploadManager;

class FileSystem
{
    private $container;
    private $requestStack;
    private $projectRootDirectory;
    private $documentRootDirectory;
    private $fileUploadManagerServiceId;
    
    public function __construct(ContainerInterface $container, RequestStack $requestStack)
    {
        $this->container = $container;
        $this->requestStack = $requestStack;

        $this->projectRootDirectory = $container->get('kernel')->getProjectDir();
        $this->documentRootDirectory = str_replace('//', '/', $this->projectRootDirectory . '/public');
        $this->fileUploadManagerServiceId = $container->getParameter('uvdesk.upload_manager.id') ?: DefaultFileUploadManager::class;
    }

    public function getUploadManager()
    {
        return $this->container->get($this->fileUploadManagerServiceId);
    }

    private function getAssetIconURL(Attachment $attachment = null)
    {
        $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/unknown.png';

        if (!empty($attachment)) {
            switch (strrchr($attachment->getName(), '.') ?: '') {
                case '.jpg':
                case '.png':
                case '.gif':
                case '.jpeg':
                    $relativePathToAsset = $attachment->getPath();
                    break;
                case '.zip':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/zip.png';
                    break;
                case '.doc':
                case '.docx':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/doc.png';
                    break;
                case '.pdf':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/pdf.png';
                    break;
                case '.xls':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/xls.png';
                    break;
                case '.csv':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/csv.png';
                    break;
                case '.ppt':
                case '.pptx':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/ppt.png';
                    break;
                case '.aspx':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/aspx.png';
                    break;
                case '.c':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/c.png';
                    break;
                case '.css':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/css.png';
                    break;
                case '.html':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/html.png';
                    break;
                case '.txt':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/txt.png';
                    break;
                case '.xml':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/xml.png';
                    break;
                case '.yaml':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/yaml.png';
                    break;
                case '.php':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/php.png';
                    break;
                case '.odt':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/odt.png';
                    break;
                case '.ods':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/ods.png';
                    break;
                case '.jsp':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/jsp.png';
                    break;
                case '.json':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/json.png';
                    break;
                case '.js':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/js.png';
                    break;
                case '.java':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/java.png';
                case '.xlsx':
                    $relativePathToAsset = '/bundles/uvdeskcoreframework/images/icons/file-system/xlsx.svg';
                    break;
                default:
                    break;
            }
        }

        return $relativePathToAsset;
    }

    public function getFileTypeAssociations(Attachment $attachment, $firewall = 'member')
    {
        $router = $this->container->get('router');
        $request = $this->requestStack->getCurrentRequest();
        
        $baseURL = $router->generate('base_route', [], UrlGeneratorInterface::ABSOLUTE_URL);
    
        $assetDetails = [
            'id' => $attachment->getId(),
            'name' => $attachment->getName(),
            'path' => $baseURL . $attachment->getPath(),
            'relativePath' => $attachment->getPath(),
            'iconURL' => $baseURL . $this->getAssetIconURL($attachment),
            'downloadURL' => null,
        ];

        if ('member' == $firewall) {
            $assetDetails['downloadURL'] = $router->generate('helpdesk_member_ticket_download_attachment', [
                'attachmendId' => $attachment->getId(),
            ]);
        } else {
            $assetDetails['downloadURL'] = $router->generate('helpdesk_customer_download_ticket_attachment', [
                'attachmendId' => $attachment->getId(),
            ]);
        }

        return $assetDetails;
    }
}