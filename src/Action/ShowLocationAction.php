<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Action;

use Nekudo\ShinyGeoip\Domain\LocationDomain;
use Nekudo\ShinyGeoip\ShowLocationResponder;

class ShowLocationAction
{
    /**
     * @var array $config
     */
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Sends location data for requested IP to client.
     *
     * @param array $arguments
     * @return bool
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function __invoke(array $arguments): bool
    {
        $domain = new LocationDomain($this->config);
        $responder = new ShowLocationResponder;

        // fetch record for requested ip (use client ip if no ip provided):
        $userIp = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $userIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        $ip = (!empty($arguments['ip'])) ? $arguments['ip'] : $userIp;
        $record = $domain->getRecord($ip);

        // set requested callback method for JSONP responses:
        if (!empty($arguments['callback'])) {
            $responder->setCallback($arguments['callback']);
        }

        // if no record was found we respond with an error message:
        if (empty($record)) {
            $responder->recordNotFound();
            return false;
        }

        // add data from geonames database in "full" mode:
        if ($arguments['type'] === 'full') {
            $record = $domain->addGeonamesData($record);
        }

        // shorten the record data to save traffic:
        if ($arguments['type'] === 'short') {
            $record = $domain->shortenRecord($record, $arguments['lang']);
        }

        // send record data to client:
        $responder->recordFound($record);
        return true;
    }
}
