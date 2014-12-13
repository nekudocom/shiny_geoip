<?php namespace ShinyGeoip\Action;

use ShinyGeoip\Core\Action;
use ShinyGeoip\Domain\CityDbDomain;
use ShinyGeoip\Domain\RecordDomain;
use ShinyGeoip\Responder\ShowHomepageResponder;

class ShowHomepageAction extends Action
{
    /**
     * Loads geoip-data for client ip and displays homepage.
     */
    public function __invoke()
    {
        $cityDbDomain = new CityDbDomain($this->app);
        $recordDomain = new RecordDomain($this->app);
        $record = $cityDbDomain->getRecord($_SERVER['REMOTE_ADDR']);
        $recordShort = $recordDomain->shortenRecord($record, $this->app->defaultLang);
        $responder = new ShowHomepageResponder;
        $responder->set('record', $recordShort);
        $responder->home();
    }
}
