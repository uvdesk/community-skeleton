## 3.4.0 (2019-06-20)

* Deprecate "excluded_404s" option
* Flush loggers on `kernel.reset`
* Register processors (`ProcessorInterface`) for autoconfiguration (tag: `monolog.processor`)
* Expose configuration for the `ConsoleHandler`
* Fixed psr-3 processing being applied to all handlers, only leaf ones are now processing
* Fixed regression when `app` channel is defined explicitly
* Fixed handlers marked as nested not being ignored properly from the stack
* Added support for Redis configuration
* Drop support for Symfony <3

## 3.3.1 (2018-11-04)

* Fixed compatiblity with Symfony 4.2

## 3.3.0 (2018-06-04)

* Fixed the autowiring of the channel logger in autoconfigured services
* Added timeouts to the pushover, hipchat, slack handlers
* Dropped support for PHP 5.3, 5.4, and HHVM
* Added configuration for HttpCodeActivationStrategy
* Deprecated "excluded_404s" option for Symfony >= 3.4

## 3.2.0 (2018-03-05)

* Removed randomness from the container build
* Fixed support for the `monolog.logger` tag specifying a channel in combination with Symfony 3.4+ autowiring
* Fixed visibility of channels configured explicitly in the bundle config (they are now public in Symfony 4 too)
* Fixed invalid service definitions

## 3.1.2 (2017-11-06)

* fix invalid usage of count()

## 3.1.1 (2017-09-26)

* added support for Symfony 4

## 3.1.0 (2017-03-26)

* Added support for server_log handler
* Allow configuring VERBOSITY_QUIET in console handlers
* Fixed autowiring
* Fixed slackbot handler not escaping channel names properly
* Fixed slackbot handler requiring `slack_team` instead of `team` to be configured

## 3.0.3 (2017-01-10)

* Fixed deprecation notices when using Symfony 3.3+ and PHP7+

## 3.0.2 (2017-01-03)

* Revert disabling DebugHandler in CLI environments
* Update configuration for slack handlers for Monolog 1.22 new options
* Revert the removal of the DebugHandlerPass (needed for Symfony <3.2)

## 3.0.1 (2016-11-15)

* Removed obsolete code (DebugHandlerPass)

## 3.0.0 (2016-11-06)

* Removed class parameters for the container configuration
* Bumped minimum version of supported Symfony version to 2.7
* Removed `NotFoundActivationStrategy` (the bundle now uses the class from MonologBridge)
