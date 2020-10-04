#!/bin/sh

echo "starting cron..."
service cron start 2>&1

echo "installing crontab..."
crontab -u root /var/www/laravel-scheduler 2>&1

echo "starting rsyslog..."
service rsyslog start 2>&1

echo "starting apache..."
exec "/usr/local/bin/apache2-foreground"