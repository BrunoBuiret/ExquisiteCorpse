FROM webdevops/php-nginx
ENV prod /app
WORKDIR ${prod}
COPY ./ $prod/
COPY vhost.conf /opt/docker/etc/nginx/vhost.conf
RUN composer install

EXPOSE 80
EXPOSE 443