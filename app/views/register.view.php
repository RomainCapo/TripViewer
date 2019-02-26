<?php
    $title = "Register";
    require('partials/header.php')
?>

<div class="background">

  <div class="card border-secondary mb-3 card-form">
    <div class="card-header"><h2>Register</h2></div>
    <div class="card-body">
      <form action="registerParse" method="post">
          <label for="username">Username</label><input class="form-control" id="username" type="text" name="username" required autocomplete="off"/><br/>
          <label for="email">Email</label><input class="form-control" id="email" type="text" name="email" required autocomplete="off"/><br/>
          <label for="password">Password</label><input class="form-control" id="password" type="password" name="password" required autocomplete="off"/><br/>
          <label for="confirm_password">Confirm password</label><input class="form-control" id="confirm_password" type="password" name="confirm_password" required autocomplete="off"/><br/>
        <button type="submit" class="btn btn-success" >Register</button>   
        <p style="margin-top:15px;">Already member ? <a href="login">Login</a>.</p>
      </form>
    </div>
  </div>

</div>

