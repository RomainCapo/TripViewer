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
    echo json_encode(Trip::getUserTripInfo(1));
  }
}
