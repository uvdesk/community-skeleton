<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Scanner;

use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Exception;

use function file_exists;
use function file_get_contents;
use function sprintf;
use function token_get_all;

class FileScanner extends TokenArrayScanner implements ScannerInterface
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @param  string $file
     * @param  null|AnnotationManager $annotationManager
     * @throws Exception\InvalidArgumentException
     */
    public function __construct($file, AnnotationManager $annotationManager = null)
    {
        $this->file = $file;
        if (! file_exists($file)) {
            throw new Exception\InvalidArgumentException(sprintf(
                'File "%s" not found',
                $file
            ));
        }
        parent::__construct(token_get_all(file_get_contents($file)), $annotationManager);
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
}
