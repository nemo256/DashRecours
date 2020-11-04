<?php
  $thisFileName = basename(__FILE__);
  require_once (dirname(__FILE__) . '/Pages/header.php');
?>

<!-- Main content -->
<section class="content pt-3">
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

  <div class="card card-warning">
    <div class="card-header">
      <h3 class="card-title"><b>Formulaire d'inscription</b></h3>
    </div>
    <div class="card-body">
      <form id="form" action="./Include/registerFULL.inc.php" method="post" enctype="multipart/form-data">

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Nom<span class="text-red ml-1">*</span></label>
              <input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez votre nom" value="<?=$_GET['nom']?>">
              <div id="errorNom" class="text-red text-sm ml-1" style="margin-bottom: -10px"></div>
            </div>
            <div class="form-group">
              <label>Prénom<span class="text-red ml-1">*</span></label>
              <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Entrez votre prénom" value="<?=$_GET['prenom']?>">
              <div id="errorPrenom" class="text-red text-sm ml-1" style="margin-bottom: -10px"></div>
            </div>
          </div>
          <div class="col-sm-6 text-center">

            <!-- Photo -->
            <input type="file" name="file" class="file" style="visibility: hidden; position: absolute;">
            <input type="text" class="form-control" disabled placeholder="Upload File" id="file" style="visibility: hidden; position: absolute;">
            <button type="button" class="browse btn btn-lg">
            <img class="profile-user-img img-fluid img-circle"
            style="width: 160px; height: 150px"
            src="./Icons/account2.png"
            alt="User profile picture"
            id="preview">
            </button>
            <!-- /Photo -->

          </div>
        </div>

        <div class="form-group">
          <label>Email<span class="text-red ml-1">*</span></label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input type="email" name="email" id="email" class="form-control" placeholder="JonDoe@mail.com" value="<?=$_SESSION['email']?>">
          </div>
        </div>
        <div id="errorEmail" class="text-red text-sm ml-1" style="margin-top: -10px"></div>

        <div class="form-group mt-2">
          <label>Date de naissance<span class="text-red ml-1">*</span></label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
            </div>
            <input type="date" name="ddn" id="ddn" class="form-control" placeholder="02/01/2000" value="<?=$_GET['ddn']?>">
          </div>
        </div>
        <div id="errorDdn" class="text-red text-sm ml-1 mb-2" style="margin-top: -10px"></div>

<?php if (isset($_GET['sex'])) $sex = $_GET['sex']; ?>
        <label>Sexe<span class="text-red ml-1">*</span></label>
        <div class="form-group clearfix">
          <div class="icheck-primary d-inline mr-2">
            <input type="radio" id="radioPrimary1" name="sex" value="Male"<?php if (!strcmp($sex, 'Male')) echo 'checked'; ?>>
            <label for="radioPrimary1">
              Male
            </label>
          </div>
          <div class="icheck-primary d-inline mr-2">
            <input type="radio" id="radioPrimary2" name="sex" value="Female"<?php if (!strcmp($sex, 'Female')) echo 'checked'; ?>>
            <label for="radioPrimary2">
              Female
            </label>
          </div>
        </div>
        <div id="errorSex" class="text-red text-sm ml-1 mb-2" style="margin-top: -10px"></div>

        <div class="form-group">
          <label>Adresse<span class="text-red ml-1">*</span></label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-map-marker"></i></span>
            </div>
            <input type="text" name="add" id="add" class="form-control" placeholder="Frantz Fanon / Boumerdes / 35000" value="<?=$_GET['add']?>">
          </div>
        </div>
        <div id="errorAdd" class="text-red text-sm ml-1 mb-2" style="margin-top: -10px"></div>

        <div class="form-group">
          <label>Numéro de téléphone<span class="text-red ml-1">*</span></label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-phone"></i></span>
            </div>
            <input type="text" name="tel" id="tel" class="form-control" placeholder="07 70 70 70 11" value="<?=$_GET['tel']?>">
          </div>
        </div>
        <div id="errorTel" class="text-red text-sm ml-1 mb-2" style="margin-top: -10px"></div>

        <div class="form-group">
          <label>Type Utilisateur<span class="text-red ml-1">*</span></label>
          <select name="TU" id="select" class="form-control select2bs4">
            <option selected="selected" value="">Choisissez le type d'utilisateur</option>
            <option value="Etudiant">Etudiant</option>
            <option value="Enseignant">Enseignant</option>
            <option value="Administrateur">Administrateur</option>
          </select>
        </div>
        <div id="errorTU" class="text-red text-sm ml-1 mb-2" style="margin-top: -10px"></div>

<!-- this is extended through AJAX on the script in header file! -->
<!-- Please see the header file -->
        <div id="myOptions"> 
        </div>

        <button type="submit" name="submit" class="btn btn-lg btn-warning mt-3">Soumettre</button>

      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<script src="./Plugins/js/registerFULL.js"></script>

<?php
    require './Pages/footer.php';
?>
