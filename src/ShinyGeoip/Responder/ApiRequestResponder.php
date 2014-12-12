<?php
namespace ShinyGeoip\Responder;

use GeoIp2\Model\City;
use ShinyGeoip\Core\Responder;

class ApiRequestResponder extends Responder
{
    public function short($record, $lang = '')
    {
        // @todo Short output with values corresponding to given language.
        echo "<pre>";
        print_r($record);
    }

    /**
     * Echos the full record as json encoded string.
     *
     * @param City $record
     */
    public function full(City $record)
    {
        $this->setContentTypeHeader('json');
        $record->jsonSerialize();
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
