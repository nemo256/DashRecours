<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register a new account</title>
    <link rel="icon" href="../Icons/Cap.png">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../Plugins/css/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../Plugins/css/adminlte.min.css">
    <!-- Custom style -->
    <link rel="stylesheet" href="../Plugins/css/register.css">
  </head>
<body class="hold-transition register-page text-center align-items-center justify-content-center">

<div class="register-box">

<?php if (isset($_SESSION['message'])): ?>
<div style="margin-top: 11px; margin-bottom: -8px" class="alert alert-<?=$_SESSION['type']?>" role="alert">
<?php
  echo $_SESSION['message'];
  unset($_SESSION['message']);
  else: ?>
<div class="alert alert-<?=$_SESSION['type']?> d-none" role="alert">
<?php
  endif;
?>
</div>

  <div class="register-logo">
    <h1 class="h2 mb-3 mt-3"><b>Dashboard</b> Recours</h1>
  </div>

  <div class="card" style="max-width: 380px">
    <div class="card-body register-card-body" style="max-width: 370px; border-radius: 15px">
      <p class="login-box-msg text-lg">Register a new account</p>

      <form id="form" class="form" action="../Include/register.inc.php" method="post">
        <div class="input-group mb-3">
        <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?=$_GET['user']?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div id="errorUsername" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
        <div class="input-group mb-3">
        <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="<?=$_GET['mail']?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div id="errorEmail" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
        <div class="input-group mb-3">
          <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div id="errorPwd" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
        <div class="input-group mb-3">
          <input type="password" name="pwd2" id="pwd2" class="form-control" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div id="errorPwd2" class="text-red text-sm ml-1 mb-4" style="margin-top: -12px"></div>
        <div class="row">
          <div class="col-5">
            <a href="login.php" class="text-center mb-2">I already have an account</a>
          </div>
          <div class="col-2 sep">Or</div>
          <!-- /.col -->
          <div class="col-5">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<script src="../Plugins/js/register.js"></script>
</body>
</html>
