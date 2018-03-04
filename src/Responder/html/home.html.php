<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Free GeoIP/Geolocation REST API. An open-source project by nekudo.com.">
    <title>Free IP GeoLocation/GeoIp API - geoip.nekudo.com</title>
    <link rel="canonical" href="http://geoip.nekudo.com">
    <link rel="stylesheet" href="/css/base.css">
</head>
<body>

<div class="container">

    <header>
        <h1>Free IP GeoLocation/GeoIp API</h1>
        <p class="h2">A free REST API to get location information for IP addresses.</p>
    </header>


    <div class="clearfix">
        <div class="left">
            <p>
                This project is open source. Setup your own instance if you like.
            </p>
            <p>
                <a href="https://github.com/nekudo/shiny_geoip" class="btn">
                    Sourcecode at GitHub
                </a>
            </p>
        </div>

        <div class="right">
            <table class="bordered">
                <caption align="bottom">Location data for your current IP address</caption>
                <tbody>
                    <?php if (!empty($record['city'])): ?>
                        <tr>
                            <td>City</td>
                            <td><?php echo htmlspecialchars($record['city']); ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if (!empty($record['country'])): ?>
                        <tr>
                            <td>Country</td>
                            <td>
                                <?php echo htmlspecialchars($record['country']['name']); ?>
                                (<?php echo htmlspecialchars($record['country']['code']); ?>)
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if (!empty($record['location'])): ?>
                        <tr>
                            <td>Latitute</td>
                            <td>
                                <?php echo htmlspecialchars($record['location']['latitude']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Longitude</td>
                            <td>
                                <?php echo htmlspecialchars($record['location']['longitude']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Time zone</td>
                            <td>
                                <?php echo htmlspecialchars($record['location']['time_zone']); ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if (empty($record)): ?>
                        <tr><td><em>No record found.</em></td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

    <div class="mt-60">
        <h3>API Documentation</h3>

        <h4>Requests</h4>
        <p>
            All requests have to be HTTP GET requests in the following schema:
        </p>
        <pre>http://geoip.nekudo.com/api/{ip}/{language}/{type}</pre>

        <h4>Parameters</h4>
        <table>
            <tbody>
            <tr>
                <td class="param-name">ip</td>
                <td class="param-required">optional</td>
                <td>Valid IP address in IPv4 or IPv6 format.</td>
            </tr>
            <tr>
                <td class="param-name">language</td>
                <td class="param-required">optional</td>
                <td>Two character language code like <em>en</em> or <em>de</em>.</td>
            </tr>
            <tr>
                <td class="param-name">type</td>
                <td class="param-required">optional</td>
                <td>
                    Possible values are <em>short</em> to get a response conataining only most relevant data or
                    <em>full</em> to get a response containing all available data.
                </td>
            </tr>
            </tbody>
        </table>

        <h4>Responses</h4>
        <p class="textblock">
            By default all responses are JSON encoded strings.<br />
            It is also possible to get JSONP responses for direct usage in javascripts. To get a JSONP response
            a callback function has to be provided within the request using the <em>?callback=</em> parameter.
        </p>

        <h4>Examples</h4>
        <pre>http://geoip.nekudo.com/api/8.8.8.8</pre>
        <pre>http://geoip.nekudo.com/api/2a00:a200:0:f::888</pre>
        <pre>http://geoip.nekudo.com/api/8.8.8.8/full</pre>
        <pre>http://geoip.nekudo.com/api/87.79.99.25/de</pre>
        <pre>
&lt;script&gt;
function foo(data) {
    document.write(&quot;City: &quot;, data.city);
    document.write(&quot;Country: &quot;, data.country.name);
    document.write(&quot;Latitude: &quot;, data.location.latitude);
    document.write(&quot;Longitude: &quot;, data.location.longitude);
}
&lt;/script&gt;
&lt;script src=&quot;http://geoip.nekudo.com/api?callback=foo&quot;&gt;&lt;/script&gt;</pre>

        <h4>SSL</h4>
        <p class="textblock">This service is also available via <a href="https://geoip.nekudo.com">https</a>.</p>

        <h4>Limits</h4>
        <p class="textblock">The API follows a fair use policy. There are no limits by default but if the service is abused
        your IP may get blocked.</p>

        <h4>Support/Donate</h4>
        <p class="textblock">
            This API is totally free, however there are a few expenses to run the servers. In case you like this project
            and use it regularly please consider
            <a href="https://paypal.me/simonsamtleben">donating a small amount using PayPal.</a>
        </p>
    </div>

    <footer>
        <p>
            <small>
                This product includes GeoLite2 data created by MaxMind, available from
                <a href="http://www.maxmind.com">http://www.maxmind.com</a>.<br />
                This website is another shiny project by <a href="https://nekudo.com">nekudo.com</a>.
            </small>
        </p>
    </footer>

</div>


</body>
</html>