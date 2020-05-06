<p align="center"><a href="https://www.uvdesk.com/en/" target="_blank">
    <img src="https://s3-ap-southeast-1.amazonaws.com/cdn.uvdesk.com/uvdesk/bundles/webkuldefault/images/uvdesk-wide.svg">
</a></p>

<p align="center">
    <a href="https://packagist.org/packages/uvdesk/community-skeleton"><img src="https://poser.pugx.org/uvdesk/community-skeleton/v/stable.svg" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/uvdesk/community-skeleton"><img src="https://poser.pugx.org/uvdesk/community-skeleton/d/total.svg" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/uvdesk/community-skeleton"><img src="https://poser.pugx.org/uvdesk/community-skeleton/license.svg" alt="License"></a>
    <a href="#backers"><img src="https://opencollective.com/uvdesk/backers/badge.svg" alt="Backers on Open Collective"></a>
    <a href="#sponsors"><img src="https://opencollective.com/uvdesk/sponsors/badge.svg" alt="Sponsors on Open Collective"></a>
    <a href="https://gitter.im/uvdesk/community"><img src="https://badges.gitter.im/uvdesk/community-skeleton.svg" alt="connect on gitter"></a>
</p>

[Uvdesk community helpdesk][1] project skeleton packaged along with the bare essential utilities and tools to build and customize your own helpdesk solutions.

Visit our official demo website to [see it in action!][15]

Check out UVdesk on **Symfony Official Website** – [Symfony][24]

Getting Started
--------------

* [About](#about)
* [Features](#features)
* [Documentation](#documentation)
* [Modules](#modules)
* [Requirements](#requirements)
* [Installation](#installation)
* [Docker Runtime](#docker-runtime)
* [License](#license)
* [Security Vulnerabilities](#security-vulnerabilities)
* [Feedback](#feedback)
* [Contributions](#contributions)

About
--------------

Build on top of [symfony](https://symfony.com/) and [backbone.js](https://backbonejs.org/), uvdesk community is a service oriented, event driven extensible opensource helpdesk system that can be used by your organization to provide efficient support to your clients effortlessly whichever way you imagine.

The standard distribution comes packaged along with the following helpdesk packages to cover a wide range of use-cases and requirements:

  * [**Core Framework**][2] - At the heart of the helpdesk system, the core framework consists of all the necessary apis required by your project and dependent packages to keep things running smoothly

  * [**Extension Framework**][3] - Introduces support for third-party package integration and development to easily build and extend the functionalities of your helpdesk system as per your requirements

  * [**Automation Bundle**][4] - Adds support for workflows and prepared responses to automate any specific operations within your helpdesk system

  * [**Mailbox Component**][11] - Convert and get all your emails to support tickets on UVDesk and manage customer query easily.

  * [**Support Center Bundle**][5] - Integrates the easily customizable support center portal to enable users to easily interact with the support staff through your helpdesk system

Reach out to us at our official [gitter chat][20] or by joining [slack][21] for any queries, concerns and feature request discussions.

The development of the uvdesk community edition is led by the [uvdesk][10] team and backed by [Webkul][9]. Visit our [website][1] to learn more about the UVDesk Helpdesk System.

Features
--------------

* Translation Support (Multilingual)
* Unlimited Agents, Group, Team, Customers, Tickets etc
* Agent Privileges
* No limit on the number of Mailbox/Email integration
* Saved Replies for common queries
* Filter based on ticket status, Id, agent, customer, etc
* Block Spam
* Standard automated workflows
* Notes for agents
* Custom branding
* Change logo & favicon
* Broadcasting message
* Ticket Forwarding
* Prepared Response
* Email Notification
* Effective search
* User Friendly Web Installer
* Add multiple attachments
* Powerful Knowledgebase/Faq (article, category & folder)
* Ticket types, Multiple Tags
* Email Templates
* [API][16] ([Doc][25])
* Edit/delete/pinned ticket and thread
* Add a collaborator and much more.
* Check Apps [here.][26]

Documentation
--------------

Visit [docs.uvdesk.com](https://docs.uvdesk.com/) to read our official documentation and learn more about the uvdesk community project.

We use Jekyll to develop and maintain our documentations. Consider contributing by submitting a pull request to our project's [jeykll repository](https://github.com/uvdesk/uvdesk.github.io).

Requirements
--------------

* **OS**: Ubuntu 16.04 LTS or higher / Windows 7 or Higher (WAMP / XAMPP).
* **SERVER**: Apache 2 or NGINX.
* **RAM**: 3 GB or higher.
* **PHP**: 7.2 or higher.
* **Processor**: Clock Cycle 1 Ghz or higher.
* **For MySQL users**: 5.7.23 or higher.
* **Composer**: 1.6.5 or higher.
* **PHP IMAP** **&** **PHP Mailparse** for [Ubuntu][7] and [Windows][23].

Installation
--------------

The installation process is broken down into two distinct steps:

* Setup
* Configuration

### Setting up your helpdesk project

In this step of the installation process, you'll be downloading the helpdesk project skeleton and installing all of its dependent components.

As per your convenience, you can choose to either use composer for download the project and install all its dependencies automatically or directly download the project archive that comes pre-packaged with all of the project dependencies already installed.

We recommend using composer over direct download whenever possible. However, if your system does not have enough ram to execute composer operations properly (for example: installing on a shared host with limited system resources), we suggest using the direct download method instead to mitigate these kind of issues.

Irrespective of the method you use, the process to configuring your helpdesk remains the same.

#### Composer

You can use composer to setup your project by simply running the following command from your terminal:

```bash
$ composer create-project uvdesk/community-skeleton helpdesk-project
```

#### Direct Download

Alternatively, you can also [download the zip archive](https://cdn.uvdesk.com/uvdesk/downloads/opensource/uvdesk-community-current-stable.zip) of the latest stable release and extract its content by running the following commands from your terminal:

```bash
$ wget "https://cdn.uvdesk.com/uvdesk/downloads/opensource/uvdesk-community-current-stable.zip" -P /var/www/
$ unzip -q /var/www/uvdesk-community-current-stable.zip -d /var/www/ \
```

### Configuring your helpdesk project

After you've downloaded and installed all the project dependencies, you can configure your helpdesk installation using either of the following ways:

#### Using Terminal

```bash
$ php bin/console uvdesk:configure-helpdesk
```

#### Using Web Installer Wizard

After opening your project in the web browser, you will be greeted by the web installer which will guide you in configuring your project.

Docker Runtime
--------------

[Dockerize your helpdesk project][22]

Modules
--------------

[Available modules](https://store.webkul.com/UVdesk/UVdesk-Open-Source.html)

Need something else ? email us at support@uvdesk.com

License
--------------

All libraries and bundles included in the UVDesk Community Edition are released under the [MIT][12] license.

Security Vulnerabilities
--------------

Please don't disclose any security vulnerabilities publicly. If you find any security vulnerability in our platform then please write us at [support@uvdesk.com](mailto:support@uvdesk.com).

Contributions
--------------

#### Feedback (Support Community project by raising feedback)

* [Trustpilot][17]
* [Capterra][18]
* [Software suggest][19]

This project is hosted on [Open Collective][13] and exists thanks to our contributors:

<a href="https://github.com/uvdesk/community-skeleton/graphs/contributors"><img src="https://opencollective.com/uvdesk/contributors.svg?width=890&button=false"/></a>

#### Backers

Thank you to all our backers! 🙏

<a href="https://opencollective.com/uvdesk#contributors" target="_blank"><img src="https://opencollective.com/uvdesk/backers.svg?width=890"></a>

#### Sponsors

Support this project by becoming a sponsor. Your logo will show up here with a link to your website.

<a href="https://opencollective.com/uvdesk/contribute/sponsor-7372/checkout" target="_blank"><img src="https://images.opencollective.com/static/images/become_sponsor.svg"></a>

[1]: https://www.uvdesk.com/
[2]: https://github.com/uvdesk/core-framework
[3]: https://github.com/uvdesk/extension-framework
[4]: https://github.com/uvdesk/automation-bundle
[5]: https://github.com/uvdesk/support-center-bundle
[6]: https://support.uvdesk.com/en/blog/prerequisites-ubuntu
[7]: https://support.uvdesk.com/en/blog/prerequisites-ubuntu
[8]: https://getcomposer.org/
[9]: https://webkul.com/
[10]: https://www.uvdesk.com/en/team/
[11]: https://github.com/uvdesk/mailbox-component
[12]: https://github.com/uvdesk/community-skeleton/blob/master/LICENSE
[13]: https://opencollective.com/uvdesk
[14]: https://docs.uvdesk.com/
[15]: https://demo.uvdesk.com/
[16]: https://github.com/uvdesk/api-bundle
[17]: https://www.trustpilot.com/review/uvdesk.com
[18]: https://www.capterra.com/p/158346/UVdesk/
[19]: https://www.softwaresuggest.com/uvdesk
[20]: https://gitter.im/uvdesk/community
[21]: https://join.slack.com/t/uvdeskopensource/shared_invite/enQtOTUwODEzNTQ1NjY5LTU1M2EyOGQ2ZjNiOGMxZTgwOGZjNTAyZGRkMGE3NWUxOWU5OGQxNjliNmZjNTA4MDRhZTFhNWMyOWE2M2M5NGM
[22]: https://github.com/uvdesk/community-skeleton/wiki/dockerize-helpdesk-project
[23]: https://support.uvdesk.com/en/blog/prerequisites-windows
[24]: https://symfony.com/projects/uvdesk
[25]: https://github.com/uvdesk/api-bundle/wiki/Ticket-Related-APIs
[26]: https://store.webkul.com/UVdesk/UVdesk-Open-Source.html