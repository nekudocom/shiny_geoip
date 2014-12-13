<?php namespace ShinyGeoip\Domain;

use ShinyGeoip\Core\Domain;

class ApiOptionsDomain extends Domain
{
    /**
     * Checks options input for valid lang-code and type.
     * Sets default if no values found in input.
     *
     * @param array $optionsInput
     * @return array
     */
    public function parseOptions($optionsInput)
    {
        $options = [];
        $options['type'] = (in_array('full', $optionsInput)) ? 'full' : 'short';
        $options['lang'] = $this->app->defaultLang;
        foreach ($optionsInput as $possibleLang) {
            if (preg_match('/[a-z]{2}/', $possibleLang) === 1) {
                $options['lang'] = $possibleLang;
                break;
            }
        }
        return $options;
    }
}
