FROM php:apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Use the default production configuration
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Set upload filesize limit
ENV UPLOAD_LIMIT=64M
RUN sed -ri -e 's/upload_max_filesize = .*/upload_max_filesize = ${UPLOAD_LIMIT}/' "$PHP_INI_DIR/php.ini"

# Copy project files
WORKDIR /var/www/html/
COPY ./public/ .
COPY ./config-env.php ./protected/config/config.php
