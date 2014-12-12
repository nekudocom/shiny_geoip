<?php
namespace ShinyGeoip\Responder;

use ShinyGeoip\Core\Responder;

class ApiRequestResponder extends Responder
{
    public function short($record, $lang = '')
    {
        // @todo Short output with values corresponding to given language.
        print_r($record);
    }

    public function full($record)
    {
        // @todo Full output
        print_r($record);
    }

    public function notFound()
    {
        // @todo Not found output
        echo 'not found';
    }
}
