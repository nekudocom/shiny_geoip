<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Action;

use Nekudo\ShinyGeoip\Domain\LocationDomain;
use Nekudo\ShinyGeoip\Responder\ShowHomepageResponder;

class ShowHomepageAction
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
     * Shows homepage.
     *
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public function __invoke()
    {
        // fetch location record for users ip to display on homepage:
        $domain = new LocationDomain($this->config);
        $userIp = $_SERVER['REMOTE_ADDR'];
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $userIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        $record = $domain->getRecord($userIp);
        if (!empty($record)) {
            $record = $domain->shortenRecord($record, 'en');
        }

        // send response to browser:
        $responder = new ShowHomepageResponder;
        $responder->showHomepage($record);
    }
}
