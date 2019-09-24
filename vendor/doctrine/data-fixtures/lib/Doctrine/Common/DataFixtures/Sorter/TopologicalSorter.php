<?php

namespace Doctrine\Common\DataFixtures\Sorter;

use Doctrine\Common\DataFixtures\Exception\CircularReferenceException;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * TopologicalSorter is an ordering algorithm for directed graphs (DG) and/or
 * directed acyclic graphs (DAG) by using a depth-first searching (DFS) to
 * traverse the graph built in memory.
 * This algorithm have a linear running time based on nodes (V) and dependency
 * between the nodes (E), resulting in a computational complexity of O(V + E).
 *
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Roman Borschel <roman@code-factory.org>
 *
 * @internal this class is to be used only by data-fixtures internals: do not
 *           rely on it in your own libraries/applications.
 */
class TopologicalSorter
{
    /**
     * Matrix of nodes (aka. vertex).
     * Keys are provided hashes and values are the node definition objects.
     *
     * @var Vertex[]
     */
    private $nodeList = [];

    /**
     * Volatile variable holding calculated nodes during sorting process.
     *
     * @var array
     */
    private $sortedNodeList = [];

    /**
     * Allow or not cyclic dependencies
     *
     * @var boolean
     */
    private $allowCyclicDependencies;

    /**
     * Construct TopologicalSorter object
     *
     * @param boolean $allowCyclicDependencies
     */
    public function __construct($allowCyclicDependencies = true)
    {
        $this->allowCyclicDependencies = $allowCyclicDependencies;
    }

    /**
     * Adds a new node (vertex) to the graph, assigning its hash and value.
     *
     * @param string        $hash
     * @param ClassMetadata $node
     *
     * @return void
     */
    public function addNode($hash, ClassMetadata $node)
    {
        $this->nodeList[$hash] = new Vertex($node);
    }

    /**
     * Checks the existence of a node in the graph.
     *
     * @param string $hash
     *
     * @return bool
     */
    public function hasNode($hash)
    {
        return isset($this->nodeList[$hash]);
    }

    /**
     * Adds a new dependency (edge) to the graph using their hashes.
     *
     * @param string $fromHash
     * @param string $toHash
     *
     * @return void
     */
    public function addDependency($fromHash, $toHash)
    {
        $definition = $this->nodeList[$fromHash];

        $definition->dependencyList[] = $toHash;
    }

    /**
     * Return a valid order list of all current nodes.
     * The desired topological sorting is the postorder of these searches.
     *
     * Note: Highly performance-sensitive method.
     *
     * @throws \RuntimeException
     * @throws CircularReferenceException
     *
     * @return array
     */
    public function sort()
    {
        foreach ($this->nodeList as $definition) {
            if ($definition->state !== Vertex::NOT_VISITED) {
                continue;
            }

            $this->visit($definition);
        }

        $sortedList = $this->sortedNodeList;

        $this->nodeList       = [];
        $this->sortedNodeList = [];

        return $sortedList;
    }

    /**
     * Visit a given node definition for reordering.
     *
     * Note: Highly performance-sensitive method.
     *
     * @throws \RuntimeException
     * @throws CircularReferenceException
     *
     * @param Vertex $definition
     */
    private function visit(Vertex $definition)
    {
        $definition->state = Vertex::IN_PROGRESS;

        foreach ($definition->dependencyList as $dependency) {
            if ( ! isset($this->nodeList[$dependency])) {
                throw new \RuntimeException(sprintf(
                    'Fixture "%s" has a dependency of fixture "%s", but it not listed to be loaded.',
                    get_class($definition->value),
                    $dependency
                ));
            }

            $childDefinition = $this->nodeList[$dependency];

            // allow self referencing classes
            if ($definition === $childDefinition) {
                continue;
            }

            switch ($childDefinition->state) {
                case Vertex::VISITED:
                    break;
                case Vertex::IN_PROGRESS:
                    if ( ! $this->allowCyclicDependencies) {
                        throw new CircularReferenceException(
                            sprintf(
                                'Graph contains cyclic dependency between the classes "%s" and'
                                .' "%s". An example of this problem would be the following: '
                                .'Class C has class B as its dependency. Then, class B has class A has its dependency. '
                                .'Finally, class A has class C as its dependency.',
                                $definition->value->getName(),
                                $childDefinition->value->getName()
                            )
                        );
                    }
                    break;
                case Vertex::NOT_VISITED:
                    $this->visit($childDefinition);
            }
        }

        $definition->state = Vertex::VISITED;

        $this->sortedNodeList[] = $definition->value;
    }
}
