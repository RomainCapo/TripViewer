<?php

class Photo extends Model
{
  private $id;
  private $file_name;
  private $id_trip;

  public function setFileName($fileName)
  {
    $this->file_name = $fileName;
  }

  public function setIdTrip($idTrip)
  {
    $this->id_trip = $idTrip;
  }

  public function save()
  {
    $statement = App::get('dbh')->prepare('INSERT INTO trip(file_name, id_trip) VALUES (:file_name, :id_trip)');
    $statement->bindValue(':file_name', $this->file_name);
    $statement->bindValue(':id_trip', $this->id_trip);
    $statement->execute();
  }
}
