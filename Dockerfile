FROM webdevops/php-nginx
ENV prod /var/www/html
WORKDIR ${prod}
RUN rm -rf *
ADD * $prod/
RUN composer install