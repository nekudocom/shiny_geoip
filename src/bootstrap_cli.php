<?php

declare(strict_types=1);

// include default bootstrap
include __DIR__ . '/bootstrap.php';

// include CLI specific files:
require_once __DIR__ . '/ShinyGeoipCli.php';
require_once __DIR__ . '/Action/Cli/CliAction.php';
require_once __DIR__ . '/Action/Cli/BenchmarkAction.php';
require_once __DIR__ . '/Action/Cli/ShowHelpAction.php';
require_once __DIR__ . '/Action/Cli/UpdateMmdbAction.php';
require_once __DIR__ . '/Responder/CliResponder.php';
