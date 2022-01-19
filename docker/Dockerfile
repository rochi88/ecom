# FROM php:7.4-fpm
# FROM php:8.1.1-fpm
FROM php:8.0.2-fpm


ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="10000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="192" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"


COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libwebp-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libldap2-dev \
    libsodium-dev \
    libgmp-dev \
    locales \
    zip \
    libzip-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-webp=/usr/include/  --with-jpeg=/usr/include/ && \
    docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install gd pdo pdo_mysql mbstring zip gmp bcmath pcntl ldap sysvmsg exif intl sodium opcache


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
#RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
