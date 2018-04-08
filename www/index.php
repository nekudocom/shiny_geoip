<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';
$shinyGeoip = new \Nekudo\ShinyGeoip\ShinyGeoip($config);
$shinyGeoip->dispatch();
