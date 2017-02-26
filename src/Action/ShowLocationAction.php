<?php
namespace Nekudo\ShinyGeoip\Action;

use MaxMind\Db\Reader;
use Nekudo\ShinyGeoip\Domain\LocationDomain;
use Nekudo\ShinyGeoip\ShowLocationResponder;

class ShowLocationAction
{
    /**
     * Sends location data for requested IP to client.
     *
     * @param array $arguments
     * @return bool
     */
    public function __invoke(array $arguments)
    {
        $domain = new LocationDomain;
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

        // shorten the record data to save traffic:
        if ($arguments['type'] === 'short') {
            $record = $domain->shortenRecord($record, $arguments['lang']);
        }

        // send record data to client:
        $responder->recordFound($record);
        return true;
    }
}
