<?php

require_once __DIR__ . '/../src/bootstrap_cli.php';

$app = new \Nekudo\ShinyGeoip\ShinyGeoipCli($config);
$app->dispatch($argv);
