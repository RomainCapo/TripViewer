<?php

class TripAddController
{

  private $error;

  public function index()
  {
      return Helper::view("tripAdd", ['error' => $this->error]);
  }

  public function tripAddParse()
  {
    $description = NULL;
    $total_price = NULL;
    $number_people = NULL;

    $isProcessingError = false;
    $this->error = '';

    //Data processing
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

            if(isset($_POST['return_date']) && !empty($_POST['return_date']) && (strtotime($departure_date) < strtotime($_POST['return_date'])))
            {
              $return_date = $_POST['return_date'];

              if(isset($_POST['trip_state']) && ($_POST['trip_state'] == 'realized' || $_POST['trip_state']) == 'reserved' || $_POST['trip_state'] == 'planned')
              {
                $trip_state = $_POST['trip_state'];

                if(isset($_POST['transport_type']) && !empty($_POST['transport_type']) && Transport::transportInDb($_POST['transport_type']))
                {
                    $transport_type = $_POST['transport_type'];

                    if(isset($_POST['description']) && isset($_POST['total_price']) && isset($_POST['number_people']))
                    {
                      $description = $_POST['description'];
                      $total_price = $_POST['total_price'];
                      $number_people = $_POST['number_people'];

                      echo 'data processing okay';

                      $Trip = new Trip;
                      $Trip->setName($name);
                      $Trip->setDescription($description);
                      $Trip->setDepartureDate($departure_date);
                      $Trip->setReturnDate($return_date);
                      $Trip->setTotalPrice($total_price);
                      $Trip->setTripState($trip_state);
                      $Trip->setNumberPeople($number_people);

                      $dest_gps_coord = GoogleMapsApiHelper::getGPSCoord($destination);
                      $depa_gps_coord = GoogleMapsApiHelper::getGPSCoord($departure);

                      if($dest_gps_coord['state'] != 'ERROR' && $depa_gps_coord['state'] != 'ERROR')
                      {
                        $Trip->setKmTraveled(GoogleMapsApiHelper::getDistBetweenTwoGPSPoint($dest_gps_coord['latitude'], $dest_gps_coord['longitude'], $depa_gps_coord['latitude'], $depa_gps_coord['longitude']));

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

                          $Trip->setIdUser(3);
                          $Trip->setIdTransportType(Transport::getTransportId($transport_type));
                          $Trip->setIdCompany(1);
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

    if($isProcessingError)
    {
      return $this->index();
    }
    else
    {
      header('Location: tripViewList');
    }
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

  public function test()
  {
    var_dump(Photo::getPhotosFromTrip(29));
  }
}
