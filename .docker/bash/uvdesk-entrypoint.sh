#!/bin/bash

# Output color codes
declare -r COLOR_NC='\033[0m'
declare -r COLOR_RED='\033[0;31m'
declare -r COLOR_GREEN='\033[0;32m'
declare -r COLOR_YELLOW='\033[1;33m'
declare -r COLOR_BLUE='\033[0;34m'

# @TODO: Debug. Returning access denied warning during container start up.
# if [[ ! -z "$MYSQL_USER" && ! -z "$MYSQL_PASSWORD" && ! -z "$MYSQL_DATABASE" ]]; then
#     if [ "$(mysqladmin ping)" == "mysqld is alive" ]; then
#         # Mysql is up and running with default configuration

#         # Update root & non-root user credentials. Grant non-root user all privileges to all database
#         # Note: Grant privileges will create user if it doesn't exists prior to mysql 8
#         mysql -u root -e "ALTER USER root@localhost IDENTIFIED WITH mysql_native_password BY '$MYSQL_ROOT_PASSWORD'";
#         mysql -u root -e "CREATE USER uvdesk@localhost IDENTIFIED WITH mysql_native_password BY '$MYSQL_PASSWORD'";
#         mysql -u root -e "GRANT ALL ON *.* To $MYSQL_USER@localhost";
#         mysql -u root -e "UPDATE mysql.user SET host='%' WHERE user='$MYSQL_USER'";
#         mysql -u root -e "FLUSH PRIVILEGES";

#         service mysql restart;

#         # Create default database if not found
#         # mysql -u root -e "CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE";

#         # Create new mysql configuration files (root & uvdesk)
#         rm -f /etc/mysql/my.cnf /home/uvdesk/.my.cnf \
#             && echo -e "[client]\nuser = root\npassword = $MYSQL_ROOT_PASSWORD\nhost = localhost" >> /etc/mysql/my.cnf \
#             && echo -e "[client]\nuser = $MYSQL_USER\npassword = $MYSQL_PASSWORD\nhost = localhost" >> /home/uvdesk/.my.cnf;
#     else
#         echo -e "${COLOR_RED}Error: Failed to establish a connection with mysql server (localhost)${COLOR_NC}\n";
#     fi
# else
#     echo -e "${COLOR_LIGHT_YELLOW}Notice: Skipping configuration of local database - one or more mysql environment variables are not defined.${COLOR_NC}\n";
# fi

chown uvdesk:uvdesk /var/www/uvdesk/.env;

# Start services
echo -e "${COLOR_BLUE}Starting services...${COLOR_NC}"
service apache2 restart && service mysql restart

# Setup MySQL if environment variables are provided
if [[ ! -z "$MYSQL_USER" && ! -z "$MYSQL_PASSWORD" && ! -z "$MYSQL_DATABASE" && ! -z "$MYSQL_ROOT_PASSWORD" ]]; then
    if ! setup_mysql; then
        echo -e "${COLOR_RED}MySQL setup failed${COLOR_NC}"
        exit 1
    fi
else
    echo -e "${COLOR_YELLOW}Skipping MySQL setup - required environment variables not set${COLOR_NC}"
fi

# Execute the command
if [ "$(id -u)" = "0" ] && [ ! -z "$APP_USER" ]; then
    exec gosu $APP_USER "$@"
else
    exec "$@"
fi