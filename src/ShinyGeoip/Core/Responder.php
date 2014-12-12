<?php namespace ShinyGeoip\Core;

use Slim\View;

class Responder extends View
{
    public function __construct()
    {
        parent::__construct();
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
                header('Content-Type: application/json', true);
                break;
            default:
                // default is html..
                break;
        }
    }
}
