<?php
namespace Nekudo\ShinyGeoip\Responder;

class HttpResponder
{
    /**
     * @var int $statusCode
     */
    protected $statusCode = 200;

    /**
     * @var string $payload The payload to be send to the client.
     */
    protected $payload = '';

    /**
     * @var array $statusMessages List of supported status codes/messages.
     */
    protected $statusMessages = [
        200 => 'OK',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
    ];

    /**
     * Responds with a 200 OK header.
     *
     * @param string $payload
     */
    public function found($payload = '')
    {
        $this->payload = $payload;
        $this->statusCode = 200;
        $this->respond();
    }

    /**
     * Responds with a 404 not found header.
     *
     * @param string $payload
     */
    public function notFound($payload = '')
    {
        $this->payload = $payload;
        $this->statusCode = 404;
        $this->respond();
    }

    /**
     * Responds with a 405 method not allowed header.
     *
     * @param string $payload
     */
    public function methodNotAllowed($payload = '')
    {
        $this->payload = $payload;
        $this->statusCode = 405;
        $this->respond();
    }

    /**
     * Responds with a 500 internal server error header.
     *
     * @param string $payload
     */
    public function error($payload = '')
    {
        $this->payload = $payload;
        $this->statusCode = 500;
        $this->respond();
    }

    /**
     * Echos out the response header and content.
     */
    protected function respond()
    {
        $statusMessage = $this->statusMessages[$this->statusCode];
        $header = sprintf('HTTP/1.1 %d %s', $this->statusCode, $statusMessage);
        header($header);
        if (!empty($this->payload)) {
            echo $this->payload;
        }
    }
}
