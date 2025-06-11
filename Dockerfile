FROM php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Create necessary directories with proper permissions
RUN mkdir -p /var/www/html/app/logs \
    && mkdir -p /var/www/html/files \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/app/logs \
    && chmod -R 777 /var/www/html/files

# Copy application files
COPY . /var/www/html/

# If there's a nested movie directory, move its contents up
RUN if [ -d "/var/www/html/movie" ]; then \
        mv /var/www/html/movie/* /var/www/html/ 2>/dev/null || :; \
        rm -r /var/www/html/movie; \
    fi

# Configure Apache
COPY docker/apache-config.conf /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN if [ -f "composer.json" ]; then \
    composer install --no-dev --no-scripts --no-interaction; \
    fi

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
