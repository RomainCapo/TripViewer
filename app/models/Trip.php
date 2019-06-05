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

//Getters
  public function __get($property)
  {
    if (property_exists($this, $property))
    {
      return $this->$property;
    }
  }

  public function getName(){
    return $this->name;
  }

//Setters
  public function setId($id){
    $this->id = $id;
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

  //@summary retourne les informations d'un voyage dans le but d'être affiché dans une vue
  //@return string : retourne l'html contenant les informations de voyage sous forme de string
  public function asCardShow()
  {
      $str = "";

      $str .= "<div class='card'><div class='card-body'><h3 class='card-title'>";
      $str .= htmlentities(Helper::mb_ucfirst(mb_strtolower(Destination::getDestinationById($this->id_destination), 'UTF-8'), 'UTF-8'));
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
      $str .= "<form action='updateForm' method='post' style='display:inline-block'><input name='editTripId' type='hidden' value='" . htmlentities($this->id) . "'/><button class='btn btn-warning' type='submit'/>Edit</button></form>";
      $str .= "<span>&nbsp;&nbsp;&nbsp;</span>";
      $str .= "<form action='tripDelete' method='post' style='display:inline-block'><input name='deleteTripId' type='hidden' value='" . htmlentities($this->id) . "'/><button class='btn btn-danger' type='submit'/>Delete</button></form>";
      $str .= "<span>&nbsp;&nbsp;&nbsp;</span>";
      $str .= "<form action='exportToPdf' method='post' style='display:inline-block'><input name='exportToPdf' type='hidden' value='" . htmlentities($this->id) . "'/><button class='btn btn-dark' type='submit'/>Export to PDF</button></form>";
      $str .= "</div></div><br>";

      return $str;
  }

  //@summary retourne les informations détaillé d'un voyage dans le but d'être affiché dans une vue
  //@return string : retourne l'html contenant les informations de voyage sous forme de string
  public function displayInfos()
  {
    $str = "";

    $str .= "<form action='tripViewList'><button type='submit' class='btn btn-outline-success'> Back to your trips</button></form><br><br>";
    $str .= "<h1>";
    $str .= htmlentities(mb_strtoupper(Destination::getDestinationById($this->id_destination), 'UTF-8'));
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
    $str .= "<li>Transport : ";
    $str .= htmlentities(Transport::getTransportById($this->id_transport_type));
    $str .= "</li>";
    $str .= "</li></ul>";

    if(!empty($this->description))
    {
        $str .= "<h3>Description of the trip</h3><hr><p>";
        $str .= htmlentities($this->description);
        $str .= "</p>";
    }

    $photos = Photo::getURLUpload($this->id);

    if(sizeof($photos) > 0)
    {
      $str .= "<div id='carouselExampleIndicators' class='carousel slide' data-ride='carousel'>";
      $str .= "<ol class='carousel-indicators'>";


      $str .= "<li data-target='#carouselExampleIndicators' data-slide-to='0' class='active'></li>";

      for($i = 1; $i < sizeof($photos); $i++)
      {
        $str .= "<li data-target='#carouselExampleIndicators' data-slide-to='" . $i . "'></li>";
      }


      $str .= "</ol>";

      $str .= "<div class='carousel-inner'>";

      $i = 0;
      foreach($photos as $key => $value)
      {
        if($i == 0)
          $str .= "<div class='carousel-item active'>";
        else
          $str .= "<div class='carousel-item'>";

        $str .= "<img src='uploads/" . htmlentities($value['file_name']) . "' alt='photo_trip' class='d-block w-100'>";
        $str .= "</div>";
        $i++;
      }

      $str .= "</div>";

      $str .= "<a class='carousel-control-prev' href='#carouselExampleIndicators' role='button' data-slide='prev'>";
      $str .= "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
      $str .= "<span class='sr-only'>Previous</span>";
      $str .= "</a>";
      $str .= "<a class='carousel-control-next' href='#carouselExampleIndicators' role='button' data-slide='next'>";
      $str .= "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
      $str .= "<span class='sr-only'>Next</span>";
      $str .= "</a>";
      $str .= "</div>";
    }

    return $str;
  }

  //@summary permet d'initialiser l'écriture sur le pdf avec l'en-tête correcte
  //@return object : retourne un objet pdf avec l'en-tête
  public static function initPdf()
  {
    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->Image('public/img/logo.png',10,6,30, 30);
    $pdf->SetFont('Helvetica','BI',48);
    $pdf->SetX(60);
    $pdf->Cell(0,22, 'Trip Viewer', 0, 1);
    $pdf->Cell(0,15, '', 0, 1);
    return $pdf;
  }

  //@summary permet d'exporter un voyage sous forme de pdf
  //@param  $pdf object : objet pdf préceddement initialisé
  //@param  $pageBreaker boolean : indique si un saut de page doit être effectué ou non
  //@return object : retourne lôbjet pdf courant
  public function exportToPdf($pdf, $pageBreaker)
  {
    if($pageBreaker)
    {
      $pdf->AddPage();
    }

    $pdf->SetFont('Arial','B',32);
    $pdf->Cell(0,15,'Trip name : '  . utf8_decode(Helper::mb_ucfirst(mb_strtolower(htmlspecialchars(Destination::getDestinationById($this->id_destination), ENT_QUOTES, "UTF-8"), "UTF-8"), "UTF-8")), 0, 1);

    $pdf->SetFont('Helvetica','I',15);
    $pdf->Cell(0, 10, 'Departure from : ' . utf8_decode(Helper::mb_ucfirst(mb_strtolower(htmlspecialchars(Destination::getDestinationById($this->id_departure), ENT_QUOTES, "UTF-8"), 'UTF-8'), 'UTF-8')), 0, 1);
    $pdf->Cell(0, 10, "Trip name : " . utf8_decode(htmlspecialchars($this->name, ENT_QUOTES, "UTF-8")), 0, 1);
    $pdf->Cell(0, 10, 'From : ' . htmlentities($this->departure_date) . ' to : ' . htmlentities($this->return_date), 0, 1);
    $pdf->Cell(0, 10, 'Price : ' . htmlentities($this->total_price), 0, 1);
    $pdf->Cell(0, 10, 'Number of people : ' . htmlentities($this->number_people), 0, 1);
    $pdf->Cell(0, 10, 'Number of km travelled : ' . htmlentities($this->km_traveled), 0, 1);
    $pdf->Cell(0, 10, 'Trip state : ' . htmlentities($this->trip_state), 0, 1);
    $pdf->Cell(0, 10, 'Transport : ' . Transport::getTransportById($this->id_transport_type), 0, 1);

    if(!empty($this->description))
    {
      $pdf->Cell(0,10, 'Description : ' . utf8_decode(htmlspecialchars($this->description, ENT_QUOTES, "UTF-8")), 0,1);
    }
    $pdf->Cell(0, 10, '',0,1);

    return $pdf;
  }

  //@summary retourne sous forme de liste deroulante html les différents transports
  //@param  $tripState string  : le nom du transport dans le but de selectionner l'élément de la liste en conséquence, si on indique rien aucune éléments n'est selectionné
  //@return string : retourne l'html de la liste deroulante
  public static function fetchAllTripState($tripState = 'none')
  {
    $arrayTripState = array('realized', 'reserved', 'planned');
    $id = -1;
    if($tripState != 'none')
    {
        $id = array_search($tripState, $arrayTripState);
    }

    $string = "";
    foreach ($arrayTripState as $key => $value) {
      if($id == -1 || $id!=$key )
      {
        $string .= "<option value='". $value ."'>" . Helper::mb_ucfirst($value, 'UTF-8') . '</option>' . PHP_EOL;
      }
      else
      {
        $string .= "<option value='". $value ."' selected>" . Helper::mb_ucfirst($value, 'UTF-8') . '</option>' . PHP_EOL;
      }
    }

    return $string;
  }

  //@summary retourne tous les voyages de la base de données
  //@return Trip : objet contenant les informations de voyages
  public static function fetchAllTrips()
  {
    return parent::fetchAll('trip', 'Trip');
  }

  //@summary retourne un tableau contenant tous les voyages d'un utilisateur avec notamment les coordonnées GPS des destinations
  //@param $id integer :  id de l'utilisateur
  //@return Trip : tableau avec toutes les voyages de l'utilisateur
  public static function getUserTripInfo($id_user)
  {
    $statement = App::get('dbh')->prepare('SELECT name, description, departure_date, return_date, km_traveled, total_price, trip_state, id_user, id_transport_type, id_destination, id_departure, number_people FROM trip WHERE id_user=:id_user');
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
    $statement = App::get('dbh')->prepare('INSERT INTO trip(name, description, departure_date, return_date, km_traveled, total_price, trip_state, id_user, id_transport_type, id_destination, id_departure, number_people)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
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
    $statement->execute();

    return App::get('dbh')->lastInsertId(); //recupére l'id de la dernière destination ajoutée
  }

  //@summary permet de modifier un voyage dans la base de données
  public function update()
  {
    $statement = App::get('dbh')->prepare('Update trip SET name=?, description=?, departure_date=?, return_date=?, km_traveled=?, total_price=?, trip_state=?, id_user=?, id_transport_type=?, id_destination=?, id_departure=?, number_people=? WHERE id=?');
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
    $statement->bindValue(13, $this->id);
    $statement->execute();
  }

  //@summary permet de supprimer un voyage
  public function delete()
  {
    $statement = App::get('dbh')->prepare('DELETE FROM trip WHERE id=:id');
    $statement->bindValue(':id', $this->id);
    $statement->execute();
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

  //@summary retourne tous les voyages pour un id donné
  //@param $id integer : id du voyage
  //@return Trip : object voyage
  public static function fetchById($id, $table="trip", $intoClass="Trip")
  {
    return parent::fetchById($id, "trip", "Trip");
  }
}
