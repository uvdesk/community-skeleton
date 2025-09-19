CHANGELOG for 1.1.x
===================

This changelog references any relevant changes introduced in 1.1 minor versions.

* 1.1.8 (2025-09-19)
    * Updates
        - Dockerfile updates.
        - Added Portuguese translation language.
        - Updated code related to Doctrine Migrations package update.

    * Issue Fixes:
      - Issue #805 - Resolved an issue encountered during migration execution
      - Check removed for docker running env.
      - Enabling permission for the uvdesk.yaml file for saving email setting in case not having read/write permission.
      - Remember me key feature is functional now.

* 1.1.7 (2025-01-03)
    * Features & Enhancements:
       - Microsoft modern app support added (For Mailbox).
       - Added Marketing module.
       - Added OTP option for customers to login.
       - Round robin ticket assignment.
       - Added a New language he (Hebrew).
       - Default read/write permission added for some required files during install.
       - Added option for selecting and save country for ticket.
       - Showing customer email along with name in side filters ticket list. (To avoid confusion in case multiple customers having same name).
       - Attachments renaming true so actual name will not show (For security purpose).
       -  In case of multiple attachments with ticket reply now added cross button for each attachment, So that user can remove a particular attachment before reply instead of removing all with single button.
       - Made updates in installation part (for database connection related issues)
       - Refactoring on code end for main and other dependent repository.

    * Issue Fixes:
        #### Issue Fixed in * [**Core Framework**][1]
        - Issue #508 #549 - Filter issue resolved for customer filtering.
        - Issue #552 - In agent activity option: date filter should be select correct date format.
        - Issue #524 - ticket is in trashed folder and we will reply from the admin then it should not send mail to the customer.
        - Issue #577 - Customer name edit from admin side on ticket view page, if we leave space in starting customer name is removed in ticket view.
        - Issue #587 - ticket is updated from the ticket list page flash message should be same of updated option.
        - Issue #582 - In agent option, the permission tab should be shown a privileges icon.
        - Issue #583 - If extra enter space leave in ticket type, group, and team description so ticket threads do not loads on ticket view page.
        - Issue #573 - In the search filter, if we space to leave in the start and last search filter not working.
        - Issue #702 #601 - system can't calculate kudos score.
        - Issue #594 - The ticket view page is not showing the proper date time format.
        - Issue #605 - If saved Replies sharing without any group and team to another agent or administrator so here shows same saved reply instead of the 403 page.
        - Issue #606 - When mail reply from collaborator side in agent and customer reply email template so collaborator email reply creates a new ticket
        Teams not removing from edit agent page - resolved
        - Issue #665 - When upload txt file in ticket , total count of words attaching at the end of the file.
        - Issue #644 - On the agent side should not be showing the reports icon without given any agent activity privileges.
        - Issue #656 - In spam settings: If email added in spam so should not be ticket created from the admin end.
        - Issue #656 - In spam settings: If email added in spam so should not be ticket created from the admin end.
        - Download link correction for ticket.
        - Initial thread opening issue if multiple emails in cc or collaborator.
        Microsoft redirect URL update.
        - Lang select snippets position issue resolved on dashboard.

        #### Issue Fixed in * [**support-center-bundle**][2]
        - Issue #538 - Tag line is not translated in other languages except the english.
        - Made required message field in ticket creation form on front end.
        - Issue #228 - front website cookies policy Popup issue if switch language in arabic.
        - Issue #168 - Branding logo file type checking issue.
        - Issue #162 - Broadcast message when choosing current date, not showing current date.
        - Issue #215 - Article's numbered list not being rendered correctly.
        - Issue #218 - In Folder, if we using the any docs file in folder image file upload so here showing an error instead of warning.
        - Issue #174 - CSS Font-size 0 hides OL/UL/LI in Knowledgebase.
        - Issue #170 - When creating an article and adding a tag this special character: " / " after click on view button shows an error.
        - Issue #169 - When creating articles and adding tags should be show warning here: Must be less than 20 characters.
        - Issue #206 - Trashed ticket should not open on customer end.
        - Issue #216 - In article should be limit added for the horizontal lines.
        - Issue #173 - In article section when choosing Div and Pre tag so customer panel not showing text or content.
        - Marketing announcement URL validation added.
        - Allowing underscore in strong password for spacial characters.
        - setting customer last reply time.
        - Issue #245 - Update in customer dashboard footer content.
        - Updated License and support email address for repository.

* 1.1.4 (2024-08-26)
    * Feature: Add functionality for tracking the installation count and count of active users (ars128)

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

    [1]: https://github.com/uvdesk/core-framework/
    [2]: https://github.com/uvdesk/support-center-bundle
