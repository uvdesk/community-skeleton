CHANGELOG for 1.0.x
===================

This changelog references any relevant changes introduced in 1.0 minor versions.

* 1.0.13 (2021-10-27)

    * **Misc. Updates:**
      * Compatibility with PHP 8.
      * Filter option on customer side with ticket listing.

    * **Bug. Fixes:**
        * Removed CC/BCC option for collaborator reply.
        * Preview option fixed for Article. 
        * login issue on customer login is timestamp not set on branding.

* 1.0.12 (2021-08-21)
    * **Bug. Fixes:**
        * **Issue #118:** date icon should be appear in broadcast message.
        * **Issue #135:** customer is not able to add reply on ticket.

    * **Misc. Updates:**
        * Reply rosolved from customer end if added CC and BCC in reply.
        * Date icon added for broadcast message.
        * Profile picture remove option added.
        * Default image show in Tickets thread when removed profile picture.
        * Added kudos feature.

* 1.0.10 (2021-06-19)
    * **Bug. Fixes:**
        * **Issue #130:** getting exception on marketing announcement when sort by Created At
        * **Issue #132:** When an agent logs in on the customer endpoint, redirect them.
        * **Issue #131:** email login is case sensitive

    * **Misc. Updates:**
        * Added Marketing Announcement feature.
        * Broadcast message field type changed to text and added validation for 300 characters for the same.
        * Colors issue fixed for knowledgebase which is set from branding section.

* 1.0.9 (2021-04-02)
    * **Bug. Fixes:**
        * **Issue #103:** Doctrine Entities Mapping error on KnowledgebaseWebsite#website.
        * **Issue #107:** Getting exception while viewing categories/folder/articles at backend.
        * **Issue #108:** contact us form is not working.
        * **Issue #117:** [Feature request] Support HTML in Knowledgebase.
        * **Issue #110:** customer panel showing error.
        * **Issue #111:** add image upload icon in tinymc editor for articles.
        * **Issue #112:** video attachment in article is not working.
        * **Issue #119:** back date should be disabled while creating broadcast message.
        * **Issue #120:** getting exception when sort category,article based on created date.
        * **Issue #121:** duplicate editor options are visible in knowledgebase article editor.
        * **Issue #122:** ticket list pagination is missing at customer panel.
        * **Issue #122:** getting error while creating ticket from the front end.

    * **Misc. Updates:**
        * Added multiple option for Article Editor.

* 1.0.8 (2020-07-21)
    * **Issue #102:** Footer cookie link issue on mobile.
    * **Issue #101:** Missed mobile menu to login, Missed operator three dots menù in a ticket.
    * **Issue #24:** Customer can view other's customer's ticket just by passing ticket id in URL

* 1.0.7 (2020-05-26)
    * **Misc. Updates:**
        * Added Not found exception in different part of bundle.

* 1.0.6 (2020-04-17)
    * **Misc. Updates:**
        * Change processing function and removed unnecessary code for speed up..

* 1.0.5 (2020-03-17)
    * **Misc. Updates:**
        * Added Missing translations.

    * **Bug. Fixes:**
        * **Issue #99:** Getting exception when collaborator login to support panel.

* 1.0.4 (2020-02-12)
    * **Misc. Updates:**
        * Included Github issue templates.
        * Made default article text color equals to black.
        
* 1.0.3 (2019-11-15)
    * **Issue #24:** Customer can view other customers ticket just by passing ticket id in url
    * **Issue #94:** Knowledgebase folders not displaying correct thumbnail
    * **Misc. Updates:**
        * Included Github issue templates
        * Included "Powered by Uvdesk" to support center panel
        * Updated composer dependencies & set minimum required php version to 7.2

* 1.0.2 (2019-10-22)
    * **Issue #60:** Cannot disable knowledgebase
    * **Issue #86:** Article Text Editor is not working with bullets
    * **Issue #83:** Enable customer/agent to reset password from single route

* 1.0.1 (2019-10-15)
    * **Issue #79:** User profile gets hidden
    * **Issue #75:** Profile issue inside ticket page
    * **Misc. Updates:**
        * Updated README.md with link to the official gitter chat for uvdesk/support-center-bundle

* 1.0.0 (Released on 2019-10-09)
    * **Issue #76:** tinymce text editor added for article section. (raised by papnoisanjeev)
    * **Issue #74:** fix initialThread user image in ticket-show page (raised by princewebkul)
    * **Issue #73:**  Issue 177; Enabling time zone dropdown functionality for customer's … (raised by anmol107)
    * **Issue #72:** Customer Profile Update Issue (raised by vaishaliwebkul)
    * **Issue #62:** Translate russian (raised by maranqz)
    * **Issue #68:** Issues (raised by kumarSaurabh27)
    * **Issue #58:** Fix article counts (raised by vaishaliwebkul)
    * **Issue #57:** Article marked as star even no settings done (raised by vaishaliwebkul)
    * **Issue #65:** Add search entries (raised by vaishaliwebkul)
    * **Issue #63:** Error when click on view article button (raised by vaishaliwebkul)
    * **Issue #61:** Add search bar component items (raised by shubhwebkul)
    * **Issue #56:** Popular article show in sidebar, article view knowledgebase. customer status active when added as a collaborator from customer panel. (raised by papnoisanjeev)
    * **Issue #55:** Validation updated for Category. (raised by kumarSaurabh27)
    * **Issue #54:** entity compatibility updates (raised by shubhwebkul)
    * **Issue #53:** customer account not active if create ticket from knowledgebase, reso… (raised by papnoisanjeev)
    * **Issue #52:** Timezone feature in branding section. (raised by kumarSaurabh27)
    * **Issue #51:** community skeleton- issue 157 (raised by kumarSaurabh27)
    * **Issue #47:** Attachment issue when customer update their profile (raised by vaishaliwebkul)
    * **Issue #49:** Article are not visible on knowledgebase  (raised by vaishaliwebkul)
    * **Issue #50:** Get popular article view. (raised by papnoisanjeev)
    * **Issue #48:** Small Thumbnail in ticket view (raised by papnoisanjeev)
    * **Issue #46:** Trim value of searching parameter in  article,category and folder search. (raised by papnoisanjeev)
    * **Issue #44:** Unable to search article from customer panel while view ticket detail (raised by vaishaliwebkul)
    * **Issue #45:** Added block spam functionality while creating ticket (raised by papnoisanjeev)
    * **Issue #43:** Website name show in branding. (raised by papnoisanjeev)
    * **Issue #42:** Removed option for disabling powered by option. (raised by papnoisanjeev)
    * **Issue #41:** Image upload in a separate folder (raised by papnoisanjeev)
    * **Issue #25:** Some of the attachments are missing from customer panel and on their mail (raised by vaishaliwebkul)
    * **Issue #22:** Customer panel not receives any images attached with thread content (raised by vaishaliwebkul)
    * **Issue #32:** Drop down list available with submit button will get open only when click on drop down list icon (raised by vaishaliwebkul)
    * **Issue #35:** Category which is listed as draft , shows at knowledgebase (raised by vaishaliwebkul)
    * **Issue #40:** Customer create ticket option, login option as per saved site config … (raised by papnoisanjeev)
    * **Issue #39:** When Directly running project(without serving), image not showing problem resolved (raised by papnoisanjeev)
    * **Issue #38:** Resolved assets issue (raised by shubhwebkul)
    * **Issue #37:** Trim article search string at customer panel (raised by papnoisanjeev)
    * **Issue #36:** Category count and showing draft category issue and article count resolve at customer panel. (raised by papnoisanjeev)
    * **Issue #31:** Drop down icon is missing available in contact form at knowledgebase (raised by vaishaliwebkul)
    * **Issue #34:** Some icon missing at customer panel (raised by papnoisanjeev)
    * **Issue #27:** Unable to create ticket from knowledgebase (raised by vaishaliwebkul)
    * **Issue #28:** Ticket status not update when customer submit reply by Reply and close (raised by vaishaliwebkul)
    * **Issue #7:** Reply contains &nbsp; if spaces in thread from customer panel (raised by vaishaliwebkul)
    * **Issue #30:** createUserInstance arguments mismatch issue (raised by shubhwebkul)
    * **Issue #29:** submit and close issue resolve and file download issue resolve for cu… (raised by papnoisanjeev)
    * **Issue #26:** Thread message with utf-8 decode for customer ticket view (raised by papnoisanjeev)
    * **Issue #23:** Agent privileges update (raised by shubhwebkul)
    * **Issue #21:** Added a new icons for attachments(ppt,pptx and docx) (raised by papnoisanjeev)
    * **Issue #20:** fixed issues (raised by shubhwebkul)
    * **Issue #5:** Folder images missing at dashboard (raised by vaishaliwebkul)
    * **Issue #6:** Check Tags field at article In knowledgebase section (raised by vaishaliwebkul)
    * **Issue #8:** Check ticket thread at admin panel, when reply is added from customer panel (raised by vaishaliwebkul)
    * **Issue #19:** Added search article link at customer profile page (raised by papnoisanjeev)
    * **Issue #18:** Issues fixes (raised by shubhwebkul)
    * **Issue #17:** Issue #73 resolved (raised by shubhwebkul)
    * **Issue #16:** More attachments icon added in ticket view (raised by papnoisanjeev)
    * **Issue #15:** attachment download link and icon in customer ticket view (raised by papnoisanjeev)
    * **Issue #14:**  added icon for files and download option for each (raised by papnoisanjeev)
    * **Issue #13:** Correct the message when article update. (raised by papnoisanjeev)
    * **Issue #12:** Added validation while adding tags, as character only (raised by papnoisanjeev)
    * **Issue #11:** knowledgebase.css change for reply and timestamp icons. (raised by papnoisanjeev)
    * **Issue #10:** article search on customer panel (raised by papnoisanjeev)
    * **Issue #9:** At customer reply added created by customer (raised by papnoisanjeev)
    * **Issue #4:** Website-Configuration (raised by shubhwebkul)
    * **Issue #3:** branding issue (raised by papnoisanjeev)
    * **Issue #2:** Branding message added (raised by papnoisanjeev)
    * **Issue #1:** category check in edit (raised by papnoisanjeev)