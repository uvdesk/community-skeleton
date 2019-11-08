FROM ubuntu:latest
LABEL maintainer="akshay.kumar758@webkul.com"

ENV GOSU_VERSION 1.11

RUN adduser uvdesk -q --disabled-password --gecos ""

# Install base supplimentary packages
RUN apt-get update && apt-get -y upgrade \
    && apt-get update && apt-get install -y software-properties-common \
    && apt-get update && DEBIAN_FRONTEND=noninteractive apt-get -y install \
        curl \
        wget \
        git \
        unzip \
        apache2 \
        mysql-server \
        php7.2 \
        libapache2-mod-php7.2 \
        php-xml \
        php7.2-imap \
        php7.2-mysql \
        php-mailparse \
        ca-certificates; \
    if ! command -v gpg; then \
		apt-get install -y --no-install-recommends gnupg2 dirmngr; \
	elif gpg --version | grep -q '^gpg (GnuPG) 1\.'; then \
		apt-get install -y --no-install-recommends gnupg-curl; \
	fi;

COPY ./.docker/config/apache2/env /etc/apache2/envvars
COPY ./.docker/config/apache2/httpd.conf /etc/apache2/apache2.conf
COPY ./.docker/config/apache2/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY ./.docker/bash/uvdesk-entrypoint.sh /usr/local/bin/
COPY . /var/www/uvdesk/

RUN \
    # Update apache configurations
    a2enmod php7.2 rewrite; \
    chmod +x /usr/local/bin/uvdesk-entrypoint.sh; \
    # Install gosu for stepping-down from root to a non-privileged user during container startup
    dpkgArch="$(dpkg --print-architecture | awk -F- '{ print $NF }')"; \
    wget -O /usr/local/bin/gosu "https://github.com/tianon/gosu/releases/download/$GOSU_VERSION/gosu-$dpkgArch" \
    && wget -O /usr/local/bin/gosu.asc "https://github.com/tianon/gosu/releases/download/$GOSU_VERSION/gosu-$dpkgArch.asc"; \
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
    # Install composer
    php /usr/local/bin/composer.php --quiet --filename=/usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer; \
    # Assign user uvdesk the ownership of source directory
    chown -R uvdesk:uvdesk /var/www; \
    # Clean up files
    rm -rf \
        "$GNUPGHOME" \
        /var/lib/apt/lists/* \
        /usr/local/bin/gosu.asc \
        /usr/local/bin/composer.php \
        /var/www/bin \
        /var/www/html \
        /var/www/uvdesk/.docker;

# Change working directory to uvdesk source
WORKDIR /var/www

ENTRYPOINT ["uvdesk-entrypoint.sh"]
CMD ["/bin/bash"]