#FROM php:8.4-rc-fpm
FROM php:8.3

# Argumentos para o usuário
ARG user=joao
ARG uid=1000

# Instalação de dependências e pacotes necessários
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libssl-dev \
    libcurl4-openssl-dev \
    supervisor \
    libbrotli-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalação de extensões do PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Instalação do Swoole via PECL
RUN pecl install swoole && \
    docker-php-ext-enable swoole

# Instalação do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criação do usuário
RUN useradd -G www-data,root -u $uid -d /home/$user $user && \
    mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Criação de diretórios de log para o Supervisor
RUN mkdir -p /var/log/supervisor /var/log/php-fpm && \
    touch /var/log/php-fpm.log /var/log/php-fpm.error.log && \
    chown www-data:www-data /var/log/php-fpm.log /var/log/php-fpm.error.log


COPY ./docker/supervisord.conf /etc/supervisor/supervisord.conf
COPY ./docker/queue-worker.conf /etc/supervisor/conf.d/queue-worker.conf
COPY ./docker/checkin-worker.conf /etc/supervisor/conf.d/checkin-worker.conf

# Ajusta permissões
RUN chown -R $user:$user /etc/supervisor/conf.d/ \
    && chown $user:$user /etc/supervisor/supervisord.conf

# Copia o script de entrada
COPY ./entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Define o ponto de entrada
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
