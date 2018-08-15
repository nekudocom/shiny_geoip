ShinyGeoip
=====

This repository contains the sourcecode of [geoip.nekudo.com](http://geoip.nekudo.com). You can use it to setup
your own geolocation API. 

The API utilizes the [Maxmind GeoLite2 Database](http://dev.maxmind.com/geoip/geoip2/geolite2/).

## Documentation

### Requirements

* Webserver supporting URL rewrites (Apache, Nginx, lighttpd, ...)
* PHP >= 7.0
* MaxMind [DbReader PHP-Extension](https://github.com/maxmind/MaxMind-DB-Reader-php) (optional for better performance)


### Installation
To setup you own API follow these steps:

1. Download the latest release of this repository to your server.
2. Download a copy of the [GeoLite2 Database](http://dev.maxmind.com/geoip/geoip2/geolite2/) to the ```data``` folder.
3. Adjust the config file in `config/config.php` if necessary.
4. Point your webserver to the ```www``` folder.
5. Rewrite all requests to the index.php file (Using htaccess, nginx configuration, e.g.).

### Database Updates

ShinyGeoip includes a CLI application which can be used to update the mmdb-file. To use this updater
run the following command from the project root folder:

```php cli/app.php mmdb_update```

You can also run a simple benchmark with the following command:

```php cli/app.php benchmark```

## Frequently Asked Questions

### I am getting an wrong/empty result for my IP - can you update the database?

This project uses the GeoLite2 Database provided by Maxmind. If there is any error in this database you can [submit
corrections directly to Maxmind](https://support.maxmind.com/correction-faq/). This project however has no influence
on the information in this database.
