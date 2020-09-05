<?php

session_start();

if (isset($_GET['validate']))
{
  require_once ('../Classes/Recours.php');

  $rec = new recours($_GET['validate']);

  $rec->validate();
}

else if (isset($_GET['refuse']))
{
  require_once ('../Classes/Recours.php');

  $rec = new recours($_GET['refuse']);

  $rec->refuse();
}

else if (isset($_GET['delete']))
{
  require_once ('../Classes/Recours.php');

  $rec = new recours($_GET['delete']);

  $rec->delete();
}


else
{
  require_once ('main.php');
  redirect (
    $GLOBALS['MSG']['AD'], 
    'danger', 
    $GLOBALS['LOC']['P'], 
    '?accessDenied'
  );
}



?>
