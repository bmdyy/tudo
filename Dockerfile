FROM debian:buster-slim

# Install necessary apt + pip packages
RUN apt-get update && apt-get install firefox-esr sudo apache2 libapache2-mod-php7.3 postgresql php7.3-pgsql python3-pip cron wget -y
RUN pip3 install selenium==3.141.0

# Install geckodriver
COPY ./.docker/geckodriver /usr/bin/

# Copy the files
COPY ./admin/ /var/www/html/admin/
COPY ./images/ /var/www/html/images/
COPY ./includes/ /var/www/html/includes/
COPY ./style/ /var/www/html/style/
COPY ./templates/ /var/www/html/templates/
COPY ./templates_c/ /var/www/html/templates_c/
COPY ./vendor/ /var/www/html/vendor/
COPY ./.htaccess /var/www/html/.htaccess
COPY ./favicon.ico /var/www/html/favicon.ico
COPY ./*.php /var/www/html/

# Copy docker stuff
COPY ./.docker/emulate_admin.py /app/emulate_admin.py
COPY ./.docker/entrypoint.sh /app/entrypoint.sh
COPY ./.docker/setup.sql /app/setup.sql
RUN chmod a+r /app/setup.sql

# Configure crontab
COPY ./.docker/emulate_cron /etc/cron.d/emulate_admin
RUN chmod 0644 /etc/cron.d/emulate_admin &&\
    crontab /etc/cron.d/emulate_admin

# Configure apache2
COPY ./.docker/vhost.conf /etc/apache2/sites-enabled/000-default.conf

# Allow www-data to manage files
RUN chown -R www-data:www-data /var/www/html

# Entrypoint for `docker run` command
EXPOSE 80
ENTRYPOINT ["/bin/sh", "/app/entrypoint.sh"]
