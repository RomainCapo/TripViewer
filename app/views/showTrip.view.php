<?php
    $title = "View Trip";
    require('partials/header.php');
    require('partials/nav.php');
?>
<div class="container">
    <?php echo $trips->displayInfos(); ?>
</div>
<script type="text/javascript">
  updateNavMenu("ViewTrips");
</script>

<?php
    require('partials/footer.php');
?>
