<?php

session_start();

if (isset($_POST['submit']))
{
  require_once ('main.php');

  $info = array(
    // Session vars to be inserted later!
    'id' => $_SESSION['id'],
    'username' => $_SESSION['username'],

    'nom' => $_POST['nom'],
    'prenom' => $_POST['prenom'],
    'email' => $_POST['email'],
    'ddn' => $_POST['ddn'],
    'type' => $_POST['TU'],
    'sexe' => $_POST['sex'],
    'adresse' => $_POST['add'],
    'tel' => $_POST['tel']
  );

  // Inserting photo here! //
  $photo = new file($info, 'file', '20000000');
  $info['photo'] = $photo->getFileName();

  if ($info['type'] == "Etudiant")
  {
    require_once ('../Classes/Etudiant.php');

    $info['matricule'] = $_POST['idet'];
    $info['speciality'] = $_POST['spc'];
    $info['groupe'] = $_POST['groupe'];

    $user = new etudiant($info);
  }
  else if ($info['type'] == "Enseignant")
  {
    require_once ('../Classes/Enseignant.php');

    $info['matricule'] = $_POST['idens'];
    $info['deplome'] = $_POST['dep'];
    $info['grade'] = $_POST['grade'];

    $user = new enseignant($info);
  }
  else if ($info['type'] == "Administrateur")
  {
    require_once ('../Classes/Administrateur.php');

    $info['matricule'] = $_POST['idadm'];
    $info['poste'] = $_POST['poste'];

    $user = new administrateur($info);
  }
  else
    redirect (
      $GLOBALS['MSG']['CT'], 
      'warning', 
      $GLOBALS['LOC']['RF'], 
      '?nom='.$info['nom'].'&prenom='.$info['prenom'].'&ddn='.$info['ddn'].'&sex='.$info['sexe'].'&add='.$info['adresse'].'&tel='.$info['tel']
    );

  // moving photo to 'Pics/' directory! //
  $photo->moveFile();

  /* Insertion of the new user! */
  $user->insert();
  $user->updateUsers();
}

else
{
  require_once ('main.php');
  redirect (
    $GLOBALS['MSG']['AD'], 
    'danger', 
    $GLOBALS['LOC']['I'], 
    '?accessDenied'
  );
}

?>
