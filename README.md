ShinyGeoip
=====

ShinyGeoip is a simple HTTP API to request geolocation data for an IP addresses.
It uses the [Maxmind GeoLite2 Database](http://dev.maxmind.com/geoip/geoip2/geolite2/).

## Demo
A live version of the API can be found at: [geoip.nekudo.com](http://geoip.nekudo.com)
 
## Requirements
To run your own copy of ShinyGeoip all you'll need is a webserver that supports PHP and URL rewriting.

## Installation
To setup you own API follow the following steps:

1. Download/Clone this repository to your webserver.
2. Run ```composer install``` to install required dependencies. If composer is not yet installed on your server please
check [https://getcomposer.org/](getcomposer.org).
3. Download a copy of the [GeoLite2 Database](http://dev.maxmind.com/geoip/geoip2/geolite2/) to the ```data``` folder.
If you need to adjust this path you can do so in the ```www/index.php``` file.
4. Point your webserver to the ```www``` folder and rewrite all requests to the index.php file.

You should now have your own instance up and running.

### Optional steps

* Maxmind provides a [http://maxmind.github.io/GeoIP2-php/](PHP extension) which is a drop-in replacement for the
PHP based database reader. Using this extension brings an enormous performance boost and you should use this extension
whenever possible.
* You may want to adjust the homepage tempalate in ```src/Responder/html/home.html.php``` with your own domain
and texts.
