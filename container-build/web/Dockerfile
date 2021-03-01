FROM php:7.3-apache

RUN apt-get update \
&& apt-get install -y git zlib1g-dev mariadb-client libzip-dev \
&& docker-php-ext-install zip mysqli pdo_mysql \
&& pecl install xdebug \
&& docker-php-ext-enable xdebug \
&& echo 'zend_extension="/usr/local/lib/php/extensions/no-debug-non-zts-20180731/xdebug.so"' >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo 'xdebug.remote_enable=on' >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo 'xdebug.remote_host=172.17.0.1' \
&& echo 'xdebug.remote_autostart=0' >> /usr/local/etc/php/conf.d/xdebug.ini \
&& echo 'xdebug.remote_connect_back=1' >> /usr/local/etc/php/conf.d/xdebug.ini \
&& a2enmod rewrite \
&& sed -i 's!var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf \
&& mv /var/www/html /var/www/public \
&& curl -sS https://getcomposer.org/installer \
 | php -- --install-dir=/usr/local/bin --filename=composer \
&& echo "AllowEncodedSlashes On" >> /etc/apache2/apache2.conf

WORKDIR /var/www