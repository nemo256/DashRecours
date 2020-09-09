<?php
  $thisFileName = basename(__FILE__);
  require_once (dirname(__FILE__) . '/Pages/header.php');
?>

<!-- Main content -->
<section class="content">
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

    <div class="row">
<?php if (!isset($_SESSION['TU'])): ?>
      <div class="col-lg-6">
        <div class="card card-warning">
          <div class="card-header">
            <h5 class="m-0">Continuez l'inscription</h5>
          </div>
          <div class="card-body">
            <p class="card-text">Merci de poursuivre votre inscription en cliquant sur le lien ci-dessous!</p>
            <a href="./registerFULL.php" class="btn btn-warning">S'inscrire</a>
          </div>
        </div>
      </div>
      <!-- /.col-lg-9 -->
<?php endif; ?>
      <div class="col-lg-6">
        <div class="card card-primary">
          <div class="card-header">
            <h5 class="m-0">Consultez Statistiques</h5>
          </div>
          <div class="card-body">
            <p class="card-text">Consultez les statistiques concernant les recours passés soumis / acceptés et refusés.</p>
            <a href="./charts.php" class="btn btn-primary">Charts</a>
          </div>
        </div>
      </div>
      <!-- /.col-lg-9 -->
<?php if ($_SESSION['TU'] == "Enseignant"): ?>
      <div class="col-lg-6">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="m-0">Activity</h5>
          </div>
          <div class="card-body">
            <p class="card-text">Acceptez ou refusez les recours soumis par vos étudiants!</p>
            <a href="./profile.php" class="btn btn-primary">Aller</a>
          </div>
        </div>
      </div>
      <!-- /.col-lg-9 -->
<?php endif; ?>
<?php if ($_SESSION['TU'] == "Etudiant"): ?>
      <div class="col-lg-6">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h5 class="m-0">Activity</h5>
          </div>
          <div class="card-body">
            <p class="card-text">Ajouter / modifier ou supprimer votre recours!</p>
            <a href="./profile.php" class="btn btn-primary">Aller</a>
          </div>
        </div>
      </div>
      <!-- /.col-lg-9 -->
<?php endif; ?>
<?php if ($_SESSION['TU'] == "Administrateur"): ?>
      <div class="col-lg-6">
        <div class="card card-primary">
          <div class="card-header">
            <h5 class="m-0">Flux de Trafic</h5>
          </div>
          <div class="card-body">
            <p class="card-text">Voir les informations détaillées sur recours!</p>
            <a href="./trafic.php" class="btn btn-primary">Trafic</a>
          </div>
        </div>
      </div>
      <!-- /.col-lg-9 -->
<?php endif; ?>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?php
    require './Pages/footer.php';
?>
