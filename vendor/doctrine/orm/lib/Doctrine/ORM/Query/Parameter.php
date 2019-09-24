<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\ORM\Query;

/**
 * Defines a Query Parameter.
 *
 * @link    www.doctrine-project.org
 * @since   2.3
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 */
class Parameter
{
    /**
     * The parameter name.
     *
     * @var string
     */
    private $name;

    /**
     * The parameter value.
     *
     * @var mixed
     */
    private $value;

    /**
     * The parameter type.
     *
     * @var mixed
     */
    private $type;

    /**
     * Constructor.
     *
     * @param string $name  Parameter name
     * @param mixed  $value Parameter value
     * @param mixed  $type  Parameter type
     */
    public function __construct($name, $value, $type = null)
    {
        $this->name = trim($name, ':');

        $this->setValue($value, $type);
    }

    /**
     * Retrieves the Parameter name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Retrieves the Parameter value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Retrieves the Parameter type.
     *
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Defines the Parameter value.
     *
     * @param mixed $value Parameter value.
     * @param mixed $type  Parameter type.
     */
    public function setValue($value, $type = null)
    {
        $this->value = $value;
        $this->type  = $type ?: ParameterTypeInferer::inferType($value);
    }
}
