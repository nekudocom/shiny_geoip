<?php
namespace Geoip\Responder;

use Geoip\Core\Responder;

class ShowHomepageResponder extends Responder
{
    public function home()
    {
        $this->display('home.html.php');
    }
}
