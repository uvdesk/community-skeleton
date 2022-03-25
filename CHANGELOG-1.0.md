CHANGELOG for 1.0.x
===================

This changelog references any relevant changes introduced in 1.0 minor versions.

* 1.0.17 (2021-10-27)
    * **Misc. Updates:**
        * Compatibility with PHP 8.
        * Updated error pages design and added links.
        * Saved reply search option added with default focus on search bar to save clicks.
        * Added yellow background for note on ticket reply box.
        * Layout updates on ticket view for scroller and search dropdown.
        * Cache clear button added on dashboard so that user can clear cache of project without 
        running command using CMD.
        * Ticket conversion issue during mailbox refresh command so now user will able to see 
        error on CMD if any error.
        * Added route for dubugging ticket creation issue using email.
        * All Attachment remove from it's physical path as well if we delete any ticket or profile etc.
        * Ticket Transfer functionality added if removing a agent all tickets will assigned to another agent using workflow.
        * Added some default workflow and email templates for collaborators.
        * Updated "last update" filter on customer ticket listing.

    * **Bug Fixes:**
        * **Issue #492:**  agent password creation redirects to customer login page.
        * **Issue #488:**  Better managment of email fetching in case of errors.
        * **Issue #485:**  Crontab.
        * **Issue #484:**  No puedo enviar ni recibir correos
        * **Issue #483:**  Get laravel 8 Uvdesk
        * **Issue #480:**  Improve 404 page enhancement.
        * **Issue #476:**  Fix the default email template to customer when ticket is created.
        * **Issue #475:**  Error when downloading attachment from customer side
        * **Issue #474:**  Add an option to not rename attachments.
        * **Issue #472:**  Login Button backend shows no reaktion.
        * **Issue #465:**  Sort ticket by latest updated.
        * **Issue #466:**  Loading issue of Tickets which have more Text messages.
        * **Issue #464:**  Line breaks are not or not nicely displayed.
        * **Issue #462:**  Error Create Ticket.
        * **Issue #461:**  swiftmailer.yaml
        * **Issue #459:**  Disable cloudflare CDN for static contents.
        * **Issue #457:**  swift error.
        * **Issue #455:**  Move the HelpDesk string to the custom field.
        * **Issue #454:**  Can not install UVdesk after install of Composer 2.x.
        * **Issue #452:**  error deleting ticket permanently.
        * **Issue #452:**  User login error message not translated.
        
* 1.0.16 (2021-08-23)
    * **Misc. Updates:**
        * Kudos feature added for UVdesk opensource.
          https://support.uvdesk.com/es/blog/uvdesk-what-is-kudos
        * Added a new option for mailbox setting that Email should be deleted from inbox after fetch and converted into ticket if user select that checkbox.
        * Added password encryption for Swift mailer and  Mailbox.
        * Corrected and added timestamp setting for agent and customer both.
        * Collaborator replies adding to the ticket thread.
        * Flash Message with a warning if swift mailer is not setup or working with ticket create process.
        * Profile picture remove option added for customer and agent both.
        * Reply to CC and BCC users from customer panel if added.
        * Fixed multiple security issues with opensource.
        * Added multiple missing translation in files.
            
    * **Bug Fixes:**
        * **Issue #423:**  Status of the ticket not transalted in customer ticket list.
        * **Issue #428:**  Attachment and Logo Issue - Web Installer Public Folder Issue.
        * **Issue #435:**  Newer TLDs are considered invalid.
        * **Issue #437:**  can’t upload logo after updating to 1.0.14.
        * **Issue #438:**  Unable to finish installation - Error during load/superuser.
        * **Issue #439:**  Update jQuery and Underscore.js
        * **Issue #433:**  Email should be deleted from mailbox after fetch.
        * **Issue #429:**  Invalid type for path "uvdesk_mailbox.mailboxes.Support.imap_server.password". Expected scalar, but got object.
        * **Issue #417:**  Potential Security vulnerability.
        * **Issue #401:** Need to implement a workflow that alert if any issue with sending email occurs.
        * **Issue #382:** Improve new user experience: install and setup.
        * **Issue #410:** Unable to create super user during installation.
        * **Issue #375:** [Feature request] support extensions.
        * **Issue #372:** Option to remove emails from mailbox after they are fetched.
        * **Issue #340:** Option for operator and for the customer to remove the profile picture.
        * **Issue #326:** Issue with translations on visitor and operator side.
        * **Issue #279:** Add possibility to delete emails when is added to the ticket.
        * **Issue #350:** Users avatar not delted from the server
        * **Issue #276:** Issues wth swiftmailer password if contains specials characters. Also save password not encrypted seems not good for security.

* 1.0.15 (2021-08-21)
    * **Misc. Updates:**
        * Kudos feature added for UVdesk opensource.
          https://support.uvdesk.com/es/blog/uvdesk-what-is-kudos
        * Added a new option for mailbox setting that Email should be deleted from inbox after fetch and converted into ticket if user select that checkbox.
        * Added password encryption for Swift mailer and  Mailbox.
        * Corrected and added timestamp setting for agent and customer both.
        * Collaborator replies adding to the ticket thread.
        * Flash Message with a warning if swift mailer is not setup or working with ticket create process.
        * Profile picture remove option added for customer and agent both.
        * Reply to CC and BCC users from customer panel if added.
        * Fixed multiple security issues with opensource.
        * Added multiple missing translation in files.
            
    * **Bug Fixes:**
        * **Issue #423:**  Status of the ticket not transalted in customer ticket list.
        * **Issue #428:**  Attachment and Logo Issue - Web Installer Public Folder Issue.
        * **Issue #435:**  Newer TLDs are considered invalid.
        * **Issue #437:**  can’t upload logo after updating to 1.0.14.
        * **Issue #438:**  Unable to finish installation - Error during load/superuser.
        * **Issue #439:**  Update jQuery and Underscore.js
        * **Issue #433:**  Email should be deleted from mailbox after fetch.
        * **Issue #429:**  Invalid type for path "uvdesk_mailbox.mailboxes.Support.imap_server.password". Expected scalar, but got object.
        * **Issue #417:**  Potential Security vulnerability.
        * **Issue #401:** Need to implement a workflow that alert if any issue with sending email occurs.
        * **Issue #382:** Improve new user experience: install and setup.
        * **Issue #410:** Unable to create super user during installation.
        * **Issue #375:** [Feature request] support extensions.
        * **Issue #372:** Option to remove emails from mailbox after they are fetched.
        * **Issue #340:** Option for operator and for the customer to remove the profile picture.
        * **Issue #326:** Issue with translations on visitor and operator side.
        * **Issue #279:** Add possibility to delete emails when is added to the ticket.
        * **Issue #350:** Users avatar not delted from the server
        * **Issue #276:** Issues wth swiftmailer password if contains specials characters. Also save password not encrypted seems not good for security.

* 1.0.14 (2021-06-19)
    * **Misc. Updates:**
        * Web installer updates for making installtion process easier and smooth also added progess bar.
            - Extra checks for file permission https://prnt.sc/11ypcoo , https://prnt.sc/11ypvna
            - Progess Bar with web installer: https://prnt.sc/11ypg5c , https://prnt.sc/11yp43d
        * compatibility with composer 2.
        * Agent Activity section added under report section. 
          https://prnt.sc/124brkr, https://prnt.sc/124bttl, https://prnt.sc/124bx1y
        * Announcement section added for uvdesk opensource.
          https://tinyurl.com/yf8zx2xy, https://prnt.sc/1239xpy
        * ZH_CN (Chinese) Translation file added into project.
        * Site_url will automatically update when saving the email setting.

    * **Bug Fixes:**
        * **Issue #404:**  UVdesk getting frequently logged out when clicking on links.
        * **Issue #405:**  Redirect users to login page after email validation
        * **Issue #406:**  Is there a way I could hid the menu links and dashboard links.
        * **Issue #407:**  Ticket forwarding option forward the entire thread. 
        * **Issue #408:**  duplicate key on ../translation/messages.ar.yml file.
        * **Issue #409:**  Emails not retrieving.
        * **Issue #411:**  error when updating composer inside latest version.
        * **Issue #412:**  i have installed uvdesk open source and i have configured mailbox, email settings and swift mailer but the customer is not able to receive a mail when replied to a ticket ? 
        * **Issue #415:**  remove debugger from the installation wizard.

* 1.0.13 (2021-04-02)
    * **Misc. Updates:**
        * **Last reply option added on ticket list to check when last time reply added on ticket.**
        * **reCAPTCHA setting option added on admin panel with profile section now admin can set recaptcha credentails on admin panel and can enable it.**
        * **Disabled old dates for datapicker in broadcast section.**
        * **Strong password added (for security purpose) for all places from where user create and update password.**
        * **Current version updated in dashboard in footer so that user have idea which version he is using currently.**
        * **Added some more option on admin/agent side when reply to a ticket i.e hyperlink, Spellcheck, adding a image by a external link, source code and differnt style formats option added into editor.**
        * **Iframe support in editor for adding Youtube link etc In article section(knowledgebase).**
        * **Fancy style added for Blockquote https://prnt.sc/xle8c4**
        * **New auto fixtures added for workflow so user don't need to add workflow for the same.**
        * **Added CC option for initial thread on ticket https://prnt.sc/1118g8e.**
        * **Added option for automatically label assign to ticket from workflow.**
        * **All latest version links updated for jquery, backbone and underscore js.**
        * **Time format added for customer panel on profile section.**
        * **Customer redirection after ticket create from customer panel - If customer is log in then will redirect to ticket listing if not then will redirect to knowledgebase.**
        * **Time format and time zone will automatically assign to customer and agent now which is set in admin side branding page.**
        * **Added New polish translation file(pl).**
        
    * **Bug Fixes:**
        * All controller code updates as according to symfony version(4.3) and maximum deprication messages removed from project.
        * Docker Fixes (FROM ubuntu:latest to FROM ubuntu:18.04 in Dockerfile)
        * Docker composer version updated.
        * Mail to customer in case of ticket status update mailing issue fixed.
        * Email regix updated for swiftmailer as from front end it is only allowing .com/.in etc not any other custom emails like .support
        * tr and it Translation files updates.
        * Branding custom css and js as duplicate issue resolved.
        * Issue with Locale in mail if ticket created using email was not correct and has been fixed now.
        * Groups and Teams Remove issue fixed for saved replies.
        * Collaborator ticket view issue on customer panel (not able to see tickets) resolved.
        * My tickets tab issue for agents as agent only see the ticket assigned to admin only not their own ticket assigned to him Resolved.
        * Email Receiving issue when assign a ticket to agent resolved.
        * Updated addPart for plain text in mail send function as in some cases email send was not working.
        * Translation update for reset password page.
        * Method change to getOneOrNullResult for mail to agent action.
        * Mail to CC and BCC users without ticket link as they are not really the customer and can not login into customer panel.
        * Forwording and Auto forwording emails conversion issue resolved.
        * Pagination issue on ticket listing on customer panel also for tag on admin panel         resolved.
        * Mailbox ticket create issue if Email send on capitalize email Id.
        * Email trailing issue on ticket reply if agent and customer both reply on ticket using email id resolved.
        * Seachbar component on dashoard based on permission issue fixed now.
        * Deleting the trash ticket issue has been fixed.
        * Issue with prod mode when clearing the cache resovled.
        * Saved reply disapper issue for agent if agent update anything Issue has been fixed now.
        * Article and Category createdAt filter issue has been fixed now.
        * Disabled user account and when user try to login then correct message for account disablity.
        * Panel sidebar active status issue fixed.

* 1.0.12 (2020-07-27)
    * **Misc. Updates:**
        * Added Mailbox filtering in ticket list. Now tickets can be filter according with different Mailboxes. 
        * Ticket type sorted alphabatically for ticket creation form and other places.
        * Translation file updates for different languages.
        * Updates in all dependent bundles.
        
    * **Bug Fixes:**
        * **Issue #292:**  Error during install: Table 'helpdesk.uv_support_role' doesn't exist.
        * **Issue #290:**  The cogs keep spinning!.
        * **Issue #284:**  Issues with Italian translations.
        * **Issue #275:**  need to add ar translation for the admin login page.  
        * **Issue #273:**  duplicate key on ../translation/messages.ar.yml file.
        * **Issue #269:**  Failed to connect to DB if DB port other then 3306.
        * **Issue #269:**  Dockerfile obsolete.  
        * **Issue #267:**  Variable "user_service" does not exist.
        
* 1.0.11 (2020-05-27)
    * **Misc. Updates:**
        * Dependedent bundles updates and issue fixes.
        * Ticket duplicate issue in conversation removed.
          
    * **Bug Fixes:**
        * **Issue #257:**  Installation never finish.
        * **Issue #259:**  /wizard/xhr/load/super-user error 500.
        * **Issue #261:**  Cannot create API Access Token.
        * **Issue #262:**  first new rule in workflow and email sending stopped working.
        * **Issue #263:**  composer update caused uvdesk broken.
        * **Issue #265:**  When the setup wizard mode on... 
       
* 1.0.10 (2020-04-17)
    * **Misc. Updates:**
        * Added missing translation words for french.
        * Change processing function and removed unnecessary code for speed up.
        * Dependedent bundles updates for speed up project.

        
    * **Bug Fixes:**
        * **Issue #255:**  Unable to install the App (Database Url malformed).
        * **Issue #256:**  Failed to exec 'php bin/console uvdesk:configure-helpdesk' on Ubuntu PHP 7.4.
        * **Resolved speed issue with previous version.**
        

* 1.0.9 (2020-03-17)
    * **Misc. Updates:**
        * Added Missing translation for different languages.
        * Installer miner changes.
    * **Bug Fixes:**
        * **Issue #252:**  Locale code from uvdesk.yaml file gets removed when update email settings.
        * **Issue #253:**  Translation while search any keywords in dashboard.
        * **Issue #254:**  Deleted Tickets Reappearing after uvdesk:referesh.

* 1.0.8 (2020-02-12)
    * **Features**
        * **Translation Support (Multilingual).**
    * **Misc. Changes:**
        * .htaccess mode rewrite condition changes(For API Bundle).
    * **Issue #247:**  Translator
    * **Issue #246:**  UVDesk hangs trying to create Customer / Agent / Team / Group.
    * **Issue #242:** Database migration gets failed if automatically created db in production environment.
    * **Issue #242:** Language Spanish.  

* 1.0.7 (2020-01-27)
    * **Misc. Changes:**
        * .htaccess mode rewrite condition changes.
        *  Web Installer design changes.
        *  Dependent packages updates.

    * **Issue #238:**  Showing older version in web-installer  

* 1.0.6 (2020-01-06)
    * **Misc. Changes:**
        * Web Installer design changes.

* 1.0.5 (2019-11-15)
    * **Issue #226:** Missing icon for internal server error page
    * **Misc. Changes:**
        * Installation wizard (web & cli) now allows users to automaticatlly create a database if it doesn't exist

* 1.0.4 (2019-10-31)
    * **Issue #137:** Dockerize application for easy installation
    * **Feature:** Easily dockerize your helpdesk project to deploy it from within a container
    * **Misc. Changes:**
        * Updated README.md and included instructions to deploying the project from within a docker conatiner

* 1.0.3 (2019-10-23)
    * **Misc. Changes:**
        * Updated web installer for better error reporting
        * Updated README.md with link to the official gitter chat for the community project

* 1.0.1 (2019-10-15)
    * **Issue #209:** User's session out will redirect to 404 error page
    * **Misc. Changes:**
        * Updated dependent packages to latest stable release

* 1.0.0 (Released on 2019-10-09)
    * **Issue #163:** Swift mailer and Email settings configuration for outlook not working (raised by alexanderoitx)
    * **Issue #135:** MAMP not working as 127.0.0.1 but works as localhost (raised by vaishaliwebkul)
    * **Issue #205:** Wizard check-requirements rendering errors (raised by piyushwebkul)
    * **Issue #171:** Welcome ticket must be there on ticket panel (raised by vaishaliwebkul)
    * **Issue #154:** Multiple error message (raised by avneesh-webkul)
    * **Issue #94:** Agent unable to view ticket which are assigned to the group (raised by vaishaliwebkul)
    * **Issue #97:** All the errors user get are in developer mode so please convert them in production mode (raised by vaishaliwebkul)
    * **Issue #175:** Stuck at step 4/5 while configuration (raised by vaishaliwebkul)
    * **Issue #134:** Request Feature : hit on setup page without accessing project's public folder on browser  (raised by vaishaliwebkul)
    * **Issue #193:** Unable to run via Composer: (raised by alexsdesign)
    * **Issue #196:** resetting password for super user update credentials link redirection to home page (raised by smallBiz)
    * **Issue #201:** Redis server went away when installing (raised by KlaasT)
    * **Issue #206:** No show Page Navigation (raised by sbonzanni)
    * **Issue #203:** Production Environment Http Error pages (raised by piyushwebkul)
    * **Issue #183:** Installer updated. (raised by piyushwebkul)
    * **Issue #145:** Permission denied error while Configuration  (raised by vaishaliwebkul)
    * **Issue #207:** Translation Added (raised by anmol107)
    * **Issue #122:** MIME type guessers issue while adding attachments for WAMP stack (raised by vaishaliwebkul)
    * **Issue #187:** Reset database configuration issue from web installer (raised by vaishaliwebkul)
    * **Issue #200:** Created issue templates (raised by prashant-webkul)
    * **Issue #197:** Installation Wizard not proceeding further configuration-database step, after pressing the cancel button. (raised by piyushwebkul)
    * **Issue #123:** Memory size issue occur while create project using composer command  (raised by vaishaliwebkul)
    * **Issue #96:** Session out error shows instead of redirect to user at login panel (raised by vaishaliwebkul)
    * **Issue #164:** Feature to set default timezone (raised by vaishaliwebkul)
    * **Issue #167:** can't clone repo due to memory issue (raised by tzak902)
    * **Issue #168:** can't set password for agent (raised by tzak902)
    * **Issue #169:** Forgot password will reset the old password immediately (raised by tzak902)
    * **Issue #190:** An error occured while loading the web debug tool bar (raised by vaishaliwebkul)
    * **Issue #192:** .htaccess mod_rewrite "No input file specified." (raised by VahanPWNS)
    * **Issue #149:** Cannot save article (raised by kzsfluxus)
    * **Issue #101:** Show meaningful warning messages with all of the mandatory input fields (raised by vaishaliwebkul)
    * **Issue #182:** Added a redirection route post Installation (raised by piyushwebkul)
    * **Issue #181:** some changes for files (raised by piyushwebkul)
    * **Issue #136:** Design Issue while resizing menu icon present at dashboard (raised by vaishaliwebkul)
    * **Issue #176:** Call to a member function getPartialDetails() on null when create ticket (raised by vaishaliwebkul)
    * **Issue #180:** 0.1 (raised by piyushwebkul)
    * **Issue #146:** Case sensitive route found for site_URL (raised by vaishaliwebkul)
    * **Issue #179:** UVdesk banner logo link redirects to 404 page in prod mode (raised by vaishaliwebkul)
    * **Issue #172:** Ticket type description data fetch in drop down list instead code (raised by vaishaliwebkul)
    * **Issue #178:** entity compatibility related update (raised by shubhwebkul)
    * **Issue #177:** Configuration Failed at 4/5 step (raised by vaishaliwebkul)
    * **Issue #104:** Search bar is hidden back to left menu bar (raised by vaishaliwebkul)
    * **Issue #165:** Collaborator unable to view ticket  (raised by vaishaliwebkul)
    * **Issue #174:** maker bundle update (raised by piyushwebkul)
    * **Issue #162:** Mailbox refresh issue (raised by rakesh10933)
    * **Issue #155:** Server Requirements (raised by kvnsmn)
    * **Issue #170:** ticket view issue  (raised by vaishaliwebkul)
    * **Issue #166:** Profiler Added (raised by papnoisanjeev)
    * **Issue #150:** Permission error when add attachment (raised by vaishaliwebkul)
    * **Issue #157:** No Route found exception (raised by vaishaliwebkul)
    * **Issue #159:** Link is not clickable for missing extension (raised by vaishaliwebkul)
    * **Issue #138:** Update README.md file by adding mailbox component bundle  (raised by vaishaliwebkul)
    * **Issue #148:** Transport needed for smtp server (raised by vaishaliwebkul)
    * **Issue #141:** If already setup uvdesk , it again redirect us to web installer when open /public directory (raised by vaishaliwebkul)
    * **Issue #158:** community-skeleton issue-154 (raised by kumarSaurabh27)
    * **Issue #152:** Update README.md (raised by vaishaliwebkul)
    * **Issue #160:** Error : Mailbox-refresh command not execute on CentOS 7 (raised by vaishaliwebkul)
    * **Issue #161:** Community Edition Installation Issue (raised by alexanderoitx)
    * **Issue #151:** ERROR: There are extensions that haven't been installed or are currently disabled  (raised by faraimupfuti)
    * **Issue #153:** Is the public folder required after uvdesk install ? (raised by iGitnow)
    * **Issue #156:** UVdesk Admin Panel Login issue. (raised by rakesh10933)
    * **Issue #144:** Signature is not getting updated on the ticket  (raised by Himaniwebkul)
    * **Issue #133:** Open wizard when project root is accessed & installer icons update (raised by shubhwebkul)
    * **Issue #116:** Redirecting route from installer to knowledgebase panel (disable web-installer) (raised by shubhwebkul)
    * **Issue #143:** Error on install (raised by eyedocs)
    * **Issue #142:** Rewrite rule with ISS (raised by mills217)
    * **Issue #139:** tttttuuuuu (raised by deadmaster566)
    * **Issue #91:** Incorrect ticket status count's at agent panel  (raised by vaishaliwebkul)
    * **Issue #107:** Broadcast Message timer UI has Inconsistent style (raised by vaishaliwebkul)
    * **Issue #111:** Attachment issue when customer is sending attachment in reply (raised by UVvidu)
    * **Issue #129:** Request Feature: Pre Installation extension description on web installer (raised by vaishaliwebkul)
    * **Issue #132:** Website prefix value set for member/customer panel are same using command line (raised by vaishaliwebkul)
    * **Issue #128:** Check Design of web installer  (raised by vaishaliwebkul)
    * **Issue #131:** Website prefix default value not set on command line (raised by vaishaliwebkul)
    * **Issue #127:** Extension list in web installer and resolved issues (raised by shubhwebkul)
    * **Issue #126:** Request Feature : to add website prefix functionality using command  (raised by vaishaliwebkul)
    * **Issue #118:** Zip file for all version of php not updated with current live code (raised by vaishaliwebkul)
    * **Issue #125:** Issue during installation of project using composer (raised by vaishaliwebkul)
    * **Issue #48:** Vulnerability found in all email type input fields (raised by vaishaliwebkul)
    * **Issue #110:** Zip 7.2 is not getting migrated with the database after [Step 5/5]  (raised by UVvidu)
    * **Issue #102:** UI issue when window resolution is minimize (raised by vaishaliwebkul)
    * **Issue #124:** Remove non unique select type element from the swiftmailer (raised by vaishaliwebkul)
    * **Issue #121:** Code refactoring (raised by shubhwebkul)
    * **Issue #119:** No Route found from web installer to agent and knowledgebase panel for zip file (raised by vaishaliwebkul)
    * **Issue #120:** Back button for navigation purpose to the previous step in web installer (raised by shubhwebkul)
    * **Issue #112:** Attachment issue when agent is attaching image in reply (raised by UVvidu)
    * **Issue #113:** No check box for account status active part in Agent creation panel (raised by UVvidu)
    * **Issue #114:** No check box to choose group in Agent creation part (raised by UVvidu)
    * **Issue #115:** No check box in permission - in agent creation section  (raised by UVvidu)
    * **Issue #117:** Installer version update (raised by shubhwebkul)
    * **Issue #109:** issue of redirection to member login and knowledgebase (raised by shubhwebkul)
    * **Issue #59:** Email template :- Placeholder should be update according to selected templated, also design issue is there in placeholder (raised by vaishaliwebkul)
    * **Issue #108:** URL change in wizards.js (raised by papnoisanjeev)
    * **Issue #75:** For the document (.pdf, .doc, .xls) attach with ticket reply icon is missing (raised by vaishaliwebkul)
    * **Issue #105:** All type of files will open to select while User profile image insert (support only PNG/JPG) format (raised by vaishaliwebkul)
    * **Issue #27:** Check the message body which contain unnecessary description attach with reply in ticket (raised by vaishaliwebkul)
    * **Issue #68:** Company logo is not showing on email which was set in email template (raised by vaishaliwebkul)
    * **Issue #82:** Customer reply to ticket by adding text effects like (Bold,Italic) then changes not get reflect  (raised by vaishaliwebkul)
    * **Issue #98:** Design end issue for every view when adjust resolution in window (raised by vaishaliwebkul)
    * **Issue #77:** Sorting based on (ticket id,customer name etc) to ticket list not sorting ticket list as selected option (raised by vaishaliwebkul)
    * **Issue #79:** When save super admin credentials their must be a option of first name and last name field as mandatory (raised by vaishaliwebkul)
    * **Issue #63:** Tickets which are assign to particular label ,when open that label :- not contain actual no of tickets (raised by vaishaliwebkul)
    * **Issue #49:** Unable to view customer and agent list at admin panel due to Full Group Join By Clause (raised by vaishaliwebkul)
    * **Issue #88:** Filter tickets by saved replies showing wrong ticket status (raised by vaishaliwebkul)
    * **Issue #99:** Only for single ticket pagination shows at agent panel (raised by vaishaliwebkul)
    * **Issue #100:** web installer next step by just hitting enter (raised by shubhwebkul)
    * **Issue #76:** If don't have required PHP extension still Web installer working for further steps (raised by vaishaliwebkul)
    * **Issue #93:** At agent panel, option available in ticket list mass action should show by assigned permission to that agent (raised by vaishaliwebkul)
    * **Issue #80:** Customer reply to ticket by email then thread content mismatch (raised by vaishaliwebkul)
    * **Issue #85:** Provided admin panel and knowledgebase link at setup page should open with new tab (raised by vaishaliwebkul)
    * **Issue #62:** If customer has more than one ticket ,still with ticket detail it's showing that customer has only 0 more ticket  (raised by vaishaliwebkul)
    * **Issue #58:** When customer reply to their previous ticket using mail then ticket isn't open at admin panel (raised by vaishaliwebkul)
    * **Issue #66:** Need to remove footer from email templates (raised by vaishaliwebkul)
    * **Issue #84:** Unable to unassigned team/group from the ticket (raised by vaishaliwebkul)
    * **Issue #55:** No document/image found when customer create ticket by attaching documents via mail (raised by vaishaliwebkul)
    * **Issue #90:** Attachment issue (raised by Himaniwebkul)
    * **Issue #22:** Search bar for article given at customer panel not response (raised by vaishaliwebkul)
    * **Issue #69:** User unable to open ticket link attached with body of email template on their mail id (raised by vaishaliwebkul)
    * **Issue #56:** New customer not receive account activation mail when customer created (raised by vaishaliwebkul)
    * **Issue #54:** Set default image shown at knowledgebase front  (raised by vaishaliwebkul)
    * **Issue #92:** Unable to remove assigned collaborator to ticket from the customer panel (raised by vaishaliwebkul)
    * **Issue #95:** Fixed issues and prefixes update (raised by shubhwebkul)
    * **Issue #78:** Admin name is missing when select forward a ticket to - > agent (raised by vaishaliwebkul)
    * **Issue #24:** Need warning message while Configure a database if any detail found invalid  (raised by vaishaliwebkul)
    * **Issue #60:** At branding, there is color picker window missing to select colors  (raised by vaishaliwebkul)
    * **Issue #81:** In workflow if select condition as "agent is equal to" ,unable to fetch agent list (raised by vaishaliwebkul)
    * **Issue #83:** Agent list missing from workflow when select option as transfer ticket (raised by vaishaliwebkul)
    * **Issue #87:** Spell error at warning message shown with naming field of email template (raised by vaishaliwebkul)
    * **Issue #89:** Agent Reset password page don't have validations (raised by vaishaliwebkul)
    * **Issue #21:** Back window is visible when success notification popup comes at customer panel (raised by vaishaliwebkul)
    * **Issue #36:** email address and password fields show warning before written anything while save super admin credentials (raised by vaishaliwebkul)
    * **Issue #43:** Validation not apply correctly on database configuration page (raised by vaishaliwebkul)
    * **Issue #46:** Mails are not received by customer by any reply is added to their ticket (raised by vaishaliwebkul)
    * **Issue #52:** Reply to ticket from admin panel by attaching zip file, then files not get found (raised by vaishaliwebkul)
    * **Issue #50:** Mails aren't fetch as ticket at admin end after configure a mailbox (raised by vaishaliwebkul)
    * **Issue #45:** Saved Replies message body is saved blank (raised by vaishaliwebkul)
    * **Issue #37:** At the part of Website Configuration, add some restrictions when add Prefix value for member/customer panel (raised by vaishaliwebkul)
    * **Issue #72:** Agent/Customer Forget Password mail not received When user forget password (raised by vaishaliwebkul)
    * **Issue #74:** Workflow :- When apply action as "mail to agent" then option to select agent are missing (raised by vaishaliwebkul)
    * **Issue #25:** When save super admin account, specify the minimum password length (raised by vaishaliwebkul)
    * **Issue #7:** Show warning if configure database with non-exist Database, or username/password (raised by vaishaliwebkul)
    * **Issue #8:** Check Image Validation at agent/customer profile (raised by vaishaliwebkul)
    * **Issue #73:** Ticket Generate Success Mail For Customer not Received (raised by vaishaliwebkul)
    * **Issue #65:** Customer not receive any attachment on their mail id when agent reply from admin panel by attaching documents (raised by vaishaliwebkul)
    * **Issue #61:** Tickets which are deleted not move into trashed (raised by vaishaliwebkul)
    * **Issue #86:** Unable to unassign team from the ticket in which specific team was already assigned (raised by vaishaliwebkul)
    * **Issue #71:** web installer events update (raised by shubhwebkul)
    * **Issue #70:** Notice Template for option in predefined email templates which are need to be selected by default  (raised by vaishaliwebkul)
    * **Issue #67:** Need to disable Kudos from the custome panel (raised by vaishaliwebkul)
    * **Issue #51:** Attached task option need to be removed from ticket list  (raised by vaishaliwebkul)
    * **Issue #53:** When ticket is created by attaching single zip file-- no single zip found with ticket (raised by vaishaliwebkul)
    * **Issue #57:** Website configuration details get saved without installing database tables (raised by vaishaliwebkul)
    * **Issue #64:** web installer bug fixes (raised by shubhwebkul)
    * **Issue #15:** All the ticket's detail can be view by agent(even that ticket not assigned to related agent) (raised by vaishaliwebkul)
    * **Issue #16:** User get put in CC/BCC mail not added to the ticket reply (raised by vaishaliwebkul)
    * **Issue #26:** File directory not found ,when get to download zip files attached with ticket reply  (raised by vaishaliwebkul)
    * **Issue #30:** At customer panel some of the icon image are missing (raised by vaishaliwebkul)
    * **Issue #47:** When click to add new email template get error  (raised by vaishaliwebkul)
    * **Issue #44:** Code standard updations (raised by shubhwebkul)
    * **Issue #33:** XSS script running while update customer name with ticket list detail (raised by vaishaliwebkul)
    * **Issue #41:** vulnerability issue at tags fields (raised by vaishaliwebkul)
    * **Issue #38:** Dashboard search bar option when search by starting letter's ' T ' (raised by vaishaliwebkul)
    * **Issue #39:** While searching for categories by dashboard search bar, and click on that category , it will redirect to wrong page (raised by vaishaliwebkul)
    * **Issue #42:** How will member login to their panel, if they are at knowledgebase?? (raised by vaishaliwebkul)
    * **Issue #40:** Resolved Git issues (raised by shubhwebkul)
    * **Issue #34:** Website prefixes (raised by shubhwebkul)
    * **Issue #10:** Check by click on ticket thread id which shows with ticket detail (raised by vaishaliwebkul)
    * **Issue #18:** Check ticket list view when click checkbox to get select all the tickets (raised by vaishaliwebkul)
    * **Issue #20:** Update notification message when edit ticket type (raised by vaishaliwebkul)
    * **Issue #11:** Customer Information aren't get update by viewing ticket detail (raised by vaishaliwebkul)
    * **Issue #6:** Super admin credentials saved blank while setup DB (raised by vaishaliwebkul)
    * **Issue #19:** No warning shows when create duplicate ticket type  (raised by vaishaliwebkul)
    * **Issue #9:** Prepared Response section missing while applying to ticket (raised by vaishaliwebkul)
    * **Issue #28:** Ticket list link is not working (raised by vaishaliwebkul)
    * **Issue #29:** While creating a project, Getting Exception as Class 'Composer\EventDispatcher\ScriptExecutionException' not found (raised by vaishaliwebkul)
    * **Issue #31:** Getting error while add saved replies (raised by vaishaliwebkul)
    * **Issue #32:** Unable to delete saved replies (raised by vaishaliwebkul)
    * **Issue #35:** Update README.md (raised by UVvidu)
    * **Issue #17:** Website-Configuration (raised by shubhwebkul)
    * **Issue #13:** Found Error while create ticket,edit workflow, update admin profile (raised by vaishaliwebkul)
    * **Issue #23:** Unable to run my newly created project and get authentication error (raised by vaishaliwebkul)
    * **Issue #12:** some of the links not work in README.md file  (raised by vaishaliwebkul)
    * **Issue #14:** Setup design (raised by shubhwebkul)
    * **Issue #5:** Website-Configuration and Generator (raised by shubhwebkul)
    * **Issue #4:** webpack setup (raised by shubhwebkul)
    * **Issue #3:** Loader, Slider, Mailbox (raised by shubhwebkul)
    * **Issue #2:** Misc. fixes in branch 0.2 (raised by akshaywebkul)
    * **Issue #1:** Web Installer Support (raised by akshaywebkul)
    * **Feature:** Add/Remove/Create third party packages for further functionalities (bundled with [uvdesk/extension-framework][7])
    * **Feature:** Easily configure and manage your support panel for customer convenience (bundled with [uvdesk/support-center-bundle][6])
    * **Feature:** Automate responses to events with workflows and prepared responses (bundled with [uvdesk/automation-bundle][5])
    * **Feature:** Pipe your emails from different sources into your helpdesk as tickets (bundled with [uvdesk/mailbox-component][4])
    * **Feature:** Easily configure and manage your users (agents & customers), tickets, and helpdesk settings (bundled with [uvdesk/core-framework][3])
    * **Feature:** Automate bundle configurations during installation via [composer][1] using the [uvdesk/composer-plugin][2]
    * **Feature:** Setup your helpdesk project from the browser using the Web Installer Wizard
    * **Feature:** Setup your helpdesk project from CLI using the Console Wizard


[1]: https://getcomposer.org/
[2]: https://github.com/uvdesk/composer-plugin
[3]: https://github.com/uvdesk/core-framework
[4]: https://github.com/uvdesk/mailbox-component
[5]: https://github.com/uvdesk/automation-bundle
[6]: https://github.com/uvdesk/support-center-bundle
[7]: https://github.com/uvdesk/extension-framework
