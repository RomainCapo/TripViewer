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

  public function asCardShow()
  {
      $str = "";

      $str .= "<div class='card'><div class='card-body'><h1 class='card-title'>"; 
      $str .= htmlentities(ucfirst(strtolower($this->getDestinationById($this->id_destination))));
      $str .= " <span style='font-size:15px'><strong>From</strong> <em>";
      $str .= htmlentities($this->departure_date) . "</em> <strong>to</strong> <em>" . htmlentities($this->return_date);
      $str .= "</em></span>";
      $str .= "</h1><h4 class='card-subtitle mb-2 text-muted'>";
      $str .= htmlentities($this->name);
      $str .= "</h4><p class='card-text'>";
      $str .= htmlentities($this->description);
      $str .= "</p><a href='tripView?id=";
      $str .= urlencode($this->id);
      $str .= "' class='card-link'>Read more about ";
      $str .= htmlentities($this->name);
      $str .= "</a><br><br>";
      $str .= "<form action='tripViewListEdit' method='post' style='display:inline-block'><input name='editTripId' type='hidden' value='" . htmlentities($this->id) . "'/><button class='btn btn-success' type='submit'/>Edit</button></form>";
      $str .= "<span>&nbsp;&nbsp;&nbsp;</span>";
      $str .= "<form action='tripViewListDelete' method='post' style='display:inline-block'><input name='deleteTripId' type='hidden' value='" . htmlentities($this->id) . "'/><button class='btn btn-danger' type='submit'/>Delete</button></form>";
      $str .= "</div></div><br>";

      return $str;
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
    if($totalPrice != '')
    {
      $this->total_price = $totalPrice;
    }
    else
    {
      $this->total_price = 0;
    }
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
    if($numberPeople != '')
    {
      $this->number_people = $numberPeople;
    }
    else
    {
      $this->number_people = 0;
    }
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

  public static function getDestinationById($id)
  {
      $statement = App::get('dbh')->prepare('SELECT destination FROM destination WHERE id = ?');
      $statement->bindValue(1, $id);
      $statement->execute();
      $res = $statement->fetchAll();
      return $res[0]['destination'];
  }

  public static function fetchTripById($id_user)
  {
    $statement = App::get('dbh')->prepare('SELECT * FROM trip WHERE id_user = ?');
    $statement->bindValue(1, $id_user);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_CLASS, 'trip');
  }
}
