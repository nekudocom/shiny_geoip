ShinyGeoip
=====

This API contains the sourcecode of the [geoip.nekudo.com](http://geoip.nekudo.com) website. It is an HTTP API to
request location data for IP addresses. Responses can be in JSON or JSONP format.
The API is based on the [Maxmind GeoLite2 Database](http://dev.maxmind.com/geoip/geoip2/geolite2/).

## Demo/Examples
The live version of this API can be found at: [geoip.nekudo.com](http://geoip.nekudo.com)
Here you will also find example requests.
 
## Requirements
To run your own instance of ShinyGeoip all you'll need is a webserver that supports PHP and URL rewriting.

## Installation
To setup you own API follow the following steps:

1. Download/Clone this repository to your webserver.
2. Download a copy of the [GeoLite2 Database](http://dev.maxmind.com/geoip/geoip2/geolite2/) to the ```data``` folder.
3. Point your webserver to the ```www``` folder and rewrite all requests to the index.php file.

You should now have your own instance up and running.

### Optional steps

* Maxmind provides a [PHP extension](http://maxmind.github.io/GeoIP2-php/) which is a drop-in replacement for the
PHP based database reader. Using this extension brings an enormous performance boost and you should use this extension
whenever possible.

## Frequently Asked Questions

### I am getting an wrong/empty result for my IP - can you update the database?

This project uses the GeoLite2 Database provided by Maxmind. If there is any error in this database you can [submit
corrections directly to Maxmind](https://support.maxmind.com/correction-faq/). This project however has no influence
on the information in this database.