<?php namespace ShinyGeoip\Action;

use ShinyGeoip\Core\Action;
use ShinyGeoip\Responder\ShowHomepageResponder;
use GeoIp2\Database\Reader;

class ShowHomepageAction extends Action
{
    /**
     * Loads geoip-data for client ip and displays homepage.
     */
    public function __invoke()
    {
        $reader = new Reader($this->app->pathCityDb);
        $record = $reader->city('87.79.99.25');
        $responder = new ShowHomepageResponder;
        $responder->set('record', $record);
        $responder->home();
    }
}
