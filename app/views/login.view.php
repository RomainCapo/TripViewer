<?php
    $title = "Login";
    require('partials/header.php')
?>
<h1>Login</h1>

<form action="login" method="post">
  <label for="username">Username : </label><input id="username" type="text" name="username" required /><br/>
  <label for="password">Password : </label><input id="password" type="password" name="password" required /><br/>
  <input type="submit" value="Login">
</form>

<?php require('partials/footer.php') ?>
