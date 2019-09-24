What do all those files mean?
=============================

 * `php5.y`:             PHP 5 grammar written in a pseudo language
 * `php7.y`:             PHP 7 grammar written in a pseudo language
 * `tokens.y`:           Tokens definition shared between PHP 5 and PHP 7 grammars
 * `parser.template`:    A `kmyacc` parser prototype file for PHP
 * `tokens.template`:    A `kmyacc` prototype file for the `Tokens` class
 * `rebuildParsers.php`: Preprocesses the grammar and builds the parser using `kmyacc`

.phpy pseudo language
=====================

The `.y` file is a normal grammar in `kmyacc` (`yacc`) style, with some transformations
applied to it:

 * Nodes are created using the syntax `Name[..., ...]`. This is transformed into
   `new Name(..., ..., attributes())`
 * Some function-like constructs are resolved (see `rebuildParsers.php` for a list)

Building the parser
===================

In order to rebuild the parser, you need [moriyoshi's fork of kmyacc](https://github.com/moriyoshi/kmyacc-forked).
After you compiled/installed it, run the `rebuildParsers.php` script.

By default only the `Parser.php` is built. If you want to additionally emit debug symbols and create `y.output`, run the
script with `--debug`. If you want to retain the preprocessed grammar pass `--keep-tmp-grammar`.
