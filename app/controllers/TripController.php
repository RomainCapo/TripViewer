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
    if(isset($_GET["id"]) && ctype_digit($_GET["id"]))
    {
      $id = $_GET['id'];

      $statement = App::get('dbh')->prepare('SELECT * FROM trip WHERE id = ?');
      $statement->bindValue(1, $id);
      $statement->execute();
      $res = $statement->fetchAll();
      $trip = $res[0];
    }
    else {
        // TODO error
    }

    return Helper::view("showTrip",[
            'trip' => $trip,
        ]);
  }
}
