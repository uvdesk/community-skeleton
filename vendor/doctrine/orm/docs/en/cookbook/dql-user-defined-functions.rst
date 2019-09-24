DQL User Defined Functions
==========================

.. sectionauthor:: Benjamin Eberlei <kontakt@beberlei.de>

By default DQL supports a limited subset of all the vendor-specific
SQL functions common between all the vendors. However in many cases
once you have decided on a specific database vendor, you will never
change it during the life of your project. This decision for a
specific vendor potentially allows you to make use of powerful SQL
features that are unique to the vendor.

It is worth to mention that Doctrine 2 also allows you to handwrite
your SQL instead of extending the DQL parser. Extending DQL is sort of an
advanced extension point. You can map arbitrary SQL to your objects
and gain access to vendor specific functionalities using the
``EntityManager#createNativeQuery()`` API as described in
the :doc:`Native Query <../reference/native-sql>` chapter.


The DQL Parser has hooks to register functions that can then be
used in your DQL queries and transformed into SQL, allowing to
extend Doctrines Query capabilities to the vendors strength. This
post explains the Used-Defined Functions API (UDF) of the Dql
Parser and shows some examples to give you some hints how you would
extend DQL.

There are three types of functions in DQL, those that return a
numerical value, those that return a string and those that return a
Date. Your custom method has to be registered as either one of
those. The return type information is used by the DQL parser to
check possible syntax errors during the parsing process, for
example using a string function return value in a math expression.

Registering your own DQL functions
----------------------------------

You can register your functions adding them to the ORM
configuration:

.. code-block:: php

    <?php
    $config = new \Doctrine\ORM\Configuration();
    $config->addCustomStringFunction($name, $class);
    $config->addCustomNumericFunction($name, $class);
    $config->addCustomDatetimeFunction($name, $class);
    
    $em = EntityManager::create($dbParams, $config);

The ``$name`` is the name the function will be referred to in the
DQL query. ``$class`` is a string of a class-name which has to
extend ``Doctrine\ORM\Query\Node\FunctionNode``. This is a class
that offers all the necessary API and methods to implement a UDF.

Instead of providing the function class name, you can also provide
a callable that returns the function object:

.. code-block:: php

    <?php
    $config = new \Doctrine\ORM\Configuration();
    $config->addCustomStringFunction($name, function () {
        return new MyCustomFunction();
    });

In this post we will implement some MySql specific Date calculation
methods, which are quite handy in my opinion:

Date Diff
---------

`Mysql's DateDiff function <http://dev.mysql.com/doc/refman/5.1/en/date-and-time-functions.html#function_datediff>`_
takes two dates as argument and calculates the difference in days
with ``date1-date2``.

The DQL parser is a top-down recursive descent parser to generate
the Abstract-Syntax Tree (AST) and uses a TreeWalker approach to
generate the appropriate SQL from the AST. This makes reading the
Parser/TreeWalker code manageable in a finite amount of time.

The ``FunctionNode`` class I referred to earlier requires you to
implement two methods, one for the parsing process (obviously)
called ``parse`` and one for the TreeWalker process called
``getSql()``. I show you the code for the DateDiff method and
discuss it step by step:

.. code-block:: php

    <?php
    /**
     * DateDiffFunction ::= "DATEDIFF" "(" ArithmeticPrimary "," ArithmeticPrimary ")"
     */
    class DateDiff extends FunctionNode
    {
        // (1)
        public $firstDateExpression = null;
        public $secondDateExpression = null;
    
        public function parse(\Doctrine\ORM\Query\Parser $parser)
        {
            $parser->match(Lexer::T_IDENTIFIER); // (2)
            $parser->match(Lexer::T_OPEN_PARENTHESIS); // (3)
            $this->firstDateExpression = $parser->ArithmeticPrimary(); // (4)
            $parser->match(Lexer::T_COMMA); // (5)
            $this->secondDateExpression = $parser->ArithmeticPrimary(); // (6)
            $parser->match(Lexer::T_CLOSE_PARENTHESIS); // (3)
        }
    
        public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
        {
            return 'DATEDIFF(' .
                $this->firstDateExpression->dispatch($sqlWalker) . ', ' .
                $this->secondDateExpression->dispatch($sqlWalker) .
            ')'; // (7)
        }
    }

The Parsing process of the DATEDIFF function is going to find two
expressions the date1 and the date2 values, whose AST Node
representations will be saved in the variables of the DateDiff
FunctionNode instance at (1).

The parse() method has to cut the function call "DATEDIFF" and its
argument into pieces. Since the parser detects the function using a
lookahead the T\_IDENTIFIER of the function name has to be taken
from the stack (2), followed by a detection of the arguments in
(4)-(6). The opening and closing parenthesis have to be detected
also. This happens during the Parsing process and leads to the
generation of a DateDiff FunctionNode somewhere in the AST of the
dql statement.

The ``ArithmeticPrimary`` method call is the most common
denominator of valid EBNF tokens taken from the
`DQL EBNF grammar <http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/dql-doctrine-query-language.html#ebnf>`_
that matches our requirements for valid input into the DateDiff Dql
function. Picking the right tokens for your methods is a tricky
business, but the EBNF grammar is pretty helpful finding it, as is
looking at the Parser source code.

Now in the TreeWalker process we have to pick up this node and
generate SQL from it, which apparently is quite easy looking at the
code in (7). Since we don't know which type of AST Node the first
and second Date expression are we are just dispatching them back to
the SQL Walker to generate SQL from and then wrap our DATEDIFF
function call around this output.

Now registering this DateDiff FunctionNode with the ORM using:

.. code-block:: php

    <?php
    $config = new \Doctrine\ORM\Configuration();
    $config->addCustomStringFunction('DATEDIFF', 'DoctrineExtensions\Query\MySql\DateDiff');

We can do fancy stuff like:

.. code-block:: sql

    SELECT p FROM DoctrineExtensions\Query\BlogPost p WHERE DATEDIFF(CURRENT_TIME(), p.created) < 7

Date Add
--------

Often useful it the ability to do some simple date calculations in
your DQL query using
`MySql's DATE\_ADD function <http://dev.mysql.com/doc/refman/5.1/en/date-and-time-functions.html#function_date-add>`_.

I'll skip the blah and show the code for this function:

.. code-block:: php

    <?php
    /**
     * DateAddFunction ::=
     *     "DATE_ADD" "(" ArithmeticPrimary ", INTERVAL" ArithmeticPrimary Identifier ")"
     */
    class DateAdd extends FunctionNode
    {
        public $firstDateExpression = null;
        public $intervalExpression = null;
        public $unit = null;
    
        public function parse(\Doctrine\ORM\Query\Parser $parser)
        {
            $parser->match(Lexer::T_IDENTIFIER);
            $parser->match(Lexer::T_OPEN_PARENTHESIS);
    
            $this->firstDateExpression = $parser->ArithmeticPrimary();
    
            $parser->match(Lexer::T_COMMA);
            $parser->match(Lexer::T_IDENTIFIER);
    
            $this->intervalExpression = $parser->ArithmeticPrimary();
    
            $parser->match(Lexer::T_IDENTIFIER);
    
            /* @var $lexer Lexer */
            $lexer = $parser->getLexer();
            $this->unit = $lexer->token['value'];
    
            $parser->match(Lexer::T_CLOSE_PARENTHESIS);
        }
    
        public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
        {
            return 'DATE_ADD(' .
                $this->firstDateExpression->dispatch($sqlWalker) . ', INTERVAL ' .
                $this->intervalExpression->dispatch($sqlWalker) . ' ' . $this->unit .
            ')';
        }
    }

The only difference compared to the DATEDIFF here is, we
additionally need the ``Lexer`` to access the value of the
``T_IDENTIFIER`` token for the Date Interval unit, for example the
MONTH in:

.. code-block:: sql

    SELECT p FROM DoctrineExtensions\Query\BlogPost p WHERE DATE_ADD(CURRENT_TIME(), INTERVAL 4 MONTH) > p.created

The above method now only supports the specification using
``INTERVAL``, to also allow a real date in DATE\_ADD we need to add
some decision logic to the parsing process (makes up for a nice
exercise).

Now as you see, the Parsing process doesn't catch all the possible
SQL errors, here we don't match for all the valid inputs for the
interval unit. However where necessary we rely on the database
vendors SQL parser to show us further errors in the parsing
process, for example if the Unit would not be one of the supported
values by MySql.

Conclusion
----------

Now that you all know how you can implement vendor specific SQL
functionalities in DQL, we would be excited to see user extensions
that add vendor specific function packages, for example more math
functions, XML + GIS Support, Hashing functions and so on.

For 2.0 we will come with the current set of functions, however for
a future version we will re-evaluate if we can abstract even more
vendor sql functions and extend the DQL languages scope.

Code for this Extension to DQL and other Doctrine Extensions can be
found
`in my Github DoctrineExtensions repository <http://github.com/beberlei/DoctrineExtensions>`_.


