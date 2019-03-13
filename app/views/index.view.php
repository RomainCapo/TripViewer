<?php
    $title = "Home";
    require('partials/header.php');
    require('partials/nav.php');    
?>

<?php if(isset($_SESSION['login'])) { ?>

    <h1>Hi <?php echo unserialize($_SESSION['login'])->getPseudo(); ?> !</h1>

<?php } ?>

<h3 style="color:grey"><strong>Welcome to TripViewer.</strong></h3>

<br><br>
<blockquote class="blockquote text-center">
  <p class="mb-0">"The use of traveling is to regulate imagination by reality, and instead of thinking how things may be, to see them as they are"</p>
  <footer class="blockquote-footer">Samuel Johnson</footer>
</blockquote>
<br><br>





