<?php

ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');

class GoogleMapsApiHelper
{
  //@summary permet d'obtenir les coordonnées GPS d'une destination via Google Maps Api
  //@param $destination : nom de la destination
  //@return array : contenant l'etat du status de la requete :
  //ERROR -> pour une erreur, IN_DATABASE -> pour indiquer que la destination est deja dans la bdd, OK -> pour indiquer que tout c'est passé comme prvevu
  //et si le status est OK le tableau contient les informations de géolocalisation comme la latitude, longitude et le pays
  public static function getGPSCoord($destination)
  {
    //on teste si la destination est deja dans la base de données pour ne pas surcharger les requtes sur l'api
    if(!Destination::destinationInDb($destination))
    {
      try
      {
        //url pour la requete a l'api on remplace avec la destination passé en parametre et la clé API
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='. str_replace(' ','', $destination ) .'&key=' . App::get('config')['google_map_api_key'];
        $content = file_get_contents($url);

        $data = json_decode($content, false);//on décode le flux json

        if($data->status == 'OK')
        {
          //on récupére la latitude et la longitude
          $latitude = $data->results[0]->geometry->location->lat;
          $longitude = $data->results[0]->geometry->location->lng;
          $countryName = GoogleMapsApiHelper::getCountryName($data);//on recupère le pays de la destination

          return array('latitude' =>  $latitude, 'longitude' => $longitude, 'country' => $countryName, 'state' => 'OK');
        }
        else
        {// si le status est pas ok on renvoie une erreur
            return array('state' => 'ERROR');
        }
      }
      catch (Exception $e)
      {//si il y a une erreur lors de la connexion a l'API
          return array('state' => 'ERROR');
      }
    }
    else
    {//si la destination est deja dans la BDD
      $reponse = Destination::getLatLngCouFromDest($destination);//on recupère les informations de la destination

      //si pour la destination passé en parametre il y une erreur on enevoie le status ERROR sinon on envoie le tableau avec les informations
      if($reponse)
      {
        $reponse['state'] = 'IN_DATABASE';
        return $reponse;
      }
      else
      {
        $reponse['state'] = 'ERROR';
        return $reponse;
      }
    }
  }

  //@summary permet de récupérer le nom du pays a partir du résultat de la requete a l'API Google Maps
  //@param $data : le résultat de la requete a l'api sous format json
  //@return string : renvoie le pays de la destination
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
