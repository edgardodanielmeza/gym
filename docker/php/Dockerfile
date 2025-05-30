FROM php:8.2-apache

# System dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    sudo \
    # Dependencias para extensiones de imagen
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    # Dependencias para pdo_pgsql
    libpq-dev \
    # Otras utilidades
    iproute2 \
    dnsutils \
    vim \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip intl opcache exif bcmath

# Enable Apache mod_rewrite
RUN a2enmod rewrite headers

# Set Apache DocumentRoot to /var/www/html/public (standard for Laravel/Symfony)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Configure Apache to allow .htaccess overrides
COPY <<EOF /etc/apache2/conf-available/allow-override.conf
<Directory /var/www/html/public>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
EOF
RUN a2enconf allow-override

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set workdir
WORKDIR /var/www/html

# Copy application code (esto es opcional aquí si se monta el volumen en docker-compose)
# COPY . /var/www/html

# Change ownership to www-data (Apache user) to avoid permission issues
# Esto es mejor hacerlo en el docker-compose o como un comando entrypoint
# RUN chown -R www-data:www-data /var/www/html

# El puerto 80 ya está expuesto por la imagen base de php:X.X-apache
# EXPOSE 80
# El CMD por defecto de la imagen base es ["apache2-foreground"], lo cual es correcto.
# CMD ["apache2-foreground"]
