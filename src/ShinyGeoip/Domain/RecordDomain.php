<?php namespace ShinyGeoip\Domain;

use GeoIp2\Model\City;
use ShinyGeoip\Core\Domain;

class RecordDomain extends Domain
{
    /**
     * Reduces full record to most relevant data. Filters only given language.
     *
     * @todo Implement shortening.
     * @todo Implement language filtering.
     *
     * @param City $record
     * @param string $language
     * @return array
     */
    public function shortenRecord(City $record, $language)
    {
        return $record->jsonSerialize();
    }
}
