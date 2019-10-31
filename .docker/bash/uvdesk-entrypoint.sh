#!/bin/bash

# Output color codes
# https://en.wikipedia.org/wiki/ANSI_escape_code

declare -r COLOR_NC='\033[0m'
declare -r COLOR_RED='\033[0;31m'
declare -r COLOR_GREEN='\033[0;32m'
declare -r COLOR_LIGHT_GREEN='\033[1;32m'
declare -r COLOR_YELLOW='\033[1;33m'
declare -r COLOR_LIGHT_YELLOW='\033[0;33m'
declare -r COLOR_BLUE='\033[0;34m'
declare -r COLOR_LIGHT_BLUE='\033[1;34m'

# Restart apache & mysql server
service apache2 restart && service mysql restart;

if [[ ! -z "$MYSQL_USER" && ! -z "$MYSQL_PASSWORD" && ! -z "$MYSQL_DATABASE" ]]; then
    if [ "$(mysqladmin ping)" == "mysqld is alive" ]; then
        # Mysql is up and running with default configuration

        # Create default database if not found and grant non-root user all privileges to that database
        # Note: Grant privileges will create user if it doesn't exists prior to mysql 8
        mysql -u root -e "CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE";
        mysql -u root -e "GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* To '$MYSQL_USER'@'localhost' IDENTIFIED BY '$MYSQL_PASSWORD'";

        # Update root user credentials
        mysql -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '$MYSQL_ROOT_PASSWORD'";

        # Create new mysql configuration files (root & uvdesk)
        rm -f /etc/mysql/my.cnf /home/uvdesk/.my.cnf \
            && echo -e "[client]\nuser = root\npassword = $MYSQL_ROOT_PASSWORD\nhost = localhost" >> /etc/mysql/my.cnf \
            && echo -e "[client]\nuser = $MYSQL_USER\npassword = $MYSQL_PASSWORD\nhost = localhost" >> /home/uvdesk/.my.cnf;
    else
        echo -e "${COLOR_RED}Error: Failed to establish a connection with mysql server (localhost)${COLOR_NC}\n";
        exit 1;
    fi
else
    echo -e "${COLOR_LIGHT_YELLOW}Notice: Skipping configuration of local database - one or more mysql environment variables are not defined.${COLOR_NC}\n";
fi

# Step down from sudo to uvdesk
/usr/local/bin/gosu uvdesk "$@"

exec "$@"
