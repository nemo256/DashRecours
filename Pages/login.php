<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Log In</title>
    <link rel="icon" href="../Icons/Cap.png">

    <!-- Bootstrap -->
    <link href="../Plugins/css/bootstrap.min.css" rel="stylesheet">
    <meta name="theme-color" content="#563d7c">
    <link rel="stylesheet" href="../Plugins/css/adminlte.min.css">


    <style> .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom style -->
    <link href="../Plugins/css/login.css" rel="stylesheet">
  </head>
  <body class="text-center">

  <form class="form-signin" action="../Include/login.inc.php" method="post">

<?php
if (isset($_SESSION['message'])): ?>
<div style="margin-top: -40px" class="alert alert-<?=$_SESSION['type']?>" role="alert">
<?php
  echo $_SESSION['message'];
  unset($_SESSION['message']);
else: ?>
<div class="alert alert-<?=$_SESSION['type']?> d-none" role="alert">
<?php
endif;
?>
</div>

  <img class="mb-3" src="../Icons/TCap.png" alt="" width="110" height="100">
  <h1 class="h3 mb-4"><b>Dashboard</b> Recours</h1>
  <input type="text" name="username" class="form-control" placeholder="Username / Email" value="<?=$_GET['user']?>">
  <input type="password" name="pwd" class="form-control" placeholder="Password">
  <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Log In</button>
  <p class="mb-2" style="margin-top: 12px;">
    <a href="register.php" class="text-center">Register a new account</a>

<footer class="fixed-bottom">
    <p class="text-muted">&copy; 2019-2020</p>
</footer>

</form>
</body>
</html>

