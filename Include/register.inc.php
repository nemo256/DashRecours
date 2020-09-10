<?php

session_start();

if (isset($_POST['submit']))
{
  require_once ('../Classes/Visitor.php');

  $info = array(
    'username' => $_POST['username'],
    'email' => $_POST['email'],
    'pwd' => $_POST['pwd'],
    'pwd2' => $_POST['pwd2']
  );

  $vis = new visitor($info);

  $vis->insert();
}

else
{
  require_once ('main.php');
  redirect (
    $GLOBALS['MSG']['AD'], 
    'danger', 
    $GLOBALS['LOC']['R'], 
    '?accessDenied'
  );
}

?>
