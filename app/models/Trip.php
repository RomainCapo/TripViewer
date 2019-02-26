<?php

class Trip extends Model
{
  //Attributes
  private $id;
  private $name;
  private $description;
  private $departure_date;
  private $return_date;
  private $km_traveled;
  private $total_price;
  private $trip_state;
  private $number_people;

  private $id_user;
  private $id_transport_type;
  private $id_destination;
  private $id_departure;


  private function save()
  {
    $statement = App::get('dbh')->prepare('INSERT INTO trip(name, description, departure_date, return_date, km_traveled, total_price, trip_state, id_user, id_transport_type, id_destination, id_departure, number_people) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    
  }
}
