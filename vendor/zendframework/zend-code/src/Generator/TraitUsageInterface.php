<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Generator;

interface TraitUsageInterface
{
    /**
     * Add a class to "use" classes
     *
     * @param  string $use
     * @param  string|null $useAlias
     * @return self
     */
    public function addUse($use, $useAlias = null);

    /**
     * Returns the "use" classes
     *
     * @return array
     */
    public function getUses();

    /**
     * Add trait takes an array of trait options or string as arguments.
     *
     * Array Format:
     * key: traitName value: String
     *
     * key: aliases value: array of arrays
     *      key: method value: @see addTraitAlias
     *      key: alias value: @see addTraitAlias
     *      key: visibility value: @see addTraitAlias
     *
     * key: insteadof value: array of arrays
     *      key: method value: @see self::addTraitOverride
     *      key: traitToReplace value: @see self::addTraitOverride
     *
     * @param mixed $trait String | Array
     * @return self
     */
    public function addTrait($trait);

    /**
     * Add multiple traits.  Trait can be an array of trait names or array of trait
     * configurations
     *
     * @param array $traits Array of string names or configurations (@see addTrait)
     * @return self
     */
    public function addTraits(array $traits);

    /**
     * Check to see if the class has a trait defined
     *
     * @param string $traitName
     * @return bool
     */
    public function hasTrait($traitName);

    /**
     * Get a list of trait names
     *
     * @return array
     */
    public function getTraits();

    /**
     * Remove a trait by its name
     *
     * @param string $traitName
     */
    public function removeTrait($traitName);

    /**
     * Add a trait alias.  This will be used to generate the AS portion of the use statement.
     *
     * $method:
     * This method provides 2 ways for defining the trait method.
     * Option 1: String
     * Option 2: Array
     * key: traitName value: name of trait
     * key: method value: trait method
     *
     * $alias:
     * Alias is a string representing the new method name.
     *
     * $visibilty:
     * ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PRIVATE | ReflectionMethod::IS_PROTECTED
     *
     * @param mixed $method String or Array
     * @param string $alias
     * @param null|int $visibility
     */
    public function addTraitAlias($method, $alias, $visibility = null);

    /**
     * @return array
     */
    public function getTraitAliases();

    /**
     * Add a trait method override.  This will be used to generate the INSTEADOF portion of the use
     * statement.
     *
     * $method:
     * This method provides 2 ways for defining the trait method.
     * Option 1: String Format: <trait name>::<method name>
     * Option 2: Array
     * key: traitName value: trait name
     * key: method value: method name
     *
     * $traitToReplace:
     * The name of the trait that you wish to supersede.
     *
     * This method provides 2 ways for defining the trait method.
     * Option 1: String of trait to replace
     * Option 2: Array of strings of traits to replace

     * @param mixed $method
     * @param mixed $traitsToReplace
     */
    public function addTraitOverride($method, $traitsToReplace);

    /**
     * Remove an override for a given trait::method
     *
     * $method:
     * This method provides 2 ways for defining the trait method.
     * Option 1: String Format: <trait name>::<method name>
     * Option 2: Array
     * key: traitName value: trait name
     * key: method value: method name
     *
     * $overridesToRemove:
     * The name of the trait that you wish to remove.
     *
     * This method provides 2 ways for defining the trait method.
     * Option 1: String of trait to replace
     * Option 2: Array of strings of traits to replace
     *
     * @param mixed $method
     * @param mixed $overridesToRemove
     * @return self
     */
    public function removeTraitOverride($method, $overridesToRemove = null);

    /**
     * Return trait overrides
     *
     * @return array
     */
    public function getTraitOverrides();
}
