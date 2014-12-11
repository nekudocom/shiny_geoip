<?php
namespace ShinyGeoip\Responder;

use ShinyGeoip\Core\Responder;

class ShowHomepageResponder extends Responder
{
    /**
     * Displays homepage.
     */
    public function home()
    {
        $this->display('home.html.php');
    }
}
