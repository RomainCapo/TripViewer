<?php
    $title = "Login";
    require('partials/header.php')
?>

<div class="background">

  <div class="card border-secondary mb-3 card-form">
    <div class="card-header">Login</div>
    <div class="card-body">
      <form action="loginParse" method="post">
          <label for="username">Username</label><input class="form-control" id="username" type="text" name="username" required autocomplete="off"/><br/>
          <label for="password">Password</label><input class="form-control" id="password" type="password" name="password" required autocomplete="off"/><br/>
        <button type="submit" class="btn btn-success" >Login</button>   
        <p style="margin-top:15px;">Not member ? <a href="register">Create an account</a>.</p>
      </form>
    </div>
  </div>

</div>

