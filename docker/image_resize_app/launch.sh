#!/bin/bash
#/usr/sbin/php-fpm5.6 -c /etc/php/5.6/fpm/php-fpm.conf -F
service php5.6-fpm start

trap 'service php5.6-fpm stop; exit 0' EXIT

tail -f /dev/null