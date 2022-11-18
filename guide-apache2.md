
Overview
-----------------

<p> We supposed that you have a already created your virtual machine. 

Also, Access the terminal using your root user credentials.

Now we will continue our ubuntu configuration, php installation, composer and Uvdesk installation

</p>

Getting Started
-----------------

* [Upgrade Ubuntu Packages](#Upgrade-the-latest-Ubuntu-Packages)
* [Create a non-root user (optional)](#Create-a-non-root-user-with-a-sudo-group-optional)
* [How to check the latest version of PHP in your packages repository (optional)](#Here-we-check-which-the-latest-PHP-version-available-optional)
* [PHP Installation](#PHP-Installation-with-install-remaining-packages)
* [Update Apache's document root file (optional)](#Update-Apache-document-root-file-optional)
* [Testing the PHP Environment (optional)](#Testing-the-PHP-Environment-optional)
* [Composer Installation](#Setting-Up-download-the-Composer)
* [Uvdesk Installation](#Installation-of-Uvdesk-Helpdesk-using-composer-command-or-zip-file)



Upgrade the latest Ubuntu Packages
-----------------                       

<!--- This is used for linking of above points clicking line ---------------- and also added same content of # together you want to link word  -->

3. Run the following commands to <b> update your packages list </b> , and then <b> upgrade to the latest available packages </b> the below commands:

        $ sudo apt-get update;

        $ sudo apt-get -y upgrade;

Create a non root user with a sudo group (optional)
-----------------

4. Run the following commands to <b> create a not-root user (uvdesk) with sudo privileges:</b>   

        $ adduser uvdesk;                          (Create user: adduser <your-user-name>)

        $ usermod -aG sudo uvdesk;                 (Add user to sudo group: usermod -addGroup sudo <your-user-name>;)

        $ groups uvdesk;                           (Verify that the user has been added to the sudo group)

5. Exit your ssh session, and then <b> create a new ssh session by using the credentials of your-user (uvdesk) </b> you just created (you might need to setup ssh keys depending on your security configurations)

    Or you can <b> switch directly </b> in the same terminal using the below command:

        $ su - uvdesk                              (su - <your-user-name>)

    Now, Enter your password when prompted. You can run commands as normal, just by typing them.


Here we check which the latest PHP version available (optional)
-----------------

6. Lookup the latest version of PHP available in your packages repository using the following command. If it's greater than 8, we'll be proceeding with that:

        $ apt-cache search php;

    Otherwise, add the <b> ppa:ondrej/php </b> repository to be able to install the latest version of php:

        $ sudo add-apt-repository -y ppa:ondrej/php;

    Finally, you update <b> apt-get </b> again so your package manager can see the newly listed packages:

        $ sudo apt-get update;


PHP Installation with install remaining packages
-----------------

7. Now you’re ready to <b> install PHP 7.4, 8.0 or 8.1 </b> as your wish using the following command:

        $ sudo apt -y install php8.1               (sudo apt -y install php <your-php-version>)

    Install the remaining packages using <b> sudo </b> as listed below:

        $ sudo apt-get install -y software-properties-common;

        $ sudo apt-get -y install 
        curl \
        wget \
        git \
        unzip \
        apache2 \
        mysql-server \ 
        php8.1 \
        libapache2-mod-php8.1 \ 
        php8.1-common \
        php8.1-xml \
        php8.1-imap \
        php8.1-mysql \
        php8.1-mailparse \
        ca-certificates;
    
        $ sudo a2enmod rewrite;
        
        $ sudo service apache2 restart;			 (For Restart again apache server)
    
        $ sudo service apache2 status			     (For checking apache status is running or not)

    > You can also used these alternatively commands for restart your apache:
        

        $ sudo systemctl restart apache2;           # Alternatively

        $ sudo /etc/init.d/apache2 restart;         # Alternatively

    > Note: If you want to install some additional PHP modules. You can use this command to install additional modules, replacing <b> PACKAGE_NAME </b> with the package you wish to install:

        $ sudo apt-get install php8.1-PACKAGE_NAME
    
    > PHP configurations related to Apache are stored in <b> /etc/php/8.1/apache2/php.ini </b>. 
    You can list all loaded PHP modules with the following command:

        $ php -m

    Now, Verify your <b> Apache & PHP installations </b> using the commands below (don't worry about the warnings):

        $ apache2 --version

        $ php --version

With apache server installed & running, you should now be able to load web reources from your server. You can check this by accessing your server IP on your web browser.


Update Apache document root file (optional)
-----------------

8. Before we move further, lets take care of a few things first:

    In your home directory (/home/uvdesk), create the following directories:

        /home/uvdesk/workstation			         (mkdir workstation)

        /home/uvdesk/workstation/projects           (we will setup our helpdesk project in this directory)

        /home/uvdesk/workstation/www                (we will setup this directory to act as apache's document root, so any content in this directory will be available to apache)

    Now, Update your <b> apache's document root </b> using the below commands:

        $ sudo nano /etc/apache2/apache2.conf

        Replace  /var/www/   with the path of our new document root directory  /home/uvdesk/workstation/www/
        
        and set AllowOverride to All

        $ sudo nano /etc/apache2/sites-available/000-default.conf
        
        Replace  /var/www/html  with the path of our new document root directory  /home/uvdesk/workstation/www
        
    After that you will restart your apache again using this command:
        
        $ sudo service apache2 restart

     > You can also used these alternatively commands for restart your apache:
        

        $ sudo systemctl restart apache2;           # Alternatively

        $ sudo /etc/init.d/apache2 restart;         # Alternatively

    Now, Add <b> user uvdesk </b> to the <b> www-data </b> user group, so that <b> www-data </b> can access the resources in our new document root directory:
        
        $ sudo usermod -aG uvdesk www-data

        $ sudo service apache2 restart

    
Testing the PHP Environment (optional)
-----------------

9. Now, <b> Create a test php file </b> on your new document root to test your changes:

        cd /home/uvdesk/workstation/www;

        $ touch index.php    
        
    Go to <b> index.php </b>  file using this command: 
        
        $ sudo nano /etc/apache2/index.php      
        
    After that <b> add this code </b> in your <b> index.php </b> file and save:
        
        <?php 
        echo phpinfo(); 
        ?>



10. With all these changes done, your apache server should be able to serve web resources from your new document root. You can check this by accessing your server IP on your web browser.

11. Now that your server is up and running, you can go ahead and configure your DNS records to point your subdomain to your servers IP. As per your requirements, I've implemented the same setup where the main domain points to one server, and a subdomain points to a different server.

12. After your DNS records update takes hold, your subdomain should now point to your newly configured server.

Voila! You're halfway there. 

>Now we can go ahead with setting up <b> composer, helpdesk project, and configuring your SSL records </b>.


Setting Up download the Composer
-----------------

13. In your terminal, navigate to <b> your workstation directory </b> and run the scripts provided on https://getcomposer.org/download/ to download composer.

    This will download composer executable to the current directory you're in.

14. Rename <b> composer.phar </b> to composer, and then <b> move it to your local bin directory </b> so that it can be easily accessed from anywhere in your terminal so run the below commands:

        $ mv composer.phar composer

        $ sudo mv composer /usr/local/bin/

    To <b> check your composer version </b> using run this command:

        $ composer --version


Installation of Uvdesk Helpdesk using composer command or zip file
-----------------

15. Now, you can install the Uvdesk Helpdesk project on your server:

Navigate to your projects directory:

    cd /home/uvdesk/workstation/projects

> Install <b> Uvdesk helpdesk community using the composer command </b>  so run the below command:

    $ composer create-project uvdesk/community-skeleton


> Direct Download in Zip File of Uvdesk latest stable release:

Alternatively, you can also download the <b> zip archive of the latest stable release and extract </b> its content by running the following commands from your terminal:

    $ wget "https://cdn.uvdesk.com/uvdesk/downloads/opensource/uvdesk-community-current-stable.zip" -P /var/www/

    $ unzip -q /var/www/uvdesk-community-current-stable.zip -d /var/www/ \

Also, click and download from here:
https://cdn.uvdesk.com/uvdesk/downloads/opensource/uvdesk-community-current-stable.zip



After composer has successfully created your helpdesk project, let's configure it so that when you visit your website, the helpdesk project is served right away.

After that you will setup of your project so you can continue from here: 
https://github.com/uvdesk/community-skeleton#installation



