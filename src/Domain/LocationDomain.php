<?php namespace Nekudo\ShinyGeoip\Domain;

use MaxMind\Db\Reader;

class LocationDomain
{
    /**
     * @var string $pathToLocationDb
     */
    protected $pathToLocationDb;
	  protected $pathToASNDb;

    /**
     * @var Reader $reader
     */
    protected $locreader;
	  protected $asnreader;

    /**
     * Init the GeoLite database reader.
     */
    public function __construct()
    {
        $this->pathToLocationDb = PROJECT_ROOT . 'data/GeoLite2-City.mmdb';
        $this->locreader = new Reader($this->pathToLocationDb);

		    $this->pathToASNDb = PROJECT_ROOT . 'data/GeoLite2-ASN.mmdb';
        $this->asnreader = new Reader($this->pathToASNDb);
    }

    /**
     * Fetches location record and ASN data for given IP.
     *
     * @param string $ip
     * @return array
     */
    public function getRecord($ip)
    {
        try {
            $recordloc = $this->locreader->get($ip);
            if (empty($recordloc)) {
                return [];
            }

            // attach IP to record (for compatibility to API v1):
            $recordloc['traits']['ip_address'] = $ip;

            //return $recordloc; HANDLED LATER
        } catch (\Exception $e) {
            return [];
        }

		    try {
            $recordasn = $this->asnreader->get($ip);
            if (empty($recordasn)) {
                return [];
            }

            //return $recordasn; HANDLED LATER
        } catch (\Exception $e) {
            return [];
        }

		    if($recordloc && $recordasn){
			    $record = array_merge($recordloc,$recordasn);
          return $record;
		    }
    }

    /**
     * Shortens a location record to the most relevant data.
     *
     * @param array $record
     * @param string $lang
     * @return array
     */
    public function shortenRecord(array $record, $lang)
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
        }

        // add location data to short record if available:
        if (!empty($record['location'])) {
            $recordShort['location'] = $record['location'];
            unset($recordShort['location']['metro_code']);
        }

        return $recordShort;
    }
}
