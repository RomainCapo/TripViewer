<?php
    $title = "Trip add";
    require('partials/header.php');
    require('partials/nav.php');
?>
<div class="container">
  <?php if(isset($error) && $error != '')
        {
    ?>
  <div class="alert alert-dismissible alert-danger">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Error : </strong> <?php echo $error; ?>
  </div>
  <?php }?>

  <div class="card border-secondary mb-3 card-form-add">
    <div class="card-header"><h2>Add a trip</h2></div>
    <div class="card-body">
      <form action="tripAddParse" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        <label for="destination">Destination : </label><input class="form-control" id="destination" type="text" name="destination" placeholder="Enter your destination" required  autocomplete="off" value="<?php if(isset($_POST['destination'])){echo $_POST['destination'];} ?>"/><br/>
        <label for="departure">Departure : </label><input class="form-control" id="departure" type="text" name="departure" placeholder="Enter your departure"  required  autocomplete="off" value="<?php if(isset($_POST['departure'])){echo $_POST['departure'];} ?>"/><br/>
        <label for="trip_name">Trip name : </label><input class="form-control" id="trip_name" type="text" name="trip_name" placeholder="Enter your trip name" required  autocomplete="off" value="<?php if(isset($_POST['trip_name'])){echo $_POST['trip_name'];} ?>"/><br/>
        <div class="row">
          <div class="col">
            <label for="departure_date">Departure date : </label><input class="form-control" id="departure_date" type="date" name="departure_date" required autocomplete="off" value="<?php if(isset($_POST['departure_date'])){echo $_POST['departure_date'];} ?>"/>
          </div>
          <div class="col">
            <label for="return_date">Return date : </label><input class="form-control" id="return_date" type="date" name="return_date" required autocomplete="off" value="<?php if(isset($_POST['return_date'])){echo $_POST['return_date'];} ?>"/><br/>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="number_people">Number of people : </label><input class="form-control" id="number_people" type="number" name="number_people" min="0" autocomplete="off" value="<?php if(isset($_POST['number_people'])){echo $_POST['number_people'];} else {echo '0';} ?>"/>
          </div>
          <div class="col">
            <label for="total_price">Total trip price : </label><input class="form-control" id="total_price" type="number" name="total_price" placeholder="Enter the trip total price"  min="0" value="0" autocomplete="off" value="<?php if(isset($_POST['total_price'])){echo $_POST['total_price'];} else {echo '0';} ?>"/><br/>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="trip_state">Trip state : </label>
            <select class="form-control" id="trip_state" name="trip_state"  autocomplete="off"/>
              <?php if(isset($_POST['trip_state'])){ echo Trip::fetchAllTripState($_POST['trip_state']);}else {echo Trip::fetchAllTripState();} ?>
            </select>
          </div>
          <div class="col">
            <label for="transport_type">Transport type : </label>
            <select class="form-control" id="transport_type" name="transport_type" autocomplete="off"/>
              <?php if(isset($_POST['transport_type'])){ echo Transport::fetchAllTransportsName($_POST['transport_type']);} else {echo Transport::fetchAllTransportsName();} ?>
            </select><br/>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="description">Trip description : </label>
            <textarea class="form-control" id="description" name="description" placeholder="Enter your trip description"  autocomplete="off" /><?php if(isset($_POST['description'])){echo $_POST['description'];} ?></textarea><br/>
          </div>
          <div class="col">
            <label for="photos">Select your 3 best photos : </label><br/>
            <input id="photos" type="file" name="photos[]" class="form-control-file" multiple accept=".png, .jpeg, .jpg, .gif"/><br/><br/>
          </div>
        </div>
        <button type="submit" class="btn btn-success block-btn" >Add the trip</button>
    </form>
  </div>
</div>
</div>
<script type="text/javascript">
  updateNavMenu("AddTrip");
</script>
<script type="text/javascript" src="public/javascript/addForm.js"></script>
<?php require('partials/footer.php') ?>
