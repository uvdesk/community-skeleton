Security
========

The Doctrine library is operating very close to your database and as such needs
to handle and make assumptions about SQL injection vulnerabilities.

It is vital that you understand how Doctrine approaches security, because
we cannot protect you from SQL injection.

Please read the documentation chapter on Security in Doctrine DBAL and ORM to
understand the assumptions we make.

- [DBAL Security Page](https://github.com/doctrine/dbal/blob/master/docs/en/reference/security.rst)
- [ORM Security Page](https://github.com/doctrine/doctrine2/blob/master/docs/en/reference/security.rst)

If you find a Security bug in Doctrine, please report it on Jira and change the
Security Level to "Security Issues". It will be visible to Doctrine Core
developers and you only.
