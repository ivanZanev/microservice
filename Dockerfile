FROM php:7.2-apache

USER root

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y cron

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --chown=www-data:www-data ./code /var/www/html

RUN cp /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled/rewrite.load

RUN mkdir -p /var/log/cron

COPY ./services/cron.d/laravel-scheduler /var/www/laravel-scheduler
RUN chmod 0600 /var/www/laravel-scheduler

COPY ./services/entrypoint.sh /usr/local/bin

ENTRYPOINT ["/usr/bin/env"]

CMD ["bash", "entrypoint.sh"]