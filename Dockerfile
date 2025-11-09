FROM php:8.1-apache-bullseye

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    libicu-dev \
    libpng-dev \
    libxml2-dev \
    libonig-dev \
    libkrb5-dev \
    libssl-dev \
    default-mysql-client \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libc-client-dev \
    libkrb5-dev \
    && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install intl gd zip xml mbstring mysqli opcache pdo pdo_mysql

# Install IMAP
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

# Install mailparse
RUN pecl install mailparse && docker-php-ext-enable mailparse

# Enable Apache modules and configure
RUN a2enmod rewrite headers && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Increase PHP memory limit
RUN echo "memory_limit = 512M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy startup script
COPY uvdesk-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/uvdesk-entrypoint.sh

# Use the startup script as entrypoint
CMD ["/usr/local/bin/uvdesk-entrypoint.sh"]
