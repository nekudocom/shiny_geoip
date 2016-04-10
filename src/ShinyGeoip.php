<?php
/**
 * ShinyGeoip
 *
 * by Simon Samtleben <simon@nekudo.com>
 *
 * A IP to location HTTP REST API.
 * For more information visit: https://github.com/nekudo/shiny_geoip
 */

namespace Nekudo\ShinyGeoip;

use Nekudo\ShinyGeoip\Action\ShowHomepageAction;
use Nekudo\ShinyGeoip\Action\ShowLocationAction;
use Nekudo\ShinyGeoip\Responder\HttpResponder;

class ShinyGeoip
{
    /**
     * Holds current route name.
     *
     * @var string $route
     */
    protected $route = '';

    /**
     * Holds request arguments.
     *
     * @var array $arguments
     */
    protected $arguments = [
        'ip' => '',
        'type' => 'short',
        'lang' => 'en',
        'callback' => '',
    ];

    /**
     * Routes the request and executes corresponding action.
     */
    public function dispatch()
    {
        $this->route();
        switch ($this->route) {
            case 'api':
                $action = new ShowLocationAction;
                $action->__invoke($this->arguments);
                break;
            case 'home':
                $action = new ShowHomepageAction;
                $action->__invoke();
                break;
            default:
                $responder = new HttpResponder;
                $responder->notFound(':( Page not found.');
                break;
        }
    }

    /**
     * Sets route depending on request path.
     *
     * @return bool
     */
    protected function route()
    {
        $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ($urlPath === false) {
            return false;
        }
        if ($urlPath === '/') {
            $this->route = 'home';
            return true;
        }
        if (substr($urlPath, 0, 4) === '/api') {
            $this->route = 'api';
            $this->parseArgumentsFromRequest($urlPath);
            return true;
        }
        return false;
    }

    /**
     * Collects known arguments out of request uri.
     *
     * @param string $urlPath
     */
    protected function parseArgumentsFromRequest($urlPath)
    {
        $pathParts = explode('/', $urlPath);
        foreach ($pathParts as $part) {
            if ($part === '' || $part === 'api') {
                continue;
            }
            // check for type:
            if ($part === 'full' || $part === 'short') {
                $this->arguments['type'] = $part;
                continue;
            }
            // check for ip:
            if (preg_match('/^[0-9a-f.:]{6,45}$/', $part) === 1) {
                $this->arguments['ip'] = $part;
                continue;
            }
            // check for language:
            if (preg_match('/^[a-z]{2}$/', $part) === 1) {
                $this->arguments['lang'] = $part;
                continue;
            }
        }

        // check for callback:
        if (isset($_GET['callback']) && !empty($_GET['callback'])) {
            $this->arguments['callback'] = $_GET['callback'];
        }
    }
}
