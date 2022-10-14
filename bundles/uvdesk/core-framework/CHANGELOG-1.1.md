CHANGELOG for 1.1.x
===================

This changelog references any relevant changes introduced in 1.1 minor versions.

* 1.1.1 (2022-09-13)
    * Bug #584: Fix sidebar from flickering during page reload & resize (vipin-shrivastava)
    * PR #576: Entity reference updates; Enable locale change; Set global timeformat; attachment is not going within ticket assign email workflow, sidebar flicker issue (vipin-shrivastava)
    * Bug #569: Wrong saved replies pagination results (papnoisanjeev)
    * PR #566: List ticket types in alphabetical order and display ticket type name instead of description (papnoisanjeev)
    * PR #192: Update BootstrappingProject.php (WebmaticMerseburg)

* 1.1.0 (2022-03-23)
    * Feature: Improved compatibility with PHP 8 and Symfony 5 components
    * PR #530: Updated ticket type and saved replies form validation criterias (vipin-shrivastava)
    * Bug #521: Only allow modification of privileged roles if acting agent has the same role enabled (vipin-shrivastava)
    * Bug #519: (514, 515, 517, 518) Resolve issues with ticket mass update, *ticket.link* ticket placeholder value, and agent account role update; remove manage group saved reply privilege settings (vipin-shrivastava)
    * Bug #512: Correctly format and process email recipient collections for outbound agent emails (vipin-shrivastava)
    * Bug #510: Add cross-site scripting checks uploaded .svg assets (vipin-shrivastava)
    * Bug #509: Throw NotFoundHttpException instead to render *404 Page Not Found* error message when ticket is not found (vipin-shrivastava)
    * Bug #506: Ticket placeholder *ticket.threadMessage* referencing the most recent thread should not be of type *note* (vipin-shrivastava)
    * PR #505: Change ordering of dashboard navigation segment items to render tickets before reports (vipin-shrivastava)
    * Bug #497: Add past ticket reference ids to mail headers for outbound customer emails (PeopleInside)
    * Bug #493: Disable user account based on defined roles instead of all disabling all instances of user account (vipin-shrivastava)
    * Bug #491: Editor resize issue while creating ticket from profile dropdown (vipin-shrivastava)
    * Bug #490: Use editor when creating ticket from profile dropdown initialize with agent signature details if available (vipin-shrivastava)
    * Bug #486: Update ticket message reference ids while sending outbound emails (vipin-shrivastava)
    * Bug #485: (476, 475) Unexpected error applying prepared responses on tickets assigned to a group, and issue rending inline base64 encoded images in mail contents (vipin-shrivastava)
    * Bug #483: Delete all customer ticket attachments from file system when deleting customer account (papnoisanjeev)
    * Bug #482: Delete customer profile picture from file system when updating account details (papnoisanjeev)
    * PR #479: Updated error message in case of issues sending emails through swiftmailer (PeopleInside)
    * PR #478: Render custom fields snippet if any custom field definitions are available (vipin-shrivastava)
    * Bug #477: Display correct channel name when viewing form builder tickets (vipin-shrivastava)
    * Bug #474: Wrong total customer tickets count being showed while viewing ticket (vipin-shrivastava)
    * Bug #473: Fix wrong custom field placeholder value being rendered while creating ticket (vipin-shrivastava)
    * PR #472: Render custom fields snippet only if any custom field details are provided by customer (vipin-shrivastava)
    * PR #468: Fix version number mentioned in dashboard (PeopleInside)
