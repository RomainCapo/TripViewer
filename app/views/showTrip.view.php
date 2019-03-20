<?php
    $title = "View Trip";
    require('partials/header.php');
    require('partials/nav.php');
?>

<h1><?php echo htmlentities(strtoupper(Trip::getDestinationById($trip['id_destination']))) ?></h1>

<h3 style="color:grey"><?php echo htmlentities($trip['name']) ?></h3>
<p style="color:grey"><strong>From</strong><em> <?php echo htmlentities($trip['departure_date']) ?></em> <strong>to</strong><em> <?php echo htmlentities($trip['return_date']) ?></em></p>

<ul>
    <li>Price : <?php echo htmlentities($trip['total_price']) ?>.-</li>
    <li>Number of people : <?php echo htmlentities($trip['number_people']) ?></li>
    <li>Number of Km : <?php echo htmlentities($trip['km_traveled']) ?> Km</li>
    <li>Departure town : <?php echo htmlentities(Trip::getDestinationById($trip['id_departure'])) ?></li>
    <li>Trip state : <?php echo htmlentities($trip['trip_state']) ?></li>
</ul>


<?php
if(!empty($trip['description']))
{
?>
    <h3>Description of the trip</h3>
    <hr>
    <p><?php echo htmlentities($trip['description']) ?></p>
<?php
}
?>

<?php require('partials/footer.php') ?>
