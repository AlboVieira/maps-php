<?php
require_once "../bootstrap.php";

$gmaps = new \Maps\GoogleMapsGeoCode();

echo $gmaps->geoCoordenates('Av. Brasil, 3014 - Rio de Janeiro, RJ');