# SERVER IIEG DATABASE: 5.6.37.  PHP VERSION: 5.4.16
FROM php:5.4-apache 
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update -y && apt-get install -y sendmail libpng-dev
RUN apt-get update \
     && apt-get install -y libzip-dev \
     && docker-php-ext-install zip \
     && apt-get update && apt-get install -y libmcrypt-dev \
     && apt-get install -y mcrypt
RUN docker-php-ext-install gd
RUN docker-php-ext-install mcrypt pdo_mysql mbstring
RUN pear install Log \ pear channel-update pear.php.net
RUN pear install HTTP_WebDAV_Server-1.0.0RC8
RUN pear channel-discover pear.dotkernel.com/zf1/svn
RUN pear install zend/zend
RUN a2enmod rewrite && service apache2 restart
RUN apt-get update
RUN curl -sS https://getcomposer.org/installer | php
#RUN mv composer.phar /usr/local/bin/composer
#RUN chmod +x /usr/local/bin/composer
RUN chmod 777 -R ./

