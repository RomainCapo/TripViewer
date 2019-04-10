<?php

class Destination extends Model
{
  //Attributs
  private $id;
  private $latitude;
  private $longitude;
  private $country;


  //Setter
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

  //@summary indique la présence ou non de la destination dans la bdd
  //@param string $dest : nom de la destination
  //@return boolean : présence ou non de la destination dans la bdd
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

  //@summary retourne toutes les destintions de la base de données
  //@return Destination : objet contenant les informations d'une destination
  public static function fetchAllDestinations()
  {
    return parent::fetchAll('destination', 'Destination');
  }

  //@summary retourne l'id, la latitude, la longitude et le pays pour une destination donné
  //@param string $dest : nom de la destination
  //@return false : si destination pas dans la base de données
  //@return array : retourne un tableau associatif contenant l'id, la latitude, la longitude et le pays pour une destination donné
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

    $array['dest'] = htmlentities(ucfirst($data['destination']));
    $array['lat'] = htmlentities($data['latitude']);
    $array['lng'] = htmlentities($data['longitude']);
    $array['coun'] = htmlentities($data['country']);

    return $array;
  }

  //@summary retourne la destination a partir d'un id
  //@param $id : id de la destination
  //@return int : id de la destination
  public static function getDestinationById($id)
  {
      $statement = App::get('dbh')->prepare('SELECT destination FROM destination WHERE id = ?');
      $statement->bindValue(1, $id);
      $statement->execute();
      $res = $statement->fetchAll();
      return $res[0]['destination'];
  }

  //@summary sauve la destination dans la base de données
  public function save()
  {
    $statement = App::get('dbh')->prepare('INSERT INTO destination (destination, latitude, longitude, country) VALUES (?, ?, ?, ?)');
    $statement->bindParam(1, $this->destination);
    $statement->bindParam(2, $this->latitude);
    $statement->bindParam(3, $this->longitude);
    $statement->bindParam(4, $this->country);

    $statement->execute();
  }

  //@summary permet de sauver une destination en indiquant le nom et les informations sur la destination, s'occupe automatiquement d'appeler la méthode save() de la classe
  //@param string $destName : nom de la destination
  //@param string $arrayDest : tableau associatif contenant les information d'un destination(latitude, longitude, country)
  //@return int : retourne l'id de la destination ajouté dans la base de données
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
