<p align="center"><a href="https://www.uvdesk.com/en/" target="_blank">
    <img src="https://s3-ap-southeast-1.amazonaws.com/cdn.uvdesk.com/uvdesk/bundles/webkuldefault/images/uvdesk-wide.svg">
</a></p>

A fully-functional [UVDesk Community Edition][1] project skeleton packaged along with the bare essential utilities that you can use to develop your own custom helpdesk solutions.

A fully-functional [UVDesk Community Edition][1] project skeleton packaged along with the bare essential utilities that you can use to develop your own custom helpdesk solutions.

Click [here][2] to view the live community project demo.

What's Included?
--------------

The standard distribution comes pre-configured with the following bundles:

  * [**UVDeskCoreBundle**][3] - The core framework bundle for bulding helpdesk solutions

  * [**UVDeskAutomationBundle**][4] - Adds support for workflows and prepared responses to automate any specific operations within your helpdesk system

  * [**UVDeskSupportCenterBundle**][5] - Integrates the easily customizable support center portal to enable users to easily interact with the support staff through your helpdesk system

Installation
--------------

Before creating your UVDesk Community project, make sure that you're using PHP 7 or higher and have [Composer][8] installed. You also need to ensure that you have the following PHP extensions installed:

  * [PHP IMAP][6]
  * [PHP Mailparse][7]

To create your project, run the following command:

```bash
$ composer create-project uvdesk/community-skeleton helpdesk-project --stability dev
```

After creating your project, you can setup the project in the following ways:

**Via Terminal**

```bash
$ php bin/console uvdesk:configure-helpdesk
```

**Via Web Installer**

After opening your project in the web browser, navigate to /setup/, where you will be greeted by the web installer to guide you in setting up your project.

About Us
--------------
The development of the UVDesk Community Edition is supported by [Webkul][9], led by the [UVDesk Team][10].

Visit our official [website][1] to learn more about the UVDesk Helpdesk System.

License
--------------

All libraries and bundles included in the UVDesk Community Edition are released under the MIT or BSD license.

[1]: https://www.uvdesk.com/
[3]: https://github.com/uvdesk/core-framework
[4]: https://github.com/uvdesk/automation-bundle
[5]: https://github.com/uvdesk/support-center-bundle
[6]: http://php.net/manual/en/book.imap.php
[7]: http://php.net/manual/en/book.mailparse.php
[8]: https://getcomposer.org/
[9]: https://webkul.com/
[10]: https://www.uvdesk.com/en/team/
