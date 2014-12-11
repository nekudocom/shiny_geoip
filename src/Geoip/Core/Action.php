<?php namespace Geoip\Core;

use Slim\Slim;

class Action
{
    protected $app;

    public function __construct(Slim $app)
    {
        $this->app = $app;
    }
}
