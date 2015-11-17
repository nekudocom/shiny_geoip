<?php namespace ShinyGeoip\Core;

use Slim\Slim;
use Slim\View;

class Responder extends View
{
    /**
     * @var Slim $app
     */
    protected $app;

    public function __construct(Slim $app)
    {
        parent::__construct();
        $this->app = $app;
        $this->setTemplatesDirectory(__DIR__ . '/../Responder/html');
    }

    public function render($template, $data = null)
    {
        $templatePathname = $this->getTemplatePathname($template);
        if (!is_file($templatePathname)) {
            throw new \RuntimeException("View cannot render `$template` because the template does not exist");
        }
        $data = array_merge($this->data->all(), (array) $data);
        extract($data);
        ob_start();
        require $templatePathname;
        return ob_get_clean();
    }

    /**
     * Sets header according to given output format.
     *
     * @param string $type
     */
    public function setContentTypeHeader($type)
    {

        switch($type) {
            case 'json':
                $this->app->response->headers->set('Content-Type', 'application/json');
                break;
            case 'javascript':
                $this->app->response->headers->set('Content-Type', 'application/javascript');
                break;
            default:
                // default is html..
                break;
        }
        $this->app->response->headers->set('Access-Control-Allow-Origin', '*');
    }

    /**
     * Sets response body.
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->app->response->setBody($content);
    }
}
