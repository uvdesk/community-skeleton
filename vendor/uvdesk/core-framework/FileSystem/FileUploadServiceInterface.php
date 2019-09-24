<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\FileSystem;

use PhpMimeMailParser\Attachment;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploadServiceInterface
{
    public function uploadFile(UploadedFile $temporaryFile, $prefix = null, bool $renameFile = true);
    public function uploadEmailAttachment(Attachment $attachmentStream, $prefix = null, bool $renameFile = true);
}