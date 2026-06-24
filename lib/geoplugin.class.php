<?php

class geoPlugin
{
    // The geoPlugin server URL
    var $host = 'http://www.geoplugin.net/php.gp?ip={IP}&base_currency={CURRENCY}&lang={LANG}';

    // Default base currency
    var $currency = 'USD';

    // Default language
    var $lang = 'en';
    /*
    supported languages:
    de, en, es, fr, ja, pt-BR, ru, zh-CN
    */

    // geoPlugin properties (set safe defaults)
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

    function __construct()
    {
        // Enable logging (optional, but useful for debugging)
        error_log("geoPlugin class initialized.");
    }

    function locate($ip = null)
    {
        global $_SERVER;

        if (is_null($ip)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        // Build the request URL
        $host = str_replace('{IP}', $ip, $this->host);
        $host = str_replace('{CURRENCY}', $this->currency, $host);
        $host = str_replace('{LANG}', $this->lang, $host);

        // Fetch the response
        $response = $this->fetch($host);

        // Attempt to unserialize the response
        $data = unserialize($response);

        // --- FIX: Check if unserialize succeeded -------------------------
        if (!is_array($data)) {
            error_log("geoPlugin Error: Invalid response from API (unserialize failed). Response was: " . substr($response, 0, 500));
            // Show a simple error on screen (if running in web context)
            if (php_sapi_name() !== 'cli') {
                echo "<pre>geoPlugin API error: Could not retrieve location data. Check logs for details.</pre>";
            }
            // Keep default empty values – no warnings will be triggered
            return;
        }

        // --- FIX: Use null coalescing to avoid undefined index warnings ---
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

        error_log("geoPlugin locate() successful for IP: $ip, Country: " . $this->countryName);
    }

    function fetch($host)
    {
        // --- Try cURL first ---------------------------------------------
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $host);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'geoPlugin PHP Class v1.1');
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);          // 10 seconds timeout
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // not needed for HTTP but safe

            $response = curl_exec($ch);
            $curl_errno = curl_errno($ch);
            $curl_error = curl_error($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // --- Log any cURL or HTTP errors ----------------------------
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

        // --- Fallback to fopen() if allow_url_fopen is enabled ----------
        if (ini_get('allow_url_fopen')) {
            $response = @file_get_contents($host);
            if ($response === false) {
                error_log("geoPlugin fopen() error: Unable to fetch $host");
                return false;
            }
            return $response;
        }

        // --- Neither method is available --------------------------------
        trigger_error(
            'geoPlugin class Error: Cannot retrieve data. Enable cURL or set allow_url_fopen=On in php.ini',
            E_USER_ERROR
        );
        return false;
    }

    function convert($amount, $float = 2, $symbol = true)
    {
        if (!is_numeric($this->currencyConverter) || $this->currencyConverter == 0) {
            trigger_error('geoPlugin class Notice: currencyConverter has no value.', E_USER_NOTICE);
            return $amount;
        }
        if (!is_numeric($amount)) {
            trigger_error('geoPlugin class Warning: The amount passed to geoPlugin::convert is not numeric.', E_USER_WARNING);
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
            trigger_error('geoPlugin class Warning: Incorrect latitude or longitude values.', E_USER_NOTICE);
            return array(array());
        }

        $host = "http://www.geoplugin.net/extras/nearby.gp?lat=" . $this->latitude . "&long=" . $this->longitude . "&radius={$radius}";
        if (is_numeric($limit)) {
            $host .= "&limit={$limit}";
        }

        $response = $this->fetch($host);
        $data = unserialize($response);
        if (!is_array($data)) {
            error_log("geoPlugin nearby() error: Invalid response.");
            return array(array());
        }
        return $data;
    }
}
?>