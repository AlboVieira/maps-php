<?php


namespace Maps\App;

use GuzzleHttp\Client;
use Maps\App\Config\Config;

class GoogleMaps
{

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function loadUrl($url){
        $response = $this->client->get($url);

        if($response->getStatusCode() != 200){
            throw new \Exception('Bad Request');
        }
        return json_decode($response->getBody()->getContents());
    }

    public function geoCoordenates($adress){

        $config = Config::all();

        //&components=country:ES
        //?address=Torun&components=administrative_area:TX|country:US&
        $url = $config['url']  . urlencode($adress) . "&key={$config['key']}";

        try{
            $results = $this->loadUrl($url)->results;
            var_dump($results);die;
            $coordenates = $results['geometry'];
            var_dump($coordenates);die;

            list($statusResponse, $zoom, $latitude, $longitude) = explode(',', $data);

            return [
                'lat' => $latitude,
                'long' => $longitude,
                'zomm' => $zoom,
                'address' => $adress
            ];

        }catch (\Exception $e){

        }
    }

    public static function addFilterCountry(){

    }

    public static function addFilterRegion(){

    }

    public static function addFilterAdministrateArea(){

    }

}