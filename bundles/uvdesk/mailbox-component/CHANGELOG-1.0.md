CHANGELOG for 1.0.x
===================

This changelog references any relevant changes introduced in 1.0 minor versions.

* 1.0.14 (2021-10-27)
    * **Misc. Updates:**
        * Compatibility with PHP 8. 
        * Added Errors catch during ticket conversion using refresh mailbox command errors will show on console  in case of any errror.
        * Added a manual check method to check ticket create process using raw content of emails. 

    * **Issue #69:** upgrade php-mime-mail-parser version to 7.
    * **Issue #71:** Use IMAP IDLE to immediately get new tickets.
    * **Issue #72:** Error configuring CRONTAB.
    * **Issue #80:** Mailbox component doesn't extract inline image as attachment.
    * **Issue #81:** Received Emails not creating/updating tickets.

* 1.0.13 (2021-08-23)
    * **Issue #399:** Reply from collaborator gmail so collaborator name is not showing.

    * **Misc. Updates:**
        * Lowercase and upercase check condition added for searching mailbox.
        * Option added for delete inbox emails after mails fetch and converted into ticket.
        * Collaborator reply threads added into ticket threads.

* 1.0.12 (2021-08-21)
    * **Issue #399:** Reply from collaborator gmail so collaborator name is not showing.

    * **Misc. Updates:**
        * Lowercase and upercase check condition added for searching mailbox.
        * Option added for delete inbox emails after mails fetch and converted into ticket.
        * Collaborator reply threads added into ticket threads.

* 1.0.11 (2021-06-19)
    * **Misc. Updates:**
        * Methods added for checking mailbox email exist in multiple to address mail and       creating ticket for the same.

* 1.0.10 (2021-04-02)

    * **Issue Fixes:**

    * **Issue #58:** MailboxService fails to create new ticket when to is not canonically defined.
    * **Issue #59:** getting exception when click on add new mailbox button.
    * **Issue #60:** mailbox is accessible by agent using search bar.
    * **Issue #61:** Email validation failure.
    * **Issue #62:** Email validation failure.
    * **Issue #64:** email are not converted into ticket as mailbox is case sensitive.
    * **Issue #65:** email are not converted into ticket if sent from web form.
    * **Issue #67:** The new MailboxService.php did not open ticket from emails.
    * **Issue #68:** Emails from same sender with same subject line not created.

    * **Misc. Updates:**
        * Controller updates as per symfony version 4.3 for removing depreciation messages.
        * Updates with precheck statement for ticket creation process.
        * Code updates for Auto-forwording and forwording emails updates.
        * Accept and convert both capitalize and non-capitalize email conversion.

* 1.0.9 (2020-07-22)
    * **Issue #57:** Can't see embedded images in ticket.
    * **Issue #56:** refresh-mailbox produces Parse Error.

* 1.0.8 (2020-05-26)
    * **Misc. Updates:**
        * Added some condition to remove redundency of tickets when more conversation between customer and agent and ticket get duplicates.

* 1.0.7 (2020-04-17)
    * **Misc. Updates:**
        * Change processing function and removed unnecessary code for speed up.

* 1.0.6 (2020-03-17)
    * **Misc. Updates:**
        * Added Missing Translations.

* 1.0.5 (2020-02-12)
    * **Misc. Updates:**
        * Included Github issue templates.

* 1.0.4 (2020-01-25)
    * **Issue #38:** Issue for imap host field when add host inside qoutes ' '.
    * **Issue #28:** Error while edit disable mailbox.
    * **Issue #50:** Email setting are not being update in production mode.
    * **Issue #51:** Duplicate entry for ticket when running refresh command second time.

* 1.0.3 (2019-11-15)
    * **Issue #46:** IMAP not creating tickets
    * **Misc. Updates:**
        * Included Github issue templates
        * Updated composer dependencies & set minimum required php version to 7.2

* 1.0.2 (2019-10-22)
    * **Misc. Updates:**
        * Use https when available while refreshing mailboxes via CLI
        * Updated README.md with link to the official gitter chat for uvdesk/mailbox-component

* 1.0.1 (2019-10-15)
    * **Misc. Updates:**
        * Only users with admin level privileges can configure mailbox settings

* 1.0.0 (Released on 2019-10-09)
    * **Issue #44:** Misc. fixes (raised by anmol107)
    * **Issue #14:** duplicate swiftmailer created with same email (raised by vaishaliwebkul)
    * **Issue #42:** SwiftMailer SVG update (raised by vaishaliwebkul)
    * **Issue #41:** Added Mailbox entry in Search  list (raised by vaishaliwebkul)
    * **Issue #40:** Add search bar component items (raised by shubhwebkul)
    * **Issue #39:** Error when update swiftmailer configuration (raised by vaishaliwebkul)
    * **Issue #32:** IMAP host field is not mandatory (raised by vaishaliwebkul)
    * **Issue #35:** update template emailSettings.html (raised by vaishaliwebkul)
    * **Issue #31:** Mailbox fields missing when edit mailbox for imap transport (raised by vaishaliwebkul)
    * **Issue #15:** Swiftmailer gets deleted for setup mailbox (raised by vaishaliwebkul)
    * **Issue #16:** updated swiftmailer id not update into uvdesk.yaml (raised by vaishaliwebkul)
    * **Issue #33:** Confirm box must be appear while deleting a mailbox configuration (raised by vaishaliwebkul)
    * **Issue #30:** uvdesk.yml file update and issues (raised by kumarSaurabh27)
    * **Issue #22:** Swiftmailer update with blank mailer_id (raised by vaishaliwebkul)
    * **Issue #10:** Define maximum character length of mailbox name (raised by vaishaliwebkul)
    * **Issue #20:** Port not define for mailbox when set transport as IMAP (raised by vaishaliwebkul)
    * **Issue #27:** Resolve issue(thread was not creating) while creating the ticket via … (raised by papnoisanjeev)
    * **Issue #26:** Feature added to show progress in Mailbox refresh command and Issues. (raised by kumarSaurabh27)
    * **Issue #24:** Update Prefix in uvdesk.yaml (raised by vaishaliwebkul)
    * **Issue #18:** yahoo configuration issue with user password  (raised by vaishaliwebkul)
    * **Issue #13:** Default site url set when update uvdesk.yaml[email settings] (raised by vaishaliwebkul)
    * **Issue #23:** mailbox-component issue-10 (raised by kumarSaurabh27)
    * **Issue #9:** Mailbox id not accept integer values  (raised by vaishaliwebkul)
    * **Issue #12:** Error while deleting swiftmailer (raised by vaishaliwebkul)
    * **Issue #8:** Mailbox fields not sanitized properly (raised by vaishaliwebkul)
    * **Issue #21:** Always set automatically created mailbox id  (raised by vaishaliwebkul)
    * **Issue #19:** Update message if mailbox configuration not found (raised by vaishaliwebkul)
    * **Issue #11:** blocked email check when creating ticket through mail (raised by papnoisanjeev)
    * **Issue #7:** resolved issue (raised by shubhwebkul)
    * **Issue #6:** Mailbox setup validation updates (raised by shubhwebkul)
    * **Issue #5:** Added a function in mailbox service for mailbox collection (raised by papnoisanjeev)
    * **Issue #4:** mailbox updates (raised by shubhwebkul)
    * **Issue #3:** resolved issues (raised by shubhwebkul)
    * **Issue #2:** resolved issues while configuring mailbox and refactored code (raised by shubhwebkul)
    * **Issue #1:** Decoupled Mailbox Component (raised by akshaywebkul)
