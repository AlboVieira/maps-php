<?php


namespace Maps\App;

use GuzzleHttp\Client;
use Maps\App\Config\Config;

class GoogleMaps
{

    private $client;
    private $config;

    public function __construct()
    {
        $this->client = new Client();
        $this->config = Config::all();
    }

    public function loadUrl($url){
        $result = '';

        return $result;
    }

    public function geoLocal($adress){

        $url = 'http://'. $this->config['url'] .'/maps/geo?output=csv&key='.
            $this->config['key'] .'&q='. urlencode($adress);

        $data = $this->loadUrl($url);
        list($statusResponse, $zoom, $latitude, $longitude) = explode(',', $data);

        if($statusResponse != 200){

        }
        return [
            'lat' => $latitude,
            'long' => $longitude,
            'zomm' => $zoom,
            'address' => $adress
        ];

    }

}