<?php
namespace ShinyGeoip\Responder;

use ShinyGeoip\Core\Responder;

class ApiRequestResponder extends Responder
{
    /**
     * Respond with short version of location record.
     */
    public function short()
    {
        $record = $this->get('record');
        $this->setResponse($record);
    }

    /**
     * Respond with full version of location record.
     */
    public function full()
    {
        $record = $this->get('record')->jsonSerialize();
        $this->setResponse($record);
    }

    /**
     * Respond with a not found message.
     */
    public function notFound()
    {
        $response = ['type' => 'error', 'msg' => 'No record found.'];
        $this->setResponse($response);
    }

    /**
     * Sets response-body depending on request as json or jsonp string and sets matching http header.
     *
     * @param array $response
     */
    protected function setResponse(array $response)
    {
        $callback = $this->app->request->get('callback', '');
        $response = json_encode($response);
        if (!empty($callback)) {
            $this->setContentTypeHeader('javascript');
            $response = $callback . '(' . $response . ');';
        } else {
            $this->setContentTypeHeader('json');
        }
        $this->setContent($response);
    }
}
