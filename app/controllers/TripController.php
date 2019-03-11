<?php

class TripController
{
  public function index()
  {
    var_dump(Trip::fetchAllTrips());
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
