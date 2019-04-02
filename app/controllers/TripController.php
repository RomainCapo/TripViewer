<?php

class TripController
{
  public function index()
  {
    $trip = Trip::fetchAllTrips();
    var_dump($trip[0]->getName());
  }

  public function mapView()
  {
    return Helper::view("tripMap");
  }

  public function getAllUserTripCoord()
  {
    //ne pas oublier de changer l'id de l'utilisateur
    echo json_encode(Trip::getUserTripInfo(4));
  }
}
