<?php
namespace ShinyGeoip\Core;

use Slim\Slim;

class Domain
{
    /**
     * @var Slim $app
     */
    protected $app;

    /**
     * Injects slim object into domains.
     *
     * @param Slim $app
     */
    public function __construct(Slim $app)
    {
        $this->app = $app;
    }
}
