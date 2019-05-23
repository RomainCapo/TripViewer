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
  <br>
  <?php if(isset($_SESSION['login'])) { ?>

      <h1>Hi <?php echo htmlentities(unserialize($_SESSION['login'])->getPseudo()); ?> !</h1>

  <?php } ?>

  <h3 style="color:grey"><strong>Welcome to TripViewer.</strong></h3>

  <br><br>
  <blockquote class="blockquote text-center">
    <p class="mb-0">"The use of traveling is to regulate imagination by reality, and instead of thinking how things may be, to see them as they are"</p>
    <footer class="blockquote-footer">Samuel Johnson</footer>
  </blockquote>
  <br><br>
  <div class="row">
    <?php if(!isset($_SESSION['login'])){
      echo '<a class="btn btn-success " href="login">Login here</a><span id="space"></span>';
      echo '<a class="btn btn-success " href="register">Register here</a>';
    }?>
  </div>
</div>
<script type="text/javascript">
  updateNavMenu("Home");
</script>

<?php
  require('partials/footer.php');
?>
