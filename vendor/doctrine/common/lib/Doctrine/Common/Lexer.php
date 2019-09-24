<?php
namespace Doctrine\Common;

use Doctrine\Common\Lexer\AbstractLexer;
use function trigger_error;
use const E_USER_DEPRECATED;

@trigger_error(Lexer::class . ' is deprecated.', E_USER_DEPRECATED);

/**
 * Base class for writing simple lexers, i.e. for creating small DSLs.
 *
 * Lexer moved into its own Component Doctrine\Common\Lexer. This class
 * only stays for being BC.
 *
 * @since  2.0
 * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author Jonathan Wage <jonwage@gmail.com>
 * @author Roman Borschel <roman@code-factory.org>
 *
 * @deprecated Use Doctrine\Common\Lexer\AbstractLexer from doctrine/lexer package instead.
 */
abstract class Lexer extends AbstractLexer
{
}
