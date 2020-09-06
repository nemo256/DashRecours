<?php

session_start();

if (isset($_POST['updatePR']))
{
  require_once ('../Classes/Visitor.php');

  $info = array (
    // Session vars to be inserted later!
    'id' => $_SESSION['id'],
    'username' => $_SESSION['username'],

    'nom' => $_POST['nom'],
    'prenom' => $_POST['prenom'],
    'email' => $_POST['email'],
    'pwd' => $_POST['pwd'],
    'pwd2' => $_POST['pwd2'],
    'photo' => $_POST['photo'],
    'updatePR' => true
  );

  $user = new visitor($info);

  $photo = new file($info, 'file', '20000000');
  $info['photo'] = $photo->getFileName();

  if ($_SESSION['TU'] == 'Etudiant')
  {
    require_once ('../Classes/Etudiant.php');

    $info['speciality'] = $_POST['spc'];
    $info['groupe'] = $_POST['groupe'];

    $User = new etudiant($info);
  }
  elseif ($_SESSION['TU'] == 'Enseignant')
  {
    require_once ('../Classes/Enseignant.php');

    $User = new enseignant($info);
  }
  elseif ($_SESSION['TU'] == 'Administrateur')
  {
    require_once ('../Classes/Administrateur.php');

    $User = new administrateur($info);
  }

  $user->update($info['photo']);

  // Moving the actual uploaded file (picture)! //
  $photo->moveFile();

  // Updating infos! //
  $User->update();
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
