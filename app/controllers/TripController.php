<?php

class TripController
{
  public function index()
  {
    //var_dump(Trip::fetchAllTrips());
    return Helper::view("viewList", ['trips' => Trip::fetchTripById(unserialize($_SESSION['login'])->getId())]);
  }

  public function showTrip()
  {
    if(isset($_GET["id"]) && ctype_digit($_GET["id"]) && (Trip::getIdUserByTripId($_GET['id']) == unserialize($_SESSION['login'])->getId()))
    {
      $id = $_GET['id'];

      $statement = App::get('dbh')->prepare('SELECT * FROM trip WHERE id = ?');
      $statement->bindValue(1, $id);
      $statement->execute();
      $res = $statement->fetchAll();
      $trip = $res[0];

      return Helper::view("showTrip",[
        'trip' => $trip,
      ]);
    }
    else {
      header('Location: tripViewList');
      exit(0);
    } 
  }
}
