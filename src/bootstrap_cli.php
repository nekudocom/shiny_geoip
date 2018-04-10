<?php

declare(strict_types=1);

// include default bootstrap
include __DIR__ . '/bootstrap.php';

// include CLI specific files:
require_once __DIR__ . '/ShinyGeoipCli.php';
require_once __DIR__ . '/Responder/CliResponder.php';
