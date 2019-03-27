<?php
    $title = "View Trip";
    require('partials/header.php');
    require('partials/nav.php');

    echo $trips->displayInfos();

    require('partials/footer.php');
?>
