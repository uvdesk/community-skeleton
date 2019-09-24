<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Scanner;

use Zend\Code\Annotation;
use Zend\Code\Exception;
use Zend\Code\NameInformation;

use function current;
use function is_string;
use function next;
use function reset;
use function strtolower;
use function substr;
use function strpos;
use function var_export;

class ConstantScanner implements ScannerInterface
{
    /**
     * @var bool
     */
    protected $isScanned = false;

    /**
     * @var array
     */
    protected $tokens;

    /**
     * @var NameInformation
     */
    protected $nameInformation;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var ClassScanner
     */
    protected $scannerClass;

    /**
     * @var int
     */
    protected $lineStart;

    /**
     * @var string
     */
    protected $docComment;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * Constructor
     *
     * @param array $constantTokens
     * @param NameInformation $nameInformation
     */
    public function __construct(array $constantTokens, NameInformation $nameInformation = null)
    {
        $this->tokens = $constantTokens;
        $this->nameInformation = $nameInformation;
    }

    /**
     * @param string $class
     */
    public function setClass($class)
    {
        $this->class = $class;
    }

    /**
     * @param ClassScanner $scannerClass
     */
    public function setScannerClass(ClassScanner $scannerClass)
    {
        $this->scannerClass = $scannerClass;
    }

    /**
     * @return ClassScanner
     */
    public function getClassScanner()
    {
        return $this->scannerClass;
    }

    /**
     * @return string
     */
    public function getName()
    {
        $this->scan();
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        $this->scan();
        return $this->value;
    }

    /**
     * @return string
     */
    public function getDocComment()
    {
        $this->scan();
        return $this->docComment;
    }

    /**
     * @param Annotation\AnnotationManager $annotationManager
     * @return AnnotationScanner
     */
    public function getAnnotations(Annotation\AnnotationManager $annotationManager)
    {
        if (($docComment = $this->getDocComment()) == '') {
            return false;
        }

        return new AnnotationScanner($annotationManager, $docComment, $this->nameInformation);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $this->scan();
        return var_export($this, true);
    }

    /**
     * Scan tokens
     *
     * @throws Exception\RuntimeException
     */
    protected function scan()
    {
        if ($this->isScanned) {
            return;
        }

        if (! $this->tokens) {
            throw new Exception\RuntimeException('No tokens were provided');
        }

        /**
         * Variables & Setup
         */
        $tokens = &$this->tokens;

        reset($tokens);

        SCANNER_TOP:

        $token = current($tokens);

        if (! is_string($token)) {
            list($tokenType, $tokenContent, $tokenLine) = $token;

            switch ($tokenType) {
                case T_DOC_COMMENT:
                    if ($this->docComment === null && $this->name === null) {
                        $this->docComment = $tokenContent;
                    }
                    goto SCANNER_CONTINUE;
                    // fall-through

                case T_STRING:
                    $string = is_string($token) ? $token : $tokenContent;

                    if (null === $this->name) {
                        $this->name = $string;
                    } else {
                        if ('self' == strtolower($string)) {
                            list($tokenNextType, $tokenNextContent, $tokenNextLine) = next($tokens);

                            if ('::' == $tokenNextContent) {
                                list($tokenNextType, $tokenNextContent, $tokenNextLine) = next($tokens);

                                if ($this->getClassScanner()->getConstant($tokenNextContent)) {
                                    $this->value = $this->getClassScanner()->getConstant($tokenNextContent)->getValue();
                                }
                            }
                        }
                    }

                    goto SCANNER_CONTINUE;
                    // fall-through

                case T_CONSTANT_ENCAPSED_STRING:
                case T_DNUMBER:
                case T_LNUMBER:
                    $string = is_string($token) ? $token : $tokenContent;

                    if (0 === strpos($string, '"') || 0 === strpos($string, "'")) {
                        $this->value = substr($string, 1, -1); // Remove quotes
                    } else {
                        $this->value = $string;
                    }
                    goto SCANNER_CONTINUE;
                    // fall-trough

                default:
                    goto SCANNER_CONTINUE;
            }
        }

        SCANNER_CONTINUE:

        if (next($this->tokens) === false) {
            goto SCANNER_END;
        }
        goto SCANNER_TOP;

        SCANNER_END:

        $this->isScanned = true;
    }
}
