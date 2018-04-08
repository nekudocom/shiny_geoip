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

    /** @var array $config */
    protected $config;

    /**
     * Init the GeoLite database reader.
     *
     * @param array $config
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $pathToMaxmindDb = $config['mmdb_path'];
        $this->reader = new Reader($pathToMaxmindDb);
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

    /**
     * Adds data from geonames database to the record.
     *
     * @param array $record
     * @return array
     */
    public function addGeonamesData(array $record): array
    {
        if (!isset($record['city'])) {
            return $record;
        }
        if (!isset($record['city']['geoname_id'])) {
            return $record;
        }

        $geonameId = (int) $record['city']['geoname_id'];
        $geonamesRecord = $this->getGeonamesRecord($geonameId);
        if (empty($geonamesRecord)) {
            return $record;
        }

        $record['geonames'] = $geonamesRecord;

        return $record;
    }

    /**
     * Fetches a record from the geonames datanase.
     *
     * @param int $geonameId
     * @return array
     */
    private function getGeonamesRecord(int $geonameId): array
    {
        if ($this->redisAvailable() === false) {
            return [];
        }

        try {
            $redis = $this->getRedisClient();
            $geonameKey = (string)$geonameId;
            $record = $redis->get($geonameKey);
            if (empty($record)) {
                return [];
            }
        } catch (\RedisException $e) {
            return [];
        }

        $values = json_decode($record, true);
        if (empty($values)) {
            return [];
        }

        $keys = [
            'geonameid',
            'name',
            'asciiname',
            'alternatenames',
            'latitude',
            'longitude',
            'feature_class',
            'feature_code',
            'country_code',
            'cc2',
            'admin1_code',
            'admin2_code',
            'admin3_code',
            'admin4_code',
            'population',
            'elevation',
            'dem',
            'timezone',
            'modification_date',
        ];

        return array_combine($keys, $values);
    }

    /**
     * Check is redis extension is installed.
     *
     * @return bool
     */
    private function redisAvailable(): bool
    {
        if ($this->config['redis_enabled'] === false) {
            return false;
        }
        return class_exists('Redis');
    }

    /**
     * Creates redis client ready to use.
     *
     * @return \Redis
     */
    private function getRedisClient(): \Redis
    {
        $redis = new \Redis;
        switch ($this->config['redis_connection_type']) {
            case 'socket':
                $redis->connect($this->config['redis_socket']);
                break;
            case 'tcp':
                $redis->connect($this->config['redis_host'], $this->config['redis_port']);
                break;
            default:
                throw new \RuntimeException('Invalid redis configuration.');
        }
        $redis->select($this->config['redis_db']);

        return $redis;
    }
}
