<?php

class TripAddController
{

  private $error;

  public function index()
  {
    User::userIsConnected();//on teste si le user est connecté
    return Helper::view("tripAdd", ['error' => $this->error]);//on affiche la vue
  }

  public function updateTrip()
  {
    //attention il faut encore tester que le voyages appartienne bien a l'utilisateur
    User::userIsConnected();
    if(isset($_POST['editTripId']))
    {
      $id = $_POST['editTripId'];
      return Helper::view("tripUpdate", ['error' => $this->error, 'id_trip' => $id]);//on affiche la vue
    }
    else
    {
      header('Location: tripViewList');
      exit(0);
    }
  }

  private function tripCheck($post)
  {
    $isProcessingError = false;//indique si il y a eu des erreurs dans le traitement des données
    $this->error = '';//pour stocker le message d'erreur

    //on fait des tests sur toute les champs du formulaire d'ajout de voyage
    if(isset($post['destination']) && !empty($post['destination']))
    {
      if(isset($post['departure']) && !empty($post['departure']))
      {
        if(isset($post['trip_name']) && !empty($post['trip_name']))
        {
          if(isset($post['departure_date']) && !empty($post['departure_date']) && $this->validateDate($post['departure_date']))
          {
            //on teste également que la date de debut est plus petite que la date de fin
            if(isset($post['return_date']) && !empty($post['return_date']) && $this->validateDate($post['return_date']))
            {
              if(strtotime($post['departure_date']) < strtotime($post['return_date']))
              {
                if(isset($post['trip_state']) && ($post['trip_state'] == 'realized' || $post['trip_state']) == 'reserved' || $post['trip_state'] == 'planned')
                {
                 //on teste également si le transport est dans la base de données
                  if(isset($post['transport_type']) && !empty($post['transport_type']) && Transport::transportInDb($post['transport_type']))
                  {
                      if(isset($post['description']) && isset($post['total_price']) && isset($post['number_people']))
                      {
                        //no errors
                        $destination = $post['destination'];
                        $departure = $post['departure'];
                        $transport_type = $post['transport_type'];

                        //on créé un objet voyage
                        $Trip = new Trip;
                        $Trip->setName($post['trip_name']);
                        $Trip->setDescription((string)$post['description']);
                        $Trip->setDepartureDate($post['departure_date']);
                        $Trip->setReturnDate($post['return_date']);
                        $Trip->setTotalPrice($post['total_price']);
                        $Trip->setTripState($post['trip_state']);
                        $Trip->setNumberPeople($post['number_people']);

                        //on géolocalise la destination et le déaprt
                        $dest_gps_coord = GoogleMapsApiHelper::getGPSCoord($destination);
                        $depa_gps_coord = GoogleMapsApiHelper::getGPSCoord($departure);

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

                          return $Trip;
                        }
                        else
                        {
                          $isProcessingError = true;
                          $this->error  = 'error with geocoding API';
                        }
                      }
                      else
                      {
                        $isProcessingError = true;
                        $this->error  = 'the description, the total price or the number of people is not valid';
                      }
                  }
                  else
                  {
                    $isProcessingError = true;
                    $this->error = 'the transport type is not valid';
                  }
                }
                else
                {
                  $isProcessingError = true;
                  $this->error = 'the trip state is not valid';
                }
              }
              else
              {
                $isProcessingError = true;
                $this->error  = 'the return must be greater than departure date';
              }
            }
            else
            {
              $isProcessingError = true;
              $this->error = 'the return date is not valid';
            }
          }
          else
          {
            $isProcessingError = true;
            $this->error = 'the departure date is not valid';
          }
        }
        else
        {
          $isProcessingError = true;
          $this->error = 'the trip name is not valid';
        }
      }
      else
      {
        $isProcessingError = true;
        $this->error = 'the departure is not valid';
      }
    }
    else
    {
      $isProcessingError = true;
      $this->error  = 'the destination is not valid';
    }

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

//permet de parser le formulaire d'ajout de voyage
  public function tripAddParse()
  {
    //Data processing
    User::userIsConnected();

      $Trip = $this->tripCheck($_POST);
      $id_user = $Trip->id_user;
      $idTrip = $Trip->save();

      if($this->fileProcessing($idTrip, $destination, $id_user))
      {
        echo 'trip added';
        header('Location: tripViewList');
        exit(0);
      }
      else
      {
        $this->error = 'error with file processing';
        return $this->index();
      }
  }

  public function tripUpdateParse()
  {
    $Trip = $this->tripCheck($_POST);
    $Trip->setId($_POST['id_trip']);
    $Trip->update();
    header('Location: tripViewList');
    exit(0);
  }

  function validateDate($date, $format = 'Y-m-d')
  {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
  }

  private function fileProcessing($tripId, $destination, $id_user)
  {
    if(isset($_FILES) && !empty($_FILES['photos']['name']))
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
          $filename = $id_user . '_' .  $destination . '_' . date("d-m-Y_h-i-s") . '_'. $i .'.'.pathinfo($_FILES['photos']['name'][$i], PATHINFO_EXTENSION);
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
