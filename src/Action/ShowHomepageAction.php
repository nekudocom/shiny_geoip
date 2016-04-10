<?php
namespace Nekudo\ShinyGeoip\Action;

use Nekudo\ShinyGeoip\Domain\LocationDomain;
use Nekudo\ShinyGeoip\Responder\ShowHomepageResponder;

class ShowHomepageAction
{
    /**
     * Shows homepage.
     */
    public function __invoke()
    {
        // fetch location record for users ip to display on homepage:
        $domain = new LocationDomain;
        $record = $domain->getRecord($_SERVER['REMOTE_ADDR']);
        if (!empty($record)) {
            $record = $domain->shortenRecord($record, 'en');
        }

        // send response to browser:
        $responder = new ShowHomepageResponder;
        $responder->showHomepage($record);
    }
}
