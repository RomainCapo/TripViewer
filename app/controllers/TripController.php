<?php

class TripController
{
  public function index()
  {
    //var_dump(Trip::fetchAllTrips());

    return Helper::view("viewList", ['trips' => Trip::fetchAllTrips()]);
  }
}
