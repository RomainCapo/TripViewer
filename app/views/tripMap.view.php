<?php
$title = "Map View";
require('partials/header.php');
?>
<!--<div id="map"></div>-->
<input id="test" type="submit" name="" value="test">

<script>
  var map;

  function getAllTripCoord(){
    $('#test').click(function(){
      $.ajax({
        type: 'POST',
        url: 'ajax',
        dataType: 'json'
      }).done(function(data){
        console.log(data);
      });
    });
  }

  getAllTripCoord();


  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: -34.397, lng: 150.644},
      zoom: 8
    });
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARzT7-H1PY8YapJo-Os6iJE1AU7QWLb8s&callback=initMap" async defer></script>
<?php require('partials/footer.php') ?>
