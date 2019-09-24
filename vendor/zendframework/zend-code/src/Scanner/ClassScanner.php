<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Scanner;

use ReflectionClass;
use Zend\Code\Annotation;
use Zend\Code\Exception;
use Zend\Code\NameInformation;

use function array_key_exists;
use function array_merge;
use function array_search;
use function array_slice;
use function array_values;
use function define;
use function defined;
use function explode;
use function in_array;
use function is_array;
use function is_int;
use function is_object;
use function is_string;
use function ltrim;
use function sprintf;
use function substr_count;
use function trigger_error;

class ClassScanner implements ScannerInterface
{
    /**
     * @var bool
     */
    protected $isScanned = false;

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
    protected $shortName;

    /**
     * @var int
     */
    protected $lineStart;

    /**
     * @var int
     */
    protected $lineEnd;

    /**
     * @var bool
     */
    protected $isTrait = false;

    /**
     * @var bool
     */
    protected $isFinal = false;

    /**
     * @var bool
     */
    protected $isAbstract = false;

    /**
     * @var bool
     */
    protected $isInterface = false;

    /**
     * @var string
     */
    protected $parentClass;

    /**
     * @var string
     */
    protected $shortParentClass;

    /**
     * @var array
     */
    protected $interfaces = [];

    /**
     * @var array
     */
    protected $shortInterfaces = [];

    /**
     * @var array
     */
    protected $tokens = [];

    /**
     * @var NameInformation
     */
    protected $nameInformation;

    /**
     * @var array
     */
    protected $infos = [];

    /**
     * @var array
     */
    protected $traits = [];

    /**
     * @var array
     */
    protected $methods = [];

    /**
     * @param  array $classTokens
     * @param  NameInformation|null $nameInformation
     * @return ClassScanner
     */
    public function __construct(array $classTokens, NameInformation $nameInformation = null)
    {
        $this->tokens          = $classTokens;
        $this->nameInformation = $nameInformation;
    }

    /**
     * Get annotations
     *
     * @param  Annotation\AnnotationManager $annotationManager
     * @return Annotation\AnnotationCollection
     */
    public function getAnnotations(Annotation\AnnotationManager $annotationManager)
    {
        if (($docComment = $this->getDocComment()) == '') {
            return false;
        }

        return new AnnotationScanner($annotationManager, $docComment, $this->nameInformation);
    }

    /**
     * Return documentation comment
     *
     * @return null|string
     */
    public function getDocComment()
    {
        $this->scan();

        return $this->docComment;
    }

    /**
     * Return documentation block
     *
     * @return false|DocBlockScanner
     */
    public function getDocBlock()
    {
        if (! $docComment = $this->getDocComment()) {
            return false;
        }

        return new DocBlockScanner($docComment);
    }

    /**
     * Return a name of class
     *
     * @return null|string
     */
    public function getName()
    {
        $this->scan();
        return $this->name;
    }

    /**
     * Return short name of class
     *
     * @return null|string
     */
    public function getShortName()
    {
        $this->scan();
        return $this->shortName;
    }

    /**
     * Return number of first line
     *
     * @return int|null
     */
    public function getLineStart()
    {
        $this->scan();
        return $this->lineStart;
    }

    /**
     * Return number of last line
     *
     * @return int|null
     */
    public function getLineEnd()
    {
        $this->scan();
        return $this->lineEnd;
    }

    /**
     * Verify if class is final
     *
     * @return bool
     */
    public function isFinal()
    {
        $this->scan();
        return $this->isFinal;
    }

    /**
     * Verify if class is a trait
     *
     * @return bool
     */
    public function isTrait()
    {
        $this->scan();
        return $this->isTrait;
    }

    /**
     * Verify if class is instantiable
     *
     * @return bool
     */
    public function isInstantiable()
    {
        $this->scan();
        return ! $this->isAbstract && ! $this->isInterface && ! $this->isTrait;
    }

    /**
     * Verify if class is an abstract class
     *
     * @return bool
     */
    public function isAbstract()
    {
        $this->scan();
        return $this->isAbstract;
    }

    /**
     * Verify if class is an interface
     *
     * @return bool
     */
    public function isInterface()
    {
        $this->scan();
        return $this->isInterface;
    }

    /**
     * Verify if class has parent
     *
     * @return bool
     */
    public function hasParentClass()
    {
        $this->scan();
        return $this->parentClass !== null;
    }

    /**
     * Return a name of parent class
     *
     * @return null|string
     */
    public function getParentClass()
    {
        $this->scan();
        return $this->parentClass;
    }

    /**
     * Return a list of interface names
     *
     * @return array
     */
    public function getInterfaces()
    {
        $this->scan();
        return $this->interfaces;
    }

    /**
     * Return a list of constant names
     *
     * @return array
     */
    public function getConstantNames()
    {
        $this->scan();

        $return = [];
        foreach ($this->infos as $info) {
            if ($info['type'] != 'constant') {
                continue;
            }

            $return[] = $info['name'];
        }

        return $return;
    }

    /**
     * Return a list of constants
     *
     * @param  bool $namesOnly Set false to return instances of ConstantScanner
     * @return array|ConstantScanner[]
     */
    public function getConstants($namesOnly = true)
    {
        if (true === $namesOnly) {
            trigger_error('Use method getConstantNames() instead', E_USER_DEPRECATED);
            return $this->getConstantNames();
        }

        $this->scan();

        $return = [];
        foreach ($this->infos as $info) {
            if ($info['type'] != 'constant') {
                continue;
            }

            $return[] = $this->getConstant($info['name']);
        }

        return $return;
    }

    /**
     * Return a single constant by given name or index of info
     *
     * @param  string|int $constantNameOrInfoIndex
     * @throws Exception\InvalidArgumentException
     * @return bool|ConstantScanner
     */
    public function getConstant($constantNameOrInfoIndex)
    {
        $this->scan();

        if (is_int($constantNameOrInfoIndex)) {
            $info = $this->infos[$constantNameOrInfoIndex];
            if ($info['type'] != 'constant') {
                throw new Exception\InvalidArgumentException('Index of info offset is not about a constant');
            }
        } elseif (is_string($constantNameOrInfoIndex)) {
            $constantFound = false;
            foreach ($this->infos as $info) {
                if ($info['type'] === 'constant' && $info['name'] === $constantNameOrInfoIndex) {
                    $constantFound = true;
                    break;
                }
            }
            if (! $constantFound) {
                return false;
            }
        } else {
            throw new Exception\InvalidArgumentException(
                'Invalid constant name of info index type.  Must be of type int or string'
            );
        }
        if (! isset($info)) {
            return false;
        }
        $p = new ConstantScanner(
            array_slice($this->tokens, $info['tokenStart'], $info['tokenEnd'] - $info['tokenStart'] + 1),
            $this->nameInformation
        );
        $p->setClass($this->name);
        $p->setScannerClass($this);
        return $p;
    }

    /**
     * Verify if class has constant
     *
     * @param  string $name
     * @return bool
     */
    public function hasConstant($name)
    {
        $this->scan();

        foreach ($this->infos as $info) {
            if ($info['type'] === 'constant' && $info['name'] === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return a list of property names
     *
     * @return array
     */
    public function getPropertyNames()
    {
        $this->scan();

        $return = [];
        foreach ($this->infos as $info) {
            if ($info['type'] != 'property') {
                continue;
            }

            $return[] = $info['name'];
        }

        return $return;
    }

    /**
     * Return a list of properties
     *
     * @return PropertyScanner[]
     */
    public function getProperties()
    {
        $this->scan();

        $return = [];
        foreach ($this->infos as $info) {
            if ($info['type'] != 'property') {
                continue;
            }

            $return[] = $this->getProperty($info['name']);
        }

        return $return;
    }

    /**
     * Return a single property by given name or index of info
     *
     * @param  string|int $propertyNameOrInfoIndex
     * @throws Exception\InvalidArgumentException
     * @return bool|PropertyScanner
     */
    public function getProperty($propertyNameOrInfoIndex)
    {
        $this->scan();

        if (is_int($propertyNameOrInfoIndex)) {
            $info = $this->infos[$propertyNameOrInfoIndex];
            if ($info['type'] != 'property') {
                throw new Exception\InvalidArgumentException('Index of info offset is not about a property');
            }
        } elseif (is_string($propertyNameOrInfoIndex)) {
            $propertyFound = false;
            foreach ($this->infos as $info) {
                if ($info['type'] === 'property' && $info['name'] === $propertyNameOrInfoIndex) {
                    $propertyFound = true;
                    break;
                }
            }
            if (! $propertyFound) {
                return false;
            }
        } else {
            throw new Exception\InvalidArgumentException(
                'Invalid property name of info index type.  Must be of type int or string'
            );
        }
        if (! isset($info)) {
            return false;
        }
        $p = new PropertyScanner(
            array_slice($this->tokens, $info['tokenStart'], $info['tokenEnd'] - $info['tokenStart'] + 1),
            $this->nameInformation
        );
        $p->setClass($this->name);
        $p->setScannerClass($this);
        return $p;
    }

    /**
     * Verify if class has property
     *
     * @param  string $name
     * @return bool
     */
    public function hasProperty($name)
    {
        $this->scan();

        foreach ($this->infos as $info) {
            if ($info['type'] === 'property' && $info['name'] === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Retrieve any traits used by the class.
     *
     * @return ClassScanner[]
     */
    public function getTraits()
    {
        if (! empty($this->traits)) {
            return $this->traits;
        }

        // get list of trait names
        $traitNames = $this->getTraitNames();
        foreach ($traitNames as $traitName) {
            $r = new ReflectionClass($traitName);
            if (! $r->isTrait()) {
                throw new Exception\RuntimeException(sprintf(
                    'Non-trait class detected as a trait: %s',
                    $traitName
                ));
            }
            $fileName = $r->getFileName();

            $file = new FileScanner($fileName);
            $this->traits[] = $file->getClass($traitName);
        }

        return $this->traits;
    }

    /**
     * Retrieve a list of trait names used by this class.
     *
     * @return array
     */
    public function getTraitNames()
    {
        $this->scan();

        $return = [];
        foreach ($this->infos as $info) {
            if ($info['type'] !== 'use') {
                continue;
            }

            if (is_array($info['use_statements'])) {
                foreach ($info['use_statements'] as $trait) {
                    $traitName = $trait;
                    if ($this->nameInformation instanceof NameInformation) {
                        $traitName = $this->nameInformation->resolveName($traitName);
                    }
                    $return[] = $traitName;
                }
            }
        }

        return $return;
    }

    /**
     * Retrieve a list of aliased traits used by the class.
     *
     * @return array
     */
    public function getTraitAliases()
    {
        $this->scan();

        $return = [];
        foreach ($this->infos as $info) {
            if ($info['type'] !== 'use') {
                continue;
            }

            if (is_array($info['aliases'])) {
                foreach ($info['aliases'] as $alias) {
                    if (null === $alias
                        || (! empty($alias['type']) && $alias['type'] !== 'as')
                    ) {
                        continue;
                    }

                    // attempt to get fqcn
                    list($trait, $method) = explode('::', $alias['original']);
                    if ($this->nameInformation instanceof NameInformation) {
                        $trait = $this->nameInformation->resolveName($trait);
                    }

                    $return[$alias['alias']] = $trait . '::' . $method;
                }
            }
        }

        return $return;
    }

    /**
     * Retrieve visibility for a given alias.
     *
     * @param mixed $aliasName
     * @return string
     */
    protected function getVisibilityForAlias($aliasName)
    {
        $this->scan();

        $return = null;
        foreach ($this->infos as $info) {
            if ($info['type'] !== 'use') {
                continue;
            }

            if (is_array($info['aliases'])) {
                foreach ($info['aliases'] as $alias) {
                    if (null === $alias
                        && (! empty($alias['type']) && $alias['type'] !== 'as')
                    ) {
                        continue;
                    }

                    if ($alias['alias'] === $aliasName) {
                        $return = $alias['visibility'];
                        break 2;
                    }
                }
            }
        }

        return $return;
    }

    /**
     * Return an array of key = trait to keep, value = trait::method to ignore
     *
     * @return array
     */
    protected function getBlockedTraitMethods()
    {
        $this->scan();

        $return = [];
        foreach ($this->infos as $info) {
            if ($info['type'] !== 'use') {
                continue;
            }

            if (is_array($info['aliases'])) {
                foreach ($info['aliases'] as $alias) {
                    if (null === $alias
                        || (! empty($alias['type']) && $alias['type'] !== 'insteadof')
                    ) {
                        continue;
                    }

                    // attempt to get fqcn
                    list($trait, $method) = explode('::', $alias['original']);
                    if ($this->nameInformation instanceof NameInformation) {
                        $trait = $this->nameInformation->resolveName($alias['alias']);
                    }

                    $return[] = $trait . '::' . $method;
                }
            }
        }

        return $return;
    }

    /**
     * Return a list of method names
     *
     * @return array
     */
    public function getMethodNames()
    {
        $this->scan();

        $methods = $this->getMethods();
        $return = [];
        foreach ($methods as $method) {
            $return[] = $method->getName();
        }

        return $return;
    }

    /**
     * Return a list of methods
     *
     * @return MethodScanner[]
     */
    public function getMethods()
    {
        $this->scan();

        if (! empty($this->methods)) {
            return $this->methods;
        }

        foreach ($this->infos as $info) {
            if ($info['type'] !== 'method' && $info['type'] !== 'use') {
                continue;
            }

            // Merge in trait methods
            if ($info['type'] === 'use') {
                $traitMethods = [];
                $traits       = $this->getTraits();
                $insteadof    = $this->getBlockedTraitMethods();
                $aliases      = $this->getTraitAliases();

                foreach ($traits as $trait) {
                    $tempMethods = $trait->getMethods();
                    foreach ($tempMethods as $tempMethod) {
                        $methodFullName = $trait->getName() . '::' . $tempMethod->getName();
                        $methodAlias = array_search($methodFullName, $aliases);

                        if (false !== $methodAlias) {
                            // trait::method is aliased
                            // clone the tempMethod as we need to change
                            // the name and possibly the visibility of the
                            // scanned method.
                            //
                            // @todo setName and setVisibility were added to
                            // MethodScanner to accomplish this, may not be the
                            // best option, could use ReflectionClass instead?
                            $newMethod = clone $tempMethod;
                            $newMethod->setName($methodAlias);

                            // if visibility exists, change it on the MethodScanner
                            $visibility = $this->getVisibilityForAlias($methodAlias);
                            if (null !== $visibility) {
                                $newMethod->setVisibility($visibility);
                            }
                            $traitMethods[$methodAlias] = $newMethod;
                        } elseif (in_array($methodFullName, $insteadof)) {
                            // ignore overridden methods
                            continue;
                        } else {
                            if (array_key_exists($tempMethod->getName(), $traitMethods)) {
                                throw new Exception\RuntimeException(sprintf(
                                    'Trait method %s has not been applied because there are'
                                    . ' collisions with other trait methods see: (insteadof OR as)',
                                    $tempMethod->getName()
                                ));
                            }

                            $traitMethods[$tempMethod->getName()] = $tempMethod;
                        }
                    }
                }

                $this->methods = array_merge($this->methods, array_values($traitMethods));
                continue;
            }

            $m = new MethodScanner(
                array_slice(
                    $this->tokens,
                    $info['tokenStart'],
                    $info['tokenEnd'] - $info['tokenStart'] + 1
                ),
                $this->nameInformation
            );
            $m->setClass($this->name);
            $m->setScannerClass($this);

            $this->methods[] = $m;
        }

        return $this->methods;
    }

    /**
     * Return a single method by given name or index of info
     *
     * @param  string|int $methodNameOrInfoIndex
     * @throws Exception\InvalidArgumentException
     * @return MethodScanner
     */
    public function getMethod($methodNameOrInfoIndex)
    {
        $this->scan();

        if (is_int($methodNameOrInfoIndex)) {
            $info = $this->infos[$methodNameOrInfoIndex];
            if ($info['type'] != 'method') {
                throw new Exception\InvalidArgumentException('Index of info offset is not about a method');
            }
            $methodNameOrInfoIndex = $info['name'];
        }

        $returnMethod = false;
        $methods = $this->getMethods();
        foreach ($methods as $method) {
            if ($method->getName() === $methodNameOrInfoIndex) {
                $returnMethod = $method;
                break;
            }
        }

        return $returnMethod;
    }

    /**
     * Verify if class has method by given name
     *
     * @param  string $name
     * @return bool
     */
    public function hasMethod($name)
    {
        $this->scan();

        return is_object($this->getMethod($name));
    }

    public static function export()
    {
        // @todo
    }

    public function __toString()
    {
        // @todo
    }

    /**
     * Scan tokens
     *
     * @return void
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
        $tokens       = &$this->tokens; // localize
        $infos        = &$this->infos; // localize
        $tokenIndex   = null;
        $token        = null;
        $tokenType    = null;
        $tokenContent = null;
        $tokenLine    = null;
        $namespace    = null;
        $infoIndex    = 0;
        $braceCount   = 0;

        /*
         * MACRO creation
         */
        $MACRO_TOKEN_ADVANCE = function () use (
            &$tokens,
            &$tokenIndex,
            &$token,
            &$tokenType,
            &$tokenContent,
            &$tokenLine
        ) {
            static $lastTokenArray = null;
            $tokenIndex = $tokenIndex === null ? 0 : $tokenIndex + 1;
            if (! isset($tokens[$tokenIndex])) {
                $token        = false;
                $tokenContent = false;
                $tokenType    = false;
                $tokenLine    = false;

                return false;
            }
            $token = $tokens[$tokenIndex];

            if (is_string($token)) {
                $tokenType    = null;
                $tokenContent = $token;
                $tokenLine    = $tokenLine + substr_count(
                    $lastTokenArray[1],
                    "\n"
                ); // adjust token line by last known newline count
            } else {
                $lastTokenArray = $token;
                list($tokenType, $tokenContent, $tokenLine) = $token;
            }

            return $tokenIndex;
        };
        $MACRO_INFO_ADVANCE  = function () use (&$infoIndex, &$infos, &$tokenIndex, &$tokenLine) {
            $infos[$infoIndex]['tokenEnd'] = $tokenIndex;
            $infos[$infoIndex]['lineEnd']  = $tokenLine;
            $infoIndex++;

            return $infoIndex;
        };

        /**
         * START FINITE STATE MACHINE FOR SCANNING TOKENS
         */
        // Initialize token
        $MACRO_TOKEN_ADVANCE();

        SCANNER_TOP:

        switch ($tokenType) {
            case T_DOC_COMMENT:
                $this->docComment = $tokenContent;
                goto SCANNER_CONTINUE;
                //goto no break needed

            case T_FINAL:
            case T_ABSTRACT:
            case T_CLASS:
            case T_INTERFACE:
            case T_TRAIT:
                // CLASS INFORMATION

                $classContext        = null;
                $classInterfaceIndex = 0;

                SCANNER_CLASS_INFO_TOP:

                if (is_string($tokens[$tokenIndex + 1]) && $tokens[$tokenIndex + 1] === '{') {
                    goto SCANNER_CLASS_INFO_END;
                }

                $this->lineStart = $tokenLine;

                switch ($tokenType) {
                    case T_FINAL:
                        $this->isFinal = true;
                        goto SCANNER_CLASS_INFO_CONTINUE;
                        // goto no break needed

                    case T_ABSTRACT:
                        $this->isAbstract = true;
                        goto SCANNER_CLASS_INFO_CONTINUE;
                        // goto no break needed

                    case T_TRAIT:
                        $this->isTrait = true;
                        $this->shortName = $tokens[$tokenIndex + 2][1];
                        if ($this->nameInformation && $this->nameInformation->hasNamespace()) {
                            $this->name = $this->nameInformation->getNamespace() . '\\' . $this->shortName;
                        } else {
                            $this->name = $this->shortName;
                        }
                        goto SCANNER_CLASS_INFO_CONTINUE;
                        // goto no break needed

                    case T_INTERFACE:
                        $this->isInterface = true;
                        // fall-through
                    case T_CLASS:
                        $this->shortName = $tokens[$tokenIndex + 2][1];
                        if ($this->nameInformation && $this->nameInformation->hasNamespace()) {
                            $this->name = $this->nameInformation->getNamespace() . '\\' . $this->shortName;
                        } else {
                            $this->name = $this->shortName;
                        }
                        goto SCANNER_CLASS_INFO_CONTINUE;
                        // goto no break needed

                    case T_NS_SEPARATOR:
                    case T_STRING:
                        switch ($classContext) {
                            case T_EXTENDS:
                                if ($this->isInterface) {
                                    $this->shortInterfaces[$classInterfaceIndex] .= $tokenContent;
                                } else {
                                    $this->shortParentClass .= $tokenContent;
                                }
                                break;
                            case T_IMPLEMENTS:
                                $this->shortInterfaces[$classInterfaceIndex] .= $tokenContent;
                                break;
                        }
                        goto SCANNER_CLASS_INFO_CONTINUE;
                        // goto no break needed

                    case T_EXTENDS:
                    case T_IMPLEMENTS:
                        $classContext = $tokenType;
                        if (($this->isInterface && $classContext === T_EXTENDS) || $classContext === T_IMPLEMENTS) {
                            $this->shortInterfaces[$classInterfaceIndex] = '';
                        } elseif (! $this->isInterface && $classContext === T_EXTENDS) {
                            $this->shortParentClass = '';
                        }
                        goto SCANNER_CLASS_INFO_CONTINUE;
                        // goto no break needed

                    case null:
                        if (($classContext == T_IMPLEMENTS && $tokenContent == ',')
                            || ($classContext == T_EXTENDS && $tokenContent == ',' && $this->isInterface)
                        ) {
                            $classInterfaceIndex++;
                            $this->shortInterfaces[$classInterfaceIndex] = '';
                        }
                }

                SCANNER_CLASS_INFO_CONTINUE:

                if ($MACRO_TOKEN_ADVANCE() === false) {
                    goto SCANNER_END;
                }
                goto SCANNER_CLASS_INFO_TOP;

                SCANNER_CLASS_INFO_END:

                goto SCANNER_CONTINUE;
        }

        if ($tokenType === null && $tokenContent === '{' && $braceCount === 0) {
            $braceCount++;
            if ($MACRO_TOKEN_ADVANCE() === false) {
                goto SCANNER_END;
            }

            SCANNER_CLASS_BODY_TOP:

            if ($braceCount === 0) {
                goto SCANNER_CLASS_BODY_END;
            }

            switch ($tokenType) {
                case T_CONST:
                    $infos[$infoIndex] = [
                        'type'          => 'constant',
                        'tokenStart'    => $tokenIndex,
                        'tokenEnd'      => null,
                        'lineStart'     => $tokenLine,
                        'lineEnd'       => null,
                        'name'          => null,
                        'value'         => null,
                    ];

                    SCANNER_CLASS_BODY_CONST_TOP:

                    if ($tokenContent === ';') {
                        goto SCANNER_CLASS_BODY_CONST_END;
                    }

                    if ($tokenType === T_STRING && null === $infos[$infoIndex]['name']) {
                        $infos[$infoIndex]['name'] = $tokenContent;
                    }

                    SCANNER_CLASS_BODY_CONST_CONTINUE:

                    if ($MACRO_TOKEN_ADVANCE() === false) {
                        goto SCANNER_END;
                    }
                    goto SCANNER_CLASS_BODY_CONST_TOP;

                    SCANNER_CLASS_BODY_CONST_END:

                    $MACRO_INFO_ADVANCE();
                    goto SCANNER_CLASS_BODY_CONTINUE;
                    // goto no break needed

                case T_USE:
                    // ensure php backwards compatibility
                    if (! defined('T_INSTEADOF')) {
                        define('T_INSTEADOF', 24000);
                    }

                    $infos[$infoIndex] = [
                        'type'           => 'use',
                        'tokenStart'     => $tokenIndex,
                        'tokenEnd'       => null,
                        'lineStart'      => $tokens[$tokenIndex][2],
                        'lineEnd'        => null,
                        'name'           => $namespace,
                        'use_statements' => [0 => null],
                        'aliases'        => [0 => null],
                    ];

                    $isOriginalName = [T_STRING, T_DOUBLE_COLON];
                    $isAlias        = [T_STRING];
                    $isVisibility   = [T_PRIVATE, T_PROTECTED, T_PUBLIC, T_STATIC];
                    $isAliasType    = [T_AS, T_INSTEADOF];
                    $isValidAlias   = array_merge($isOriginalName, $isAlias, $isVisibility, $isAliasType);

                    $useStatementIndex   = 0;
                    $aliasStatementIndex = 0;
                    $useAliasContext     = false;
                    $useAsContext        = false;

                    // start processing with next token
                    if ($MACRO_TOKEN_ADVANCE() === false) {
                        goto SCANNER_END;
                    }

                    SCANNER_USE_TOP:

                    if ($tokenType === null) {
                        if ($tokenContent === '{') {
                            $useStatementIndex = 0;
                            $useAliasContext   = true;
                            $infos[$infoIndex]['aliases'][$useStatementIndex] = [
                                'original'   => null,
                                'alias'      => null,
                                'visibility' => null,
                                'type'       => 'as',
                            ];
                        } elseif ($tokenContent === '}') {
                            $useAliasContext = false;
                            goto SCANNER_USE_END;
                        } elseif ($tokenContent === ';') {
                            if ($useAliasContext === true) {
                                $useStatementIndex++;
                                $useAsContext = false;
                            }
                            // only end if we aren't inside braces
                            if (false === $useAliasContext) {
                                goto SCANNER_USE_END;
                            }
                        } elseif ($tokenContent === ',') {
                            $useStatementIndex++;
                            $infos[$infoIndex]['use_statements'][$useStatementIndex] = '';
                        }
                    }

                    // ANALYZE
                    if ($tokenType !== null) {
                        // use context
                        if (false === $useAliasContext) {
                            if ($tokenType == T_NS_SEPARATOR || $tokenType == T_STRING) {
                                $infos[$infoIndex]['use_statements'][$useStatementIndex] .= $tokenContent;
                            }
                        } else {
                            if (in_array($tokenType, $isValidAlias)
                                && empty($infos[$infoIndex]['aliases'][$useStatementIndex])
                            ) {
                                $infos[$infoIndex]['aliases'][$useStatementIndex] = [
                                    'original'   => null,
                                    'visibility' => null,
                                    'alias'      => null,
                                    'type'       => null,
                                ];
                            }

                            if ($tokenType == T_AS || $tokenType == T_INSTEADOF) {
                                $useAsContext = true;
                                $infos[$infoIndex]['aliases'][$useStatementIndex]['type'] = $tokenType == T_INSTEADOF
                                    ? 'insteadof'
                                    : 'as';
                                goto SCANNER_USE_CONTINUE;
                            }

                            // in alias context
                            if ($useAsContext === true && in_array($tokenType, $isAlias)) {
                                $infos[$infoIndex]['aliases'][$useStatementIndex]['alias'] = $tokenContent;
                            } elseif (in_array($tokenType, $isOriginalName)) {
                                $infos[$infoIndex]['aliases'][$useStatementIndex]['original'] .= $tokenContent;
                            } elseif (in_array($tokenType, $isVisibility)) {
                                //add whitespace (will trim later)
                                $infos[$infoIndex]['aliases'][$useStatementIndex]['visibility'] = $tokenType;
                            }
                        }
                    }

                    SCANNER_USE_CONTINUE:

                    if ($MACRO_TOKEN_ADVANCE() === false) {
                        goto SCANNER_END;
                    }
                    goto SCANNER_USE_TOP;

                    SCANNER_USE_END:

                    $MACRO_INFO_ADVANCE();
                    goto SCANNER_CLASS_BODY_CONTINUE;
                    // goto no break needed

                case T_DOC_COMMENT:
                case T_PUBLIC:
                case T_PROTECTED:
                case T_PRIVATE:
                case T_ABSTRACT:
                case T_FINAL:
                case T_VAR:
                case T_FUNCTION:
                    $infos[$infoIndex] = [
                        'type'        => null,
                        'tokenStart'  => $tokenIndex,
                        'tokenEnd'    => null,
                        'lineStart'   => $tokenLine,
                        'lineEnd'     => null,
                        'name'        => null,
                    ];

                    $memberContext     = null;
                    $methodBodyStarted = false;

                    SCANNER_CLASS_BODY_MEMBER_TOP:

                    if ($memberContext === 'method') {
                        switch ($tokenContent) {
                            case '{':
                                $methodBodyStarted = true;
                                $braceCount++;
                                goto SCANNER_CLASS_BODY_MEMBER_CONTINUE;
                                // goto no break needed

                            case '}':
                                $braceCount--;
                                goto SCANNER_CLASS_BODY_MEMBER_CONTINUE;
                                // goto no break needed

                            case ';':
                                $infos[$infoIndex]['tokenEnd'] = $tokenIndex;
                                goto SCANNER_CLASS_BODY_MEMBER_CONTINUE;
                                // goto no break needed
                        }
                    }

                    if ($memberContext !== null) {
                        if (($memberContext === 'property' && $tokenContent === ';')
                            || ($memberContext === 'method' && $methodBodyStarted && $braceCount === 1)
                            || ($memberContext === 'method' && $this->isInterface && $tokenContent === ';')
                        ) {
                            goto SCANNER_CLASS_BODY_MEMBER_END;
                        }
                    }

                    switch ($tokenType) {
                        case T_CONST:
                            $memberContext             = 'constant';
                            $infos[$infoIndex]['type'] = 'constant';
                            goto SCANNER_CLASS_BODY_CONST_CONTINUE;
                            //goto no break needed

                        case T_VARIABLE:
                            if ($memberContext === null) {
                                $memberContext             = 'property';
                                $infos[$infoIndex]['type'] = 'property';
                                $infos[$infoIndex]['name'] = ltrim($tokenContent, '$');
                            }
                            goto SCANNER_CLASS_BODY_MEMBER_CONTINUE;
                            // goto no break needed

                        case T_FUNCTION:
                            $memberContext             = 'method';
                            $infos[$infoIndex]['type'] = 'method';
                            goto SCANNER_CLASS_BODY_MEMBER_CONTINUE;
                            // goto no break needed

                        case T_STRING:
                            if ($memberContext === 'method' && null === $infos[$infoIndex]['name']) {
                                $infos[$infoIndex]['name'] = $tokenContent;
                            }
                            goto SCANNER_CLASS_BODY_MEMBER_CONTINUE;
                            // goto no break needed
                    }

                    SCANNER_CLASS_BODY_MEMBER_CONTINUE:

                    if ($MACRO_TOKEN_ADVANCE() === false) {
                        goto SCANNER_END;
                    }
                    goto SCANNER_CLASS_BODY_MEMBER_TOP;

                    SCANNER_CLASS_BODY_MEMBER_END:

                    $memberContext = null;
                    $MACRO_INFO_ADVANCE();
                    goto SCANNER_CLASS_BODY_CONTINUE;
                    // goto no break needed

                case null: // no type, is a string
                    switch ($tokenContent) {
                        case '{':
                            $braceCount++;
                            goto SCANNER_CLASS_BODY_CONTINUE;
                            // goto no break needed

                        case '}':
                            $braceCount--;
                            goto SCANNER_CLASS_BODY_CONTINUE;
                            // goto no break needed
                    }
            }

            SCANNER_CLASS_BODY_CONTINUE:

            if ($braceCount === 0 || $MACRO_TOKEN_ADVANCE() === false) {
                goto SCANNER_CONTINUE;
            }
            goto SCANNER_CLASS_BODY_TOP;

            SCANNER_CLASS_BODY_END:

            goto SCANNER_CONTINUE;
        }

        SCANNER_CONTINUE:

        if ($tokenContent === '}') {
            $this->lineEnd = $tokenLine;
        }

        if ($MACRO_TOKEN_ADVANCE() === false) {
            goto SCANNER_END;
        }
        goto SCANNER_TOP;

        SCANNER_END:

        // process short names
        if ($this->nameInformation) {
            if ($this->shortParentClass) {
                $this->parentClass = $this->nameInformation->resolveName($this->shortParentClass);
            }
            if ($this->shortInterfaces) {
                foreach ($this->shortInterfaces as $siIndex => $si) {
                    $this->interfaces[$siIndex] = $this->nameInformation->resolveName($si);
                }
            }
        } else {
            $this->parentClass = $this->shortParentClass;
            $this->interfaces  = $this->shortInterfaces;
        }

        $this->isScanned = true;
    }
}
