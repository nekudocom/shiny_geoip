<?php namespace ShinyGeoip\Domain;

use GeoIp2\Model\City;
use ShinyGeoip\Core\Domain;

class RecordDomain extends Domain
{
    /**
     * Reduces full record to most relevant data. Filters only given language.
     *
     * @param City $record
     * @param string $language
     * @return array
     */
    public function shortenRecord(City $record, $language)
    {
        $shortRecordData = [
            'city' => $this->getCityName($record, $language),
            'country' => $this->getCountryData($record, $language),
            'location' => $this->getLocation($record),
            'ip' => $this->getIp($record),
        ];
        return $shortRecordData;
    }

    /**
     * Fetches city name in given language of passed record.
     *
     * @param City $record
     * @param string $language
     * @return bool|string City name if found or false otherwise.
     */
    public function getCityName(City $record, $language)
    {
        if (empty($record->city->names)) {
            return false;
        }
        return $this->getLangValue($record->city->names, $language);
    }

    /**
     * Fetches country data in given language of passed record.
     *
     * @param City $record
     * @param string $language
     * @return bool|string Country data if found or false otherwise.
     */
    public function getCountryData(City $record, $language)
    {
        if (empty($record->country->names)) {
            return false;
        }
        $countryData = [
            'name' => $this->getLangValue($record->country->names, $language),
            'code' => $record->country->isoCode,
        ];
        return $countryData;
    }

    /**
     * Fetches location data of passed record.
     *
     * @param City $record
     * @return array|bool
     */
    public function getLocation(City $record)
    {
        if (empty($record->location)) {
            return false;
        }
        return [
            'latitude' => $record->location->latitude,
            'longitude' => $record->location->longitude,
            'time_zone' => $record->location->timeZone,
        ];
    }

    /**
     * Returns IP address of passed record.
     *
     * @param City $record
     * @return bool|null
     */
    public function getIp(City $record)
    {
        if (empty($record->traits)) {
            return false;
        }
        return $record->traits->ipAddress;
    }

    /**
     * Fetches value in given language from array containing results.
     * Returns first value from array if language key not found.
     *
     * @param array $values
     * @param string $language
     * @return bool|mixed
     */
    private function getLangValue(array $values, $language)
    {
        if (empty($values)) {
            return false;
        }
        if (!empty($values[$language])) {
            return $values[$language];
        }
        return reset($values);
    }
}
