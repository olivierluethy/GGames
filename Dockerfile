# GGames – PHP/Apache image
FROM php:8.2-apache

# PHP extensions needed by the app (PDO + mysqli)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Custom PHP config (errors to log, not into the response body)
COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-ggames.ini

# The app relies on .htaccess RewriteRules, so enable mod_rewrite
# and allow .htaccess overrides for the document root.
RUN a2enmod rewrite \
    && sed -ri 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# The app uses absolute redirects to http://localhost/GGames/...,
# so it must be served from the /GGames/ sub-path.
COPY . /var/www/html/GGames/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
