<?php

/**
 * La classe Destination hérite de Model. Cette classe a pour but de stocker diverses informations en lien avec les destinations et de fournir diverses méthodes utiles.
 */
class Destination extends Model
{


  /**
  * Variable qui stocke l'id
  * @var int
  */
  private $id;


  /**
  * Variable qui stocke la destination
  * @var float
  */
  private $destination;

  /**
  * Variable qui stocke la latitude
  * @var float
  */
  private $latitude;

  /**
  * Variable qui stocke la longitude
  * @var float
  */
  private $longitude;

  /**
  * Variable qui stocke le pays
  * @var string
  */
  private $country;


  /**
  * Fonction qui modifie la valeur de l'attribut destination
  *
  * @param string $dest, c'est un string qui contient la nouvelle valeur qui sera affectée à l'attribut
  *
  * @return void
  */
  public function setDestination($dest)
  {
    $this->destination = $dest;
  }

  /**
  * Fonction qui modifie la valeur de l'attribut latitude
  *
  * @param string $lat, c'est un string qui contient la nouvelle valeur qui sera affectée à l'attribut
  *
  * @return void
  */
  public function setLatitude($lat)
  {
    $this->latitude= $lat;
  }

  /**
  * Fonction qui modifie la valeur de l'attribut longitude
  *
  * @param string $lng, c'est un string qui contient la nouvelle valeur qui sera affectée à l'attribut
  *
  * @return void
  */
  public function setLongitude($lng)
  {
    $this->longitude= $lng;
  }

  /**
  * Fonction qui modifie la valeur de l'attribut country
  *
  * @param string $cou, c'est un string qui contient la nouvelle valeur qui sera affectée à l'attribut
  *
  * @return void
  */
  public function setCountry($cou)
  {
    $this->country= $cou;
  }

  /**
  * Fonction qui indique la présence ou non de la destination dans la bdd
  *
  * @param string $dest : nom de la destination
  *
  * @return boolean : présence ou non de la destination dans la bdd
  */
  public static function destinationInDb($dest)
  {
    $statement = App::get('dbh')->prepare('SELECT id FROM destination WHERE LOWER(destination)=:destination');
    $dest = mb_strtolower($dest, 'UTF-8');
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

  /**
  * Fonction qui retourne toutes les destintions de la base de données
  *
  * @return Destination : objet contenant les informations d'une destination
  */
  public static function fetchAllDestinations()
  {
    return parent::fetchAll('destination', 'Destination');
  }

  /**
  * Fonction qui retourne l'id, la latitude, la longitude et le pays pour une destination donné
  *
  * @param string $dest : nom de la destination
  *
  * @return false : si destination pas dans la base de données
  * @return array : retourne un tableau associatif contenant l'id, la latitude, la longitude et le pays pour une destination donné
  */
  public static function getLatLngCouFromDest($dest)
  {
    $statement = App::get('dbh')->prepare('SELECT id, latitude, longitude, country FROM destination WHERE LOWER(destination)=:destination');
    $dest = mb_strtolower($dest, 'UTF-8');
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

  /**
  * Fonction qui retourne un tableau d'informations (destination, latitude, longitude et pays) selon un id
  *
  * @param int $id : id d'une destination dans la base de données
  *
  * @return array : retourne un tableau associatif contenant la destination, la latitude, la longitude et le pays pour un id donné
  */
  public static function getDestInfo($id)
  {
    $statement = App::get('dbh')->prepare('SELECT destination, latitude, longitude, country FROM destination WHERE id=:id');
    $statement->bindParam(':id', $id);
    $statement->execute();

    $array = array();
    $data = $statement->fetchAll()[0];

    $array['dest'] = htmlentities(Helper::mb_ucfirst($data['destination'], 'UTF-8'));
    $array['lat'] = htmlentities($data['latitude']);
    $array['lng'] = htmlentities($data['longitude']);
    $array['coun'] = htmlentities($data['country']);

    return $array;
  }

  /**
  * Fonction qui retourne la destination a partir d'un id
  *
  * @param int $id : id de la destination
  *
  * @return int : id de la destination
  */
  public static function getDestinationById($id)
  {
      $statement = App::get('dbh')->prepare('SELECT destination FROM destination WHERE id = ?');
      $statement->bindValue(1, $id);
      $statement->execute();
      $res = $statement->fetchAll();
      return $res[0]['destination'];
  }

  /**
  * Fonction qui sauve la destination dans la base de données
  *
  * @return void
  */
  public function save()
  {
    $statement = App::get('dbh')->prepare('INSERT INTO destination (destination, latitude, longitude, country) VALUES (?, ?, ?, ?)');
    $statement->bindParam(1, $this->destination);
    $statement->bindParam(2, $this->latitude);
    $statement->bindParam(3, $this->longitude);
    $statement->bindParam(4, $this->country);

    $statement->execute();
  }

  /**
  * Fonction qui permet de sauver une destination en indiquant le nom et les informations sur la destination, s'occupe automatiquement d'appeler la méthode save() de la classe
  *
  * @param string $destName : nom de la destination
  * @param string $arrayDest : tableau associatif contenant les information d'un destination(latitude, longitude, country)
  *
  * @return int : retourne l'id de la destination ajouté dans la base de données
  */
  public static function saveDestination($destName, $arrayDest)
  {
    $dest = new Destination;
    $dest->setDestination(mb_strtolower($destName, 'UTF-8'));
    $dest->setLatitude($arrayDest['latitude']);
    $dest->setLongitude($arrayDest['longitude']);
    $dest->setCountry($arrayDest['country']);
    $dest->save();

    return App::get('dbh')->lastInsertId(); //recupére l'id de la dernière destination ajoutée
  }
}
