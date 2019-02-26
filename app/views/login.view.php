<?php
    $title = "Login";
    require('partials/header.php')
?>
<h1>Login</h1>

<form action="login" method="post">
  <div class="form-group">
    <label for="username">Username : </label><input class="form-control" id="username" type="text" name="username" required autocomplete="off"/><br/>
  </div>
  <div class="form-group">
    <label for="password">Password : </label><input class="form-control" id="password" type="password" name="password" required autocomplete="off"/><br/>
  </div>
  <button type="button" class="btn btn-success" >Login</button>





</form>

<?php require('partials/footer.php') ?>
