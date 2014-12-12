<?php namespace ShinyGeoip\Action;

use ShinyGeoip\Core\Action;
use ShinyGeoip\Domain\ApiOptionsDomain;
use ShinyGeoip\Domain\CityDbDomain;
use ShinyGeoip\Responder\ApiRequestResponder;

class ApiRequestAction extends Action
{
    /**
     * Queries database for given ip and returns result as json encoded string.
     *
     * @param string $ip
     * @param array $optionsInput
     * @return bool
     */
    public function __invoke($ip, $optionsInput = [])
    {
        // get record from city-db:
        $cityDbDomain = new CityDbDomain($this->app);
        $record = $cityDbDomain->getRecord($ip);

        // prepare api options from request:
        $apiOptionsDomain = new ApiOptionsDomain($this->app);
        $options = $apiOptionsDomain->parseOptions($optionsInput);

        // handle response:
        $apiRequestResponder = new ApiRequestResponder;
        if (empty($record)) {
            $apiRequestResponder->notFound();
            return false;
        }
        if ($options['type'] === 'full') {
            $apiRequestResponder->full($record);
        } else {
            $apiRequestResponder->short($record, $options['lang']);
        }
        return true;
    }
}
