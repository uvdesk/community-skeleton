<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Generator;

use Reflection;
use ReflectionMethod;

use function array_key_exists;
use function array_search;
use function array_values;
use function count;
use function current;
use function explode;
use function implode;
use function in_array;
use function is_array;
use function is_string;
use function sprintf;
use function strpos;

class TraitUsageGenerator extends AbstractGenerator implements TraitUsageInterface
{
    /**
     * @var ClassGenerator
     */
    protected $classGenerator;

    /**
     * @var array Array of trait names
     */
    protected $traits = [];

    /**
     * @var array Array of trait aliases
     */
    protected $traitAliases = [];

    /**
     * @var array Array of trait overrides
     */
    protected $traitOverrides = [];

    /**
     * @var array Array of string names
     */
    protected $uses = [];

    public function __construct(ClassGenerator $classGenerator)
    {
        $this->classGenerator = $classGenerator;
    }

    /**
     * @inheritDoc
     */
    public function addUse($use, $useAlias = null)
    {
        $this->removeUse($use);

        if (! empty($useAlias)) {
            $use .= ' as ' . $useAlias;
        }

        $this->uses[$use] = $use;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUses()
    {
        return array_values($this->uses);
    }

    /**
     * @param string $use
     * @return bool
     */
    public function hasUse($use)
    {
        foreach ($this->uses as $key => $value) {
            $parts = explode(' ', $value);
            if ($parts[0] === $use) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $use
     * @return bool
     */
    public function hasUseAlias($use)
    {
        foreach ($this->uses as $key => $value) {
            $parts = explode(' as ', $value);
            if ($parts[0] === $use && count($parts) == 2) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the alias of the provided FQCN
     *
     * @param string $use
     * @return string|null
     */
    public function getUseAlias(string $use): ?string
    {
        foreach ($this->uses as $key => $value) {
            $parts = explode(' as ', $key);
            if ($parts[0] === $use && count($parts) == 2) {
                return $parts[1];
            }
        }
        return null;
    }

    /**
     * Returns true if the alias is defined in the use list
     *
     * @param string $alias
     * @return bool
     */
    public function isUseAlias(string $alias): bool
    {
        foreach ($this->uses as $key => $value) {
            $parts = explode(' as ', $key);
            if (count($parts) === 2 && $parts[1] === $alias) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $use
     * @return TraitUsageGenerator
     */
    public function removeUse($use)
    {
        foreach ($this->uses as $key => $value) {
            $parts = explode(' ', $value);
            if ($parts[0] === $use) {
                unset($this->uses[$value]);
            }
        }

        return $this;
    }

    /**
     * @param string $use
     * @return TraitUsageGenerator
     */
    public function removeUseAlias($use)
    {
        foreach ($this->uses as $key => $value) {
            $parts = explode(' as ', $value);
            if ($parts[0] === $use && count($parts) == 2) {
                unset($this->uses[$value]);
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addTrait($trait)
    {
        $traitName = $trait;
        if (is_array($trait)) {
            if (! array_key_exists('traitName', $trait)) {
                throw new Exception\InvalidArgumentException('Missing required value for traitName');
            }
            $traitName = $trait['traitName'];

            if (array_key_exists('aliases', $trait)) {
                foreach ($trait['aliases'] as $alias) {
                    $this->addAlias($alias);
                }
            }

            if (array_key_exists('insteadof', $trait)) {
                foreach ($trait['insteadof'] as $insteadof) {
                    $this->addTraitOverride($insteadof);
                }
            }
        }

        if (! $this->hasTrait($traitName)) {
            $this->traits[] = $traitName;
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addTraits(array $traits)
    {
        foreach ($traits as $trait) {
            $this->addTrait($trait);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function hasTrait($traitName)
    {
        return in_array($traitName, $this->traits);
    }

    /**
     * @inheritDoc
     */
    public function getTraits()
    {
        return $this->traits;
    }

    /**
     * @inheritDoc
     */
    public function removeTrait($traitName)
    {
        $key = array_search($traitName, $this->traits);
        if (false !== $key) {
            unset($this->traits[$key]);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function addTraitAlias($method, $alias, $visibility = null)
    {
        $traitAndMethod = $method;
        if (is_array($method)) {
            if (! array_key_exists('traitName', $method)) {
                throw new Exception\InvalidArgumentException('Missing required argument "traitName" for $method');
            }

            if (! array_key_exists('method', $method)) {
                throw new Exception\InvalidArgumentException('Missing required argument "method" for $method');
            }

            $traitAndMethod = $method['traitName'] . '::' . $method['method'];
        }

        // Validations
        if (false === strpos($traitAndMethod, '::')) {
            throw new Exception\InvalidArgumentException(
                'Invalid Format: $method must be in the format of trait::method'
            );
        }
        if (! is_string($alias)) {
            throw new Exception\InvalidArgumentException('Invalid Alias: $alias must be a string or array.');
        }
        if ($this->classGenerator->hasMethod($alias)) {
            throw new Exception\InvalidArgumentException('Invalid Alias: Method name already exists on this class.');
        }
        if (null !== $visibility
            && $visibility !== ReflectionMethod::IS_PUBLIC
            && $visibility !== ReflectionMethod::IS_PRIVATE
            && $visibility !== ReflectionMethod::IS_PROTECTED
        ) {
            throw new Exception\InvalidArgumentException(
                'Invalid Type: $visibility must of ReflectionMethod::IS_PUBLIC,'
                . ' ReflectionMethod::IS_PRIVATE or ReflectionMethod::IS_PROTECTED'
            );
        }

        list($trait, $method) = explode('::', $traitAndMethod);
        if (! $this->hasTrait($trait)) {
            throw new Exception\InvalidArgumentException('Invalid trait: Trait does not exists on this class');
        }

        $this->traitAliases[$traitAndMethod] = [
            'alias'      => $alias,
            'visibility' => $visibility,
        ];

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTraitAliases()
    {
        return $this->traitAliases;
    }

    /**
     * @inheritDoc
     */
    public function addTraitOverride($method, $traitsToReplace)
    {
        if (false === is_array($traitsToReplace)) {
            $traitsToReplace = [$traitsToReplace];
        }

        $traitAndMethod = $method;
        if (is_array($method)) {
            if (! array_key_exists('traitName', $method)) {
                throw new Exception\InvalidArgumentException('Missing required argument "traitName" for $method');
            }

            if (! array_key_exists('method', $method)) {
                throw new Exception\InvalidArgumentException('Missing required argument "method" for $method');
            }

            $traitAndMethod = (string) $method['traitName'] . '::' . (string) $method['method'];
        }

        // Validations
        if (false === strpos($traitAndMethod, '::')) {
            throw new Exception\InvalidArgumentException(
                'Invalid Format: $method must be in the format of trait::method'
            );
        }

        list($trait, $method) = explode('::', $traitAndMethod);
        if (! $this->hasTrait($trait)) {
            throw new Exception\InvalidArgumentException('Invalid trait: Trait does not exists on this class');
        }

        if (! array_key_exists($traitAndMethod, $this->traitOverrides)) {
            $this->traitOverrides[$traitAndMethod] = [];
        }

        foreach ($traitsToReplace as $traitToReplace) {
            if (! is_string($traitToReplace)) {
                throw new Exception\InvalidArgumentException(
                    'Invalid Argument: $traitToReplace must be a string or array of strings'
                );
            }

            if (! in_array($traitToReplace, $this->traitOverrides[$traitAndMethod])) {
                $this->traitOverrides[$traitAndMethod][] = $traitToReplace;
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeTraitOverride($method, $overridesToRemove = null)
    {
        if (! array_key_exists($method, $this->traitOverrides)) {
            return $this;
        }

        if (null === $overridesToRemove) {
            unset($this->traitOverrides[$method]);
            return $this;
        }

        $overridesToRemove = ! is_array($overridesToRemove)
            ? [$overridesToRemove]
            : $overridesToRemove;
        foreach ($overridesToRemove as $traitToRemove) {
            $key = array_search($traitToRemove, $this->traitOverrides[$method]);
            if (false !== $key) {
                unset($this->traitOverrides[$method][$key]);
            }
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTraitOverrides()
    {
        return $this->traitOverrides;
    }

    /**
     * @inheritDoc
     */
    public function generate()
    {
        $output = '';
        $indent = $this->getIndentation();
        $traits = $this->getTraits();

        if (empty($traits)) {
            return $output;
        }

        $output .= $indent . 'use ' . implode(', ', $traits);

        $aliases   = $this->getTraitAliases();
        $overrides = $this->getTraitOverrides();
        if (empty($aliases) && empty($overrides)) {
            $output .= ';' . self::LINE_FEED . self::LINE_FEED;
            return $output;
        }

        $output .= ' {' . self::LINE_FEED;
        foreach ($aliases as $method => $alias) {
            $visibility = null !== $alias['visibility']
                ? current(Reflection::getModifierNames($alias['visibility'])) . ' '
                : '';

            // validation check
            if ($this->classGenerator->hasMethod($alias['alias'])) {
                throw new Exception\RuntimeException(sprintf(
                    'Generation Error: Aliased method %s already exists on this class',
                    $alias['alias']
                ));
            }

            $output .=
                $indent
                . $indent
                . $method
                . ' as '
                . $visibility
                . $alias['alias']
                . ';'
                . self::LINE_FEED;
        }

        foreach ($overrides as $method => $insteadofTraits) {
            foreach ($insteadofTraits as $insteadofTrait) {
                $output .=
                    $indent
                    . $indent
                    . $method
                    . ' insteadof '
                    . $insteadofTrait
                    . ';'
                    . self::LINE_FEED;
            }
        }

        $output .= self::LINE_FEED . $indent . '}' . self::LINE_FEED . self::LINE_FEED;

        return $output;
    }
}
