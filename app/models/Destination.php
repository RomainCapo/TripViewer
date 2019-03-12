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
    $dest = strtolower($dest);
    $statement->bindParam(':destination', $dest);
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
    $statement = App::get('dbh')->prepare('SELECT id, latitude, longitude, country FROM destination WHERE LOWER(destination)=:destination');
    $dest = strtolower($dest);
    $statement->bindParam(':destination', $dest);
    $statement->execute();

    $data = $statement->fetchAll();

    if(!empty($data))
    {
      $id = $data[0]['id'];
      $lat = $data[0]['latitude'];
      $lng = $data[0]['longitude'];
      $cou = $data[0]['country'];

      return array('latitude' => $lat, 'longitude' => $lng, 'country' => $cou, 'id' =>$id);
    }
    else
    {
      return false;
    }
  }

  public static function getDestInfo($id)
  {
    $statement = App::get('dbh')->prepare('SELECT destination, latitude, longitude, country FROM destination WHERE id=:id');
    $statement->bindParam(':id', $id);
    $statement->execute();

    $array = array();
    $data = $statement->fetchAll()[0];

    $array['dest'] = ucfirst($data['destination']);
    $array['lat'] = $data['latitude'];
    $array['lng'] = $data['longitude'];
    $array['coun'] = $data['country'];

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
