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

  //@summary retourne le nom du transport par rapport a son id
  //@param integer : id du transport
  //@return string : retourne le transport
  public static function getTransportById($id)
  {
    $statement = App::get('dbh')->prepare("select transport from transport where id=:id");
    $statement->bindParam(':id', $id);
    $statement->execute();
    return $statement->fetchAll()[0]['transport'];
  }

  //@summary retourne tous les moyens de transport disponible dans un élément checkbox html, cette méthode permet de génerer la liste déroulante qui est affiché dans la vue
  //@param integer or string : on indique sois l'id du transport, sois le nom du transport dans le but de selectionner l'élément de la liste en conséquence, si on indique rien aucune éléments n'est selectionné
  //@return string : retourne l'html de la liste déroulante sous forme de string
  public static function fetchAllTransportsName($id = -1)
  {
    $statement = App::get('dbh')->prepare("select transport from transport");
    $statement->execute();
    $transports = $statement->fetchAll();

    if(is_string($id))
    {
      $id = Transport::getTransportId($id)- 1; //on doit shift l'index de -1 car l'ide dans la bdd commence à 1 et l'id du tableau commence a 0
    }

    $string = '';
    foreach ($transports as $key => $value)
    {
      if($id == -1 || ($id - 1) != $key)
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

  //Pour l'instant nous n'avons pas besoin d'enregistrer des transports dans la base de données mais nous sommes
  //obligé de réimplémenter la méthode
  public function save()
  {

  }
}
