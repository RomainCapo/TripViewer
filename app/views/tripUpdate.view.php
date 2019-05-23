<?php
    $title = "Trip update";
    require('partials/header.php');
    require('partials/nav.php');

    $trip = Trip::fetchById($id_trip);
?>
<div class="container">
  <?php if(isset($error) && $error != '')
        { ?>


  <div class="alert alert-dismissible alert-danger">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Error : </strong> <?php echo $error; ?>
  </div>
  <?php } ?>
  <div class="card border-secondary mb-3 card-form-add">
    <div class="card-header"><h2>Update a trip</h2></div>
    <div class="card-body">
      <form action="updateParse" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_trip" value="<?php echo $id_trip; ?>">
        <label for="destination">Destination : </label><input class="form-control" id="destination" type="text" name="destination" placeholder="Enter your destination" value="<?php echo ucfirst(Destination::getDestNameById($trip->id_destination)); ?>"  autocomplete="off"/><br/>
        <label for="departure">Departure : </label><input class="form-control" id="departure" type="text" name="departure" placeholder="Enter your departure"  value="<?php echo ucfirst(Destination::getDestNameById($trip->id_departure)); ?>"  autocomplete="off"/><br/>
        <label for="trip_name">Trip name : </label><input class="form-control" id="trip_name" type="text" name="trip_name" placeholder="Enter your trip name" value="<?php echo $trip->name; ?>"  autocomplete="off"/><br/>
        <div class="row">
          <div class="col">
            <label for="departure_date">Departure date : </label><input class="form-control" id="departure_date" type="date" name="departure_date" required value="<?php echo $trip->departure_date; ?>" autocomplete="off"/>
          </div>
          <div class="col">
            <label for="return_date">Return date : </label><input class="form-control" id="return_date" type="date" name="return_date" required value="<?php echo $trip->return_date; ?>" autocomplete="off"/><br/>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="number_people">Number of people : </label><input class="form-control" id="number_people" type="number" name="number_people" min="0" value="<?php echo (int)$trip->number_people; ?>" autocomplete="off"/>
          </div>
          <div class="col">
            <label for="total_price">Total trip price : </label><input class="form-control" id="total_price" type="number" name="total_price" placeholder="Enter the trip total price"  min="0" value="<?php echo $trip->total_price; ?>" autocomplete="off"/><br/>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="trip_state">Trip state : </label>
            <select class="form-control" id="trip_state" name="trip_state"  autocomplete="off"/>
              <?php echo Trip::fetchAllTripState($trip->trip_state); ?>
            </select>
          </div>
          <div class="col">
            <label for="transport_type">Transport type : </label>
            <select class="form-control" id="transport_type" name="transport_type"   autocomplete="off"/>
              <?php echo Transport::fetchAllTransportsName($trip->id_transport_type); ?>
            </select><br/>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="description">Trip description : </label>
            <textarea class="form-control" id="description" name="description" placeholder="Enter your trip description" autocomplete="off"/><?php echo $trip->description; ?></textarea><br/>
          </div>
        </div>
        <button type="submit" class="btn btn-warning block-btn" >Update the trip</button>
    </form>
  </div>
</div>

</div>
<?php require('partials/footer.php') ?>
