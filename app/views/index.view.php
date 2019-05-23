<?php
  $title = "Home";

  if(isset($_SESSION['login']))
  {
    require('partials/nav.php');
  }
  require('partials/header.php');
?>

<div class="container">
  <br>
  <?php if(isset($_SESSION['login'])) { ?>

      <h1>Hi <?php echo htmlentities(unserialize($_SESSION['login'])->getPseudo()); ?> !</h1><br>

  <?php } ?>

  <!--<h3 style="color:grey"><strong>Welcome to TripViewer.</strong></h3>-->

  <div class="jumbotron">
    <h1 class="display-4">Welcome to TripViewer.</h1>
    <p class="lead">You can add a trip, give it a name, added some pictures and see it on a map.</p>
    <hr class="my-4">
    <p>You'll will never forget a trip by using this application.</p>

    <?php if(!isset($_SESSION['login'])){
      echo '<a class="btn btn-success" href="login" role="button">Login here</a><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>';
      echo '<a class="btn btn-success" href="register" role="button">Register here</a>';
    }?>
  </div>

  <br><br>
  <blockquote class="blockquote text-center">
    <p class="mb-0">"The use of traveling is to regulate imagination by reality, and instead of thinking how things may be, to see them as they are"</p>
    <footer class="blockquote-footer">Samuel Johnson</footer>
  </blockquote>
  <br><br>
  <div class="row">
    
  </div>
</div>
<script type="text/javascript">
  updateNavMenu("Home");
</script>

<?php
  require('partials/footer.php');
?>
