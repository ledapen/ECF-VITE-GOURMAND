FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite headers \
    && printf '<Directory /var/www/html/public>\n    AllowOverride All\n    Options FollowSymLinks\n    Require all granted\n</Directory>\n' \
       > /etc/apache2/conf-available/vite-gourmand.conf \
    && a2enconf vite-gourmand

COPY . /var/www/html

RUN mkdir -p /var/www/html/public/uploads \
    && chown -R www-data:www-data /var/www/html

EXPOSE 80
