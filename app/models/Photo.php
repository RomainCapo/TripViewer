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

  //@summary retourne toutes les voyages de la base de données
  //@summary retourne les noms de chaque fichier photo lié à un voyage
  //@return noms des fichiers photo
  public static function getURLUpload($id_trip)
  {
    $statement = App::get('dbh')->prepare('SELECT file_name FROM photo WHERE id_trip = :id_trip');
    $statement->bindParam(':id_trip', $id_trip);
    $statement->execute();

    return $statement->fetchAll();
  }

  public function save()
  {
    $statement = App::get('dbh')->prepare('INSERT INTO photo(file_name, id_trip) VALUES (?, ?)');
    $statement->bindValue(1, $this->file_name);
    $statement->bindValue(2, $this->id_trip);
    $statement->execute();
  }
}
