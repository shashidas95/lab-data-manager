FROM php:8.2-fpm

# Install Composer
RUN cd /tmp && \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Install required extensions and useful packages
RUN apt-get update -y && \
    apt-get install -y \
    apt-utils \
    nano \
    wget \
    dialog \
    vim \
    build-essential \
    git \
    curl \
    libcurl4 \
    libcurl4-openssl-dev \
    zlib1g-dev \
    libzip-dev \
    zip \
    libbz2-dev \
    locales \
    libmcrypt-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev && \
    docker-php-ext-install pdo pdo_mysql && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo_pgsql pgsql && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Create necessary directories for Laravel
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache

# Set permissions and ownership for Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Ensure PHP-FPM runs as the www-data user
USER www-data

# Expose port 80
EXPOSE 80

# Command to run PHP-FPM
CMD ["php-fpm"]
