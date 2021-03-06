<?php
    $title = "Register";
    require('partials/header.php')
?>
  <div class="background">
    <br><br>
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-2 col-lg-4">
        </div>
        <div class="col-12 col-sm-8 col-lg-4">
        <div class="card border-secondary">
          <div class="card-header"><h2>Register</h2></div>
          <div class="card-body">
            <form action="registerParse" method="post">

                <?php
                if(isset($error_register) && !empty($error_register))
                {
                ?>
                  <div class="alert alert-dismissible alert-danger">
                    <?php
                    foreach ($error_register as $key => $value)
                    {
                      echo $key . " : " . $value . "\n";
                    }
                    ?>
                  </div>
                <?php
                }
                ?>

                <label for="username">Username</label><input class="form-control" id="username" type="text" name="username" required autocomplete="off" autofocus placeholder="Enter your username"/><br/>
                <label for="email">Email</label><input class="form-control" id="email" type="email" name="email" required autocomplete="off" placeholder="Enter your email"/><br/>
                <label for="password">Password</label><input class="form-control" id="password" type="password" name="password" required autocomplete="off" placeholder="Enter your password"/><br/>
                <label for="confirm_password">Confirm password</label><input class="form-control" id="confirm_password" type="password" name="confirm_password" required autocomplete="off" placeholder="Confirm your password"/><br/>
              <button type="submit" class="btn btn-success" >Register</button>
              <p style="margin-top:15px;">Already member ? <a href="login">Login</a>.</p>
            </form>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-2 col-lg-4">
        </div>
    </div>
  </div>
</div>
</div>
