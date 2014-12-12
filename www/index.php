<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

$app = new \Slim\Slim;

// Set path to GeoLite city database:
$app->pathCityDb = __DIR__ . '/../data/GeoLite2-City.mmdb';

// Home route
$app->get(
    '/',
    function () use ($app) {
        $showHomepageAction = new \ShinyGeoip\Action\ShowHomepageAction($app);
        $showHomepageAction->__invoke();
    }
);

// API route
$app->get(
    '/api/:ip(/:options+)',
    function ($ip, $options = []) use ($app) {
        $apiRequestAction = new \ShinyGeoip\Action\ApiRequestAction($app);
        $apiRequestAction->__invoke($ip, $options);
    }
)->conditions(
    [
        'ip' => '[0-9a-f.:]{6,45}',
    ]
);

// let's roll
$app->run();
