<?php
    $title = "Login";
    require('partials/header.php')
?>

<div class="background">

  <div class="card border-secondary mb-3 card-form">
    <div class="card-header">Login</div>
    <div class="card-body">
      <form action="login" method="post">
        <div class="form-group">
          <label for="username">Username : </label><input class="form-control" id="username" type="text" name="username" required autocomplete="off"/><br/>
        </div>
        <div class="form-group">
          <label for="password">Password : </label><input class="form-control" id="password" type="password" name="password" required autocomplete="off"/><br/>
        </div>
        <button type="button" class="btn btn-success" >Login</button>   
        <br> 
        <p>Not member ? <a href="#">Create an account</a>.</p>
      </form>
    </div>
  </div>

</div>

