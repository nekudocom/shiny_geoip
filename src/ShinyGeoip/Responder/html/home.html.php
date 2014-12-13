<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>geoip.nekudo.com | Free IP to geolocation API</title>
    <link rel="stylesheet" href="/css/base.min.css">
    <link rel="stylesheet" href="/css/general.css">
</head>
<body>

<div class="container">
    <header>
        <div class="clear row">
            <h1>geoip.nekudo.com</h1>
            <h2 class="h4">Free IP to geolocation API.</h2>
        </div>
    </header>

    <div class="content">
        <div class="row clear">
            <div class="col col-7 tablet-col-7 mobile-col-1-2">
                <p>
                    <strong>geoip.nekudo.com</strong> provides a free and easy to use API to get geolocation data for
                    IP addresses.
                </p>
                <p>
                    The whole project is free and open-source. You can setup your own copy if you like.
                </p>
                <p>
                    <a href="https://github.com/nekudo/shiny_geoip" class="button grey-button">
                        ShinyGeoip at GitHub
                    </a>
                </p>
            </div>
            <div class="col col-4 tablet-col-4 mobile-col-1-2">

                <table>
                    <caption><h4>Your geolocation data</h4></caption>
                    <tbody>
                        <?php if (!empty($record['city'])): ?>
                            <tr>
                                <td><b>City</b></td>
                                <td><?php echo htmlspecialchars($record['city']); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($record['country'])): ?>
                            <tr>
                                <td><b>Country</b></td>
                                <td>
                                    <?php echo htmlspecialchars($record['country']['name']); ?>
                                    (<?php echo htmlspecialchars($record['country']['code']); ?>)
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php if (!empty($record['location'])): ?>
                            <tr>
                                <td><b>Latitute</b></td>
                                <td>
                                    <?php echo htmlspecialchars($record['location']['latitude']); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Longitude</b></td>
                                <td>
                                    <?php echo htmlspecialchars($record['location']['longitude']); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><b>Time zone</b></td>
                                <td>
                                    <?php echo htmlspecialchars($record['location']['time_zone']); ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row clear">
            <div class="col col-12 tablet-full mobile-full">
                <h2>The API</h2>
                <p>
                    All requests have to be HTTP GET requests. The response will be a JSON encoded string.
                    The API accepts requests in the following schema:
                </p>
                <pre>http://geoip.nekudo.com/api/{ip}/{language}/{type}</pre>
                <h4>Parameters</h4>
                <p>There are two parameters <em>type</em> and <em>language</em>. Both parameters are optional.</p>
                <p>
                    <strong>Type:</strong> Can be <em>short</em> or <em>full</em> and defines if the API returns
                    all available data (full) or just the most relevant data (short). Short is the default.
                </p>
                <p>
                    <strong>Language:</strong> The language can be a two character language code like <em>en</em> or
                    <em>de</em>. The response data will be in this language (if available). This parameter is only
                    reasonable in short mode as full mode contains all available languages.
                </p>

                <h4>Examples</h4>
                <pre>http://geoip.nekudo.com/api/8.8.8.8</pre>
                <pre>http://geoip.nekudo.com/api/8.8.8.8/full</pre>
                <pre>http://geoip.nekudo.com/api/87.79.99.25/de</pre>

                <h4>Limits</h4>
                <p>The API follows a fair use policy. There are no limits by default but if the service is abused
                your IP may get blocked. In case you need to do a massive amount of requests please contact us or
                setup your own copy of the ShinyGeoip API.</p>
            </div>
        </div>
    </div>

    <footer>
        <p class="text-center">
            This product includes GeoLite2 data created by MaxMind, available from
            <a href="http://www.maxmind.com">http://www.maxmind.com</a>.<br />
            This website is another shiny project of <a href="https://nekudo.com">nekudo.com</a>.
        </p>
    </footer>
</div>

</body>
</html>