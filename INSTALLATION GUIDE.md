Installation Guide
-----------------

This guide will walk you through all the steps necessary from setting up your server environment to installing the uvdesk community helpdesk project.

> Note: This guide assumes that you already have your instance (docker instance, virtual machine, remote instance, etc...) prepared and have all the necessary credentials to perform operations requiring elevated privileges.

Overview
-----------------

We've broken this guide down into multiple sections from installing latest dependencies, to mantaining proper user permissions & file ownerships, and installing the helpdesk project using composer. You can jump right to the part most relevant to you:

* [(Optional) Upgrade to latest available Ubuntu packages](#optional-upgrade-to-latest-available-ubuntu-packages)
* [(Optional) Create a non-root user with elevated privileges](#optional-create-a-non-root-user-with-elevated-privileges)
* [(Optional) Checking for the latest PHP version available](#optional-checking-for-the-latest-php-version-available)
* [Install PHP, Apache and all the necessary packages](#install-php-apache-and-all-the-necessary-packages)
* [(Optional) Update Apache's Document Root](#optional-update-apaches-document-root)
* [Downloading and setting up Composer](#downloading-and-setting-up-composer)
* [Installing and setting up Uvdesk Community Helpdesk](#installing-and-setting-up-uvdesk-community-helpdesk)

(Optional) Upgrade to latest available Ubuntu packages
-----------------

Although optional, it's advisable to update to the latest available packages. To do so, use the following commands:

```bash
# Update the list of available packages so that the package manager is aware about the latest packages
$ sudo apt-get update;

# Update the packages to their latest available versions
$ sudo apt-get -y upgrade;
```

(Optional) Create a non-root user with elevated privileges
-----------------

It's advisable to have a non-root user configured on your instance with elevated privileges other than a root account, so that your file ownerships are properly managed and you don't run into un-intended permission related issues. To add a non-root user with elevated privileges (say *uvdesk*), use the following commands:

```bash
# Create user
$ adduser uvdesk;

# Add user to the sudo group so they can perform operations requiring elevated privileges
$ usermod -aG sudo uvdesk;

# Verify that the user uvdesk has been added to the sudo group
$ groups uvdesk;

# You can also additionaly use the passwd command if you want to set user password
$ passwd uvdesk;
```

Once your non-root user with elevated privileges has been created, you can switch to the new user account in your current terminal session using the following command:

```bash
# Use '-' if you want to be prompted for user password before switching session into the new user.
$ su - uvdesk
```

> Note: We will be using the user we just created to setup our helpdesk project, and then add this user to apache's www-data user group. This way, while the project ownership will belong to our user, apache will still have the necessary access to manage our project resources so we don't run into any permission related issues.

(Optional) Checking for the latest PHP version available
-----------------

If you want to check for the latest PHP version available, you can use the following command to list all the PHP packages available for installation:

```bash
$ apt-cache search php;
```

If you find a PHP version to your preference, you can proceed with that (it's recommended to use PHP 7.4 or greater). Otherwise, you can ppa:ondrej/php apt repository to install the latest version of PHP available:

```bash
$ sudo add-apt-repository -y ppa:ondrej/php;

# Make sure the package manager is aware about the newly listed packages
$ sudo apt-get update;
```

Install PHP, Apache and all the necessary packages
-----------------

Note: We're proceeding with installing PHP 8.2 in this guide. If you want to use a different version of PHP, simply replace 8.2 with your preferred version.

```bash
$ sudo apt -y install php8.2;

# Install the remaining packages
$ sudo apt-get install -y software-properties-common;
$ sudo apt-get -y install \
    curl \
    wget \
    git \
    unzip \
    apache2 \
    mysql-server \ 
    php8.2 \
    libapache2-mod-php8.2 \ 
    php8.2-common \
    php8.2-xml \
    php8.2-imap \
    php8.2-mysql \
    php8.2-mailparse \
    ca-certificates;

# Enable apache rewrite module
$ sudo a2enmod rewrite;

# Restart your apache server
$ sudo service apache2 restart;
# Or alternatively, use 'sudo systemctl restart apache2'

# Verify that your apache server is up & running
$ sudo service apache2 status;
```

> Note: You can list all available loaded PHP modules using the following command: $ php -m

Now, Verify your Apache & PHP installations using the commands below (don't worry about the warnings):

```bash
$ apache2 --version;
$ php --version;
```

With apache server installed & running, you should now be able to load web reources from your server. You can check this by accessing your server IP on your web browser.

(Optional) Update Apache's Document Root
-----------------

In your home directory (/home/uvdesk), create the following directories:

```bash
/home/uvdesk/workstation

# We will setup our helpdesk project within this directory
/home/uvdesk/workstation/projects

# We will setup this directory to be used as the document root for apache, so any resources within this directory will be servable by apache through localhost
/home/uvdesk/workstation/www
````

At this moment, apache will currently be serving documents from the /var/www/ directory. In order to serve documents from /home/uvdesk/workstation/www directory instead, we need to modify a few apache configurations and restart the apache service for these changes to take affect.

```bash
# File: /etc/apache2/apache2.conf
# Replace /var/www/ with the path of our new document root directory /home/uvdesk/workstation/www/ and set AllowOverride to All
$ sudo nano /etc/apache2/apache2.conf

# File: /etc/apache2/sites-available/000-default.conf
# Replace /var/www/html with the path of our new document root directory /home/uvdesk/workstation/www
$ sudo nano /etc/apache2/sites-available/000-default.conf

# Restart your apache server
$ sudo service apache2 restart;
# Or alternatively, use 'sudo systemctl restart apache2'
```

Now, add user uvdesk to the www-data user group, so that www-data can access the resources in our new document root directory:

```bash
$ sudo usermod -aG uvdesk www-data;
$ sudo service apache2 restart;
```

### Testing the PHP Environment (optional)

Now, create a php script *index.php* within your new document root directory using the following commands:

```bash
$ cd /home/uvdesk/workstation/www;

# Create and add the following code to index.php
$ echo "<?php echo phpinfo(); ?>" > index.php
```

Navigate to localhost/index.php to verify that localhost is able to serve your script.

> Note: If you're setting up the project on a remote instance, you can use your server's IP address instead of localhost to verify the same. Depending on your server configurations, you might need to manage your firewall settings to allow HTTP/HTTPS requests.

With all these changes done, your apache server should be able to serve web resources from your new document root. You can further go ahead and configure your DNS records to point your domains to your server's IP at this step.

Downloading and setting up Composer
-----------------

Follow the instructions provided on the official [composer website](https://getcomposer.org/download/) to download and install composer package manager. Once installed, it's advisable to move the composer executable to the /usr/local/bin/ directory so that it can be easily accessed from anywhere in your terminal. To do so, use the following commands:

```bash
# Assuming you used the default download instructions, the composer executable will be named composer.phar.
# We will rename and move the executable script to the /usr/local/bin/ directory.

$ mv composer.phar composer
$ sudo mv composer /usr/local/bin/

# Use the following command to verify that composer executable is accessible to you from your current directory
$ composer --version
```

Installing and setting up Uvdesk Community Helpdesk
-----------------

To install the uvdesk community helpdesk project using composer (recommended), use the following commands:

> We will be installing the project within the /home/uvdesk/workstation/projects directory, and then symlink the public directory of our project to/within apache's document root so that the project is servable from localhost. This can be changed however according to your own preference.

```bash
$ cd /home/uvdesk/workstation/projects
$ composer create-project uvdesk/community-skeleton
```

If you don't wish to use composer, you can just download the zip archive of the project and unpack it instead.

```bash
$ cd /home/uvdesk/workstation/projects
$ wget "https://cdn.uvdesk.com/uvdesk/downloads/opensource/uvdesk-community-current-stable.zip"
$ unzip uvdesk-community-current-stable.zip
```

After your project has been installed, you can navigate to your helpdesk project and run the following command to configure your helpdesk from the command line itself:

```bash
$ php bin/console uvdesk:configure-helpdesk
```

---

Please feel free to further contribute to this resource.