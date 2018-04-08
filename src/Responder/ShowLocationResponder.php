<?php

declare(strict_types=1);

namespace Nekudo\ShinyGeoip;

use Nekudo\ShinyGeoip\Responder\HttpResponder;

class ShowLocationResponder extends HttpResponder
{
    /**
     * Defines if we respond with json or javascript header.
     *
     * @var string $responseType
     */
    protected $responseType = 'json';

    /**
     * Holds the callback function name for JSONP responses.
     *
     * @var string $callback
     */
    protected $callback = '';

    /**
     * Sets callback function name for JSONP responses.
     *
     * @param string $callback
     */
    public function setCallback(string $callback)
    {
        $this->callback = $callback;
        $this->responseType = 'javascript';
    }

    /**
     * Sends json encoded record data to client.
     *
     * @param array $record
     */
    public function recordFound(array $record)
    {
        $payload = json_encode($record);
        $this->respondLocation($payload);
    }

    /**
     * Responds with error message if no record was found for requested IP.
     */
    public function recordNotFound()
    {
        $response = json_encode([
            'type' => 'error',
            'msg' => 'No record found.'
        ]);
        $this->respondLocation($response);
    }

    /**
     * Sets headers and sends response data to client.
     *
     * @param string $payload
     */
    protected function respondLocation(string $payload)
    {
        if ($this->responseType === 'javascript') {
            header('Content-Type: application/javascript', true);
        } else {
            header('Content-Type: application/json', true);
        }
        header('Access-Control-Allow-Origin: *', true);
        if (!empty($this->callback)) {
            $payload = $this->callback . '(' . $payload . ');';
        }
        $this->found($payload);
    }
}
