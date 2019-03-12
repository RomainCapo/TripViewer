<?php
    $title = "View list";
    require('partials/header.php');
    require('partials/nav.php');
?>

<?php 

//var_dump($trips); 

foreach($trips as $trip)
{
    echo $trip->asCardShow();
}

?>

<?php require('partials/footer.php') ?>