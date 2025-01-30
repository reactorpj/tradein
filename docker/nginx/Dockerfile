FROM nginx:stable-bookworm-perl

COPY ./etc/templates/default.conf /etc/nginx/templates/default.conf.template

WORKDIR /var/www/html

RUN  apt update && apt -yq install jq