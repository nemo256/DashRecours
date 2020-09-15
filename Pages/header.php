<?php

session_start();

if (!isset($_SESSION['id']))
{
  header("Location: ./Pages/login.php");
  exit();
}

else
{
  require_once ('.workingDir.info.php');
  basename(dirname(__FILE__)) != $projectDir ?
    $level = 2 :
    $level = 1;

  require_once (dirname(__FILE__, $level) . '/Include/db.php');
  require_once (dirname(__FILE__, $level) . '/Include/main.php');

  if ($thisFileName == 'registerFULL.php' && isset($_SESSION['TU']))
  {
    header ('Location: ./index.php');
    exit;
  }
  if ($thisFileName == 'trafic.php' && $_SESSION['TU'] != 'Administrateur')
  {
    header ('Location: ./index.php');
    exit;
  }

  // For generating Profile pic //
  $id = $_SESSION['id'];

  if ($thisFileName == 'index.php') { $pageName = 'Accueil'; $titleName = 'Dashboard Recours'; }
  else if ($thisFileName == 'profile.php') { $pageName = 'My Profile'; $titleName = $pageName; }
  else if ($thisFileName == 'dashboard.php') { $pageName = 'Dashboard'; $titleName = $pageName; }
  else if ($thisFileName == 'charts.php') { $pageName = 'Graphiques'; $titleName = $pageName; }
  else if ($thisFileName == 'contact.php') { $pageName = 'Contactez-nous'; $titleName = $pageName; }
  else if ($thisFileName == 'registerFULL.php') { $pageName = 'Registration'; $titleName = $pageName; }
  else if ($thisFileName == 'trafic.php') { $pageName = 'Traffic'; $titleName = $pageName; }

  if ($thisFileName == 'dashboard.php' || $thisFileName == 'charts.php')
  {
    require_once (dirname(__FILE__, $level) . '/Classes/Visitor.php');
    require_once (dirname(__FILE__, $level) . '/Classes/Recours.php');
    // Vars Instantiation, for dashboard and charts pages //
    $nbrEtudiant = 0;
    $nbrEnseignant = 0;
    $nbrAdministrateur = 0;
    $nbrUtilisateur = 0;
    $nbrVisiteur = 0;
    $nbrRecours = 0;
    $nbrRecoursValide = 0;
    $nbrRecoursRefuse = 0;
    $nbrRecoursEnCours = 0;

    $vis = new visitor(-1);
    $users = $vis->getUsers();

    foreach ($users as $key => $user)
    {
        if ($user['type'] == 'Etudiant') $nbrEtudiant++;
        elseif ($user['type'] == 'Enseignant') $nbrEnseignant++;
        elseif ($user['type'] == 'Administrateur') $nbrAdministrateur++;
        else $nbrVisiteur++;
        $nbrUtilisateur++;
    }
    // For generating recours info // 
    $rec = new recours(-1);
    $recours = $rec->getAllRecours();

    foreach ($recours as $key => $row)
    {
        if ($row['status'] == 'En Cours') $nbrRecoursEnCours++;
        elseif($row['status'] == 'Valid&eacute;') $nbrRecoursValide++;
        elseif ($row['status'] == 'Refus&eacute;') $nbrRecoursRefuse++;
        $nbrRecours++;
    }

    // Round to get only 2 digits after floating point //
    $nbrRecoursEnCoursPerc = round($nbrRecoursEnCours / $nbrRecours, 4) * 100;
    $nbrRecoursValidePerc = round($nbrRecoursValide / $nbrRecours, 4) * 100;
    $nbrRecoursRefusePerc = round($nbrRecoursRefuse / $nbrRecours, 4) * 100;
  }

  // Getting infos regarding each user! //
  if ($_SESSION['TU'] == 'Etudiant')
  {
    require_once (dirname(__FILE__, $level) . '/Classes/Etudiant.php');
    $user = new etudiant($id);
    $info = $user->getInfo();
  }
  else if ($_SESSION['TU'] == "Enseignant")
  {
    require_once (dirname(__FILE__, $level) . '/Classes/Enseignant.php');
    $user = new enseignant($id);
    $info = $user->getInfo();
  }
  else if ($_SESSION['TU'] == "Administrateur")
  {
    require_once (dirname(__FILE__, $level) . '/Classes/Administrateur.php');
    $user = new administrateur($id);
    $info = $user->getInfo();
  }

  else { $info['nom'] = $_SESSION['username']; $info['prenom'] = ''; }

  if (empty($info['photo']) || $info['photo'] == '<null>') $photo = './Icons/account2.png';
  else $photo = './Pics/' . $info['photo'];

  if ($thisFileName == 'trafic.php')
  {
    require_once (dirname(__FILE__, $level) . '/Classes/Etudiant.php');
    require_once (dirname(__FILE__, $level) . '/Classes/Enseignant.php');
    require_once (dirname(__FILE__, $level) . '/Classes/Recours.php');

    $recours = new recours(-1);
    $recours = $recours->getAllRecours();

    foreach ($recours as $key => $REC)
      if ($REC['module'] != 'dummyModule')
        $recs[$key] = $REC;
  }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$titleName?></title>
  <link rel="icon" href="./Icons/Cap.png">

  <!-- Ajax for multiple select -->
  <script type="text/javascript" src="./Plugins/js/ajax.min.js"></script>
  <!-- Ionicons -->
  <link rel="stylesheet" href="./Plugins/css/ionicons-2.0.1/css/ionicons.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="./Plugins/css/source-sans-pro-font/google-font.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="./Plugins/css/fontawesome-free/css/all.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="./Plugins/css/tempusdominus-bootstrap-4.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="./Plugins/css/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="./Plugins/css/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./Plugins/css/adminlte.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="./Plugins/css/daterangepicker.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="./Plugins/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="./Plugins/css/responsive.bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="./Plugins/css/summernote-bs4.min.css">
</head>

<!-- For multiple new options when selecting between users (registerFULL.php) -->
<?php if ($thisFileName == 'registerFULL.php'): ?>
<script>
  $(document).ready(function(){
  var options="";
  $("#select").on('change',function(){
      var value=$(this).val();
      if(value=="Etudiant")
      {
          options='<div class="form-group">'
+'          <label>Matricule<span class="text-red ml-1">*</span></label>'
+'          <div class="input-group mb-3">'
+'            <div class="input-group-prepend">'
+'              <span class="input-group-text"><i class="fas fa-id-card"></i></span>'
+'            </div>'
+'            <input type="text" name="idet" class="form-control" placeholder="17172102983" value="">'
+'          </div>'
+'        </div>'
+'        <div class="row">'
+'          <div class="col-sm-6">'
+'            <div class="form-group">'
+'              <label>Spécialité<span class="text-red ml-1">*</span></label>'
+'              <select name="spc" class="form-control select2bs4">'
+'                <option selected="selected" value="">Choisissez votre spécialité </option>'
+'                <option>L1-MI</option>'
+'                <option>L2-INFO</option>'
+'                <option>L3-ISIL</option>'
+'                <option>L3-SI</option>'
+'                <option>M1-ILTI</option>'
+'                <option>M1-SIR</option>'
+'                <option>M1-TI</option>'
+'                <option>M2-ILTI</option>'
+'                <option>M2-SIR</option>'
+'                <option>M2-TI</option>'
+'              </select>'
+'            </div>'
+'          </div>'
+'          <div class="col-sm-6">'
+'            <div class="form-group">'
+'             <label>Groupe<span class="text-red ml-1">*</span></label>'
+'             <div class="input-group mb-3">'
+'               <div class="input-group-prepend">'
+'                 <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>'
+'               </div>'
+'               <input type="text" name="groupe" class="form-control" placeholder="07" value="">'
+'              </div>'
+'            </div>'
+'          </div>'
+'        </div>';

          $("#myOptions").html(options);
      }
      else if(value=="Enseignant")
      {
          options='<div class="form-group">'
                   +'<label>Matricule<span class="text-red ml-1">*</span></label>'
                   +'<div class="input-group mb-3">'
                     +'<div class="input-group-prepend">'
                       +'<span class="input-group-text"><i class="fas fa-id-card"></i></span>'
                     +'</div>'
                     +'<input type="text" name="idens" class="form-control" placeholder="21992983" value="">'
                    +'</div>'
                  +'</div>'
                +'<div class="form-group">'
              +'    <label>Diplôme<span class="text-red ml-1">*</span></label>'
              +'    <div class="input-group">'
              +'      <div class="input-group-prepend">'
              +'        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>'
              +'      </div>'
              +'      <input type="text" name="dep" class="form-control" placeholder="Licence BioInformatique" value="">'
              +'    </div>'
              +'  </div>'
              +'  <div class="form-group">'
              +'    <label>Grade<span class="text-red ml-1">*</span></label>'
              +'    <select name="grade" class="form-control select2bs4" style="width: 40%;">'
              +'      <option selected="selected" value="">Choisissez votre grade</option>'
              +'      <option>MAA</option>'
              +'      <option>MAB</option>'
              +'      <option>MCA</option>'
              +'      <option>MCB</option>'
              +'      <option>PROF</option>'
              +'    </select>'
              +'  </div>';
          $("#myOptions").html(options);
      }
      else if(value=="Administrateur")
      {
          options='<div class="form-group">'
+'                    <label>Id Administrateur<span class="text-red ml-1">*</span></label>'
+'                    <div class="input-group">'
+'                      <div class="input-group-prepend">'
+'                        <span class="input-group-text"><i class="far fa-id-badge"></i></span>'
+'                      </div>'
+'                      <input type="text" name="idadm" class="form-control" placeholder="1928179" value="">'
+'                    </div>'
+'                  </div>'
+'                  <div class="form-group">'
+'                    <label>Poste<span class="text-red ml-1">*</span></label>'
+'                    <div class="input-group mb-3">'
+'                      <div class="input-group-prepend">'
+'                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>'
+'                      </div>'
+'                      <input type="text" name="poste" class="form-control" placeholder="Secrétaire" value="">'
+'                    </div>'
+'                  </div>';
          $("#myOptions").html(options);
      }
      else
      {
          options=""
          $("#myOptions").html(options);
          //$("#myOptions").find('option').remove()
      }
  });
  });
</script>
<?php endif; ?>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Accueil</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-auto">
      <div class="input-group input-group-md">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="./contact.php" class="nav-link">Contactez-nous</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="./Icons/Cap.png" alt="DashboardLogo" class="brand-image img-circle elevation-3" style="opacity: 9">
<?php if ($thisFileName == 'index.php'): ?>
      <span class="brand-text" style="font-weight: 1000; margin-left: 1px">Dashboard Recours</span>
<?php else: ?>
      <span class="brand-text font-weight-light" style="margin-left: 1px"><b>Dashboard Recours</b></span>
<?php endif; ?>
    </a>

    <!-- Profile -->
    <a href="profile.php" class="brand-link">
      <img class="profile-user-img img-fluid img-circle"
      style="width: 47px; height: 45px; margin-left: 7px; margin-right: 7px; margin-top: -6px; margin-bottom: -4px"
      src="<?php echo $photo . '?t=' . time(); ?>"
      alt="User profile picture">
<?php if ($thisFileName == 'profile.php'): ?>
      <span class="brand-text" style="font-weight: 1000; margin-left: -3px"><?php echo $info['nom'] . ' ' . $info['prenom']; ?></span>
<?php else: ?>
      <span class="brand-text font-weight-light" style="margin-left: -3px"><b><?php echo $info['nom'] . ' ' . $info['prenom']; ?></b></span>
<?php endif; ?>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
          <a href="./dashboard.php" class="nav-link <?php if ($thisFileName == 'dashboard.php') echo 'active'; ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
          <a href="./charts.php" class="nav-link <?php if ($thisFileName == 'charts.php') echo 'active'; ?>">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Graphiques 
              </p>
            </a>
          </li>
<?php if (!isset($_SESSION['TU'])): ?>
          <li class="nav-item bg-orange">
            <a href="./registerFULL.php" class="nav-link">
              <i class="nav-icon fas fa-address-card"></i>
              <p>
                Continuer l'inscription
              </p>
            </a>
          </li>
<?php endif; ?>
<?php if (isset($_SESSION['TU']) && $_SESSION['TU'] == 'Administrateur'): ?>
          <li class="nav-item">
            <a href="./trafic.php" class="nav-link <?php if ($thisFileName == 'trafic.php') echo 'active'; ?>">
              <i class="nav-icon fas fa-traffic-light"></i>
              <p>
                Trafic
              </p>
            </a>
          </li>
<?php endif; ?>
          <li class="nav-item">
            <a href="./Include/logout.inc.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Déconnecter 
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
<?php if ($thisFileName != 'registerFULL.php' && $thisFileName != 'profile.php' && $thisFileName != 'trafic.php'): ?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?=$pageName?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="./index.php">Accueil</a></li>
            <li class="breadcrumb-item active"><?php if ($thisFileName == 'index.php') echo ''; else echo $pageName; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<?php endif; ?>
