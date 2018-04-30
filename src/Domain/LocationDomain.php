<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Domain;

use MaxMind\Db\Reader;

class LocationDomain
{
    /**
     * @var Reader $reader
     */
    protected $reader;

    /**
     * Init the GeoLite database reader.
     *
     * @param array $config
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function __construct(array $config)
    {
        $this->reader = new Reader($config['mmdb_path']);
    }

    /**
     * Fetches location record for given IP.
     *
     * @param string $ip
     * @return array
     */
    public function getRecord(string $ip): array
    {
        try {
            $record = $this->reader->get($ip);
            if (empty($record)) {
                return [];
            }

            // attach IP to record (for compatibility to API v1):
            $record['traits']['ip_address'] = $ip;

            return $record;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Shortens a location record to the most relevant data.
     *
     * @param array $record
     * @param string $lang
     * @return array
     */
    public function shortenRecord(array $record, string $lang): array
    {
        $recordShort = [
            'city' => false,
            'country' => [],
            'location' => [],
            'ip' => $record['traits']['ip_address'],
        ];

        // expand some language keys to match keys in database:
        $lang = strtr($lang, ['pt' => 'pt-BR', 'zh' => 'zh-CN']);

        // add city data to short record if available:
        if (!empty($record['city'])) {
            $recordShort['city'] = (isset($record['city']['names'][$lang]))
                ? $record['city']['names'][$lang]
                : reset($record['city']['names']);
        }

        // add country data to short record if available:
        if (!empty($record['country'])) {
            $recordShort['country']['name'] = (isset($record['country']['names'][$lang]))
                ? $record['country']['names'][$lang]
                : reset($record['country']['names']);
            $recordShort['country']['code'] = $record['country']['iso_code'];
        } elseif (!empty($record['registered_country'])) {
            $recordShort['country']['name'] = (isset($record['registered_country']['names'][$lang]))
                ? $record['registered_country']['names'][$lang]
                : reset($record['registered_country']['names']);
            $recordShort['country']['code'] = $record['registered_country']['iso_code'];
        }

        // add location data to short record if available:
        if (!empty($record['location'])) {
            $recordShort['location'] = $record['location'];
            unset($recordShort['location']['metro_code']);
        }

        // convert empty arrays to objects for consistency:
        if (empty($recordShort['country'])) {
            $recordShort['country'] = (object) [];
        }
        if (empty($recordShort['location'])) {
            $recordShort['location'] = (object) [];
        }

        return $recordShort;
    }
}
