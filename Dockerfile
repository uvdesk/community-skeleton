FROM php:7.2-apache

# Install dependencies
RUN apt-get update \
    && apt-get install -y \
    libc-client-dev \
    libkrb5-dev \
    git \
    zip \
    && rm -r /var/lib/apt/lists/*

# Enable PHP extensions
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap \
    && docker-php-ext-install mysqli \
    && a2enmod rewrite

# Install PECL extensions
RUN pecl install \
    mailparse \
    && docker-php-ext-enable \
    mailparse

# Install application
WORKDIR /var/www
RUN rm -rf /var/www/html
COPY . /var/www/
RUN chown -R www-data:www-data /var/www \
    && ln -s public html

# Install composer dependencies
USER www-data
RUN curl -sS https://getcomposer.org/installer | php -- \
    && php composer.phar install \
    && rm -f composer.phar

USER root
EXPOSE 80
