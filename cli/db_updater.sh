#!/bin/bash

cd /var/www/geoip.nekudo.com/data
wget http://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz || { echo 'Could not download GeoLiteCity, exiting.' ; exit 1; }
gunzip -f GeoLite2-City.mmdb.gz