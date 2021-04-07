FROM phpdockerio/php74-fpm:latest
WORKDIR "/app"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php-memcached php7.4-mysql php-redis php7.4-sqlite3 php7.4-xdebug php7.4-dba php7.4-gmp php-imagick php7.4-imap php7.4-ldap php-mongodb php7.4-odbc php7.4-phpdbg \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git
RUN apt-get update \
    && apt-get -y install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install npm
RUN apt-get update \
    && apt-get -y install nodejs \
    && apt-get -y install npm \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install laravel
RUN composer global require "laravel/installer" 
ENV PATH="/root/.composer/vendor/bin:${PATH}"