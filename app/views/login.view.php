<?php
    $title = "Login";
    require('partials/header.php')
?>
<div class="background">
  <br><br>
  <div class="container">
    <div class="row">
      <div class="col-12 col-sm-2 col-lg-4">
        </div>
        <div class="col-12 col-sm-8 col-lg-4">
          <div class="card border-secondary mb-3">
            <div class="card-header"><h2>Login</h2></div>
            <div class="card-body">
              <?php
              if(isset($error_login) && !empty($error_login))
              {
              ?>
                <div class="alert alert-dismissible alert-danger">
                  <strong><?php echo $error_login['user'] ?></strong>
                </div>
              <?php
              }
              ?>

              <form action="loginParse" method="post">
                  <label for="username">Username</label><input class="form-control" id="username" type="text" name="username" placeholder="Enter your username" required autocomplete="off" autofocus/><br/>
                  <label for="password">Password</label><input class="form-control" id="password" type="password" name="password" placeholder="Enter your password" required autocomplete="off"/><br/>
                <button type="submit" class="btn btn-success" >Login</button>
                <p style="margin-top:15px;">Not member ? <a href="register">Create an account</a>.</p>
              </form>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-2 col-lg-4">
        </div>
    </div>
  </div>
</div>