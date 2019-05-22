<?php

class Transport extends Model
{
  //attributs
  private $id;
  private $name;

  //@summary retourne toutes les transports de la base de données
  //@return Transport : objet contenant les transports
  public static function fetchAllTransports()
  {
    return parent::fetchAll('transport', 'Transport');
  }

  public static function getTransportById($id)
  {
    $statement = App::get('dbh')->prepare("select transport from transport where id=:id");
    $statement->bindValue(':id', $id);
    $statement->execute();
    return $statement->fetchAll()[0]['transport'];
  }

  private static function getIdFromTransportName($transports, $name)
  {
    $id = -1;
    foreach ($transports as $key => $value)
    {
      if($value[0] == $name)
      {
        $id = $key;
      }
    }
    return $id;
  }

  //@summary retourne tous les moyens de transport disponible dans un élément checkbox html, cette méthode permet de génerer la liste déroulante qui est affiché dans la vue
  //@return string : retourne l'html de la liste déroulante sous forme de string
  public static function fetchAllTransportsName($id = -1)
  {
    $statement = App::get('dbh')->prepare("select transport from transport");
    $statement->execute();
    $transports = $statement->fetchAll();

    if(is_string($id))
    {
      $id = Transport::getIdFromTransportName($transports, $id);
    }

    echo $id;

    $string = '';
    foreach ($transports as $key => $value)
    {
      if($id == -1 || $id != $key)
      {
        $string.= "<option value='". htmlentities($value[0]) ."'>" . htmlentities($value[0]) . '</option>' . PHP_EOL;
      }
      else
      {
        $string.= "<option value='". htmlentities($value[0]) ."' selected>" . htmlentities($value[0]) . '</option>' . PHP_EOL;
      }
    }
    return $string;
  }

  //@summary indique si le transport passé en parametre exsiste
  //@param string $transport : nom du moyen de transport
  //@return boolean : indique si le transport est dans la base de donnée ou non
  public static function transportInDb($transport)
  {
    $statement = App::get('dbh')->prepare("select * from transport where transport=:transport");
    $statement->bindParam(':transport', $transport);
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

  //@summary retourne l'id du transport passé en paramétre
  //@param string $transport : nom du moyen de transport
  //@return int : retourne l'id du moyen de transport
  public static function getTransportId($transport)
  {
    $statement = App::get('dbh')->prepare("select id from transport where transport=:transport");
    $statement->bindParam(':transport', $transport);
    $statement->execute();

    return $statement->fetchAll()[0]['id'];
  }

  //Pour l'insatnt nous n'avons pas besoin d'enregistrer des transports dans la base de données mais nous sommes
  //obligé de réimplémenter la méthode
  public function save()
  {

  }
}
