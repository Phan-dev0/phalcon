FROM php:8.1-fpm

WORKDIR /var/www/html/

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    libpcre3-dev \
    git \
    curl \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Phalcon
ENV PHALCON_VERSION=5.9.0
RUN curl -sSL "https://codeload.github.com/phalcon/cphalcon/tar.gz/v${PHALCON_VERSION}" | tar -xz \
    && cd cphalcon-${PHALCON_VERSION}/build \
    && ./install \
    && echo "extension=phalcon.so" > /usr/local/etc/php/conf.d/phalcon.ini \
    && cd ../../ \
    && rm -r cphalcon-${PHALCON_VERSION}

# Install Phalcon DevTools globally
RUN composer global require phalcon/devtools \
    && ln -s /root/.composer/vendor/bin/phalcon /usr/local/bin/phalcon

# Configure Nginx
COPY default.conf /etc/nginx/conf.d/default.conf

# Copy application files (with .dockerignore in place)
COPY . .

# Fix permissions
RUN chown -R www-data:www-data /var/www/html

# Start services
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]