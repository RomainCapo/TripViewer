<?php

class Destination extends Model
{
  //Attributes
  private $id;
  private $latitude;
  private $longitude;
  private $country;


  public function setDestination($dest)
  {
    $this->destination = $dest;
  }

  public function setLatitude($lat)
  {
    $this->latitude= $lat;
  }

  public function setLongitude($lng)
  {
    $this->longitude= $lng;
  }

  public function setCountry($cou)
  {
    $this->country= $cou;
  }

  public static function destinationInDb($dest)
  {
    $statement = App::get('dbh')->prepare('SELECT id FROM destination WHERE LOWER(destination)=:destination');
    $statement->bindParam(':destination', strtolower($dest));
    $statement->execute();

    if(empty($statement->fetchAll()))
    {
      return false;
    }
    else
    {
      return true;
    }
  }

  public static function fetchAllDestinations()
  {
    return parent::fetchAll('destination', 'Destination');
  }

  public static function getLatLngCouFromDest($dest)
  {
    $statement = App::get('dbh')->prepare('SELECT latitude, longitude, country FROM destination WHERE destination=:destination');
    $statement->bindParam(':destination', $dest);
    $statement->execute();

    $data = $statement->fetchAll()[0];

    $lat = $data['latitude'];
    $lng = $data['longitude'];
    $cou = $data['country'];

    $array = array('latitude' => $lat, 'longitude' => $lng, 'country' => $cou);

    return $array;
  }

  public function save()
  {
    $statement = App::get('dbh')->prepare('INSERT INTO destination (destination, latitude, longitude, country) VALUES (?, ?, ?, ?)');
    $statement->bindParam(1, $this->destination);
    $statement->bindParam(2, $this->latitude);
    $statement->bindParam(3, $this->longitude);
    $statement->bindParam(4, $this->country);

    $statement->execute();
  }

  public static function saveDestination($destName, $arrayDest)
  {
    $dest = new Destination;
    $dest->setDestination(strtolower($destName));
    $dest->setLatitude($arrayDest['latitude']);
    $dest->setLongitude($arrayDest['longitude']);
    $dest->setCountry($arrayDest['country']);
    $dest->save();

    return App::get('dbh')->lastInsertId(); //recupére l'id de la dernière destination ajoutée
  }
}
