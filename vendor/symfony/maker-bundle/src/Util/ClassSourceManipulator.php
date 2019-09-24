<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Util;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PhpParser\BuilderHelpers;
use PhpParser\Comment\Doc;
use PhpParser\Lexer;
use PhpParser\Node;
use PhpParser\Parser;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor;
use PhpParser\Builder;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\Doctrine\BaseCollectionRelation;
use Symfony\Bundle\MakerBundle\Doctrine\BaseRelation;
use Symfony\Bundle\MakerBundle\Doctrine\RelationManyToMany;
use Symfony\Bundle\MakerBundle\Doctrine\RelationManyToOne;
use Symfony\Bundle\MakerBundle\Doctrine\RelationOneToMany;
use Symfony\Bundle\MakerBundle\Doctrine\RelationOneToOne;
use Symfony\Bundle\MakerBundle\Str;

/**
 * @internal
 */
final class ClassSourceManipulator
{
    const CONTEXT_OUTSIDE_CLASS = 'outside_class';
    const CONTEXT_CLASS = 'class';
    const CONTEXT_CLASS_METHOD = 'class_method';

    private $overwrite;
    private $useAnnotations;
    private $fluentMutators;
    private $parser;
    private $lexer;
    private $printer;
    /** @var ConsoleStyle|null */
    private $io;

    private $sourceCode;
    private $oldStmts;
    private $oldTokens;
    private $newStmts;

    private $pendingComments = [];

    public function __construct(string $sourceCode, bool $overwrite = false, bool $useAnnotations = true, bool $fluentMutators = true)
    {
        $this->overwrite = $overwrite;
        $this->useAnnotations = $useAnnotations;
        $this->fluentMutators = $fluentMutators;
        $this->lexer = new Lexer\Emulative([
            'usedAttributes' => [
                'comments',
                'startLine', 'endLine',
                'startTokenPos', 'endTokenPos',
            ],
        ]);
        $this->parser = new Parser\Php7($this->lexer);
        $this->printer = new PrettyPrinter();

        $this->setSourceCode($sourceCode);
    }

    public function setIo(ConsoleStyle $io)
    {
        $this->io = $io;
    }

    public function getSourceCode(): string
    {
        return $this->sourceCode;
    }

    public function addEntityField(string $propertyName, array $columnOptions, array $comments = [])
    {
        $typeHint = $this->getEntityTypeHint($columnOptions['type']);
        $nullable = $columnOptions['nullable'] ?? false;
        $isId = (bool) ($columnOptions['id'] ?? false);

        $comments[] = $this->buildAnnotationLine('@ORM\Column', $columnOptions);
        $defaultValue = null;
        if ('array' === $typeHint) {
            $defaultValue = new Node\Expr\Array_([], ['kind' => Node\Expr\Array_::KIND_SHORT]);
        }
        $this->addProperty($propertyName, $comments, $defaultValue);

        $this->addGetter(
            $propertyName,
            $typeHint,
            // getter methods always have nullable return values
            // because even though these are required in the db, they may not be set yet
            true
        );

        // don't generate setters for id fields
        if (!$isId) {
            $this->addSetter($propertyName, $typeHint, $nullable);
        }
    }

    public function addEmbeddedEntity(string $propertyName, string $className)
    {
        $typeHint = $this->addUseStatementIfNecessary($className);

        $annotations = [
            $this->buildAnnotationLine(
                '@ORM\\Embedded',
                [
                    'class' => $className,
                ]
            ),
        ];

        $this->addProperty($propertyName, $annotations);

        // logic to avoid re-adding the same ArrayCollection line
        $addEmbedded = true;
        if ($this->getConstructorNode()) {
            // We print the constructor to a string, then
            // look for "$this->propertyName = "

            $constructorString = $this->printer->prettyPrint([$this->getConstructorNode()]);
            if (false !== strpos($constructorString, sprintf('$this->%s = ', $propertyName))) {
                $addEmbedded = false;
            }
        }

        if ($addEmbedded) {
            $this->addStatementToConstructor(
                new Node\Stmt\Expression(new Node\Expr\Assign(
                    new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $propertyName),
                    new Node\Expr\New_(new Node\Name($typeHint))
                ))
            );
        }

        $this->addGetter($propertyName, $typeHint, false);
        $this->addSetter($propertyName, $typeHint, false);
    }

    public function addManyToOneRelation(RelationManyToOne $manyToOne)
    {
        $this->addSingularRelation($manyToOne);
    }

    public function addOneToOneRelation(RelationOneToOne $oneToOne)
    {
        $this->addSingularRelation($oneToOne);
    }

    public function addOneToManyRelation(RelationOneToMany $oneToMany)
    {
        $this->addCollectionRelation($oneToMany);
    }

    public function addManyToManyRelation(RelationManyToMany $manyToMany)
    {
        $this->addCollectionRelation($manyToMany);
    }

    public function addInterface(string $interfaceName)
    {
        $this->addUseStatementIfNecessary($interfaceName);

        $this->getClassNode()->implements[] = new Node\Name(Str::getShortClassName($interfaceName));
        $this->updateSourceCodeFromNewStmts();
    }

    public function addAccessorMethod(string $propertyName, string $methodName, $returnType, bool $isReturnTypeNullable, array $commentLines = [], $typeCast = null)
    {
        $this->addCustomGetter($propertyName, $methodName, $returnType, $isReturnTypeNullable, $commentLines, $typeCast);
    }

    public function addGetter(string $propertyName, $returnType, bool $isReturnTypeNullable, array $commentLines = [])
    {
        $methodName = 'get'.Str::asCamelCase($propertyName);

        $this->addCustomGetter($propertyName, $methodName, $returnType, $isReturnTypeNullable, $commentLines);
    }

    public function addSetter(string $propertyName, $type, bool $isNullable, array $commentLines = [])
    {
        $builder = $this->createSetterNodeBuilder($propertyName, $type, $isNullable, $commentLines);
        $this->makeMethodFluent($builder);
        $this->addMethod($builder->getNode());
    }

    public function addMethodBuilder(Builder\Method $methodBuilder)
    {
        $this->addMethod($methodBuilder->getNode());
    }

    public function addMethodBody(Builder\Method $methodBuilder, string $methodBody)
    {
        $nodes = $this->parser->parse($methodBody);
        $methodBuilder->addStmts($nodes);
    }

    public function createMethodBuilder(string $methodName, $returnType, bool $isReturnTypeNullable, array $commentLines = []): Builder\Method
    {
        $methodNodeBuilder = (new Builder\Method($methodName))
            ->makePublic()
        ;

        if (null !== $returnType) {
            $methodNodeBuilder->setReturnType($isReturnTypeNullable ? new Node\NullableType($returnType) : $returnType);
        }

        if ($commentLines) {
            $methodNodeBuilder->setDocComment($this->createDocBlock($commentLines));
        }

        return $methodNodeBuilder;
    }

    public function createMethodLevelCommentNode(string $comment)
    {
        return $this->createSingleLineCommentNode($comment, self::CONTEXT_CLASS_METHOD);
    }

    public function createMethodLevelBlankLine()
    {
        return $this->createBlankLineNode(self::CONTEXT_CLASS_METHOD);
    }

    public function addProperty(string $name, array $annotationLines = [], $defaultValue = null)
    {
        if ($this->propertyExists($name)) {
            // we never overwrite properties
            return;
        }

        $newPropertyBuilder = (new Builder\Property($name))->makePrivate();
        if ($annotationLines && $this->useAnnotations) {
            $newPropertyBuilder->setDocComment($this->createDocBlock($annotationLines));
        }

        if (null !== $defaultValue) {
            $newPropertyBuilder->setDefault($defaultValue);
        }
        $newPropertyNode = $newPropertyBuilder->getNode();

        $this->addNodeAfterProperties($newPropertyNode);
    }

    public function addAnnotationToClass(string $annotationClass, array $options)
    {
        $annotationClassAlias = $this->addUseStatementIfNecessary($annotationClass);
        $docComment = $this->getClassNode()->getDocComment();

        $docLines = $docComment ? explode("\n", $docComment->getText()) : [];
        if (0 === \count($docLines)) {
            $docLines = ['/**', ' */'];
        } elseif (1 === \count($docLines)) {
            // /** inline doc syntax */
            // imperfect way to try to find where to split the lines
            $endOfOpening = strpos($docLines[0], '* ');
            $endingPosition = strrpos($docLines[0], ' *', $endOfOpening);
            $extraComments = trim(substr($docLines[0], $endOfOpening + 2, $endingPosition - $endOfOpening - 2));
            $newDocLines = [
                substr($docLines[0], 0, $endOfOpening + 1),
            ];

            if ($extraComments) {
                $newDocLines[] = ' * '.$extraComments;
            }

            $newDocLines[] = substr($docLines[0], $endingPosition);
            $docLines = $newDocLines;
        }

        array_splice(
            $docLines,
            \count($docLines) - 1,
            0,
            ' * '.$this->buildAnnotationLine('@'.$annotationClassAlias, $options)
        );

        $docComment = new Doc(implode("\n", $docLines));
        $this->getClassNode()->setDocComment($docComment);
        $this->updateSourceCodeFromNewStmts();
    }

    private function addCustomGetter(string $propertyName, string $methodName, $returnType, bool $isReturnTypeNullable, array $commentLines = [], $typeCast = null)
    {
        $propertyFetch = new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $propertyName);

        if (null !== $typeCast) {
            switch ($typeCast) {
                case 'string':
                    $propertyFetch = new Node\Expr\Cast\String_($propertyFetch);
                    break;
                default:
                    // implement other cases if/when the library needs them
                    throw new \Exception('Not implemented');
            }
        }

        $getterNodeBuilder = (new Builder\Method($methodName))
            ->makePublic()
            ->addStmt(
                new Node\Stmt\Return_($propertyFetch)
            )
        ;

        if (null !== $returnType) {
            $getterNodeBuilder->setReturnType($isReturnTypeNullable ? new Node\NullableType($returnType) : $returnType);
        }

        if ($commentLines) {
            $getterNodeBuilder->setDocComment($this->createDocBlock($commentLines));
        }

        $this->addMethod($getterNodeBuilder->getNode());
    }

    private function createSetterNodeBuilder(string $propertyName, $type, bool $isNullable, array $commentLines = [])
    {
        $methodName = 'set'.Str::asCamelCase($propertyName);
        $setterNodeBuilder = (new Builder\Method($methodName))->makePublic();

        if ($commentLines) {
            $setterNodeBuilder->setDocComment($this->createDocBlock($commentLines));
        }

        $paramBuilder = new Builder\Param($propertyName);
        if (null !== $type) {
            $paramBuilder->setTypeHint($isNullable ? new Node\NullableType($type) : $type);
        }
        $setterNodeBuilder->addParam($paramBuilder->getNode());

        $setterNodeBuilder->addStmt(
            new Node\Stmt\Expression(new Node\Expr\Assign(
                new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $propertyName),
                new Node\Expr\Variable($propertyName)
            ))
        );

        return $setterNodeBuilder;
    }

    /**
     * @param string $annotationClass The annotation: e.g. "@ORM\Column"
     * @param array  $options         Key-value pair of options for the annotation
     *
     * @return string
     */
    private function buildAnnotationLine(string $annotationClass, array $options)
    {
        $formattedOptions = array_map(function ($option, $value) {
            if (\is_array($value)) {
                if (!isset($value[0])) {
                    return sprintf('%s={%s}', $option, implode(', ', array_map(function ($val, $key) {
                        return sprintf('"%s" = %s', $key, $this->quoteAnnotationValue($val));
                    }, $value, array_keys($value))));
                }

                return sprintf('%s={%s}', $option, implode(', ', array_map(function ($val) {
                    return $this->quoteAnnotationValue($val);
                }, $value)));
            }

            return sprintf('%s=%s', $option, $this->quoteAnnotationValue($value));
        }, array_keys($options), array_values($options));

        return sprintf('%s(%s)', $annotationClass, implode(', ', $formattedOptions));
    }

    private function quoteAnnotationValue($value)
    {
        if (\is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (null === $value) {
            return 'null';
        }

        if (\is_int($value) || '0' === $value) {
            return $value;
        }

        if (\is_array($value)) {
            throw new \Exception('Invalid value: loop before quoting.');
        }

        return sprintf('"%s"', $value);
    }

    private function addSingularRelation(BaseRelation $relation)
    {
        $typeHint = $this->addUseStatementIfNecessary($relation->getTargetClassName());
        if ($relation->getTargetClassName() == $this->getThisFullClassName()) {
            $typeHint = 'self';
        }

        $annotationOptions = [
            'targetEntity' => $relation->getTargetClassName(),
        ];
        if ($relation->isOwning()) {
            // sometimes, we don't map the inverse relation
            if ($relation->getMapInverseRelation()) {
                $annotationOptions['inversedBy'] = $relation->getTargetPropertyName();
            }
        } else {
            $annotationOptions['mappedBy'] = $relation->getTargetPropertyName();
        }

        if ($relation instanceof RelationOneToOne) {
            $annotationOptions['cascade'] = ['persist', 'remove'];
        }

        $annotations = [
            $this->buildAnnotationLine(
                $relation instanceof RelationManyToOne ? '@ORM\\ManyToOne' : '@ORM\\OneToOne',
                $annotationOptions
            ),
        ];

        if (!$relation->isNullable() && $relation->isOwning()) {
            $annotations[] = $this->buildAnnotationLine('@ORM\\JoinColumn', [
                'nullable' => false,
            ]);
        }
        $this->addProperty($relation->getPropertyName(), $annotations);

        $this->addGetter(
            $relation->getPropertyName(),
            $typeHint,
            // getter methods always have nullable return values
            // because even though these are required in the db, they may not be set
            true
        );

        $setterNodeBuilder = $this->createSetterNodeBuilder(
            $relation->getPropertyName(),
            $typeHint,
            // make the type-hint nullable always for ManyToOne to allow the owning
            // side to be set to null, which is needed for orphanRemoval
            // (specifically: when you set the inverse side, the generated
            // code will *also* set the owning side to null - so it needs to be allowed)
            // e.g. $userAvatarPhoto->setUser(null);
            $relation instanceof RelationOneToOne ? $relation->isNullable() : true
        );

        // set the *owning* side of the relation
        // OneToOne is the only "singular" relation type that
        // may be the inverse side
        if ($relation instanceof RelationOneToOne && !$relation->isOwning()) {
            $setterNodeBuilder->addStmt($this->createBlankLineNode(self::CONTEXT_CLASS_METHOD));

            $this->addNodesToSetOtherSideOfOneToOne($relation, $setterNodeBuilder);
        }

        $this->makeMethodFluent($setterNodeBuilder);
        $this->addMethod($setterNodeBuilder->getNode());
    }

    private function addCollectionRelation(BaseCollectionRelation $relation)
    {
        $typeHint = $relation->isSelfReferencing() ? 'self' : $this->addUseStatementIfNecessary($relation->getTargetClassName());

        $arrayCollectionTypeHint = $this->addUseStatementIfNecessary(ArrayCollection::class);
        $collectionTypeHint = $this->addUseStatementIfNecessary(Collection::class);

        $annotationOptions = [
            'targetEntity' => $relation->getTargetClassName(),
        ];
        if ($relation->isOwning()) {
            // sometimes, we don't map the inverse relation
            if ($relation->getMapInverseRelation()) {
                $annotationOptions['inversedBy'] = $relation->getTargetPropertyName();
            }
        } else {
            $annotationOptions['mappedBy'] = $relation->getTargetPropertyName();
        }

        if ($relation->getOrphanRemoval()) {
            $annotationOptions['orphanRemoval'] = true;
        }

        $annotations = [
            $this->buildAnnotationLine(
                $relation instanceof RelationManyToMany ? '@ORM\\ManyToMany' : '@ORM\\OneToMany',
                $annotationOptions
            ),
        ];

        $this->addProperty($relation->getPropertyName(), $annotations);

        // logic to avoid re-adding the same ArrayCollection line
        $addArrayCollection = true;
        if ($this->getConstructorNode()) {
            // We print the constructor to a string, then
            // look for "$this->propertyName = "

            $constructorString = $this->printer->prettyPrint([$this->getConstructorNode()]);
            if (false !== strpos($constructorString, sprintf('$this->%s = ', $relation->getPropertyName()))) {
                $addArrayCollection = false;
            }
        }

        if ($addArrayCollection) {
            $this->addStatementToConstructor(
                new Node\Stmt\Expression(new Node\Expr\Assign(
                    new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $relation->getPropertyName()),
                    new Node\Expr\New_(new Node\Name($arrayCollectionTypeHint))
                ))
            );
        }

        $this->addGetter(
            $relation->getPropertyName(),
            $collectionTypeHint,
            false,
            // add @return that advertises this as a collection of specific objects
            [sprintf('@return %s|%s[]', $collectionTypeHint, $typeHint)]
        );

        $argName = Str::pluralCamelCaseToSingular($relation->getPropertyName());

        // adder method
        $adderNodeBuilder = (new Builder\Method($relation->getAdderMethodName()))->makePublic();

        $paramBuilder = new Builder\Param($argName);
        $paramBuilder->setTypeHint($typeHint);
        $adderNodeBuilder->addParam($paramBuilder->getNode());

        //if (!$this->avatars->contains($avatar))
        $containsMethodCallNode = new Node\Expr\MethodCall(
            new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $relation->getPropertyName()),
            'contains',
            [new Node\Expr\Variable($argName)]
        );
        $ifNotContainsStmt = new Node\Stmt\If_(
            new Node\Expr\BooleanNot($containsMethodCallNode)
        );
        $adderNodeBuilder->addStmt($ifNotContainsStmt);

        // append the item
        $ifNotContainsStmt->stmts[] = new Node\Stmt\Expression(
            new Node\Expr\Assign(
                new Node\Expr\ArrayDimFetch(
                    new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $relation->getPropertyName())
                ),
                new Node\Expr\Variable($argName)
            ))
        ;

        // set the owning side of the relationship
        if (!$relation->isOwning()) {
            $ifNotContainsStmt->stmts[] = new Node\Stmt\Expression(
                new Node\Expr\MethodCall(
                    new Node\Expr\Variable($argName),
                    $relation->getTargetSetterMethodName(),
                    [new Node\Expr\Variable('this')]
                )
            );
        }

        $this->makeMethodFluent($adderNodeBuilder);
        $this->addMethod($adderNodeBuilder->getNode());

        /*
         * Remover
         */
        $removerNodeBuilder = (new Builder\Method($relation->getRemoverMethodName()))->makePublic();

        $paramBuilder = new Builder\Param($argName);
        $paramBuilder->setTypeHint($typeHint);
        $removerNodeBuilder->addParam($paramBuilder->getNode());

        // add if check to see if item actually exists
        //if ($this->avatars->contains($avatar))
        $ifContainsStmt = new Node\Stmt\If_($containsMethodCallNode);
        $removerNodeBuilder->addStmt($ifContainsStmt);

        // call removeElement
        $ifContainsStmt->stmts[] = BuilderHelpers::normalizeStmt(new Node\Expr\MethodCall(
            new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $relation->getPropertyName()),
            'removeElement',
            [new Node\Expr\Variable($argName)]
        ));

        // set the owning side of the relationship
        if (!$relation->isOwning()) {
            if ($relation instanceof RelationOneToMany) {
                // OneToMany: $student->setCourse(null);
                /*
                 * // set the owning side to null (unless already changed)
                 * if ($student->getCourse() === $this) {
                 *     $student->setCourse(null);
                 * }
                 */

                $ifContainsStmt->stmts[] = $this->createSingleLineCommentNode(
                    'set the owning side to null (unless already changed)',
                    self::CONTEXT_CLASS_METHOD
                );

                // if ($student->getCourse() === $this) {
                $ifNode = new Node\Stmt\If_(new Node\Expr\BinaryOp\Identical(
                    new Node\Expr\MethodCall(
                        new Node\Expr\Variable($argName),
                        $relation->getTargetGetterMethodName()
                    ),
                    new Node\Expr\Variable('this')
                ));

                // $student->setCourse(null);
                $ifNode->stmts = [
                    new Node\Stmt\Expression(new Node\Expr\MethodCall(
                        new Node\Expr\Variable($argName),
                        $relation->getTargetSetterMethodName(),
                        [new Node\Arg($this->createNullConstant())]
                    )),
                ];

                $ifContainsStmt->stmts[] = $ifNode;
            } elseif ($relation instanceof RelationManyToMany) {
                // ManyToMany: $student->removeCourse($this);
                $ifContainsStmt->stmts[] = new Node\Stmt\Expression(new Node\Expr\MethodCall(
                    new Node\Expr\Variable($argName),
                    $relation->getTargetRemoverMethodName(),
                    [new Node\Expr\Variable('this')]
                ));
            } else {
                throw new \Exception('Unknown relation type');
            }
        }

        $this->makeMethodFluent($removerNodeBuilder);
        $this->addMethod($removerNodeBuilder->getNode());
    }

    private function addStatementToConstructor(Node\Stmt $stmt)
    {
        if (!$this->getConstructorNode()) {
            $constructorNode = (new Builder\Method('__construct'))->makePublic()->getNode();

            // add call to parent::__construct() if there is a need to
            try {
                $ref = new \ReflectionClass($this->getThisFullClassName());

                if ($ref->getParentClass() && $ref->getParentClass()->getConstructor()) {
                    $constructorNode->stmts[] = new Node\Stmt\Expression(
                        new Node\Expr\StaticCall(new Node\Name('parent'), new Node\Identifier('__construct'))
                    );
                }
            } catch (\ReflectionException $e) {
            }

            $this->addNodeAfterProperties($constructorNode);
        }

        $constructorNode = $this->getConstructorNode();
        $constructorNode->stmts[] = $stmt;
        $this->updateSourceCodeFromNewStmts();
    }

    /**
     * @return Node\Stmt\ClassMethod|null
     *
     * @throws \Exception
     */
    private function getConstructorNode()
    {
        foreach ($this->getClassNode()->stmts as $classNode) {
            if ($classNode instanceof Node\Stmt\ClassMethod && '__construct' == $classNode->name) {
                return $classNode;
            }
        }

        return null;
    }

    /**
     * @param string $class
     *
     * @return string The alias to use when referencing this class
     */
    public function addUseStatementIfNecessary(string $class): string
    {
        $shortClassName = Str::getShortClassName($class);
        if ($this->isInSameNamespace($class)) {
            return $shortClassName;
        }

        $namespaceNode = $this->getNamespaceNode();

        $targetIndex = null;
        $addLineBreak = false;
        $lastUseStmtIndex = null;
        foreach ($namespaceNode->stmts as $index => $stmt) {
            if ($stmt instanceof Node\Stmt\Use_) {
                // I believe this is an array to account for use statements with {}
                foreach ($stmt->uses as $use) {
                    $alias = $use->alias ? $use->alias->name : $use->name->getLast();

                    // the use statement already exists? Don't add it again
                    if ($class === (string) $use->name) {
                        return $alias;
                    }

                    if ($alias === $shortClassName) {
                        // we have a conflicting alias!
                        // to be safe, use the fully-qualified class name
                        // everywhere and do not add another use statement
                        return '\\'.$class;
                    }
                }

                // if $class is alphabetically before this use statement, place it before
                // only set $targetIndex the first time you find it
                if (null === $targetIndex && Str::areClassesAlphabetical($class, (string) $stmt->uses[0]->name)) {
                    $targetIndex = $index;
                }

                $lastUseStmtIndex = $index;
            } elseif ($stmt instanceof Node\Stmt\Class_) {
                if (null !== $targetIndex) {
                    // we already found where to place the use statement

                    break;
                }

                // we hit the class! If there were any use statements,
                // then put this at the bottom of the use statement list
                if (null !== $lastUseStmtIndex) {
                    $targetIndex = $lastUseStmtIndex + 1;
                } else {
                    $targetIndex = $index;
                    $addLineBreak = true;
                }

                break;
            }
        }

        if (null === $targetIndex) {
            throw new \Exception('Could not find a class!');
        }

        $newUseNode = (new Builder\Use_($class, Node\Stmt\Use_::TYPE_NORMAL))->getNode();
        array_splice(
            $namespaceNode->stmts,
            $targetIndex,
            0,
            $addLineBreak ? [$newUseNode, $this->createBlankLineNode(self::CONTEXT_OUTSIDE_CLASS)] : [$newUseNode]
        );

        $this->updateSourceCodeFromNewStmts();

        return $shortClassName;
    }

    private function updateSourceCodeFromNewStmts()
    {
        $newCode = $this->printer->printFormatPreserving(
            $this->newStmts,
            $this->oldStmts,
            $this->oldTokens
        );

        // replace the 3 "fake" items that may be in the code (allowing for different indentation)
        $newCode = preg_replace('/(\ |\t)*private\ \$__EXTRA__LINE;/', '', $newCode);
        $newCode = preg_replace('/use __EXTRA__LINE;/', '', $newCode);
        $newCode = preg_replace('/(\ |\t)*\$__EXTRA__LINE;/', '', $newCode);

        // process comment lines
        foreach ($this->pendingComments as $i => $comment) {
            // sanity check
            $placeholder = sprintf('$__COMMENT__VAR_%d;', $i);
            if (false === strpos($newCode, $placeholder)) {
                // this can happen if a comment is createSingleLineCommentNode()
                // is called, but then that generated code is ultimately not added
                continue;
            }

            $newCode = str_replace($placeholder, '// '.$comment, $newCode);
        }
        $this->pendingComments = [];

        $this->setSourceCode($newCode);
    }

    private function setSourceCode(string $sourceCode)
    {
        $this->sourceCode = $sourceCode;
        $this->oldStmts = $this->parser->parse($sourceCode);
        $this->oldTokens = $this->lexer->getTokens();

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new NodeVisitor\CloningVisitor());
        $traverser->addVisitor(new NodeVisitor\NameResolver(null, [
            'replaceNodes' => false,
        ]));
        $this->newStmts = $traverser->traverse($this->oldStmts);
    }

    private function getClassNode(): Node\Stmt\Class_
    {
        $node = $this->findFirstNode(function ($node) {
            return $node instanceof Node\Stmt\Class_;
        });

        if (!$node) {
            throw new \Exception('Could not find class node');
        }

        return $node;
    }

    private function getNamespaceNode(): Node\Stmt\Namespace_
    {
        $node = $this->findFirstNode(function ($node) {
            return $node instanceof Node\Stmt\Namespace_;
        });

        if (!$node) {
            throw new \Exception('Could not find namespace node');
        }

        return $node;
    }

    /**
     * @param callable $filterCallback
     *
     * @return Node|null
     */
    private function findFirstNode(callable $filterCallback)
    {
        $traverser = new NodeTraverser();
        $visitor = new NodeVisitor\FirstFindingVisitor($filterCallback);
        $traverser->addVisitor($visitor);
        $traverser->traverse($this->newStmts);

        return $visitor->getFoundNode();
    }

    /**
     * @param callable $filterCallback
     * @param array    $ast
     *
     * @return Node|null
     */
    private function findLastNode(callable $filterCallback, array $ast)
    {
        $traverser = new NodeTraverser();
        $visitor = new NodeVisitor\FindingVisitor($filterCallback);
        $traverser->addVisitor($visitor);
        $traverser->traverse($ast);

        $nodes = $visitor->getFoundNodes();
        $node = end($nodes);

        return false === $node ? null : $node;
    }

    private function createBlankLineNode(string $context)
    {
        switch ($context) {
            case self::CONTEXT_OUTSIDE_CLASS:
                return (new Builder\Use_('__EXTRA__LINE', Node\Stmt\Use_::TYPE_NORMAL))
                    ->getNode()
                ;
            case self::CONTEXT_CLASS:
                return (new Builder\Property('__EXTRA__LINE'))
                    ->makePrivate()
                    ->getNode()
                ;
            case self::CONTEXT_CLASS_METHOD:
                return new Node\Expr\Variable('__EXTRA__LINE');
            default:
                throw new \Exception('Unknown context: '.$context);
        }
    }

    private function createSingleLineCommentNode(string $comment, string $context)
    {
        $this->pendingComments[] = $comment;
        switch ($context) {
            case self::CONTEXT_OUTSIDE_CLASS:
                // just not needed yet
                throw new \Exception('not supported');
            case self::CONTEXT_CLASS:
                // just not needed yet
                throw new \Exception('not supported');
            case self::CONTEXT_CLASS_METHOD:
                return BuilderHelpers::normalizeStmt(new Node\Expr\Variable(sprintf('__COMMENT__VAR_%d', \count($this->pendingComments) - 1)));
            default:
                throw new \Exception('Unknown context: '.$context);
        }
    }

    private function createDocBlock(array $commentLines)
    {
        $docBlock = "/**\n";
        foreach ($commentLines as $commentLine) {
            if ($commentLine) {
                $docBlock .= " * $commentLine\n";
            } else {
                // avoid the empty, extra space on blank lines
                $docBlock .= " *\n";
            }
        }
        $docBlock .= "\n */";

        return $docBlock;
    }

    private function addMethod(Node\Stmt\ClassMethod $methodNode)
    {
        $classNode = $this->getClassNode();
        $methodName = $methodNode->name;
        $existingIndex = null;
        if ($this->methodExists($methodName)) {
            if (!$this->overwrite) {
                $this->writeNote(sprintf(
                    'Not generating <info>%s::%s()</info>: method already exists',
                    Str::getShortClassName($this->getThisFullClassName()),
                    $methodName
                ));

                return;
            }

            // record, so we can overwrite in the same place
            $existingIndex = $this->getMethodIndex($methodName);
        }

        $newStatements = [];

        // put new method always at the bottom
        if (!empty($classNode->stmts)) {
            $newStatements[] = $this->createBlankLineNode(self::CONTEXT_CLASS);
        }

        $newStatements[] = $methodNode;

        if (null === $existingIndex) {
            // add them to the end!

            $classNode->stmts = array_merge($classNode->stmts, $newStatements);
        } else {
            array_splice(
                $classNode->stmts,
                $existingIndex,
                1,
                $newStatements
            );
        }

        $this->updateSourceCodeFromNewStmts();
    }

    private function makeMethodFluent(Builder\Method $methodBuilder)
    {
        if (!$this->fluentMutators) {
            return;
        }

        $methodBuilder
            ->addStmt($this->createBlankLineNode(self::CONTEXT_CLASS_METHOD))
            ->addStmt(new Node\Stmt\Return_(new Node\Expr\Variable('this')))
        ;
        $methodBuilder->setReturnType('self');
    }

    private function getEntityTypeHint($doctrineType)
    {
        switch ($doctrineType) {
            case 'string':
            case 'text':
            case 'guid':
            case 'bigint':
            case 'decimal':
                return 'string';

            case 'array':
            case 'simple_array':
            case 'json':
            case 'json_array':
                return 'array';

            case 'boolean':
                return 'bool';

            case 'integer':
            case 'smallint':
                return 'int';

            case 'float':
                return 'float';

            case 'datetime':
            case 'datetimetz':
            case 'date':
            case 'time':
                return '\\'.\DateTimeInterface::class;

            case 'datetime_immutable':
            case 'datetimetz_immutable':
            case 'date_immutable':
            case 'time_immutable':
                return '\\'.\DateTimeImmutable::class;

            case 'dateinterval':
                return '\\'.\DateInterval::class;

            case 'object':
            case 'binary':
            case 'blob':
            default:
                return null;
        }
    }

    private function isInSameNamespace($class)
    {
        $namespace = substr($class, 0, strrpos($class, '\\'));

        return $this->getNamespaceNode()->name->toCodeString() === $namespace;
    }

    private function getThisFullClassName(): string
    {
        return (string) $this->getClassNode()->namespacedName;
    }

    /**
     * Adds this new node where a new property should go.
     *
     * Useful for adding properties, or adding a constructor.
     *
     * @param Node $newNode
     */
    private function addNodeAfterProperties(Node $newNode)
    {
        $classNode = $this->getClassNode();

        // try to add after last property
        $targetNode = $this->findLastNode(function ($node) {
            return $node instanceof Node\Stmt\Property;
        }, [$classNode]);

        // otherwise, try to add after the last constant
        if (!$targetNode) {
            $targetNode = $this->findLastNode(function ($node) {
                return $node instanceof Node\Stmt\ClassConst;
            }, [$classNode]);
        }

        // add the new property after this node
        if ($targetNode) {
            $index = array_search($targetNode, $classNode->stmts);

            array_splice(
                $classNode->stmts,
                $index + 1,
                0,
                [$this->createBlankLineNode(self::CONTEXT_CLASS), $newNode]
            );

            $this->updateSourceCodeFromNewStmts();

            return;
        }

        // put right at the beginning of the class
        // add an empty line, unless the class is totally empty
        if (!empty($classNode->stmts)) {
            array_unshift($classNode->stmts, $this->createBlankLineNode(self::CONTEXT_CLASS));
        }
        array_unshift($classNode->stmts, $newNode);
        $this->updateSourceCodeFromNewStmts();
    }

    private function createNullConstant()
    {
        return new Node\Expr\ConstFetch(new Node\Name('null'));
    }

    private function addNodesToSetOtherSideOfOneToOne(RelationOneToOne $relation, Builder\Method $setterNodeBuilder)
    {
        if (!$relation->isNullable()) {
            $setterNodeBuilder->addStmt($this->createSingleLineCommentNode(
                'set the owning side of the relation if necessary',
                self::CONTEXT_CLASS_METHOD
            ));

            // if ($this !== $user->getUserProfile()) {
            $ifNode = new Node\Stmt\If_(new Node\Expr\BinaryOp\NotIdentical(
                new Node\Expr\Variable('this'),
                new Node\Expr\MethodCall(
                    new Node\Expr\Variable($relation->getPropertyName()),
                    $relation->getTargetGetterMethodName()
                )
            ));

            // $user->setUserProfile($this);
            $ifNode->stmts = [
                new Node\Stmt\Expression(new Node\Expr\MethodCall(
                    new Node\Expr\Variable($relation->getPropertyName()),
                    $relation->getTargetSetterMethodName(),
                    [new Node\Arg(new Node\Expr\Variable('this'))]
                )),
            ];
            $setterNodeBuilder->addStmt($ifNode);

            return;
        }

        // at this point, we know the relation is nullable
        $setterNodeBuilder->addStmt($this->createSingleLineCommentNode(
            'set (or unset) the owning side of the relation if necessary',
            self::CONTEXT_CLASS_METHOD
        ));

        $varName = 'new'.ucfirst($relation->getTargetPropertyName());
        // $newUserProfile = null === $user ? null : $this;
        $setterNodeBuilder->addStmt(
            new Node\Stmt\Expression(new Node\Expr\Assign(
                new Node\Expr\Variable($varName),
                new Node\Expr\Ternary(
                    new Node\Expr\BinaryOp\Identical(
                        new Node\Expr\Variable($relation->getPropertyName()),
                        $this->createNullConstant()
                    ),
                    $this->createNullConstant(),
                    new Node\Expr\Variable('this')
                )
            ))
        );

        // if ($newUserProfile !== $user->getUserProfile()) {
        $ifNode = new Node\Stmt\If_(new Node\Expr\BinaryOp\NotIdentical(
            new Node\Expr\Variable($varName),
            new Node\Expr\MethodCall(
                new Node\Expr\Variable($relation->getPropertyName()),
                $relation->getTargetGetterMethodName()
            )
        ));

        // $user->setUserProfile($newUserProfile);
        $ifNode->stmts = [
            new Node\Stmt\Expression(new Node\Expr\MethodCall(
                new Node\Expr\Variable($relation->getPropertyName()),
                $relation->getTargetSetterMethodName(),
                [new Node\Arg(new Node\Expr\Variable($varName))]
            )),
        ];
        $setterNodeBuilder->addStmt($ifNode);
    }

    private function methodExists(string $methodName): bool
    {
        return false !== $this->getMethodIndex($methodName);
    }

    private function getMethodIndex(string $methodName)
    {
        foreach ($this->getClassNode()->stmts as $i => $node) {
            if ($node instanceof Node\Stmt\ClassMethod && strtolower($node->name->toString()) === strtolower($methodName)) {
                return $i;
            }
        }

        return false;
    }

    private function propertyExists(string $propertyName)
    {
        foreach ($this->getClassNode()->stmts as $i => $node) {
            if ($node instanceof Node\Stmt\Property && $node->props[0]->name->toString() === $propertyName) {
                return true;
            }
        }

        return false;
    }

    private function writeNote(string $note)
    {
        if (null !== $this->io) {
            $this->io->text($note);
        }
    }
}
