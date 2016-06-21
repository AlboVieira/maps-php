<?php

/**
 * Created by PhpStorm.
 * User: albo-vieira
 * Date: 21/06/16
 * Time: 16:27
 */

namespace Maps\App\Config;

class Config
{
    public static function all(){

        return [
            'url' => 'https://maps.googleapis.com/maps/api/geocode/json?address=',
            'key' => 'AIzaSyASlWsBkfJ8sX_uPQbAnYGlq32-uztwCbU',
        ];

    }
}