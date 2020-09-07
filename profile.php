<?php

$thisFileName = basename(__FILE__);
require_once (dirname(__FILE__) . '/Pages/header.php');
require_once (dirname(__FILE__) . '/Classes/Recours.php');

if ($_SESSION['TU'] == 'Etudiant')
{
  require_once (dirname(__FILE__) . '/Classes/Enseignant.php');

  // For generating recours info //
  $rec = new recours($id);
  $rec = $rec->getAllRecoursET();
  // Pour generer le nombre totale des recours soumis par cette etudiant //
  $nbrRecours = count($rec);

  // Pour la table CRUD des recours! //
  foreach ($rec as $key => $recours)
    if ($recours['statusET'] == 'show')
      $recToShow[$key] = $recours;

  if (isset($_GET['view']))
  {
    $idrec = $_GET['view'];

    if (checkNum($idrec))
    {
      $_SESSION['message'] = '<b>Accessing that page is not permitted!</b>';
      $_SESSION['type'] = "danger";
      unset($_GET['view']);
    }

    else
    {
      $viewRec = new recours($idrec);
      $viewRec = $viewRec->getRecours();

      if (empty($viewRec))
      {
        $_SESSION['message'] = '<b>You have no permission to view this page!</b>';
        $_SESSION['type'] = "danger";
        unset($_GET['view']);
      }

      else if (!strcmp($viewRec['statusET'], 'hide'))
      {
        $_SESSION['message'] = '<b>Recours has been deleted by you!</b>';
        $_SESSION['type'] = "danger";
        unset($_GET['view']);
      }

      else
      {
        $ENSV = new enseignant($viewRec['idens']);
        $ENSV = $ENSV->getInfo();
      }
    }
  }

  if (isset($_GET['update']))
  {
    $idrec = $_GET['update'];

    if (checkNum($idrec))
    {
      $_SESSION['message'] = '<b>Accessing that page is not permitted!</b>';
      $_SESSION['type'] = "danger";
      unset($_GET['update']);
    }

    else
    {
      $update = new recours($idrec);
      $update = $update->getRecours();

      if (empty($update))
      {
        $_SESSION['message'] = '<b>You have no permission to view this page!</b>';
        $_SESSION['type'] = "danger";
        unset($_GET['update']);
      }

      else if ($_SESSION['id'] != $update['idet'])
      {
        $_SESSION['message'] = '<b>You have no permission!</b>';
        $_SESSION['type'] = "danger";

        header("Location: ../profile.php?errorupdate");
        unset($_GET['update']);
      }

      else if (!strcmp($update['statusET'], 'hide'))
      {
        $_SESSION['message'] = '<b>You have deleted this recours, you cannot modify it!</b>';
        $_SESSION['type'] = "danger";
        unset($_GET['update']);
      }

      else if (!strcmp($update['status'], 'Valid&eacute;'))
      {
        $_SESSION['message'] = '<b>Recours already validated, you cannot modify it!</b>';
        $_SESSION['type'] = "danger";
        unset($_GET['update']);
      }

      else if (!strcmp($update['status'], 'Refus&eacute;'))
      {
        $_SESSION['message'] = '<b>Recours already refused, you cannot modify it!</b>';
        $_SESSION['type'] = "danger";
        unset($_GET['update']);
      }

      else
      {
        $module = $update['module'];
        $typeE = $update['typeE']; 
        $emailens = $update['emailens'];
        $desc = $update['description'];
      }
    }
  }
}

else if ($_SESSION['TU'] == 'Enseignant')
{
  require_once (dirname(__FILE__) . '/Classes/Etudiant.php');

  // For generating recours info //
  $rec = new recours($id);
  $rec = $rec->getAllRecoursENS();
  // Pour generer le nombre totale des recours soumis par cette etudiant //
  $nbrRecours = count($rec);

  // Pour la table CRUD des recours! //
  foreach ($rec as $key => $recours)
    if ($recours['statusENS'] == 'show')
    {
      if ($recours['status'] == 'En Cours')
        $recNonTreated[$key] = $recours;
      elseif ($recours['status'] == 'Valid&eacute;')
        $recValidated[$key] = $recours;
      elseif ($recours['status'] == 'Refus&eacute;')
        $recRefused[$key] = $recours;
    }

  // Viewing the recours! //
  if (isset($_GET['view']))
  {
    $idrec = $_GET['view'];

    if (checkNum($idrec))
    {
      $_SESSION['message'] = '<b>Accessing that page is not permitted!</b>';
      $_SESSION['type'] = "danger";
      unset($_GET['view']);
    }

    else
    {
      $viewRec = new recours($idrec);
      $viewRec = $viewRec->getRecours();

      if (empty($viewRec))
      {
        $_SESSION['message'] = '<b>You have no permission to view this page!</b>';
        $_SESSION['type'] = "danger";
        unset($_GET['view']);
      }

      else if (!strcmp($viewRec['statusENS'], 'hide'))
      {
        $_SESSION['message'] = '<b>Recours has been deleted by you or the student before refusing or validating!</b>';
        $_SESSION['type'] = "danger";
        unset($_GET['view']);
      }

      else
      {
        $ETV = new etudiant($viewRec['idet']);
        $ETV = $ETV->getInfo();
      }
    }
  }
}

else if ($_SESSION['TU'] == 'Administrateur') 
{
  require_once (dirname(__FILE__) . '/Classes/Visitor.php');
  require_once (dirname(__FILE__) . '/Classes/Etudiant.php');
  require_once (dirname(__FILE__) . '/Classes/Enseignant.php');

  // For generating users info //
  $allUsers = new visitor($id);
  $allUsers = $allUsers->getUsers();

  // Pour la table CRUD des utilisateurs! //
  foreach ($allUsers as $key => $user)
    if ($user['username'] != 'dummyUser' && !empty($user['type']) && $user['type'] != 'Administrateur' && $user['auth'] != 'Unauthorized')
      $users[$key] = $user;

  if (isset($_GET['view']))
  {
    $iduser = $_GET['view'];

    if (checkNum($iduser))
    {
      $_SESSION['message'] = '<b>Accessing that page is not permitted!</b>';
      $_SESSION['type'] = "danger";
      unset($_GET['view']);
    }
    else
    {
      // Fetching user info! //
      foreach ($users as $user)
        if ($iduser == $user['id'])
        {
          if ($user['type'] == 'Etudiant')
            $viewUser = new etudiant($iduser);
          elseif ($user['type'] == 'Enseignant')
            $viewUser = new enseignant($iduser);
        }

      if (isset($viewUser))
        $viewUser = $viewUser->getInfo();

      // Verifying user info! //
      if (!isset($viewUser) || empty($viewUser))
      {
        $_SESSION['message'] = '<b>You have no permission to view this page!</b>';
        $_SESSION['type'] = "danger";
        unset($_GET['view']);
      }
    }
  }

  if (isset($_GET['update']))
  {
    $iduser = $_GET['update'];

    if (checkNum($iduser))
    {
      $_SESSION['message'] = '<b>Accessing that page is not permitted!</b>';
      $_SESSION['type'] = "danger";
      unset($_GET['update']);
    }

    else
    {
      // Fetching user info! //
      foreach ($users as $user)
        if ($iduser == $user['id'])
        {
          if ($user['type'] == 'Etudiant')
          {
            $type = 'Etudiant';
            $viewUser = new etudiant($iduser);
          }
          elseif ($user['type'] == 'Enseignant')
          {
            $type = 'Enseignant';
            $viewUser = new enseignant($iduser);
          }
        }

      if (isset($viewUser))
        $viewUser = $viewUser->getInfo();

      // Verifying user info! //
      if (!isset($viewUser) || empty($viewUser) || !isset($type))
      {
        $_SESSION['message'] = '<b>You have no permission to view this page!</b>';
        $_SESSION['type'] = "danger";
        unset($_GET['update']);
      }
    }
  }
}



?>

<!-- Main content -->
<section class="content mt-3">
  <div class="container-fluid">

<!-- Session Message -->
<?php
if (isset($_SESSION['message'])): ?>
<div class="alert alert-<?=$_SESSION['type']?> alert-dismissible fade show" role="alert">
<?php
  if (!strcmp($_SESSION['type'], 'danger')) echo '<i class="icon fas fa-ban"></i>' . $_SESSION['message'];
  if (!strcmp($_SESSION['type'], 'warning')) echo '<i class="icon fas fa-exclamation-triangle"></i>' . $_SESSION['message'];
  if (!strcmp($_SESSION['type'], 'success')) echo '<i class="icon fas fa-check"></i>' . $_SESSION['message'];
  unset($_SESSION['message']);
else: ?>
<div class="alert alert-<?=$_SESSION['type']?> alert-dismissible fade show d-none" role="alert">
<?php
endif;
?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<!-- /Session Message -->

<!-- Redirecting not fully registered users! -->
<?php if (!isset($_SESSION['TU'])): ?>
  <!-- Default box -->
  <div class="card card-warning mt-3">
    <div class="card-header">
      <h3 class="card-title"><b>Registration</b></h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
          <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    <div class="card-body">
      You have to continue your full registration to access this page with it's extra functionalies!
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <a class="btn btn-warning btn-outline" href="./registerFULL.php">
        Register
      </a>
    </div>
    <!-- /.card-footer-->
  </div>
  <!-- /.card -->
<?php endif; ?>

<!-- ET -->
<?php if ($_SESSION['TU'] == "Etudiant")
        require_once ('./Pages/profileET.php');
?>
<!-- /ET -->

<!-- ENS -->
<?php if ($_SESSION['TU'] == "Enseignant")
        require_once ('./Pages/profileENS.php');
?>
<!-- /ENS -->

<!-- ADM -->
<?php if ($_SESSION['TU'] == "Administrateur")
        require_once ('./Pages/profileADM.php');
?>
<!-- /ADM -->

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?php
    require './Pages/footer.php';
?>
