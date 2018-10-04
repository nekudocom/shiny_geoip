![nekudo ipapi](https://github.com/nekudocom/shiny_geoip/blob/master/warning-ipapi.jpg?raw=true)

# ShinyGeoip / geoip.nekudo.com API - Good News

*[The current API available at geoip.nekudo.com is now deprecated and will be discontinued on Nov 5th, 2018]*

We are happy to announce that after months of preparation and development, the Open-Source Project ShinyGeoip, or better known as GeoIP Nekudo, is turning into a fully-fledged IP Geolocation API platform capable of offering more than 45 data points for each processed IP address, including Time Zone data, Currency data, Language data, Connection data and Risk Assessment data. API responses are delivered within only a few milliseconds, an Uptime Service-Level Agreement has been established and more than 10 Customer Service and Tech Support members will be ready to help.  

## geoip.nekudo.com becomes ipapi.com

In the process of rebuilding the entire API from scratch we've also decided to give the new product a new name that reflects in the best way possible the simplicity and power of our new brand: **[ipapi.com](https://ipapi.com)**. 

## Required Changes to Legacy Integrations (freegeoip.net/json/xml) 

As of November 5th 2018 the API available at geoip.nekudo.com will be discontinued. To keep using our new, still free IP to location API you will be required to follow 2 simple steps: 

1. Register for a free ipapi API Key

The new ipapi.com platform offers a generous Free Plan, for which you can sign up here: https://ipapi.com/product. This Plan comes with a free amount of API requests that can be made each month, without an expiration date, and will remain free forever. 

2. Integrate the new ipapi request URL

Almost done! As the next step, you will need to make a few adjustments to your current implementation to point to the new ipapi API URL. It should take less than 10 minutes to make this change and the only difference to your current implementation is the requirement to add your new API Key to your request URL and parse the new API response JSON or XML structure.

The easiest way to learn more is signing up and taking a look at our [3-Step Quickstart Guide](https://ipapi.com/quickstart). To go into more detail and learn about all new features, you can also head over to our complete [API Documentation](https://ipapi.com/documentation). 

## New features with ipapi
To name just a few features that come with the new ipapi product: 

- Advanced IP Data
- Faster Response Times
- Bulk IP Requests
- Security & Fraud Prevention 
- ASN & ISP Lookup
- Language Detection
- Currency Detection
- Timezone Detection

## Next Steps

- Deprecation of old API on Nov 5th, 2018

It is our top priority to prevent service disruption for current users of the GeoIP Nekudo API, which is why we've decided to allow a period of 30 days before officially discontinuing all deprecated API endpoints. To make sure you're on the safe side and your implementation remains up and running, please *sign up for a free ipapi API Key* as soon as possible.

- Any Questions? Please get in touch!

If you have questions or feedback of any sort, please do not hesitate to send us an email at support@ipapi.com. 

## Open-Source

Please stand by for our brand-new nekudo Open-Source Project, which will accommodate all existing Open-Source users. More information will be available on December 1st, 2018. 





ShinyGeoip - Deprecated Documentation
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
