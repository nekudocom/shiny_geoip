<?php namespace Nekudo\ShinyGeoip\Responder;

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
        require PROJECT_ROOT . '/src/Resonder/html/home.html.php';
        $payload = ob_get_clean();
        $this->found($payload);
    }
}
