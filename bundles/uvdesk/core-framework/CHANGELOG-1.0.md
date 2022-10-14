CHANGELOG for 1.0.x
===================

This changelog references any relevant changes introduced in 1.0 minor versions.

* 1.0.17 (2021-10-27)
    * **Misc. Updates:**
        * **Compatibility with PHP 8.**
        * **Background color of note updated to yellow for reply box.**
        * **Saved reply search filter added and focus on search added.**
        * **Added some default email templates.**
        * **Ticket transfer functionality using workflow.**
        * **Delete attachment from physical path.**

    * **Bug Fixes:**
        * **Issue #423:** When Choose format option in H1,h2 headings from customer and admin side so in admin and customer panel format is not showing properly bug
        * **Issue #424:** When Set Status from admin side so customer side not showing bug.
        * **Issue #425:** When Forward message from admin and agent side so mail format is not showing properly.
        * **Issue #426:** In kudos is not able to team and source fields filter. 
        * **Issue #428:** When I make manually template from workflow and email templates so collaborators name and email not showing in collaborator mail.
        * **Issue #429:** when create workflow for new ticket generate so automatically assigned to agent bug.
        * **Issue #430:** When create new agent with select new create set privileges and group so showing error bug Fixed.
        * **Issue #432:** When I make manually template from workflow and email templates so manually templates create new ticket when coll. reply from mail side bug Fixed
        * **Issue #433:** When create Note for customer reply so agent mail side showing note message instead of reply message.
        * **Issue #435:** when collaborator reply from web and mail side so not going to mail to agent mail id regarding customer added a reply bug.
        * **Issue #441:** when we use add a note for customer reply so not going to attachment in mail side of agent and collaborator side bug Fixed.
        * **Issue #442:** When go to workflow and choose option Set Type As so here showing is Disabled Ticket Type bug
        * **Issue #443:** When Ticket Assign to agent so not showing to these placeholders {%ticket.message%} {%ticket.threadMessage%} bug Fixed.
        * **Issue #451:** When Unchecked Website status in branding section so showing frontend page from customer side instead of removing frontend page bug.
        * **Issue #451:** When Unchecked Website status in branding section so showing frontend page from customer side instead of removing frontend page bug.
        * **Issue #458:** When Unchecked Website status in branding section so showing frontend page from customer side instead of removing frontend page bug.

* 1.0.16 (2021-08-23)
    * **Misc. Updates:**
        * **Flash Mesaage with a warning if swiftmailer is not setup or working with ticket create process**
        * **Save password with encryption in swiftmailer.yaml for security**
        * **Time stamp format correction for agent as well as for customer.**

    * **Bug Fixes:**
        * **Issue #383:** getting exception when filter kudos based on customer group
        * **Issue #384:** broken image on kudos customer filter.
        * **Issue #385:** customer image should be visible along with customer name in kudos grid.
        * **Issue #386:** Collaborator name is coming wrong on ticket thread at agent ticket view.   
        * **Issue #387:** Collaborator on email is coming wrong format.
        * **Issue #388:** Users Image not displaying properly in Group and Team Section.
        * **Issue #392:** Gmail Replies from admin gmail is not added in ticket thread of admin panel.
        * **Issue #393:** Email format is not properly showing in CC and BCC Email.
        * **Issue #394:** In Customer and Collaborator dashboard image not displaying of Admin Image.
        * **Issue #396:** Agent Activity is not working properly from agent side.
        * **Issue #397:** Translation is not showing properly in it(italian) language admin website and agent side view.
        * **Issue #399:** Reply from collaborator gmail so collaborator name is not showing.
        * **Issue #403:** Remove from customer side image so default image not showing in Tickets thread.
        * **Issue #405:** Reply from Customer Side also added CC and BCC mails So Not going to mail CC and BCC mail id's.

* 1.0.15 (2021-08-21)
    * **Misc. Updates:**
        * **Flash Mesaage with a warning if swiftmailer is not setup or working with ticket create process**
        * **Save password with encryption in swiftmailer.yaml for security**
        * **Time stamp format correction for agent as well as for customer.**

    * **Bug Fixes:**
        * **Issue #383:** getting exception when filter kudos based on customer group
        * **Issue #384:** broken image on kudos customer filter.
        * **Issue #385:** customer image should be visible along with customer name in kudos grid.
        * **Issue #386:** Collaborator name is coming wrong on ticket thread at agent ticket view.   
        * **Issue #387:** Collaborator on email is coming wrong format.
        * **Issue #388:** Users Image not displaying properly in Group and Team Section.
        * **Issue #392:** Gmail Replies from admin gmail is not added in ticket thread of admin panel.
        * **Issue #393:** Email format is not properly showing in CC and BCC Email.
        * **Issue #394:** In Customer and Collaborator dashboard image not displaying of Admin Image.
        * **Issue #396:** Agent Activity is not working properly from agent side.
        * **Issue #397:** Translation is not showing properly in it(italian) language admin website and agent side view.
        * **Issue #399:** Reply from collaborator gmail so collaborator name is not showing.
        * **Issue #403:** Remove from customer side image so default image not showing in Tickets thread.
        * **Issue #405:** Reply from Customer Side also added CC and BCC mails So Not going to mail CC and BCC mail id's.

* 1.0.14 (2021-06-19)
    * **Misc. Updates:**
        * **Add new feature under report section Agent Activity.**
        * **Attachment download issues for some extension like docx.**
        * **Italian language translation corrections.**

    * **Bug Fixes:**
        * **Issue #374:** {%ticket.customerEmail%} placeholder is not working with saved replies when apply on ticket.
        * **Issue #373:** admin name is not coming in agent list drop down.
        * **Issue #372:** Getting 404 on ticket view at agent panel if group is not added in ticket.
        * **Issue #371:** getting exception when edit agent profile.
        * **Issue #370:** Creating a new agent without activating creates zombie agent.
        * **Issue #369:** exception when agent view activity section.
        * **Issue #368:** member prefix or customer prefix value should be saved in database.
        * **Issue #365:** broken agent images in report filter search bar.
        * **Issue #363:** not able to filter group based on status.
        * **Issue #362:** An exception has been thrown during the rendering of a template ("Class "1\BaseController" does not exist in C:\Program Files\Xampp\htdocs\uvdesk-community-v1.0.13\config/routes\../../src/Controller/ (which is being imported from "C:\Program Files\Xampp\htdocs\uvdesk-community-v1.0.13\config/routes/annotations.yaml"). Make sure annotations are installed and enabled.").

* 1.0.13 (2021-04-02)
    * **Misc. Updates:**
        * **Last reply Field Added with ticket listing.**
        * **reCAPTCHA setting option provided on Admin panel.**
        * **Strong password added (for security purpose) for all places from where user create and update password.**
        * **Current version updated in dashboard in footer so that user have idea which version he is using currently.**
        * **Fancy style added for Blockquote https://prnt.sc/xle8c4**
        * **Added option for automatically label assign to ticket from workflow.**
        * **All latest version links updated for jquery, backbone and underscore js.**

    * **Bug Fixes:**
        * **Issue #313:** user.service not found exception.
        * **Issue #317:** Exception showing when view agent list.
        * **Issue #318:** getting exception when redirect to ticket view page.
        * **Issue #319:** exception when creating swiftmailer.
        * **Issue #320:** showing error while save email settings.
        * **Issue #321:** display flash message when save branding theme.
        * **Issue #322:** error on console when add new email template.
        * **Issue #323:** getting exception when submitting a reply to ticket.
        * **Issue #325:** getting error when save agent profile.
        * **Issue #326:** ticket quick view icon is not working.
        * **Issue #327:** customer profile image is broken in filter.
        * **Issue #329:** all the apps are visible to agent in search even they don't have privilege to manage.
        * **Issue #330:** Not able to remove assigned group/team from saved replies.
        * **Issue #331:** unnecessary privilege added.
        * **Issue #332:** getting exception when agent update customer profile.
        * **Issue #334:** Email validation failure.
        * **Issue #337:** Asking for ability to set color of all text on homepage..
        * **Issue #338:** EmailService: add text/plain version of the email content.
        * **Issue #340:** assign ticket are not visible to agent in my ticket section.
        * **Issue #343:** saved reply is getting removed from the agent panel.
        * **Issue #349:** duplicate customer routes are visible on search at admin panel.
        * **Issue #350:** CC/BCC user should only receive ticket message in email notification.
        * **Issue #352:** Update jQuery to update to 3.6.0.
        * **Issue #354:** ReCaptcha should be mandatory on member login.
        * **Issue #356:** Last reply option is missing Asset Visibility.
        * **Issue #357:** getting error when view ticket which are fetched from email.
        * **Issue #360:** Agent should not able to manage recaptcha settings.

* 1.0.12 (2020-07-20)
    * **Misc. Updates:**
        * **Added mailbox filter for ticket so that we get to know from which mailbox ticket came from.**
        * **Ticket type sort alphabetically**
        
    * **Bug Fixes:**
        * **Issue #304:** getting exception when update status in ticket set as workflow condition.
        * **Issue #301:** My ticket's section ticket status are not clickable on agent panel
        * **Issue #306:** Incorrect email headers.
        * **Issue #299:** getting exception when drag & drop image on ticket reply editor box.
        * **Issue #302:** getting error on agent panel when filter ticket by customer name

* 1.0.11 (2020-05-22)
    * **Bug Fixes:**
        * **Issue #296:** translation exception when forwarding ticket thread.
        * **Issue #297:** Getting none encryption error when select none in swiftmailer.
        * **Issue #298:** no tickets.
        * **Issue #299:** 1.0.10 no email to agent & duplicate tickets.
        * **Issue #300:** helpdesk prefix are resetting when update email settings.

* 1.0.10 (2020-04-17)
    * **Misc. Updates:**
        * **Change processing function and removed unnecessary code for speed up.**
        
    * **Bug Fixes:**
        * **Issue #290:** counts of view more ticket link is wrong when single ticket exist.
        * **Issue #292:** getting exception when apply save reply on ticket.
        * **Issue #293:** Wrong ticket count at agents panel.
        * **Issue #294:** customer is not receiving email when agent reply on customer's ticket.

* 1.0.9 (2020-03-17)
    * **Misc. Updates:**
        * **Added Missing translation**
        
    * **Bug Fixes:**
        * **Issue #285:** No Ticket counts when login as another administrative account.
        * **Issue #289:** Error when trying to open Email templates.
        * **Issue #288:** Uploading image in branding showing tmp file doesn't exist.

* 1.0.8 (2020-02-12)
    * **Misc. Updates:**
        * **#175:** Set default article text color equals to black.
        * **#245:** Show error page instead of simple text error.
        * **#281:** Issue template Added.

    * **Bug Fixes:**
        * **Issue #280:** Error when update mass ticket group or team.
        * **Issue #282:** Agent unable to view listed saved replies.
        * **Issue #283:** Getting error during ticket assignment to an agent
        * **Issue #284:** Exception occurred when view fetched ticket(When Creted ticket through email and there is no content in message).
        * **Issue #59:** Mails not received by forward mail to / CC / BCC users when add into ticket.
        * **Issue #279:** Getting exception when redirects customer/agents list from admin panel.

* 1.0.7 (2020-01-25)
    * **Issue #277:** error when ticket is created - mail to customer not sent
    * **Issue #240:** super admin name is not showing when set via terminal.
    
* 1.0.6 (2020-01-04)
    * **Issue #275:** Customer reply error when workflow set for Mail to Agent.
    * **Issue #276:** Exception occur while forwording ticket (undefined variable container).

* 1.0.4 (2019-11-15)
    * **Issue #237:** Invalid base url for file icon
    * **Issue #242:** Prepared response (ticket quick action button) always enabled irrespective of assigned privileges
    * **Issue #243:** Deny access to protected routes based on user privileges
    * **Issue #195:** Collaborator replies via email are not being added to ticket
    * **Issue #263:** Wrong thumbnail is being shown for system generated threads
    * **Issue #264:** Workflow actions are not working when perform over ticket list
    * **Issue #261:** Wrong thumbnails are being shown for user threads in ticket quick view
    * **Issue #260:** Exception occur while executing action {mail to agent:repsonse performing agent}
    * **Issue #256:** Same flash message being shown for different ticket replies
    * **Issue #248:** Remove knowledgebase from dashboard navigation if user doesn't have required privileges
    * **Issue #250:** Saved replies should be accessible irrespective of privileges assigned
    * **Feature:** Ticket Quick Action Buttons & Dashboard Navigation Items can now define minimum required user privileges to be accessible
    * **Misc. Updates:**
        * Included Github issue templates
        * Included "Powered by Uvdesk" to dashboard
        * Updated composer dependencies & set minimum required php version to 7.2

* 1.0.3 (2019-10-23)
    * **Issue #230:** Custom field privilege issue
    * **Issue #29:** File attachment limit exceed
    * **Issue #234:** Agent profile issue while thread added at customer panel
    * **Issue #240:** Super admin name is not showing when set via terminal
    * **Misc. Updates:**
        * Added patch to support previously configured workflows with deprecated events
        * Both agents and customers now share a common password reset page (events agent.forgot_password & customer.forgot_password deprecated)
        * Updated README.md with link to the official gitter chat for uvdesk/core-framework

* 1.0.1 (2019-10-15)
    * **Issue #223:** Custom field privilege issue
    * **Issue #224:** Email template privilege issue
    * **Issue #177:** How could individual customer set timezone for their own panel?
    * **Issue #119:** Asset visibility checkbox layout in ticket view
    * **Issue #217:** Super user could not access the tickets assign to other agent
    * **Issue #216:** No access of customer's tickets to super user
    * **Issue #209:** Mail Received by customer for add note and forward reply even no workflow setup
    * **Issue #226:** Show saved replies as default privileges to Agent
    * **Issue #218:** Side bar missing at agent panel
    * **Issue #208:** Customer not receive ticket reply mail if attachment were added to ticket
    * **Issue #54:** Attachment's are not received on agent's mail
    * **Misc. Updates:**
        * Only users with admin level privileges can configure Swiftmailer settings

* 1.0.0 (Released on 2019-10-09)
    * **Issue #202:** Agent receives customer forget password link (raised by vaishaliwebkul)
    * **Issue #63:** Ticket counts get wrong when filter ticket on the basis of ticket replies (raised by vaishaliwebkul)
    * **Issue #215:** check agent have privilege for manage agent role (raised by princewebkul)
    * **Issue #121:** Admin profile not showing with listed prepared response (raised by vaishaliwebkul)
    * **Issue #133:** missing popular article on knowledgebase (raised by vaishaliwebkul)
    * **Issue #41:** Agent has priviledge to access any ticket by passing ticket id to URL (raised by vaishaliwebkul)
    * **Issue #39:** Agent can edit the admin or other agent's profile by accessing their id (raised by vaishaliwebkul)
    * **Issue #213:** Shift tags under productivity section (raised by vaishaliwebkul)
    * **Issue #148:** User is logged out but does not know it (raised by kruisdraad)
    * **Issue #197:** Error with update users - SQL Unique constraint (raised by alessioluciano)
    * **Issue #214:** Misc. Fixes (raised by piyushwebkul)
    * **Issue #211:** fix initial thread user image in ticket view page (raised by princewebkul)
    * **Issue #171:** Ticket from Imap mail not being created (raised by sukhbirgs)
    * **Issue #192:** Attempt load language dropdown changer after reply on ticket (raised by maranqz)
    * **Issue #199:** Create New Ticket in UvDesk (raised by sbonzanni)
    * **Issue #108:** Receives ticket from the blocked user (raised by vaishaliwebkul)
    * **Issue #62:** Duplicate reply added to old ticket when fetch new ticket from mailbox (raised by vaishaliwebkul)
    * **Issue #203:** Super User gets logout when update profile (raised by vaishaliwebkul)
    * **Issue #212:** Xss payload when upload an image as attachment  (raised by vaishaliwebkul)
    * **Issue #210:** Invalid ticket status (raised by vaishaliwebkul)
    * **Issue #137:** Upgrade dependencies  (raised by FBL-dev)
    * **Issue #207:** Issue 177 - Added getTimeZone() to UserService.php (raised by anmol107)
    * **Issue #185:** Translate russian (raised by maranqz)
    * **Issue #204:** Misc. changes (raised by kumarSaurabh27)
    * **Issue #201:** Error with update users - SQL Unique constraint (raised by piyushwebkul)
    * **Issue #88:** No feature provided to add support email in uvdesk.yaml file  (raised by vaishaliwebkul)
    * **Issue #112:** Getting exception when click to view quick view ticket icon (raised by vaishaliwebkul)
    * **Issue #176:** Check Time format at customer panel  (raised by vaishaliwebkul)
    * **Issue #200:** Mailbox not found in PROD environment (raised by vaishaliwebkul)
    * **Issue #191:** search for some icons are not working at dashboard (raised by vaishaliwebkul)
    * **Issue #198:** Mailbox not found in PROD environment (raised by piyushwebkul)
    * **Issue #196:** Update Search icons and routes (raised by vaishaliwebkul)
    * **Issue #189:** Search bar result for non existing keyword{{ 'No result found'|trans }} (raised by vaishaliwebkul)
    * **Issue #188:** configurable search bar bug fix (raised by shubhwebkul)
    * **Issue #187:** Error on Email settings (raised by vaishaliwebkul)
    * **Issue #164:** Customer status set inactive when created from website  (raised by vaishaliwebkul)
    * **Issue #186:** Configurable search bar component update (raised by shubhwebkul)
    * **Issue #184:** Tags are not open  (raised by vaishaliwebkul)
    * **Issue #126:** Email settings (raised by shubhwebkul)
    * **Issue #180:** Unknown Entity namespace alias 'CoreFrameworkBundle' (raised by vaishaliwebkul)
    * **Issue #173:** Customer status active when added as a collaborator. (raised by papnoisanjeev)
    * **Issue #172:** Email Settings Edit Update. (raised by kumarSaurabh27)
    * **Issue #38:** Create ticket by attaching media in a message body but not receive attached media in ticket (raised by vaishaliwebkul)
    * **Issue #124:** Update collaborator warning message when add existing collaborator at admin panel (raised by vaishaliwebkul)
    * **Issue #170:** Imap Settings all wrong and on mail box edit form is missing fields (raised by sukhbirgs)
    * **Issue #169:** Updates in layout (raised by kumarSaurabh27)
    * **Issue #130:** Error when update ticket tag code (raised by vaishaliwebkul)
    * **Issue #168:** code refactoring (raised by shubhwebkul)
    * **Issue #167:** Open source layout bug fixed. (raised by kumarSaurabh27)
    * **Issue #163:** Ticket tag update and delete action added. (raised by papnoisanjeev)
    * **Issue #166:**  entity compatibility updates with maker bundle (raised by shubhwebkul)
    * **Issue #165:** Opensource layout update (raised by kumarSaurabh27)
    * **Issue #162:** Timezone feature for Agent + issues (raised by kumarSaurabh27)
    * **Issue #146:** Once installation is completed wizard still shows (raised by kruisdraad)
    * **Issue #147:** Installation wizard no admin validation (raised by kruisdraad)
    * **Issue #140:** Opened sections available in dashboards are not showing in bold (raised by vaishaliwebkul)
    * **Issue #152:** wrong workflow set for event "ticket create" (raised by vaishaliwebkul)
    * **Issue #153:** Customer account create email template placeholder issue (raised by vaishaliwebkul)
    * **Issue #157:** Trashed folder show 0 tickets ,even tickets flag set to trash (raised by vaishaliwebkul)
    * **Issue #154:** Article counts not increased for support-tags  (raised by vaishaliwebkul)
    * **Issue #159:** Ticket Initial thread not created if channel as email (raised by vaishaliwebkul)
    * **Issue #161:** welcome ticket fixture added (raised by papnoisanjeev)
    * **Issue #160:** revert changes (raised by papnoisanjeev)
    * **Issue #158:** entity compatibility with maker bundle (raised by piyushwebkul)
    * **Issue #156:** Timezone Feature and issues (raised by kumarSaurabh27)
    * **Issue #155:** welcome ticket message fixture added, workflow changes, Article count in tag listing. (raised by papnoisanjeev)
    * **Issue #141:** Is there any option to change admin panel logo?? (raised by vaishaliwebkul)
    * **Issue #150:** Exception on Branding and email settings section (raised by vaishaliwebkul)
    * **Issue #151:** 0.1 (raised by kumarSaurabh27)
    * **Issue #149:** Added static access variable in ticket repository. (raised by papnoisanjeev)
    * **Issue #136:** Missing icon on agent assigned priviledge  (raised by vaishaliwebkul)
    * **Issue #145:** duplicate user or team on add, whole users removed (raised by papnoisanjeev)
    * **Issue #144:** Dynamic admin panel logo. (raised by kumarSaurabh27)
    * **Issue #142:** Search for email settings not found (raised by vaishaliwebkul)
    * **Issue #143:** Fixing prefix for customer and member panel. (raised by kumarSaurabh27)
    * **Issue #139:** mailbox-component issue-13 (raised by kumarSaurabh27)
    * **Issue #134:** Change 'addslashes' for 'escape' to solve error on `translation:update` (raised by raphox)
    * **Issue #138:** 1.0 (raised by kumarSaurabh27)
    * **Issue #135:** unknown addslashes in twig issue (raised by shubhwebkul)
    * **Issue #105:** Console error occur at dashboard (raised by vaishaliwebkul)
    * **Issue #123:** Error while mail to group set as workflow (raised by vaishaliwebkul)
    * **Issue #129:** Agent Signature work (raised by papnoisanjeev)
    * **Issue #131:** Article at front end (raised by papnoisanjeev)
    * **Issue #128:** Checking current user agent Instance (raised by papnoisanjeev)
    * **Issue #125:** Ticket service changes and workflow action mail to group changes  (raised by papnoisanjeev)
    * **Issue #122:** Getting error while mail to last collaborator by made reply by agent (raised by vaishaliwebkul)
    * **Issue #101:** Image not get inserted anywhere in the admin /customer panel (raised by vaishaliwebkul)
    * **Issue #120:** Resolved Issues (raised by shubhwebkul)
    * **Issue #118:** Small thumbnail in ticket view (raised by papnoisanjeev)
    * **Issue #64:** Search bar should trim spaces(Before and After Query set) (raised by vaishaliwebkul)
    * **Issue #117:** Agent profile is missing when agent view ticket  (raised by vaishaliwebkul)
    * **Issue #113:** Getting console error when type text to reply box (raised by vaishaliwebkul)
    * **Issue #116:** resolved issues & code refactoring (raised by shubhwebkul)
    * **Issue #115:** missing image URl  add for ticket view and list (raised by papnoisanjeev)
    * **Issue #114:** Ticket view console error resolved (raised by papnoisanjeev)
    * **Issue #67:** Tickets not filter based on priority set , before date  (raised by vaishaliwebkul)
    * **Issue #73:** Icon of attachments not found when view ticket by clicking on quick view trigger icon (raised by vaishaliwebkul)
    * **Issue #74:** Name of the ticket creator is missing while view ticket detail using quick view trigger icon (raised by vaishaliwebkul)
    * **Issue #103:** Default Value not set for knowledgebase name at branding section (raised by vaishaliwebkul)
    * **Issue #104:** Remove non unique select type element from the swiftmailer (raised by vaishaliwebkul)
    * **Issue #107:** Ticket view scope permission to agent are not set when create agent  (raised by vaishaliwebkul)
    * **Issue #75:** Remove checkbox from the tickets# page if tickets are not available (raised by vaishaliwebkul)
    * **Issue #111:** Configure your website prefixes with command line (raised by shubhwebkul)
    * **Issue #110:** Added some functions in ticket and user service for block spam functionality. (raised by papnoisanjeev)
    * **Issue #109:** resolved issues (raised by shubhwebkul)
    * **Issue #102:** Multiple select checkbox disable when no ticket in list and active when ti… (raised by papnoisanjeev)
    * **Issue #99:** Get ticket's initial thread from getTicketInitialThreadDetails rather than getCreateReply (raised by shubhwebkul)
    * **Issue #82:** Unable to delete swiftmailer (raised by vaishaliwebkul)
    * **Issue #81:** mailbox not get successfully deleted (raised by vaishaliwebkul)
    * **Issue #106:** Define maximum character length of mailbox name (raised by vaishaliwebkul)
    * **Issue #83:** Get error warning while edit existing mailbox (raised by vaishaliwebkul)
    * **Issue #80:** Duplicate mailer_id created while fetching in mailbox (raised by vaishaliwebkul)
    * **Issue #71:** Productivity and settings section icons are not listing sequencially as shown on dashboard (raised by vaishaliwebkul)
    * **Issue #70:** Enable or disable customer sign in option or ticket create options not worked (raised by vaishaliwebkul)
    * **Issue #65:** Disable ticket types shows on the ticket type drop down list in backend (raised by vaishaliwebkul)
    * **Issue #100:** Swiftmailer.php  file change. (raised by papnoisanjeev)
    * **Issue #85:** Issue while fetching mails on helpdesk (raised by vaishaliwebkul)
    * **Issue #98:** Upload image in separate folder (raised by papnoisanjeev)
    * **Issue #97:** Seperate Email Template for agent when ticket created by customer (raised by papnoisanjeev)
    * **Issue #96:**  initialThread's attachments resolved issues (raised by shubhwebkul)
    * **Issue #95:** Attachments show in ticket list quickview (raised by papnoisanjeev)
    * **Issue #94:** Regular Expression update of swiftmailer id (raised by shubhwebkul)
    * **Issue #93:** Validation for Swift Mailer id only character and digit without space … (raised by papnoisanjeev)
    * **Issue #53:** Quick view trigger icon is not responsive for the ticket's email channel (raised by vaishaliwebkul)
    * **Issue #89:** Thread action icon and profile navigation action icon is missing from admin panel (raised by vaishaliwebkul)
    * **Issue #48:** Add global placeholder in email templates  (raised by vaishaliwebkul)
    * **Issue #60:** Ticket list filter view--> remove unused channels from drop down list (label as; source)  (raised by vaishaliwebkul)
    * **Issue #72:** Remove special character( 's ) from the default created email template (raised by vaishaliwebkul)
    * **Issue #92:** deletion of Swift Mailer change the enable status and mailer id for ma… (raised by papnoisanjeev)
    * **Issue #91:** mailbox updates (raised by shubhwebkul)
    * **Issue #90:** Image not showing when not serving project resolve, sidebar sequence … (raised by papnoisanjeev)
    * **Issue #87:** assets update (raised by shubhwebkul)
    * **Issue #86:** assets issue in production mode (raised by shubhwebkul)
    * **Issue #84:** Checkbox hide when no ticket and Swiftmailer white space validation. (raised by papnoisanjeev)
    * **Issue #79:** Texual change for swiftmailer views and member.yaml change (raised by papnoisanjeev)
    * **Issue #78:** Textual changes in swift mailer views and removed function from controllers. (raised by papnoisanjeev)
    * **Issue #77:** missing configurations of mailbox and code refactoring (raised by shubhwebkul)
    * **Issue #76:** Default Swift Mailer Config with comment spool and url (raised by papnoisanjeev)
    * **Issue #69:** Decoupled UVDesk Mailboxes into seperate component (raised by akshaywebkul)
    * **Issue #68:** Filtration of duplicate routes (raised by shubhwebkul)
    * **Issue #66:** Ticket type with status active will only show with type drop down in ticket. (raised by papnoisanjeev)
    * **Issue #61:** Removed some sources from filter which are not present yet. (raised by papnoisanjeev)
    * **Issue #58:** Design updates (raised by shubhwebkul)
    * **Issue #55:** Required Changes for mailbox-bundle (raised by shubhwebkul)
    * **Issue #52:** Email Template and content issue admin at first ticket created. (raised by papnoisanjeev)
    * **Issue #43:** Some files format attached with ticket thread are not download on agent/customer panel (raised by vaishaliwebkul)
    * **Issue #44:** Apply Prepared response(action as delete ticket) to ticket then get error in a Development mode (raised by vaishaliwebkul)
    * **Issue #40:** "Template for" option should be pre selected for the default created email templates (raised by vaishaliwebkul)
    * **Issue #42:** Thread update which contains only image (raised by vaishaliwebkul)
    * **Issue #47:** My ticket link inside ticket list throws exception (raised by vaishaliwebkul)
    * **Issue #33:** Status of tickets not updated when click on customer's "more ticket" link in ticket detail (raised by vaishaliwebkul)
    * **Issue #37:** Unassigned status for ticket list not updated (raised by vaishaliwebkul)
    * **Issue #30:** Admin added as a collaborator but undefined name found (raised by vaishaliwebkul)
    * **Issue #51:** Attachments in thread (raised by shubhwebkul)
    * **Issue #50:** Email template form change (raised by papnoisanjeev)
    * **Issue #35:** No result option is active to added in the tags and labels fields with ticket (raised by vaishaliwebkul)
    * **Issue #49:** company logo, name and URL added for email template (raised by papnoisanjeev)
    * **Issue #46:** Resolved issues and updates (raised by shubhwebkul)
    * **Issue #45:** update thread mandatory  condition even after content. resolved (raised by papnoisanjeev)
    * **Issue #8:** On the ticket list page, you will see the icon with each ticket, to get full detail about ticket, which is not worked (raised by vaishaliwebkul)
    * **Issue #27:** Ticket link attach with message body on agent's mail id redirect to wrong panel (raised by vaishaliwebkul)
    * **Issue #34:** Inactive pagination with customer list at admin panel (raised by vaishaliwebkul)
    * **Issue #36:** Default workflow set for agent account create mail receives two times to agent (raised by vaishaliwebkul)
    * **Issue #24:** Unable to update status of ticket when add a note to ticket  (raised by vaishaliwebkul)
    * **Issue #32:** Pagination problem resolve and separate link for customer and agent to view ticket after getting mail. (raised by papnoisanjeev)
    * **Issue #31:** Resolved issues (raised by shubhwebkul)
    * **Issue #28:** New customer status show disable to agent when customer created from mail (raised by vaishaliwebkul)
    * **Issue #14:** Image not get insert by option given in rich text editor at the time of reply to any ticket (raised by vaishaliwebkul)
    * **Issue #26:** Tags are not get Sort by ticket count (raised by vaishaliwebkul)
    * **Issue #25:** sorting tag by ticket count, last name validation removed, search filter added for tag, label, team, group. (raised by papnoisanjeev)
    * **Issue #23:** fixed issues (raised by shubhwebkul)
    * **Issue #22:** Update attachments count (raised by shubhwebkul)
    * **Issue #21:** Transfer ticket action added in workflow. (raised by papnoisanjeev)
    * **Issue #20:** Mail for customer create on uvdesk (raised by shubhwebkul)
    * **Issue #19:** Issue #65 resolved (raised by shubhwebkul)
    * **Issue #18:** Ticket list sorting resolve and added some more formats for attachments (raised by papnoisanjeev)
    * **Issue #17:** customer create email (raised by shubhwebkul)
    * **Issue #16:** Color-picker (raised by shubhwebkul)
    * **Issue #15:** saved reply body message validation added (raised by papnoisanjeev)
    * **Issue #12:** Ticket status is not changed when reply to ticket by selecting different option of submit list (raised by vaishaliwebkul)
    * **Issue #13:** Added By default status open for ticket when reply (raised by papnoisanjeev)
    * **Issue #11:** Profile image validation add for customer agent and user profile (raised by papnoisanjeev)
    * **Issue #4:** Undefined variable found when add reply to the ticket (raised by vaishaliwebkul)
    * **Issue #10:** ticketList.html.twig change color to colorCode. (raised by papnoisanjeev)
    * **Issue #9:** short info about ticket, pop up functionality on ticket list added (raised by papnoisanjeev)
    * **Issue #7:** ticket type validation for name and other textual change (raised by papnoisanjeev)
    * **Issue #6:** Website-Configuration (raised by shubhwebkul)
    * **Issue #5:** mailbox configuration (raised by shubhwebkul)
    * **Issue #3:** Ticket filter functionality and Prepared response added (raised by papnoisanjeev)
    * **Issue #2:** ticket type view and ticket repository changes (raised by papnoisanjeev)
    * **Issue #1:** Ticket default priority and status set in config (raised by papnoisanjeev)
