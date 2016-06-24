<?php


namespace Maps\App;

use GuzzleHttp\Client;
use Maps\App\Config\Config;

class GoogleMapsGeoCode
{

    private $client;

    const ZERO_RESULTS = 'ZERO_RESULTS';
    const OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
    const REQUEST_DENIED = 'REQUEST_DENIED';
    const INVALID_REQUEST = 'INVALID_REQUEST';
    const UNKNOWN_ERROR = 'UNKNOWN_ERROR';

    /**
     * GoogleMaps constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Return the coordenates( lat and long) from  a valid address
     *
     * @param $adress
     * @return string
     */
    public function geoCoordenates($adress){

        $config = Config::all();

        $url = $config['url']
            . urlencode($adress)
            . "&key={$config['key']}";

        try{
            $results = $this->loadUrl($url)->results;

            $count = count($results);
            if($count > 1){
                throw new \Exception('More than one register found for the address given, be more specific');
            }

            $geometry = reset($results)->geometry;
            $location = $geometry->location;

            $data =  [
                'address' => $adress,
                'lat' => $location->lat,
                'long' => $location->lng
            ];

            return json_encode($data);

        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Get data from Google's server
     *
     * @param $url
     * @return array
     * @throws \Exception
     */
    private function loadUrl($url){

        $response = $this->client->get($url);

        if($response->getStatusCode() != 200){
            throw new \Exception('Bad Request');
        }

        $result = json_decode($response->getBody()->getContents());

        switch($result->status){
            case self::ZERO_RESULTS :
                throw new \Exception('No address found');
                break;
            case self::OVER_QUERY_LIMIT :
                throw new \Exception('Limit exceeded');
                break;
            case self::REQUEST_DENIED :
                throw new \Exception('Request Denied');
                break;
            case self::INVALID_REQUEST :
                throw new \Exception('Invalid Request');
                break;
            case self::UNKNOWN_ERROR :
                throw new \Exception('Something wrong on Google\'s  Server');
                break;
        }

        return $result;
    }

}