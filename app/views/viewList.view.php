<?php
    $title = "View list";
    require('partials/header.php');
    require('partials/nav.php');
?>

<?php 

//var_dump($trips); 

if(empty($trips))
{
    echo "<h1>You don't have any trip...</h1><a href=\"tripAdd\">Add one</a>";
}
else
{
    echo "<h1>That's all your trips...</h1><a href=\"tripAdd\">Add an another trip !</a><br><br>";
}

foreach($trips as $trip)
{
    echo $trip->asCardShow();
}

?>

<?php require('partials/footer.php') ?>