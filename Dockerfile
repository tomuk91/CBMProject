FROM php:8.4-apache

# Install system deps
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git unzip libzip-dev libpng-dev libonig-dev libpq-dev supervisor \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip gd opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && a2dismod mpm_event \
    && a2enmod mpm_prefork \
    && a2enmod rewrite \
    && a2enmod deflate \
    && a2enmod expires \
    && a2enmod headers \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy app
COPY . .

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader

# Build frontend assets
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get update \
    && apt-get install -y --no-install-recommends nodejs \
    && npm ci \
    && npm run build \
    && apt-get purge -y nodejs \
    && apt-get autoremove -y \
    && rm -rf /var/lib/apt/lists/*

# Ensure Laravel writable dirs
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rw storage bootstrap/cache

# Copy PHP configuration
COPY docker/php.ini /usr/local/etc/php/conf.d/99-custom.ini

# Apache config
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Add compression and caching headers
RUN echo '<IfModule mod_deflate.c>\n\
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json\n\
</IfModule>\n\
<IfModule mod_expires.c>\n\
    ExpiresActive On\n\
    ExpiresByType image/jpg "access plus 1 year"\n\
    ExpiresByType image/jpeg "access plus 1 year"\n\
    ExpiresByType image/gif "access plus 1 year"\n\
    ExpiresByType image/png "access plus 1 year"\n\
    ExpiresByType image/svg+xml "access plus 1 year"\n\
    ExpiresByType text/css "access plus 1 month"\n\
    ExpiresByType application/javascript "access plus 1 month"\n\
    ExpiresByType application/json "access plus 0 seconds"\n\
</IfModule>' > /etc/apache2/conf-available/performance.conf \
    && a2enconf performance

EXPOSE 80
ENV PORT=80

RUN chmod +x docker/entrypoint.sh

# Copy supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/var/www/html/docker/entrypoint.sh"]
