<p align="center"><a href="https://www.uvdesk.com/en/" target="_blank">
    <img src="https://s3-ap-southeast-1.amazonaws.com/cdn.uvdesk.com/uvdesk/bundles/webkuldefault/images/uvdesk-wide.svg">
</a></p>

UVDesk Extension Framework Bundle
--------------

The extension framework bundle empowers merchants and developers alike with the ability to utilize the full benefits of the uvdesk community.

Whether you're a merchant looking for solutions to extend the capabilities of your helpdesk system, or a developer looking to roll out their own solutions for other merchants to use, the extension framework bundle provides you with all the tools necessary to easily build powerful integrations.

Installation
--------------

Before installing, make sure that you have [Composer][1] installed.

To require the extension framework bundle into your uvdesk community helpdesk project, simply run the following from your project's root:

```bash
$ composer require uvdesk/extension-framework
```

Installing packages
--------------

To add packages to your helpdesk system, simply copy the desired packages into your project's **apps** directory as per the name of the package.

**Example**: Suppose if we want to integrate the [uvdesk/ecommerce][2] package to our helpdesk system, we'll simply copy the package to the *apps/uvdesk/ecommerce* directory relative to our project's root.

Once you've copied all the packages you would like to integrate into your helpdesk system, run the following command from your project's root:

```bash
$ php bin/console uvdesk_extensions:configure-extensions
```

This command will automatically search and configure any available packages found within the apps directory. Once your packages have been configured successfully, they are ready for use.

>**Please Note:**
>
>Although running this command alone should take care of the entire package installation process, your helpdesk system may require some futher additional configurations varying from package to package in order to ensure they work as expected.
>
> Therefore, it is usually a good idea to also follow up running the extension configurations command with the following commands as well: 
>
>```bash
>$ php bin/console assets:install
>$ php bin/console doctrine:migrations:diff
>$ php bin/console doctrine:migrations:migrate
>```
>
>These commands will install any missing web assets as well as update your database with any entities found within the packages.



License
--------------

The **UVDesk Extension Framework Bundle** and libraries included within the bundle are released under the MIT or BSD license.

[1]: https://getcomposer.org/
[2]: https://github.com/uvdesk/ecommerce