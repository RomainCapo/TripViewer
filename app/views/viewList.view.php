<?php
    $title = "View list";
    require('partials/header.php');
    require('partials/nav.php');
?>
<div class="container">
<?php


if(empty($trips))
{
    echo "<h3>You don't have any trip...</h3><a href=\"tripAdd\">Add one</a>";
}
else
{
    echo "<h3>That's all your trips...</h3><a href=\"tripAdd\">Add an another trip !</a><br><br>";
    echo "<form action='exportAllToPdf' method='post' style='display:inline-block'><button class='btn btn-dark' type='submit'/>Export all trip to PDF</button></form><br><br>";
    foreach($trips as $trip)
    {
        echo $trip->asCardShow();
    }
}

?>
</div>
<script type="text/javascript">
  updateNavMenu("ViewTrips");
</script>
<?php require('partials/footer.php') ?>
