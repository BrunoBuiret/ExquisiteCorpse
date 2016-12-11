FROM mrvil/nginx-php7-composer-modmongo
ENV ws /var/www/html
WORKDIR ${ws}
COPY ./ ${ws}
RUN ./composer.phar install