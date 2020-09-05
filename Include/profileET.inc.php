<?php

session_start();

if (isset($_POST['submitET']))
{
  require_once ('../Classes/Etudiant.php');
  require_once ('../Classes/Recours.php');

  $info = array (
    // Session vars to be inserted later!
    'idet' => $_SESSION['id'],

    'emailens' => $_POST['emailens'],
    'module' => $_POST['module'],
    'typeE' => $_POST['typeE'],
    'desc' => $_POST['desc'],
    'status' => 'En Cours',
    'dateR' => date('F')
  );

  $ET = new etudiant($info['idet']);
  $fileNameInfo = $ET->getInfo();

  $fileNameInfo['module'] = $info['module'];
  $fileNameInfo['typeE'] = $info['typeE'];

  // Inserting file attached here! //
  $attachment = new file($fileNameInfo, 'attachment', '20000000');
  $info['attachment'] = $attachment->getFileName();

  if (isset($_GET['update']))
    $info['id'] = $_GET['update'];

  $rec = new recours($info);

  $attachment->moveFile();

  isset($_GET['update']) ? $rec->update() : $rec->insert();
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
