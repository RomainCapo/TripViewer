<?php

class Destination extends Model
{
  //Attributes
  private $id;
  private $destination;
  private $latitude;
  private $longitude;
  private $country;


  public function setDestination($des)
  {
    $this->destination = $dest;
  }

  public function setLatitude($lat)
  {
    $this->latitude= $lat;
  }

  public function setLongitude($lon)
  {
    $this->longitude= $lon;
  }

  public function setCountry($cou)
  {
    $this->country= $cou;
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
}
