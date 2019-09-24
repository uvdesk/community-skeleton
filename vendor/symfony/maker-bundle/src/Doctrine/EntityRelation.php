<?php

/*
 * This file is part of the Symfony MakerBundle package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Bundle\MakerBundle\Doctrine;

/**
 * @internal
 */
final class EntityRelation
{
    const MANY_TO_ONE = 'ManyToOne';
    const ONE_TO_MANY = 'OneToMany';
    const MANY_TO_MANY = 'ManyToMany';
    const ONE_TO_ONE = 'OneToOne';

    private $type;

    private $owningClass;

    private $inverseClass;

    private $owningProperty;

    private $inverseProperty;

    private $isNullable = false;

    private $isSelfReferencing = false;

    private $orphanRemoval = false;

    private $mapInverseRelation = true;

    public function __construct(string $type, string $owningClass, string $inverseClass)
    {
        if (!\in_array($type, self::getValidRelationTypes())) {
            throw new \Exception(sprintf('Invalid relation type "%s"', $type));
        }

        if (self::ONE_TO_MANY === $type) {
            throw new \Exception('Use ManyToOne instead of OneToMany');
        }

        $this->type = $type;
        $this->owningClass = $owningClass;
        $this->inverseClass = $inverseClass;
        $this->isSelfReferencing = $owningClass === $inverseClass;
    }

    public function setOwningProperty(string $owningProperty)
    {
        $this->owningProperty = $owningProperty;
    }

    public function setInverseProperty(string $inverseProperty)
    {
        if (!$this->mapInverseRelation) {
            throw new \Exception('Cannot call setInverseProperty() when the inverse relation will not be mapped.');
        }

        $this->inverseProperty = $inverseProperty;
    }

    public function setIsNullable(bool $isNullable)
    {
        $this->isNullable = $isNullable;
    }

    public function setOrphanRemoval(bool $orphanRemoval)
    {
        $this->orphanRemoval = $orphanRemoval;
    }

    public static function getValidRelationTypes(): array
    {
        return [
            self::MANY_TO_ONE,
            self::ONE_TO_MANY,
            self::MANY_TO_MANY,
            self::ONE_TO_ONE,
        ];
    }

    public function getOwningRelation()
    {
        switch ($this->getType()) {
            case self::MANY_TO_ONE:
                return (new RelationManyToOne())
                    ->setPropertyName($this->owningProperty)
                    ->setTargetClassName($this->inverseClass)
                    ->setTargetPropertyName($this->inverseProperty)
                    ->setIsNullable($this->isNullable)
                    ->setIsSelfReferencing($this->isSelfReferencing)
                    ->setMapInverseRelation($this->mapInverseRelation)
                ;
                break;
            case self::MANY_TO_MANY:
                return (new RelationManyToMany())
                    ->setPropertyName($this->owningProperty)
                    ->setTargetClassName($this->inverseClass)
                    ->setTargetPropertyName($this->inverseProperty)
                    ->setIsOwning(true)->setMapInverseRelation($this->mapInverseRelation)
                    ->setIsSelfReferencing($this->isSelfReferencing)
                ;
                break;
            case self::ONE_TO_ONE:
                return (new RelationOneToOne())
                    ->setPropertyName($this->owningProperty)
                    ->setTargetClassName($this->inverseClass)
                    ->setTargetPropertyName($this->inverseProperty)
                    ->setIsNullable($this->isNullable)
                    ->setIsOwning(true)
                    ->setIsSelfReferencing($this->isSelfReferencing)
                    ->setMapInverseRelation($this->mapInverseRelation)
                ;
                break;
            default:
                throw new \InvalidArgumentException('Invalid type');
        }
    }

    public function getInverseRelation()
    {
        switch ($this->getType()) {
            case self::MANY_TO_ONE:
                return (new RelationOneToMany())
                    ->setPropertyName($this->inverseProperty)
                    ->setTargetClassName($this->owningClass)
                    ->setTargetPropertyName($this->owningProperty)
                    ->setOrphanRemoval($this->orphanRemoval)
                    ->setIsSelfReferencing($this->isSelfReferencing)
                ;
                break;
            case self::MANY_TO_MANY:
                return (new RelationManyToMany())
                    ->setPropertyName($this->inverseProperty)
                    ->setTargetClassName($this->owningClass)
                    ->setTargetPropertyName($this->owningProperty)
                    ->setIsOwning(false)
                    ->setIsSelfReferencing($this->isSelfReferencing)
                ;
                break;
            case self::ONE_TO_ONE:
                return (new RelationOneToOne())
                    ->setPropertyName($this->inverseProperty)
                    ->setTargetClassName($this->owningClass)
                    ->setTargetPropertyName($this->owningProperty)
                    ->setIsNullable($this->isNullable)
                    ->setIsOwning(false)
                    ->setIsSelfReferencing($this->isSelfReferencing)
                ;
                break;
            default:
                throw new \InvalidArgumentException('Invalid type');
        }
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOwningClass(): string
    {
        return $this->owningClass;
    }

    public function getInverseClass(): string
    {
        return $this->inverseClass;
    }

    public function getOwningProperty()
    {
        return $this->owningProperty;
    }

    public function getInverseProperty(): string
    {
        return $this->inverseProperty;
    }

    public function isNullable(): bool
    {
        return $this->isNullable;
    }

    public function isSelfReferencing(): bool
    {
        return $this->isSelfReferencing;
    }

    public function getMapInverseRelation(): bool
    {
        return $this->mapInverseRelation;
    }

    public function setMapInverseRelation(bool $mapInverseRelation)
    {
        if ($mapInverseRelation && $this->inverseProperty) {
            throw new \Exception('Cannot set setMapInverseRelation() to true when the inverse relation property is set.');
        }

        $this->mapInverseRelation = $mapInverseRelation;
    }
}
