<?php
$title = "Map View";
require('partials/header.php');
require('partials/nav.php');
?>
<div class="container" style="height:70%; width:100%;" id="map_container">
  <h1>Trips maps view</h1><br/>
  <h5 class='card-subtitle mb-2 text-muted'>Clic on marker to display trip infos !</h5><br>
  <div id="map"></div>
  <p>
    <ul id="markerInfo">
      <li><img src="public/img/red-dot.png" alt="red_marker"> Realized trips</li>
      <li><img src="public/img/green-dot.png" alt="green_marker"> Reserved trips</li>
      <li><img src="public/img/blue-dot.png" alt="blue_marker"> Planned trips</li>
    </ul>
  </p>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyARzT7-H1PY8YapJo-Os6iJE1AU7QWLb8s&callback=initMap" async defer></script>
  <script src="public/javascript/maps.js"></script>
</div>
<script type="text/javascript">
  updateNavMenu("Maps");
</script>
<?php require('partials/footer.php') ?>
