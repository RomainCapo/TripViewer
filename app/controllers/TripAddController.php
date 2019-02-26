<?php

class TripAddController
{
  public function index()
  {
      return Helper::view("tripAdd");
  }

  public function test()
  {
    GoogleMapsApiHelper::getGPSCoord('London');
  }

  public function tripAddParse()
  {
    $destination;
    $departure;
    $departure_date;
    $return_date;
    $trip_state;
    $transport_type;

    $name;
    $description;
    $km_traveled;
    $total_price;
    $number_people;

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

          if(isset($_POST['return_date']) && !empty($_POST['return_date']))
          {
            $return_date = $_POST['return_date'];

            if(isset($_POST['trip_state']) && ($_POST['trip_state'] == 'realized' || $_POST['trip_state']) == 'reserved' || $_POST['trip_state'] == 'planned')
            {
              $trip_state = $_POST['trip_state'];


              if(isset($_POST['transport_type']) && !empty($_POST['transport_type']))
              {
                  $transport_type = $_POST['transport_type'];

                  if(isset($_POST['trip_name']) && isset($_POST['description']) && isset($_POST['total_price']) && isset($_POST['number_people']))
                  {
                    $name = $_POST['trip_name'];
                    $description = $_POST['description'];
                    $total_price = $_POST['total_price'];
                    $number_people= $_POST['number_people'];

                    echo 'data processing okay';


                  }
              }
            }
          }
        }
      }
    }
  }
}
