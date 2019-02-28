<?php

class TripController
{
  public function index()
  {
    var_dump(Trip::fetchAllTrips());
  }
}
