<?php
namespace ShinyGeoip\Responder;

use ShinyGeoip\Core\Responder;

class ApiRequestResponder extends Responder
{
    /**
     * Echos short version of record as json or jsonp string.
     */
    public function short()
    {
        $callback = $this->app->request->get('callback', '');
        $record = $this->get('record');
        $record = json_encode($record);
        if (!empty($callback)) {
            $this->setContentTypeHeader('javascript');
            $record = $callback . '(' . $record . ');';
        } else {
            $this->setContentTypeHeader('json');
        }
        $this->setContent($record);
    }

    /**
     * Echos the full record as json or jsonp string.
     */
    public function full()
    {
        $callback = $this->app->request->get('callback', '');
        $record = $this->get('record')->jsonSerialize();
        $record = json_encode($record);
        if (!empty($callback)) {
            $this->setContentTypeHeader('javascript');
            $record = $callback . '(' . $record . ');';
        } else {
            $this->setContentTypeHeader('json');
        }
        $this->setContent($record);
    }

    /**
     * Echos a json encoded not found error message.
     */
    public function notFound()
    {
        $callback = $this->app->request->get('callback', '');
        $response = json_encode(['type' => 'error', 'msg' => 'No record found.']);
        if (!empty($callback)) {
            $this->setContentTypeHeader('javascript');
            $response = $callback . '(' . $response . ');';
        } else {
            $this->setContentTypeHeader('json');
        }
        $this->setContent($response);
    }
}
