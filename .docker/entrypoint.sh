# TUDO!!!!!
echo
echo
echo "-=-=-=-[ TUDO ]-=-=-=-"
echo 
echo 

# start and configure psql server
/etc/init.d/postgresql start
sudo -u postgres psql -c "CREATE DATABASE tudo"
sudo -u postgres psql -c "ALTER USER postgres PASSWORD 'postgres'"
sudo -u postgres psql -f /app/setup.sql tudo

# start cron
/etc/init.d/cron start

# start apache server
/usr/sbin/apache2ctl -D FOREGOUND

# stayin alive
/bin/bash -c 'while [[ 1 ]]; do sleep 60; done';
