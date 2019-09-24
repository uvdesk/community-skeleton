Symfony Polyfill / Intl: ICU
============================

This component provides a collection of functions/classes using the
[`symfony/intl`](https://github.com/symfony/intl) package when the
[Intl](http://php.net/intl) extension is not installed, including:

- [`intl_is_failure()`](http://php.net/manual/en/function.intl-is-failure.php)
- [`intl_get_error_code()`](http://php.net/manual/en/function.intl-get-error-code.php)
- [`intl_get_error_message()`](http://php.net/manual/en/function.intl-get-error-message.php)
- [`intl_error_name()`](http://php.net/manual/en/function.intl-error-name.php)
- [`Collator`](http://php.net/Collator)
- [`NumberFormatter`](http://php.net/NumberFormatter)
- [`Locale`](http://php.net/Locale)
- [`IntlDateFormatter`](http://php.net/IntlDateFormatter)

More information can be found in the
[main Polyfill README](https://github.com/symfony/polyfill/blob/master/README.md).

License
=======

This library is released under the [MIT license](LICENSE).
