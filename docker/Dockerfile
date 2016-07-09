FROM php:7.0

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    --no-install-recommends && rm -r /var/lib/apt/lists/*

RUN mkdir --parent /usr/src/composer && \
    cd /usr/src/composer && \
    php -r "readfile('https://getcomposer.org/installer');" > composer-setup.php && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" &&\
    mv composer.phar /usr/bin/composer

RUN docker-php-ext-install \
    zip

ARG UID
ARG GID
ARG UNAME

WORKDIR /var/www/twitter-keyword-frequency

RUN groupadd -f -g ${GID} ${UNAME} && \
    useradd -d /home/${UNAME} -m -u ${UID} -g ${UNAME} ${UNAME}

USER ${UNAME}

CMD ["php", "--version"]