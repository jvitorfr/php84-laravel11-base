FROM php:8.4-rc-fpm

ARG user=joao
ARG uid=1000

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN apt-get update && apt-get install -y supervisor \
    && mkdir -p /etc/supervisor/conf.d

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

RUN mkdir -p /var/log/supervisor /var/log/php-fpm && \
    touch /var/log/php-fpm.log /var/log/php-fpm.error.log && \
    chown www-data:www-data /var/log/php-fpm.log /var/log/php-fpm.error.log

COPY ./docker/supervisord.conf /etc/supervisor/supervisord.conf
COPY ./docker/queue-worker.conf /etc/supervisor/conf.d/queue-worker.conf

RUN chown -R joao:joao /etc/supervisor/conf.d/ \
    && chown joao:joao /etc/supervisor/supervisord.conf

COPY ./entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]


