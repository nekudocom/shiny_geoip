<?php
namespace ShinyGeoip\Responder;

use ShinyGeoip\Core\Responder;

class ApiRequestResponder extends Responder
{
    /**
     * Echos short version of record as json encodes string.
     */
    public function short()
    {
        $this->setContentTypeHeader('json');
        $record = $this->get('record');
        echo json_encode($record);
    }

    /**
     * Echos the full record as json encoded string.
     */
    public function full()
    {
        $this->setContentTypeHeader('json');
        $record = $this->get('record')->jsonSerialize();
        echo json_encode($record);
    }

    /**
     * Echos a json encoded not found error message.
     */
    public function notFound()
    {
        $this->setContentTypeHeader('json');
        echo json_encode(['type' => 'error', 'msg' => 'No record found.']);
    }
}
