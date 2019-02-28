<?php

class Transport extends Model
{
  private $id;
  private $name;

  public static function fetchAllTransports()
  {
    return parent::fetchAll('transport', 'Transport');
  }

  public static function fetchAllTransportsName()
  {
    $statement = App::get('dbh')->prepare("select transport from Transport");
    $statement->execute();

    $string = '';
    foreach ($statement->fetchAll() as $key => $value)
    {
      $string.= "<option value='". $value[0] ."'>" . $value[0] . '</option>' . PHP_EOL;
    }
    return $string;
  }

  public static function transportInDb($transport)
  {
    $statement = App::get('dbh')->prepare("select * from Transport where transport=:transport");
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

  public static function getTransportId($transport)
  {
    $statement = App::get('dbh')->prepare("select id from Transport where transport=:transport");
    $statement->bindParam(':transport', $transport);
    $statement->execute();

    return $statement->fetchAll()[0]['id'];
  }

  public function save()
  {

  }
}
