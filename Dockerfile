FROM ubuntu:latest
LABEL maintainer="support@uvdesk.com"

ENV GOSU_VERSION=1.11

# Install base supplementary packages
RUN apt-get update && \
    apt-get -y upgrade && \
    apt-get install -y software-properties-common && \
    add-apt-repository -y ppa:ondrej/php && \
    apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get -y install \
        adduser \
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
        php8.1-curl \
        ca-certificates \
        gnupg2 dirmngr && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Create a non-root user for UVDesk
RUN adduser uvdesk --disabled-password --gecos ""

# Copy Apache configuration files
COPY ./.docker/config/apache2/env /etc/apache2/envvars
COPY ./.docker/config/apache2/httpd.conf /etc/apache2/apache2.conf
COPY ./.docker/config/apache2/vhost.conf /etc/apache2/sites-available/000-default.conf

# Copy entrypoint script and source code
COPY ./.docker/bash/uvdesk-entrypoint.sh /usr/local/bin/
COPY . /var/www/uvdesk/

# Update Apache configurations and enable modules
RUN a2enmod php8.1 rewrite && \
    chmod +x /usr/local/bin/uvdesk-entrypoint.sh

# Install GOSU for stepping down from root
RUN dpkgArch="$(dpkg --print-architecture | awk -F- '{ print $NF }')" && \
    wget -O /usr/local/bin/gosu "https://github.com/tianon/gosu/releases/download/$GOSU_VERSION/gosu-$dpkgArch" && \
    wget -O /usr/local/bin/gosu.asc "https://github.com/tianon/gosu/releases/download/$GOSU_VERSION/gosu-$dpkgArch.asc" && \
    gpg --batch --keyserver hkps://keys.openpgp.org --recv-keys B42F6819007F00F88E364FD4036A9C25BF357DD4 && \
    gpg --batch --verify /usr/local/bin/gosu.asc /usr/local/bin/gosu && \
    gpgconf --kill all && \
    chmod +x /usr/local/bin/gosu && \
    gosu nobody true && \
    rm -rf /usr/local/bin/gosu.asc

# Install Composer
RUN wget -O /usr/local/bin/composer.php "https://getcomposer.org/installer" && \
    actualSig="$(wget -q -O - https://composer.github.io/installer.sig)" && \
    currentSig="$(sha384sum /usr/local/bin/composer.php | awk '{print $1}')" && \
    if [ "$currentSig" != "$actualSig" ]; then \
        echo "Warning: Failed to verify composer signature."; \
        exit 1; \
    fi && \
    php /usr/local/bin/composer.php --quiet --filename=/usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer && \
    rm -f /usr/local/bin/composer.php

# Set working directory
WORKDIR /var/www/uvdesk

# Install Composer dependencies
RUN cd /var/www/uvdesk/ && composer install

# Set correct permissions for UVDesk files
RUN chown -R uvdesk:uvdesk /var/www/uvdesk && \
    chmod -R 775 /var/www/uvdesk/var \
                 /var/www/uvdesk/config \
                 /var/www/uvdesk/public \
                 /var/www/uvdesk/migrations \
                 /var/www/uvdesk/.env

RUN composer dump-autoload --optimize && \
    php bin/console cache:clear --env=prod --no-debug || true

# Entry point for the container
ENTRYPOINT ["/usr/local/bin/uvdesk-entrypoint.sh"]
CMD ["/bin/bash"]