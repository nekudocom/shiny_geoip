<?php
require_once '../vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$app = new \Slim\Slim;
$app->pathCityDb = __DIR__ . '/../data/GeoLite2-City.mmdb';
$app->get(
    '/',
    function () use ($app) {
        $showHomepageAction = new \Geoip\Action\ShowHomepageAction($app);
        $showHomepageAction->__invoke();
    }
);
$app->run();
