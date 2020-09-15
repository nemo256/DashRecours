<!-- PR -->
<div class="tab-pane" id="PR">
  <form action="./Include/settings.inc.php" method="post" enctype="multipart/form-data">

    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label>Nom<span class="text-red ml-1">*</span></label>
          <input type="text" name="nom" class="form-control" placeholder="Entrez votre nom" value="<?=$info['nom']?>">
        </div>
        <div class="form-group">
          <label>Prénom<span class="text-red ml-1">*</span></label>
          <input type="text" name="prenom" class="form-control" placeholder="Entrez votre prénom" value="<?=$info['prenom']?>">
        </div>
      </div>
      <div class="col-sm-6 text-center">

        <!-- Photo -->
        <input type="file" name="file" class="file" style="visibility: hidden; position: absolute;">
        <input type="text" class="form-control" disabled placeholder="Upload File" id="file" style="visibility: hidden; position: absolute;">
        <button type="button" class="browse btn btn-lg mt-3">
        <img class="profile-user-img img-fluid img-circle"
        style="width: 160px; height: 150px"
        src="<?php echo $photo . '?t=' . time(); ?>"
        alt="User profile picture"
        id="preview">
        </button>
        <!-- /Photo -->
        <!-- To populate existing photo and not discard it upon uploading! -->
        <input type="hidden" name="photo" value="<?=$photo?>">

      </div>
    </div>

    <div class="form-group">
      <label>Email<span class="text-red ml-1">*</span></label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        </div>
        <input type="email" name="email" class="form-control" value="<?=$_SESSION['email']?>">
      </div>
    </div>

<?php if (!strcmp($_SESSION['TU'], 'Etudiant')): ?>
<?php if (isset($_GET['spc'])) $info['speciality'] = $_GET['spc']; ?>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Spécialité<span class="text-red ml-1">*</span></label>
              <select name="spc" class="form-control select2bs4">
                <option value="">Choisissez votre spécialité </option>
                <option <?php if (!strcmp($info['speciality'], 'L1-MI')) echo 'selected'; ?>>L1-MI</option>
                <option <?php if (!strcmp($info['speciality'], 'L2-INFO')) echo 'selected'; ?>>L2-INFO</option>
                <option <?php if (!strcmp($info['speciality'], 'L3-ISIL')) echo 'selected'; ?>>L3-ISIL</option>
                <option <?php if (!strcmp($info['speciality'], 'L3-SI')) echo 'selected'; ?>>L3-SI</option>
                <option <?php if (!strcmp($info['speciality'], 'M1-ILTI')) echo 'selected'; ?>>M1-ILTI</option>
                <option <?php if (!strcmp($info['speciality'], 'M1-SIR')) echo 'selected'; ?>>M1-SIR</option>
                <option <?php if (!strcmp($info['speciality'], 'M1-TI')) echo 'selected'; ?>>M1-TI</option>
                <option <?php if (!strcmp($info['speciality'], 'M2-ILTI')) echo 'selected'; ?>>M2-ILTI</option>
                <option <?php if (!strcmp($info['speciality'], 'M2-SIR')) echo 'selected'; ?>>M2-SIR</option>
                <option <?php if (!strcmp($info['speciality'], 'M2-TI')) echo 'selected'; ?>>M2-TI</option>
              </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
             <label>Groupe<span class="text-red ml-1">*</span></label>
             <div class="input-group mb-3">
               <div class="input-group-prepend">
                 <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>
               </div>
               <input type="text" name="groupe" class="form-control" placeholder="07" value="<?=$info['groupe']?>">
              </div>
            </div>
          </div>
        </div>
<?php endif; ?>

    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label>Nouveau Mot de passe</label>
          <input type="password" name="pwd" class="form-control" placeholder="Entrez un nouveau mot de passe" value="">
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label>Confirmer Mot de passe</label>
          <input type="password" name="pwd2" class="form-control" placeholder="Confirmer votre mot de passe" value="">
        </div>
      </div>
    </div>

    <button type="submit" name="updatePR" class="btn btn-primary mt-3" style="width: 27%">Submit</button>

  </form>
</div>
<!-- PR -->
