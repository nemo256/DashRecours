<?php

session_start();

if (isset($_POST['submit']))
{
  require_once ('../Classes/Administrateur.php');
  require_once ('../Classes/Etudiant.php');
  require_once ('../Classes/Enseignant.php');

  $info = array (
    // Session vars to be inserted later!
    'idadm' => $_SESSION['id'],

    'nom' => $_POST['nom'],
    'prenom' => $_POST['prenom'],
    'matricule' => $_POST['matricule'],
    'TU' => $_POST['TU'],
    'sexe' => $_POST['sexe'],
    'pwd' => $_POST['pwd'],
    'pwd2' => $_POST['pwd2'],
    'photo' => $_POST['photo'],
    'updatePR' => true
  );

  if (isset($_POST['spc']))
    $info['speciality'] = $_POST['spc'];
  if (isset($_POST['groupe']))
    $info['groupe'] = $_POST['groupe'];
  if (isset($_POST['dep']))
    $info['deplome'] = $_POST['dep'];
  if (isset($_POST['grade']))
    $info['grade'] = $_POST['grade'];

  $photo = new file($info, 'file', '20000000');
  $info['photo'] = $photo->getFileName();

  print_r($info);



//  $ET = new etudiant($info['idet']);
//  $fileNameInfo = $ET->getInfo();
//
//  $fileNameInfo['module'] = $info['module'];
//  $fileNameInfo['typeE'] = $info['typeE'];
//
//  // Inserting file attached here! //
//  $attachment = new file($fileNameInfo, 'attachment', '20000000');
//  $info['attachment'] = $attachment->getFileName();
//
//  if (isset($_GET['update']))
//    $info['id'] = $_GET['update'];
//
//  $rec = new recours($info);
//
//  $attachment->moveFile();
//
//  isset($_GET['update']) ? $rec->update() : $rec->insert();
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
