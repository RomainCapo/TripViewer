<?php

class GoogleMapsApiHelper
{
  public static function getGPSCoord($destination)
  {
    $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='. $destination .'&key=AIzaSyARzT7-H1PY8YapJo-Os6iJE1AU7QWLb8s';
    $content = file_get_contents($url);

    $data = json_decode($content, false);

    var_dump($data);
  }

}
