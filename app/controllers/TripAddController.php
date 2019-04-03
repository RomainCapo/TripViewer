<?php

class TripAddController
{

  private $error;

  public function index()
  {
    User::userIsConnected();//on teste si le user est connecté
    return Helper::view("tripAdd", ['error' => $this->error]);//on affiche la vue
  }

//permet de parser le formulaire d'ajout de voyage
  public function tripAddParse()
  {

    //Data processing
    User::userIsConnected();

    $isProcessingError = false;//indique si il y a eu des erreurs dans le traitement des données
    $this->error = '';//pour stocker le message d'erreur

    //on fait des tests sur toute les champs du formulaire d'ajout de voyage
    if(isset($_POST['destination']) && !empty($_POST['destination']))
    {
      $destination = $_POST['destination'];

      if(isset($_POST['departure']) && !empty($_POST['departure']))
      {
        $departure = $_POST['departure'];

        if(isset($_POST['trip_name']) && !empty($_POST['trip_name']))
        {
          $name = $_POST['trip_name'];

          if(isset($_POST['departure_date']) && !empty($_POST['departure_date']))
          {
            $departure_date = $_POST['departure_date'];

            //on teste également que la date de debut est plus petite que la date de fin
            if(isset($_POST['return_date']) && !empty($_POST['return_date']) && (strtotime($departure_date) < strtotime($_POST['return_date'])))
            {
              $return_date = $_POST['return_date'];

              if(isset($_POST['trip_state']) && ($_POST['trip_state'] == 'realized' || $_POST['trip_state']) == 'reserved' || $_POST['trip_state'] == 'planned')
              {
                $trip_state = $_POST['trip_state'];

                //on teste également si le transport est dans la base de données
                if(isset($_POST['transport_type']) && !empty($_POST['transport_type']) && Transport::transportInDb($_POST['transport_type']))
                {
                    $transport_type = $_POST['transport_type'];

                    if(isset($_POST['description']) && isset($_POST['total_price']) && isset($_POST['number_people']))
                    {
                      $description = $_POST['description'];
                      $total_price = $_POST['total_price'];
                      $number_people = $_POST['number_people'];

                      echo 'data processing okay';

                      //on créé un objet voyage
                      $Trip = new Trip;
                      $Trip->setName($name);
                      $Trip->setDescription($description);
                      $Trip->setDepartureDate($departure_date);
                      $Trip->setReturnDate($return_date);
                      $Trip->setTotalPrice($total_price);
                      $Trip->setTripState($trip_state);
                      $Trip->setNumberPeople($number_people);

                      //on géolocalise la destination et le déaprt
                      $dest_gps_coord = GoogleMapsApiHelper::getGPSCoord($destination);
                      $depa_gps_coord = GoogleMapsApiHelper::getGPSCoord($departure);

                      //selon le status de la requete on effectue différent traitement
                      if($dest_gps_coord['state'] != 'ERROR' && $depa_gps_coord['state'] != 'ERROR')
                      {
                        //on recupere la distance entre les 2 destinations
                        $Trip->setKmTraveled(GoogleMapsApiHelper::getDistBetweenTwoGPSPoint($dest_gps_coord['latitude'], $dest_gps_coord['longitude'], $depa_gps_coord['latitude'], $depa_gps_coord['longitude']));

                        //on sauvegarde les destinations avec leur informations dans l'object voyage
                        if($dest_gps_coord['state'] == 'OK' && $depa_gps_coord['state'] == 'OK')
                        {
                          $Trip->setIdDestination(Destination::saveDestination($destination, $dest_gps_coord));
                          $Trip->setIdDeparture(Destination::saveDestination($departure, $depa_gps_coord));
                        }
                        elseif ($dest_gps_coord['state'] == 'OK' && $depa_gps_coord['state'] == 'IN_DATABASE')
                        {
                          $Trip->setIdDestination(Destination::saveDestination($destination, $dest_gps_coord));
                          $Trip->setIdDeparture($depa_gps_coord['id']);
                        }
                        elseif($dest_gps_coord['state'] == 'IN_DATABASE' && $depa_gps_coord['state'] == 'OK')
                        {
                          $Trip->setIdDestination($dest_gps_coord['id']);
                          $Trip->setIdDeparture(Destination::saveDestination($departure, $depa_gps_coord));
                        }
                        elseif($dest_gps_coord['state'] == 'IN_DATABASE' && $depa_gps_coord['state'] == 'IN_DATABASE')
                        {
                          $Trip->setIdDestination($dest_gps_coord['id']);
                          $Trip->setIdDeparture($depa_gps_coord['id']);
                        }
                        $userId = unserialize($_SESSION['login'])->getId();//on récupére l'id de l'utilisateur
                        $Trip->setIdUser($userId);
                        $Trip->setIdTransportType(Transport::getTransportId($transport_type));//on definit l'id du type de transport
                        $Trip->setIdCompany(1);//pour l'instant l'id de la company aérien est défini à 1
                        $idTrip = $Trip->save();

                        if($this->fileProcessing($idTrip, $destination, 'Romain'))
                        {
                          echo 'trip added';
                        }
                        else
                        {
                          $isProcessingError = true;
                          $this->error = 'error with file processing';
                        }
                      }
                      else
                      {
                        $isProcessingError = true;
                        $this->error = 'error with the geocoding API';
                      }
                    }
                    else
                    {
                      $isProcessingError = true;
                      $this->error  = 'error with description, total_price or number_people';
                    }
                }
                else
                {
                  $isProcessingError = true;
                  $this->error = 'error with the transport_type';
                }
              }
              else
              {
                $isProcessingError = true;
                $this->error = 'error with the trip_state';
              }
            }
            else
            {
              $isProcessingError = true;
              $this->error = 'error with the return_date';
            }
          }
          else
          {
            $isProcessingError = true;
            $this->error = 'error with the departure_date';
          }
        }
        else
        {
          $isProcessingError = true;
          $this->error = 'error with the trip name';
        }
      }
      else
      {
        $isProcessingError = true;
        $this->error = 'error with the departure';
      }
    }
    else
    {
      $isProcessingError = true;
      $this->error  = 'error with the destination';
    }

    //si il y a eu des erreur on raffiche le formulaire d'ajout de voyage avec le message d'erreur
    //sinon on redirige vers l'affichage des voyages
    if($isProcessingError)
    {
      return $this->index();
    }
    else
    {
      header('Location: tripViewList');
      exit(0);
    }
  }

  private function validateDate($date, $format = 'dd.mm.YYYY')
  {
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
  }

  public function debug()
  {
    var_dump($this->validateDate('03.10.2020'));
  }

  private function fileProcessing($tripId, $destination, $username)
  {
    if(!empty($_FILES['photos']['name'][0]) && isset($_FILES))
    {
      $noFileError = true;

      $target_dir = "uploads/";
      $total = count($_FILES['photos']['name']);
      for($i = 0; $i < $total; $i++)
      {
        $tmpFilePath = $_FILES['photos']['tmp_name'][$i];
        $newFilePath = $target_dir . basename($_FILES['photos']['name'][$i]);

        if(move_uploaded_file($tmpFilePath, $newFilePath))
        {
          //format de stockage de l'image : uploads/username_destination_day-month-Year_hour-minute-seconde_numeroPhoto.extension
          $filename = $username . '_' .  $destination . '_' . date("d-m-Y_h-i-s") . '_'. $i .'.'.pathinfo($_FILES['photos']['name'][$i], PATHINFO_EXTENSION);
          $definitiveFilePath = $target_dir . $filename;
          rename($newFilePath, $definitiveFilePath);

          $photo = new Photo;
          $photo->setFileName($filename);
          $photo->setIdTrip($tripId);
          $photo->save();
        }
        else
        {
          $noFileError = false;
        }
      }

      return $noFileError;
    }
    else
    {
      return true;
    }
  }

//permet de supprimer un voyage
  public function deleteTrip()
  {
    User::userIsConnected();

    if(isset($_POST['deleteTripId']) && (Trip::getIdUserByTripId($_POST['deleteTripId']) == unserialize($_SESSION['login'])->getId()))
    {
      $id = $_POST['deleteTripId'];

      $statement = App::get('dbh')->prepare('DELETE FROM trip WHERE id = ?');
      $statement->bindValue(1, $id);

      if($statement->execute())
      {
        header('Location: tripViewList'); // TODO add success messages
        exit(0);
      }
      else
      {
        header('Location: tripViewList'); // TODO add errors messages
        exit(0);
      }
    }
    else
    {
      header('Location: tripViewList');
      exit(0);
    }
  }
}
