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
 * A parse tree printer for Doctrine Query Language parser.
 *
 * @author      Janne Vanhala <jpvanhal@cc.hut.fi>
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 * @link        http://www.phpdoctrine.org
 * @since       2.0
 */
class Printer
{
    /**
     * Current indentation level
     *
     * @var int
     */
    protected $_indent = 0;

    /**
     * Defines whether parse tree is printed (default, false) or not (true).
     *
     * @var bool
     */
    protected $_silent;

    /**
     * Constructs a new parse tree printer.
     *
     * @param bool $silent Parse tree will not be printed if true.
     */
    public function __construct($silent = false)
    {
        $this->_silent = $silent;
    }

    /**
     * Prints an opening parenthesis followed by production name and increases
     * indentation level by one.
     *
     * This method is called before executing a production.
     *
     * @param string $name Production name.
     *
     * @return void
     */
    public function startProduction($name)
    {
        $this->println('(' . $name);
        $this->_indent++;
    }

    /**
     * Decreases indentation level by one and prints a closing parenthesis.
     *
     * This method is called after executing a production.
     *
     * @return void
     */
    public function endProduction()
    {
        $this->_indent--;
        $this->println(')');
    }

    /**
     * Prints text indented with spaces depending on current indentation level.
     *
     * @param string $str The text.
     *
     * @return void
     */
    public function println($str)
    {
        if ( ! $this->_silent) {
            echo str_repeat('    ', $this->_indent), $str, "\n";
        }
    }
}
