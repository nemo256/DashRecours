<?php

session_start();

if (isset($_POST['submit']))
{
  require_once ('../Classes/Visitor.php');

  $userInfo = array (
    // Session vars to be inserted later!
    'idadm' => $_SESSION['id'],

    'nom' => $_POST['nom'],
    'prenom' => $_POST['prenom'],
    'matricule' => $_POST['matricule'],
    'username' => 'AD' . $_POST['nom'] . $_POST['prenom'],
    'email' => $_POST['nom'] . $_POST['prenom'] . '@mail.com',
    'type' => $_POST['TU'],
    'sexe' => $_POST['sexe'],
    'ddn' => '00-00-0000',
    'adresse' => 'NoAddress',
    'tel' => '000000000',
    'photo' => $_POST['photo'],
    'updatePR' => true
  );

  $visInfo = array ( // `vis` references `Visitor` \ `user`
    'nom' => $_POST['nom'],
    'prenom' => $_POST['prenom'],
    'username' => 'AD' . $_POST['nom'] . $_POST['prenom'],
    'email' => $_POST['nom'] . $_POST['prenom'] . '@mail.com',
    'pwd' => $_POST['pwd'],
    'pwd2' => $_POST['pwd2'],
    'photo' => $_POST['photo'],
    'location' => 'P'
  );

  $photo = new file($userInfo, 'file', '20000000');
  $userInfo['photo'] = $photo->getFileName();

  if (isset($_GET['update']))
    $visInfo['id'] = $userInfo['id'] = $_GET['update'];

  $vis = new visitor($visInfo);

  // Getting id to be inserted on!
  if (!isset($_GET['update']))
    $userInfo['id'] = $userInfo['id'] = $vis->getId();

  if ($userInfo['type'] == "Etudiant")
  {
    require_once ('../Classes/Etudiant.php');

    $userInfo['speciality'] = $_POST['spc'];
    $userInfo['groupe'] = $_POST['groupe'];

    $user = new etudiant($userInfo);
  }
  else if ($userInfo['type'] == "Enseignant")
  {
    require_once ('../Classes/Enseignant.php');

    $userInfo['deplome'] = $_POST['dep'];
    $userInfo['grade'] = $_POST['grade'];

    $user = new enseignant($userInfo);
  }
  else
    redirect (
      $GLOBALS['MSG']['CT'], 
      'warning', 
      $GLOBALS['LOC']['P'], 
      '?nom='.$userInfo['nom'].'&prenom='.$userInfo['prenom'].'&sex='.$userInfo['sexe'].'&matricule='.$userInfo['matricule']
    );

  // Moving the actual uploaded file (picture)! //
  $photo->moveFile();

  // (Updating / Inserting) infos! //
  if (isset($_GET['update']))
  {
    $vis->update($userInfo['photo']);
    $user->update();
  }
  else
  {
    $vis->insert();
    $user->insert();
    $user->updateUsers();
  }
}

else if (isset($_GET['delete']))
{
  require_once ('../Classes/Administrateur.php');

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
