CHANGELOG for 1.1.x
===================

This changelog references any relevant changes introduced in 1.1 minor versions.

* 1.1.3 (2023-06-13)
    * Update: Render project version number dynamically

* 1.1.2 (2023-06-12)
    * Update: Dropped dependency on uvdesk/composer-plugin in support of symfony/flex
    * PR #619: Changes for error page: Home and support option links (Komal-sharma-2712)
    * Update: Update installation wizard to specify database version during installation
    * PR #614: Translation updates: Correctly render website name in ZH locale (Komal-sharma-2712)

* 1.1.1 (2022-09-13)
    * PR #592: Translation updates (Komal-sharma-2712)
    * PR #582: Translation updates (Komal-sharma-2712)

* 1.1.0 (2022-03-25)
    * Feature: Improved compatibility with PHP 8 and Symfony 5 components
    * Bug #546: Use *getThrowable()* instead of deprecated *getException()* function in *ExceptionSubscriber.php* (vipin-shrivastava)
    * PR #545: Update *README.md* - Add link to respective uvdesk's twitter and youtube profiles (papnoisanjeev)
    * PR #532: Fix typo *mode_rewrite* to *mod_rewrite* (harrisonratcliffe)
    * PR #522: Clicking on website logo should redirect to admin login instead of dashboard in *error.html.twig* (vipin-shrivastava)
    * Bug #518: Retrieve user from security token in *ExceptionSubscriber.php* (vipin-shrivastava)
    * PR #515: Remove miscellaneous duplicate translation records - *messages.it.yml* (Komal-sharma-2712)
    * PR #513: Update italian translation resources - *messages.it.yml* (PeopleInside)
    * PR #509: Update french translation resources - *messages.fr.yml* (user592965)
    * PR #505: Update translation file resources (Komal-sharma-2712)
    * PR #504: Update translation file resources (Komal-sharma-2712)
    * PR #503: Update italian translation resources - *messages.it.yml* (PeopleInside)
    * PR #502: Update translation resources for error page translations (vipin-shrivastava)
