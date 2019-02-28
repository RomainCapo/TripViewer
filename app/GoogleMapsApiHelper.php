<?php

ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');

class GoogleMapsApiHelper
{
  public static function getGPSCoord($destination)
  {
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='. $destination .'&key=' . App::get('config')['google_map_api_key'];
    $content = file_get_contents($url);

    $data = json_decode($content, false);

    $latitude = $data->results[0]->geometry->location->lat;
    $longitude = $data->results[0]->geometry->location->lng;
    $countryName = getCountryName($data);

    echo $latitude . ' - ' . $longitude . ' - ' . $countryName;
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
  echo $country;
  }
}
