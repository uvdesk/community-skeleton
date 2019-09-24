<?php

namespace Doctrine\Common\DataFixtures\Sorter;

use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * @author Marco Pivetta <ocramius@gmail.com>
 *
 * @internal this class is to be used only by data-fixtures internals: do not
 *           rely on it in your own libraries/applications. This class is
 *           designed to work with {@see \Doctrine\Common\DataFixtures\Sorter\TopologicalSorter}
 *           only.
 */
class Vertex
{
    const NOT_VISITED = 0;
    const IN_PROGRESS = 1;
    const VISITED     = 2;

    /**
     * @var int one of either {@see self::NOT_VISITED}, {@see self::IN_PROGRESS} or {@see self::VISITED}.
     */
    public $state = self::NOT_VISITED;

    /**
     * @var ClassMetadata Actual node value
     */
    public $value;

    /**
     * @var string[] Map of node dependencies defined as hashes.
     */
    public $dependencyList = [];

    /**
     * @param ClassMetadata $value
     */
    public function __construct(ClassMetadata $value)
    {
        $this->value = $value;
    }
}
