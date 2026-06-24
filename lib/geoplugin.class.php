<?php

class geoPlugin
{
    var $host = 'http://www.geoplugin.net/php.gp?ip={IP}&base_currency={CURRENCY}&lang={LANG}';
    var $currency = 'USD';
    var $lang = 'en';

    var $ip = null;
    var $city = '';
    var $region = '';
    var $regionCode = '';
    var $regionName = '';
    var $dmaCode = '';
    var $countryCode = '';
    var $countryName = '';
    var $inEU = '';
    var $euVATrate = false;
    var $continentCode = '';
    var $continentName = '';
    var $latitude = '';
    var $longitude = '';
    var $locationAccuracyRadius = '';
    var $timezone = '';
    var $currencyCode = '';
    var $currencySymbol = '';
    var $currencyConverter = null;

    function __construct() {}

    function locate($ip = null)
    {
        global $_SERVER;

        if (is_null($ip)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $host = str_replace('{IP}', $ip, $this->host);
        $host = str_replace('{CURRENCY}', $this->currency, $host);
        $host = str_replace('{LANG}', $this->lang, $host);

        $response = $this->fetch($host);

        // --- SUPPRESS native warnings from unserialize (invalid data) ---
        $data = @unserialize($response);

        if (!is_array($data)) {
            error_log("geoPlugin Error: Invalid response (unserialize failed). Raw: " . substr($response, 0, 500));
            return; // keeps default empty values, NO warnings on screen
        }

        // --- Safe null coalescing (no undefined index warnings) ---
        $this->ip = $ip;
        $this->city = $data['geoplugin_city'] ?? '';
        $this->region = $data['geoplugin_region'] ?? '';
        $this->regionCode = $data['geoplugin_regionCode'] ?? '';
        $this->regionName = $data['geoplugin_regionName'] ?? '';
        $this->dmaCode = $data['geoplugin_dmaCode'] ?? '';
        $this->countryCode = $data['geoplugin_countryCode'] ?? '';
        $this->countryName = $data['geoplugin_countryName'] ?? '';
        $this->inEU = $data['geoplugin_inEU'] ?? '';
        $this->continentCode = $data['geoplugin_continentCode'] ?? '';
        $this->continentName = $data['geoplugin_continentName'] ?? '';
        $this->latitude = $data['geoplugin_latitude'] ?? '';
        $this->longitude = $data['geoplugin_longitude'] ?? '';
        $this->locationAccuracyRadius = $data['geoplugin_locationAccuracyRadius'] ?? '';
        $this->timezone = $data['geoplugin_timezone'] ?? '';
        $this->currencyCode = $data['geoplugin_currencyCode'] ?? '';
        $this->currencySymbol = $data['geoplugin_currencySymbol'] ?? '';
        $this->currencyConverter = $data['geoplugin_currencyConverter'] ?? null;

        error_log("geoPlugin locate() success for IP: $ip, Country: " . $this->countryName);
    }

    function fetch($host)
    {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $host);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'geoPlugin PHP Class v1.1');
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $curl_errno = curl_errno($ch);
            $curl_error = curl_error($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($curl_errno) {
                error_log("geoPlugin cURL error ($curl_errno): $curl_error");
                return false;
            }
            if ($http_code >= 400) {
                error_log("geoPlugin HTTP error: $http_code for URL $host");
                return false;
            }
            if (empty($response)) {
                error_log("geoPlugin Warning: Empty response from API");
                return false;
            }
            return $response;
        }

        if (ini_get('allow_url_fopen')) {
            $response = @file_get_contents($host);
            if ($response === false) {
                error_log("geoPlugin fopen() error: Unable to fetch $host");
                return false;
            }
            return $response;
        }

        // --- Instead of fatal trigger_error, just log it and return false ---
        error_log('geoPlugin Error: Cannot retrieve data. Enable cURL or set allow_url_fopen=On in php.ini');
        return false;
    }

    function convert($amount, $float = 2, $symbol = true)
    {
        if (!is_numeric($this->currencyConverter) || $this->currencyConverter == 0) {
            error_log('geoPlugin Notice: currencyConverter has no value.');
            return $amount;
        }
        if (!is_numeric($amount)) {
            error_log('geoPlugin Warning: The amount passed to geoPlugin::convert is not numeric.');
            return $amount;
        }
        if ($symbol === true) {
            return $this->currencySymbol . round(($amount * $this->currencyConverter), $float);
        } else {
            return round(($amount * $this->currencyConverter), $float);
        }
    }

    function nearby($radius = 10, $limit = null)
    {
        if (!is_numeric($this->latitude) || !is_numeric($this->longitude)) {
            error_log('geoPlugin Notice: Incorrect latitude or longitude values.');
            return array(array());
        }

        $host = "http://www.geoplugin.net/extras/nearby.gp?lat=" . $this->latitude . "&long=" . $this->longitude . "&radius={$radius}";
        if (is_numeric($limit)) {
            $host .= "&limit={$limit}";
        }

        $response = $this->fetch($host);
        $data = @unserialize($response);
        if (!is_array($data)) {
            error_log("geoPlugin nearby() error: Invalid response.");
            return array(array());
        }
        return $data;
    }
}
?>