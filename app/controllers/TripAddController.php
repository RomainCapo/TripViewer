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
    $destination;
    $departure;
    $departure_date;
    $return_date;
    $trip_state;
    $transport_type;

    $name = 'NULL';
    $description = 'NULL';
    $total_price = 'NULL';
    $number_people = 'NULL';
    $km_traveled;

    $isProcessingError = true;
    $this->error = '';

    //Data processing
    if(isset($_POST['destination']) && !empty($_POST['destination']))
    {
      $destination = $_POST['destination'];

      if(isset($_POST['departure']) && !empty($_POST['departure']))
      {
        $departure = $_POST['departure'];

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

                  if(isset($_POST['trip_name']) && isset($_POST['description']) && isset($_POST['total_price']) && isset($_POST['number_people']))
                  {
                    $name = $_POST['trip_name'];
                    $description = $_POST['description'];
                    $total_price = $_POST['total_price'];
                    $number_people= $_POST['number_people'];

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

                    //$Trip->setKmTraveled(GoogleMapsApiHelper::getDistBetweenTwoGPSPoint($dest_gps_coord['latitude'], $dest_gps_coord['longitude'], $depa_gps_coord['latitude'], $depa_gps_coord['longitude']));

                    $Trip->setIdDestination(Destination::saveDestination($destination, $dest_gps_coord));
                    $Trip->setIdDeparture(Destination::saveDestination($departure, $depa_gps_coord));

                    $Trip->setIdUser(1);
                    $Trip->setIdTransportType(Transport::getTransportId($transport_type));
                    $Trip->setIdCompany(1);
                    $Trip->save();
                  }
                  else
                  {
                    $isProcessingError = true;
                    $this->error  = 'error with trip_name, description, total_price or number_people';
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

  public function test()
  {
    var_dump(Destination::getLatLngCouFromDest('Buenos Aires'));
  }
}
