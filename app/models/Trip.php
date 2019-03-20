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
  private $id_company;

  public function getName(){
    return $this->name;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function setDescription($description)
  {
    $this->description = $description;
  }

  public function setDepartureDate($departureDate)
  {
    $this->departure_date = $departureDate;
  }

  public function setReturnDate($returnDate)
  {
    $this->return_date = $returnDate;
  }

  public function setKmTraveled($kmTraveled)
  {
    $this->km_traveled = $kmTraveled;
  }

  public function setTotalPrice($totalPrice)
  {
    $this->total_price = $totalPrice;
  }

  public function setTripState($tripState)
  {
    $this->trip_state = $tripState;
  }

  public function setIdUser($id)
  {
    $this->id_user = $id;
  }

  public function setNumberPeople($numberPeople)
  {
    $this->numberPeople = $numberPeople;
  }

  public function setIdTransportType($id)
  {
    $this->id_transport_type = $id;
  }

  public function setIdDestination($id)
  {
    $this->id_destination = $id;
  }

  public function setIdDeparture($id)
  {
    $this->id_departure = $id;
  }

  public function setIdCompany($id)
  {
    $this->id_company = $id;
  }

  public static function fetchAllTrips()
  {
    return parent::fetchAll('trip', 'Trip');
  }

  public static function getUserTripInfo($id_user)
  {
    $statement = App::get('dbh')->prepare('SELECT name, description, departure_date, return_date, km_traveled, total_price, trip_state, id_user, id_transport_type, id_destination, id_departure, number_people, id_company FROM trip WHERE id_user=:id_user');
    $statement->bindParam(':id_user', $id_user);
    $statement->execute();

    $array = array();
    $i = 0;

    foreach ($statement->fetchAll() as $key => $value) {

      $array[$i] = Destination::getDestInfo($value['id_destination']);
      $array[$i]['departure'] = Destination::getDestInfo($value['id_departure'])['dest'];
      $array[$i]['name'] = htmlentities($value['name']);
      $array[$i]['description'] = htmlentities($value['description']);
      $array[$i]['departure_date'] = htmlentities($value['departure_date']);
      $array[$i]['return_date'] = htmlentities($value['return_date']);
      $array[$i]['km_traveled'] = htmlentities($value['km_traveled']);
      $array[$i]['total_price'] = htmlentities($value['total_price']);
      $array[$i]['trip_state'] = htmlentities($value['trip_state']);
      $array[$i]['number_people'] = htmlentities($value['number_people']);

      $i++;
    }
    return $array;
  }

  public function save()
  {
    $statement = App::get('dbh')->prepare('INSERT INTO trip(name, description, departure_date, return_date, km_traveled, total_price, trip_state, id_user, id_transport_type, id_destination, id_departure, number_people, id_company)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $statement->bindValue(1, $this->name);
    $statement->bindValue(2, $this->description);
    $statement->bindValue(3, $this->departure_date);
    $statement->bindValue(4, $this->return_date);
    $statement->bindValue(5, $this->km_traveled);
    $statement->bindValue(6, $this->total_price);
    $statement->bindValue(7, $this->trip_state);
    $statement->bindValue(8, $this->id_user);
    $statement->bindValue(9, $this->id_transport_type);
    $statement->bindValue(10, $this->id_destination);
    $statement->bindValue(11, $this->id_departure);
    $statement->bindValue(12, $this->number_people);
    $statement->bindValue(13, $this->id_company);
    $statement->execute();
  }
}
