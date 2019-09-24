## 2.1.0

*Released at 2019-07-15*

* added new callback pagination
* fixed sorting when using class properties
* made some requirements explicit
* removed some unused code
* allowed for null Request object passed in, to avoid edge cases
* switched from PSR-0 to PSR-4

## 2.0.0

*Released at 2019-06-26*

* increased php minimum version
* added support form mongodb-odm version 2 (and removed support for version 1)
* added getters to PaginationInterface
* removed DBALQueryBuilderSubscriber
* removed deprecations for Symfony event system
* changed signature of ArraySubscriber (and, in general, many signatures that got type hinting)
