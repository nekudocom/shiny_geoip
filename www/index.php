<?php
require_once __DIR__ . '/../src/bootstrap.php';
$shinyGeoip = new \Nekudo\ShinyGeoip\ShinyGeoip;
$shinyGeoip->dispatch();
