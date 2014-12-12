<?php namespace ShinyGeoip\Domain;

use ShinyGeoip\Core\Domain;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class CityDbDomain extends Domain
{
    /**
     * Queries city-db with given ip.
     *
     * @param string $ip
     * @return bool|\GeoIp2\Model\City
     */
    public function getRecord($ip)
    {
        $reader = new Reader($this->app->pathCityDb);
        try {
            $record = $reader->city($ip);
        } catch (AddressNotFoundException $e) {
            return false;
        }
        return $record;
    }
}
