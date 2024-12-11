FROM ubuntu:20.04
LABEL maintainer="akshay.kumar758@webkul.com"

ENV GOSU_VERSION 1.11

# Add a non-privileged user for running the application
RUN adduser uvdesk -q --disabled-password --gecos ""

# Install base and supplementary packages
RUN apt-get update && apt-get -y upgrade \
    && apt-get install -y software-properties-common && add-apt-repository -y ppa:ondrej/php \
    && apt-get update && DEBIAN_FRONTEND=noninteractive apt-get -y install \
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
        ca-certificates; \
    if ! command -v gpg; then \
        apt-get install -y --no-install-recommends gnupg2 dirmngr; \
    elif gpg --version | grep -q '^gpg (GnuPG) 1\.'; then \
        apt-get install -y --no-install-recommends gnupg-curl; \
    fi;

# Copy configuration files
COPY ./.docker/config/apache2/env /etc/apache2/envvars
COPY ./.docker/config/apache2/httpd.conf /etc/apache2/apache2.conf
COPY ./.docker/config/apache2/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY ./.docker/bash/uvdesk-entrypoint.sh /usr/local/bin/
COPY . /var/www/uvdesk/

# Set up Apache and PHP
RUN \
    a2enmod php8.1 rewrite; \
    chmod +x /usr/local/bin/uvdesk-entrypoint.sh; \
    \
    # Install gosu for stepping-down from root to a non-privileged user during container startup
    dpkgArch="$(dpkg --print-architecture | awk -F- '{ print $NF }')"; \
    wget -O /usr/local/bin/gosu "https://github.com/tianon/gosu/releases/download/$GOSU_VERSION/gosu-$dpkgArch" \
    && wget -O /usr/local/bin/gosu.asc "https://github.com/tianon/gosu/releases/download/$GOSU_VERSION/gosu-$dpkgArch.asc"; \
    \
    # Verify gosu installation
    export GNUPGHOME="$(mktemp -d)" \
    && gpg --batch --keyserver hkps://keys.openpgp.org --recv-keys B42F6819007F00F88E364FD4036A9C25BF357DD4 \
    && gpg --batch --verify /usr/local/bin/gosu.asc /usr/local/bin/gosu \
    && gpgconf --kill all \
    && chmod +x /usr/local/bin/gosu \
    && gosu nobody true; \
    \
    # Download and verify composer installer signature
    wget -O /usr/local/bin/composer.php "https://getcomposer.org/installer"; \
    actualSig="$(wget -q -O - https://composer.github.io/installer.sig)"; \
    currentSig="$(shasum -a 384 /usr/local/bin/composer.php | awk '{print $1}')"; \
    if [ "$currentSig" != "$actualSig" ]; then \
        echo "Warning: Failed to verify composer signature."; \
        exit 1; \
    fi; \
    \
    # Install composer
    php /usr/local/bin/composer.php --quiet --filename=/usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer; \
    \
    # Assign user uvdesk the ownership of the source directory
    chown -R uvdesk:uvdesk /var/www; \
    \
    # Clean up temporary files
    rm -rf \
        "$GNUPGHOME" \
        /var/lib/apt/lists/* \
        /usr/local/bin/gosu.asc \
        /usr/local/bin/composer.php \
        /var/www/bin \
        /var/www/html \
        /var/www/uvdesk/.docker;

# Set the working directory to UVdesk source
WORKDIR /var/www

# Define entrypoint and default command
ENTRYPOINT ["uvdesk-entrypoint.sh"]
CMD ["/bin/bash"]
