CHANGELOG for 1.1.x
===================

This changelog references any relevant changes introduced in 1.1 minor versions.

* 1.1.1 (2022-09-13)
    * Bug #193: Correctly enable/disable contact us banner on front website based on settings (vipin-shrivastava)
    * PR #193: Entity reference updates; Set default locale (vipin-shrivastava)
    * Bug #192: Remove old folder image from physical path if new folder image is uploaded (papnoisanjeev)
    * Bug #189: Resolve issue with wrong sort order on category listings and add support for managing enabled locale settings (vipin-shrivastava)
    * Bug #177: Display asterisk icons for required fields on customer create ticket form (Sanjaybhattwebkul)

* 1.1.0 (2022-03-23)
    * Feature: Improved compatibility with PHP 8 and Symfony 5 components
    * Bug #172: Update misc. validation error messages while working with knowledgebase categories and folders (vipin-shrivastava)
    * Bug #167: Add cross-site scripting checks for uploaded .svg assets (vipin-shrivastava)
    * Bug #166: Throw *NotFoundHttpException* instead to render *404 Page Not Found* error message when ticket is not found (vipin-shrivastava)
    * Bug #164: Fix misc. issues while updating articles (vipin-shrivastava)
    * Bug #163: Show warning when creating article with an already occupied slug name, update validation criteria when creating folders (vipin-shrivastava)
    * Bug #160: Delete previous website logo asset from filesystem while updating a new logo (vipin-shrivastava)
    * Bug #159: Delete knowledgebase folder image asset from file system when deleting folder (vipin-shrivastava)
    * Bug #158: Editor resize issue while creating ticket (vipin-shrivastava)
    * Bug #157: Use editor when creating ticket (vipin-shrivastava)
    * Bug #156: Article's numbered list not being rendered correctly (vipin-shrivastava)
    * Bug #155: Delete customer profile picture from file system when updating account details (papnoisanjeev)
    * Bug #154: Fix wrong custom field placeholder value being rendered (vipin-shrivastava)
