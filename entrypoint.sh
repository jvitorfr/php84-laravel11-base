#!/bin/bash

chown -R joao:joao /etc/supervisor/conf.d/
chown joao:joao /etc/supervisor/supervisord.conf

exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
