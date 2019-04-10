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

//Setters
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

//valeur par défaut 0
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

//valeur par défaut 0
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

  //@summary retourne les informations d'un voyage dans le but d'être affiché dans une vue
  //@return string : retourne l'html contenant les informations de voyage sous forme de string
  public function asCardShow()
  {
      $str = "";

      $str .= "<div class='card'><div class='card-body'><h3 class='card-title'>";
      $str .= htmlentities(ucfirst(strtolower(Destination::getDestinationById($this->id_destination))));
      $str .= " <span style='font-size:15px'><strong>From</strong> <em>";
      $str .= htmlentities($this->departure_date) . "</em> <strong>to</strong> <em>" . htmlentities($this->return_date);
      $str .= "</em></span>";
      $str .= "</h3><h5 class='card-subtitle mb-2 text-muted'>";
      $str .= htmlentities($this->name);
      $str .= "</h5><p class='card-text'>";
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

  public function displayInfos()
  {
    $str = "";

    $str .= "<h1>";
    $str .= htmlentities(strtoupper(Destination::getDestinationById($this->id_destination)));
    $str .= "</h1><h3 style='color:grey'>";
    $str .= htmlentities($this->name);
    $str .= "</h3><p style='color:grey'><strong>From </strong><em>";
    $str .= htmlentities($this->departure_date);
    $str .= "</em> <strong>to </strong><em>";
    $str .= htmlentities($this->return_date);
    $str .= "</em></p>";

    $str .= "<ul>";
    $str .= "<li>Price : ";
    $str .= htmlentities($this->total_price);
    $str .= ".-</li>";
    $str .= "<li>Number of people : ";
    $str .= htmlentities($this->number_people);
    $str .= "</li>";
    $str .= "<li>Number of Km : ";
    $str .= htmlentities($this->km_traveled);
    $str .= " Km</li>";
    $str .= "<li>Departure town : ";
    $str .= htmlentities(Destination::getDestinationById($this->id_departure));
    $str .= "</li>";
    $str .= "<li>Trip state : ";
    $str .= htmlentities($this->trip_state);
    $str .= "</li></ul>";

    if(!empty($this->description))
    {
        $str .= "<h3>Description of the trip</h3><hr><p>";
        $str .= htmlentities($this->description);
        $str .= "</p>";
    }

    return $str;
  }

  //@summary retourne toutes les voyages de la base de données
  //@return Trip : objet contenant les informations de voyages
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

  //@summary sauve les voyages dans la base de données
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

    return App::get('dbh')->lastInsertId(); //recupére l'id de la dernière destination ajoutée
  }

  //@summary retourne toutes les informations de voyage a partir d'un id d'utilisateur
  //@param $id_user : id de l'utilisateur
  //@return Trip : objet contentant les informations de voyages
  public static function fetchTripById($id_user)
  {
    $statement = App::get('dbh')->prepare('SELECT * FROM trip WHERE id_user = ?');
    $statement->bindValue(1, $id_user);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_CLASS, 'trip');
  }

  //@summary retourne l'id de l'utilisateur a partir d'un id de voyage
  //@param $id_trip : id du voyage
  //@return 0 : dans le cas ou aucun voyage ne corresponds à l'utilisateur
  //@return int : id de l'utilisateur
  public static function getIdUserByTripId($id_trip)
  {
    $statement = App::get('dbh')->prepare('SELECT id_user FROM trip WHERE id = ?');
    $statement->bindValue(1, $id_trip);
    $statement->execute();
    $res = $statement->fetchAll();
    if(!empty($res))
    {
      return $res[0]['id_user'];
    }
    else
    {
      return 0;
    }
  }

  public static function fetchById($id, $table, $intoClass)
  {
    return parent::fetchById($id, $table, $intoClass);
  }
}
