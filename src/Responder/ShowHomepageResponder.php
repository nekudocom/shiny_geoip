<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip\Responder;

class ShowHomepageResponder extends HttpResponder
{
    /**
     * Shows homepage including location data for clients IP.
     *
     * @param array $record
     */
    public function showHomepage(array $record)
    {
        ob_start();
        require PROJECT_ROOT . '/src/Responder/html/home.html.php';
        $payload = ob_get_clean();
        $this->found($payload);
    }
}
