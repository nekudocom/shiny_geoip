<?php
require_once '../vendor/autoload.php';

$app = new \Slim\Slim;

// Set path to GeoLite city database:
$app->pathCityDb = __DIR__ . '/../data/GeoLite2-City.mmdb';

// Routing
$app->get(
    '/',
    function () use ($app) {
        $showHomepageAction = new \ShinyGeoip\Action\ShowHomepageAction($app);
        $showHomepageAction->__invoke();
    }
);
$app->run();
