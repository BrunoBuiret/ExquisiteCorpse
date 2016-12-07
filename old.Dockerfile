FROM webdevops/php-nginx
ENV prod /app
WORKDIR ${prod}
COPY ./ $prod/
COPY vhost.conf /opt/docker/etc/nginx/vhost.conf
RUN composer install
RUN apt-get update
RUN apt-get install php-pear php7.0-dev libcurl3-openssl-dev -y
RUN pecl install mongodb

EXPOSE 80
EXPOSE 443