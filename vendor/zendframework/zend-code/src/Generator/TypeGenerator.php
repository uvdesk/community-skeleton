<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\Code\Generator;

use Zend\Code\Generator\Exception\InvalidArgumentException;

use function in_array;
use function ltrim;
use function preg_match;
use function sprintf;
use function strpos;
use function strtolower;
use function substr;

final class TypeGenerator implements GeneratorInterface
{
    /**
     * @var bool
     */
    private $isInternalPhpType;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $nullable;

    /**
     * @var string[]
     *
     * @link http://php.net/manual/en/functions.arguments.php#functions.arguments.type-declaration
     */
    private static $internalPhpTypes = [
        'void',
        'int',
        'float',
        'string',
        'bool',
        'array',
        'callable',
        'iterable',
        'object'
    ];

    /**
     * @var string a regex pattern to match valid class names or types
     */
    private static $validIdentifierMatcher = '/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*'
        . '(\\\\[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)*$/';

    /**
     * @param string $type
     *
     * @return TypeGenerator
     *
     * @throws InvalidArgumentException
     */
    public static function fromTypeString($type)
    {
        list($nullable, $trimmedNullable) = self::trimNullable($type);
        list($wasTrimmed, $trimmedType) = self::trimType($trimmedNullable);

        if (! preg_match(self::$validIdentifierMatcher, $trimmedType)) {
            throw new InvalidArgumentException(sprintf(
                'Provided type "%s" is invalid: must conform "%s"',
                $type,
                self::$validIdentifierMatcher
            ));
        }

        $isInternalPhpType = self::isInternalPhpType($trimmedType);

        if ($wasTrimmed && $isInternalPhpType) {
            throw new InvalidArgumentException(sprintf(
                'Provided type "%s" is an internal PHP type, but was provided with a namespace separator prefix',
                $type
            ));
        }

        if ($nullable && $isInternalPhpType && 'void' === strtolower($trimmedType)) {
            throw new InvalidArgumentException(sprintf('Provided type "%s" cannot be nullable', $type));
        }

        $instance = new self();

        $instance->type              = $trimmedType;
        $instance->nullable          = $nullable;
        $instance->isInternalPhpType = $isInternalPhpType;

        return $instance;
    }

    private function __construct()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function generate()
    {
        $nullable = $this->nullable ? '?' : '';

        if ($this->isInternalPhpType) {
            return $nullable . strtolower($this->type);
        }

        return $nullable . '\\' . $this->type;
    }

    /**
     * @return string the cleaned type string
     */
    public function __toString()
    {
        return ltrim($this->generate(), '?\\');
    }

    /**
     * @param string $type
     *
     * @return bool[]|string[] ordered tuple, first key represents whether the type is nullable, second is the
     *                         trimmed string
     */
    private static function trimNullable($type)
    {
        if (0 === strpos($type, '?')) {
            return [true, substr($type, 1)];
        }

        return [false, $type];
    }

    /**
     * @param string $type
     *
     * @return bool[]|string[] ordered tuple, first key represents whether the values was trimmed, second is the
     *                         trimmed string
     */
    private static function trimType($type)
    {
        if (0 === strpos($type, '\\')) {
            return [true, substr($type, 1)];
        }

        return [false, $type];
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    private static function isInternalPhpType($type)
    {
        return in_array(strtolower($type), self::$internalPhpTypes, true);
    }
}
