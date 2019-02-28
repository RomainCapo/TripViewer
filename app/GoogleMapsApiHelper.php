<?php

ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');

class GoogleMapsApiHelper
{

  public static function getGPSCoord($destination)
  {
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='. str_replace(' ','', $destination ) .'&key=' . App::get('config')['google_map_api_key'];
    $content = file_get_contents($url);

    $data = json_decode($content, false);


    $latitude = $data->results[0]->geometry->location->lat;
    $longitude = $data->results[0]->geometry->location->lng;
    $countryName = GoogleMapsApiHelper::getCountryName($data);

    return array('latitude' =>  $latitude, 'longitude' => $longitude, 'country' => $countryName);
  }

  public static function getCountryName($data)
  {
    $country = 'NULL';

    foreach($data->results[0]->address_components as $key => $value)
    {
      if($value->types[0] == "country")
      {
          $country = $value->long_name;
      }
    }
    return $country;
    }

    //function de https://stackoverflow.com/questions/365826/calculate-distance-between-2-gps-coordinates
    public static function getDistBetweenTwoGPSPoint($lat1, $lng1, $lat2, $lng2)
    {
      $earth_rad = 6371;

      $d_lat = GoogleMapsApiHelper::degToRad($lat2 - $lat1);
      $d_lng = GoogleMapsApiHelper::degToRad($lng2 - $lng1);

      $lat1 = GoogleMapsApiHelper::degToRad($lat1);
      $lat2 = GoogleMapsApiHelper::degToRad($lat2);

      $a = sin($d_lat/2) * sin($d_lat/2) + sin($d_lng/2) * sin($d_lng/2) * cos($lat1) * cos($lat2);
      $c = 2 * atan2(sqrt($a), sqrt(1-$a));

      return $earth_rad * $c;
    }

    private static function degToRad($deg)
    {
      return $deg * pi() / 180;
    }
}
