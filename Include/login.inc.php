<?php

session_start();

if (isset($_POST['submit']))
{
  require_once ('../Classes/Login.php');

  $info = array(
    'username' => $_POST['username'],
    'pwd' => $_POST['pwd'],
  );

  $log = new login($info);
}

else
{
  require_once ('main.php');
  redirect (
    $GLOBALS['MSG']['AD'], 
    'danger', 
    $GLOBALS['LOC']['L'], 
    '?accessDenied'
  );
}

?>
