FROM php:8.1-fpm-alpine

WORKDIR /var/www/html/
# Install Nginx
RUN apk add --no-cache nginx \
    && docker-php-ext-install mysqli 

# # Create folders
# RUN mkdir -p /run/nginx /app

# Copy Nginx config
COPY default.conf /etc/nginx/http.d/default.conf

# Copy PHP files
COPY . .

# Start both PHP-FPM and Nginx when the container runs
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]