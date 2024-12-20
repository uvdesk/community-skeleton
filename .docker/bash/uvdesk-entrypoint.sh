#!/bin/bash

# Output color codes
declare -r COLOR_NC='\033[0m'
declare -r COLOR_RED='\033[0;31m'
declare -r COLOR_GREEN='\033[0;32m'
declare -r COLOR_YELLOW='\033[1;33m'
declare -r COLOR_BLUE='\033[0;34m'

# Get the current user or use the provided APP_USER environment variable
CURRENT_USER=${APP_USER:-$(whoami)}
CURRENT_GROUP=${APP_GROUP:-$CURRENT_USER}

# Function to setup MySQL
setup_mysql() {
    echo -e "${COLOR_BLUE}Starting MySQL setup...${COLOR_NC}"
    
    # Wait for MySQL to be ready
    MAX_TRIES=30
    TRIES=0
    until mysqladmin ping >/dev/null 2>&1; do
        TRIES=$((TRIES+1))
        if [ $TRIES -gt $MAX_TRIES ]; then
            echo -e "${COLOR_RED}Failed to connect to MySQL after $MAX_TRIES attempts${COLOR_NC}"
            return 1
        fi
        echo -e "${COLOR_YELLOW}Waiting for MySQL to start... ($TRIES/$MAX_TRIES)${COLOR_NC}"
        sleep 2
    done

    echo -e "${COLOR_GREEN}MySQL is running${COLOR_NC}"

    # Create database if it doesn't exist
    if mysql -u root -e "CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE;"; then
        echo -e "${COLOR_GREEN}Database '$MYSQL_DATABASE' created/verified${COLOR_NC}"
    else
        echo -e "${COLOR_RED}Failed to create database${COLOR_NC}"
        return 1
    fi

    # Create user if it doesn't exist (works for MySQL 5.7 and 8.0)
    if mysql -u root -e "SELECT User FROM mysql.user WHERE User='$MYSQL_USER';" | grep -q "$MYSQL_USER"; then
        echo -e "${COLOR_YELLOW}User '$MYSQL_USER' already exists${COLOR_NC}"
    else
        echo -e "${COLOR_BLUE}Creating MySQL user '$MYSQL_USER'...${COLOR_NC}"
        # MySQL 8.0 syntax
        if mysql -u root -e "CREATE USER '$MYSQL_USER'@'localhost' IDENTIFIED BY '$MYSQL_PASSWORD';"; then
            echo -e "${COLOR_GREEN}User created successfully${COLOR_NC}"
        else
            echo -e "${COLOR_RED}Failed to create MySQL user${COLOR_NC}"
            return 1
        fi
    fi

    # Grant privileges
    echo -e "${COLOR_BLUE}Setting up user privileges...${COLOR_NC}"
    if mysql -u root -e "GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* TO '$MYSQL_USER'@'localhost';"; then
        mysql -u root -e "FLUSH PRIVILEGES;"
        echo -e "${COLOR_GREEN}Privileges granted successfully${COLOR_NC}"
    else
        echo -e "${COLOR_RED}Failed to grant privileges${COLOR_NC}"
        return 1
    fi

    # Update root password
    echo -e "${COLOR_BLUE}Updating root password...${COLOR_NC}"
    if mysql -u root -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '$MYSQL_ROOT_PASSWORD';"; then
        echo -e "${COLOR_GREEN}Root password updated${COLOR_NC}"
    else
        echo -e "${COLOR_RED}Failed to update root password${COLOR_NC}"
        return 1
    fi

    # Create configuration files
    echo -e "${COLOR_BLUE}Creating MySQL configuration files...${COLOR_NC}"
    rm -f /etc/mysql/my.cnf /home/$CURRENT_USER/.my.cnf
    
    # Root config
    echo -e "[client]\nuser = root\npassword = $MYSQL_ROOT_PASSWORD\nhost = localhost" > /etc/mysql/my.cnf
    
    # User config
    echo -e "[client]\nuser = $MYSQL_USER\npassword = $MYSQL_PASSWORD\nhost = localhost" > /home/$CURRENT_USER/.my.cnf
    chmod 600 /home/$CURRENT_USER/.my.cnf
    chown $CURRENT_USER:$CURRENT_GROUP /home/$CURRENT_USER/.my.cnf

    return 0
}

# Set permissions for directories
echo -e "${COLOR_BLUE}Setting up directory permissions for user: $CURRENT_USER${COLOR_NC}"
for dir in "/var/www/uvdesk/.env" "/var/www/uvdesk/var" "/var/www/uvdesk/config" "/var/www/uvdesk/public" "/var/www/uvdesk/migrations"; do
    if [ -e "$dir" ]; then
        chmod 775 "$dir"
        chown $CURRENT_USER:$CURRENT_GROUP "$dir"
        echo -e "${COLOR_GREEN}Set permissions for $dir${COLOR_NC}"
    fi
done

# Create var directory if it doesn't exist
if [ ! -d "/var/www/uvdesk/var" ]; then
    mkdir -p /var/www/uvdesk/var
    chmod 775 /var/www/uvdesk/var
    chown $CURRENT_USER:$CURRENT_GROUP /var/www/uvdesk/var
    echo -e "${COLOR_GREEN}Created var directory${COLOR_NC}"
fi

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