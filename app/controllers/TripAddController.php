<?php

class TripAddController
{

  private $error;

  public function index()
  {
    var_dump($_SESSION['login']);
    if(isset($_SESSION['login']))
    {
      return Helper::view("tripAdd", ['error' => $this->error]);
    }
    else
    {
      //header('Location: login');
    }
  }

  public function tripAddParse()
  {
    if(isset($_SESSION['login']))
    {
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

                        var_dump($_POST);

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

                        var_dump($dest_gps_coord);
                        var_dump($depa_gps_coord);

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

                          $userId = unserialize($_SESSION['login'])->getId();
                          $Trip->setIdUser($userId);
                          $Trip->setIdTransportType(Transport::getTransportId($transport_type));
                          $Trip->setIdCompany(1);
                          $Trip->save();
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
                        $this->error  =  'error with description, total_price or number_people';
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
            $this->error  =  'error with trip name';
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
    else
    {
      header('Location: login');
    }
  }

  public function test()
  {
    $reponse = Destination::getLatLngCouFromDest('Zurich');
    $reponse['state'] = 'in';
    var_dump($reponse);
  }
}
