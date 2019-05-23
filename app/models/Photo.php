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
    $statement = App::get('dbh')->prepare('INSERT INTO photo(file_name, id_trip) VALUES (?, ?)');
    $statement->bindValue(1, $this->file_name);
    $statement->bindValue(2, $this->id_trip);
    $statement->execute();
  }
}
