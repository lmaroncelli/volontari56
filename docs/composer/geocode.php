<?php 

use Spatie\Geocoder\Geocoder;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'vendor/autoload.php';


$client = new GuzzleHttp\Client();

$geocoder = new Geocoder($client);


$geocoder->setApiKey('AIzaSyCAyCUJ63a6dtvWfdAaqCmLxrWqOombjM8');
$geocoder->setLanguage('it');
$geocoder->setRegion('it');



$var = $geocoder->getAddressForCoordinates($_POST['lat'], $_POST['long']);


dump($var);
die();




 ?>