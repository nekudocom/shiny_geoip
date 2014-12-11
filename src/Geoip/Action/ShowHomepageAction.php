<?php namespace Geoip\Action;

use Geoip\Core\Action;
use Geoip\Responder\ShowHomepageResponder;
use GeoIp2\Database\Reader;

class ShowHomepageAction extends Action
{
    public function __invoke()
    {
        $reader = new Reader($this->app->pathCityDb);
        $record = $reader->city($_SERVER['REMOTE_ADDR']);
        echo "<pre>";
        print_r($record);
        echo "</pre>";


        $responder = new ShowHomepageResponder;
        $responder->set('foo', 'bar');
        $responder->home();
    }
}
