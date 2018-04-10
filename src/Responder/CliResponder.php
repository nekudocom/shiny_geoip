<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Responder;

class CliResponder
{
    /**
     * Sends a default message to stdout.
     *
     * @param string $message
     */
    public function out(string $message)
    {
        echo $message . PHP_EOL;
    }

    /**
     * Sends an error/red message to stdout.
     *
     * @param string $message
     */
    public function error(string $message)
    {
        echo "\033[0;31m".$message."\033[0m" . PHP_EOL;
    }

    /**
     * Sends an success/green message to stdout.
     *
     * @param string $message
     */
    public function success(string $message)
    {
        echo "\033[0;32m".$message."\033[0m" . PHP_EOL;
    }
}
