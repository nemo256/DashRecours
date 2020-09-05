<?php

session_start();

session_unset();

session_destroy();

if (isset($_GET['passwordChanged']))
{
  require_once ('main.php');
  session_start();

  redirect (
    $GLOBALS['MSG']['PC'], 
    'warning', 
    $GLOBALS['LOC']['L'], 
    '?passwordChanged'
  );
}

header('Location: ../Pages/login.php');

?>
