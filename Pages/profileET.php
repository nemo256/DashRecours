    <!-- Profile Infos-->
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
       <div class="row">
        <div class="col-md-3 text-center" style="margin-left: -25px">
            <img class="profile-user-img img-fluid img-circle mb-2"
            style="width: 110px; height: 105px"
            src="<?php echo $photo . '?t=' . time(); ?>"
            alt="User profile picture">

          <h3 class="profile-username"><?php echo $info['nom'] . ' ' . $info['prenom']; ?></h3>


<?php if (!strcmp($info['sexe'], "Male")): ?>
          <p class="text-muted" style="margin-top: -5px">Étudiant</p>
<?php elseif (!strcmp($info['sexe'], "Female")): ?>
          <p class="text-muted" style="margin-top: -5px">Étudiante</p>
<?php endif; ?>
        </div>

        <div class="col-md-9">
          <ul class="list-group list-group-unbordered mb-1 mt-2">
            <li class="list-group-item">
              <b>Matricule</b> <a class="float-right"><?=$info['matricule']?></a>
            </li>
            <li class="list-group-item">
              <b>Spécialité</b> <a class="float-right"><?=$info['speciality']?></a>
            </li>
            <li class="list-group-item">
              <b>Recours Soumis</b> <a class="float-right"><?=$nbrRecours?></a>
            </li>
          </ul>
        </div>
      </div>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

  <!-- Activity nav-bar -->
  <div class="card">
    <div class="card-header p-2">
      <ul class="nav nav-pills">
<?php if (isset($_GET['update']) || isset($_GET['view'])): ?>
        <li class="nav-item"><a class="nav-link <?php if (!isset($_GET['view']) && !isset($_GET['update'])) echo 'active'; ?>" href="./profile.php">Liste Des Recours</a></li>
<?php else: ?>
        <li class="nav-item"><a class="nav-link <?php if (!isset($_GET['view']) && !isset($_GET['update'])) echo 'active'; ?>" href="#LRE" data-toggle="tab">Liste Des Recours</a></li>
<?php endif; ?>
<?php if (isset($_GET['view'])): ?>
        <li class="nav-item"><a class="nav-link active" href="#RE" data-toggle="tab">Voir Recours</a></li>
<?php endif; ?>
<?php if (isset($_GET['update'])): ?>
        <li class="nav-item"><a class="nav-link active" href="#MR" data-toggle="tab">Modifier Un Recours</a></li>
<?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="#AR" data-toggle="tab">Ajouter Un Recours</a></li>
        <li class="nav-item"><a class="nav-link" href="#PR" data-toggle="tab">Paramètres</a></li>
      </ul>
    </div><!-- /.card-header -->
    <div class="card-body">
      <div class="tab-content">

        <!-- LRE -->
        <div class="<?php if (!isset($_GET['view']) && !isset($_GET['update'])) echo 'active'; ?> tab-pane" id="LRE">
<?php header("Location: ./profile.php?"); ?>

<!-- Check if there are no recours -->
<?php if (empty($recToShow)): ?>
        <div class="callout callout-info">
          <h5>Aucun recours!</h5>

          <p>Vous pouvez cliquer sur ajouter un recours pour ajouter un nouveau recours.</p>
        </div>

<?php else: ?>
          <table class="table table-striped table-bordered projects">
            <thead>
              <tr>
                <th style="width: 1%" class="text-center">#</th>
                <th style="width: 10%" class="text-center">Module</th>
                <th style="width: 10%" class="text-center">Type</th>
                <th style="width: 10%" class="text-center">Enseignant</th>
                <th style="width: 20%" class="text-center">Description</th>
                <th style="width: 10%" class="text-center">Status</th>
                <th style="width: 20%" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
<!-- Selecting everything from 'recours' table -->
<?php $idCounter = 1; ?>
<?php foreach ($recToShow as $recours):?>
              <tr>
                <td class="text-center"><?=$idCounter++?></td>
<?php 
  $ENS = new enseignant($recours['idens']);
  $ENS = $ENS->getInfo();
?>
                <td class="text-center"><?=$recours['module']?></td>
                <td class="text-center"><?=$recours['typeE']?></td>
                <td class="text-center"><?=$ENS['nom']?></td>
                <td class="text-break"><?php if (empty($recours['description'])) echo 'No description'; else echo $recours['description']; ?></td>
                <td class="project-state">
                  <span class="badge badge-<?php if ($recours['status'] == 'En Cours') echo 'warning'; elseif ($recours['status'] == 'Refus&eacute;') echo 'danger'; elseif ($recours['status'] == 'Valid&eacute;') echo 'success'; ?>"><?=$recours['status']?></span>
                </td>
                <td class="project-actions text-center">
                <a class="btn btn-primary btn-sm" href="./profile.php?view=<?=$recours['id']?>">
                  <i class="fas fa-folder"></i>
                 </a>
<?php if (!strcmp($recours['status'], 'En Cours')): ?>
                 <a class="btn btn-info btn-sm" href="./profile.php?update=<?=$recours['id']?>">
                  <i class="fas fa-pencil-alt"></i>
                 </a>
<?php endif; ?>
                 <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-danger<?php echo $recours['id'];?>">
                  <i class="fas fa-trash"></i>
                 </button>

                <!-- Un hack pour generer le modal sans perdre l'id -->
                <!-- Modal -->
                <div class="modal fade" id="modal-danger<?php echo $recours['id'];?>">
                  <div class="modal-dialog">
                    <div class="modal-content bg-danger">
                      <div class="modal-header">
                        <h4 class="modal-title">Supprimer</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>Voulez-vous vraiment supprimer ce recours?</p>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                        <a class="btn btn-outline-light" href="./Include/profileET.inc.php?delete=<?=$recours['id']?>">Continuer</a>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                </td>
              </tr>
<?php endforeach; ?>
            </tbody>
          </table>
<?php endif; ?>
        </div>
        <!-- /LRE -->

        <!-- RE -->
<?php if (isset($_GET['view'])): ?>
      <div class="active tab-pane" id="RE">
        <div class="row">
          <div class="col-sm-6">
            <strong><i class="fas fa-book mr-2"></i>Module</strong>
            <p class="text-muted mt-1"><?=$viewRec['module']?></p>
          </div>
          <div class="col-sm-6">
            <strong><i class="fas fa-id-badge mr-2"></i>Nom Enseignant</strong>
            <p class="text-muted mt-1"><?=$ENSV['nom']?></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-6">
            <strong><i class="fas fa-file mr-2"></i>Type</strong>
            <p class="text-muted mt-1"><?=$viewRec['typeE']?></p>
          </div>
          <div class="col-sm-6">
            <strong><i class="fas fa-envelope mr-2"></i>Email Enseignant</strong>
            <p class="text-muted mt-1"><?=$viewRec['emailens']?></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-6">
            <strong><i class="fas fa-info-circle mr-1"></i>Status</strong>
            <p class="text-muted">
            <span class="mt-2 badge badge-<?php if ($viewRec['status'] == 'En Cours') echo 'warning'; elseif ($viewRec['status'] == 'Refus&eacute;') echo 'danger'; elseif ($viewRec['status'] == 'Valid&eacute;') echo 'success'; ?>"><?=$viewRec['status']?></span>
            </p>
          </div>
          <div class="col-sm-6">
            <strong><i class="fas fa-file-code mr-2"></i>Fichier</strong>
            <p class="text-muted text-break mt-1"><?php if (empty($viewRec['attachment'])) echo 'No files attached'; else echo $viewRec['attachment']; ?></p>
          </div>
        </div>
        <hr>
        <strong><i class="fas fa-align-left mr-1"></i>Description</strong>
        <p class="text-muted mt-2"><?php if (empty($viewRec['description'])) echo 'No description'; else echo $viewRec['description']; ?></p>
        <hr>
        <div class="row">
          <div class="col-sm-6 align-items-center text-center justify-content-center" style="margin-left: -15px">
<?php if (!strcmp($viewRec['status'], 'Valid&eacute;') || !strcmp($viewRec['status'], 'Refus&eacute;')): ?>
            <button type="button" style="width: 90%; font-size: 20px" class="btn btn-info disabled">
              <i class="fas fa-pencil-alt" style="margin-right: 4px"></i>
              Modifier
            </button>
<?php else: ?>
            <a style="width: 90%; font-size: 20px" class="btn btn-info" href="./profile.php?update=<?=$viewRec['id']?>">
              <i class="fas fa-pencil-alt" style="margin-right: 4px"></i>
              Modifier 
            </a>
<?php endif; ?>
          </div>
          <div class="col-sm-6 align-items-center text-center justify-content-center" style="margin-left: 15px">
            <button type="button" style="width: 90%; font-size: 20px" class="btn btn-danger" data-toggle="modal" data-target="#modalDelete<?php echo $viewRec['id'];?>">
              <i class="fas fa-trash" style="margin-right: 4px"></i>
              Supprimer 
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalDelete<?php echo $viewRec['id'];?>">
              <div class="modal-dialog">
                <div class="modal-content bg-danger">
                  <div class="modal-header">
                    <h4 class="modal-title">Suppression</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Voulez-vous vraiment supprimer ce recours?</p>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-outline-light" href="./Include/profileET.inc.php?delete=<?=$viewRec['id']?>">Supprimer</a>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
          </div>
        </div>
      </div>
<?php endif; ?>

      <!-- AR -->
      <div class="tab-pane" id="AR">

      <form action="./Include/profileET.inc.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
        <i class="fas fa-book mr-1"></i>
          <label>Module<span class="text-red ml-1">*</span></label>
          <input type="text" name="module" class="form-control" placeholder="Nom du module" value="<?=$_GET['mod']?>">
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <i class="fas fa-file mr-1"></i>
              <label>Type<span class="text-red ml-1">*</span></label>
                <select name="typeE" class="form-control select2" style="width: 100%;">
                <option>Examin</option>
                <option>Test</option>
                </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <i class="fas fa-file-code mr-1"></i>
              <label for="exampleInputFile" class="mr-2">Fichier</label>(Facultatif)
              <div class="custom-file">
                <input type="file" name="attachment" class="custom-file-input" id="exampleInputFile">
                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
        <i class="fas fa-id-badge mr-1"></i>
          <label>Enseignant<span class="text-red ml-1">*</span></label>
          <input type="text" name="emailens" class="form-control" placeholder="Email" value="<?=$_GET['mailens']?>">
        </div>

        <div class="form-group">
        <i class="fas fa-align-left mr-1"></i>
          <label>Description</label>
          <textarea name="desc" class="form-control" rows="3" placeholder="Enter ..."><?=$_GET['descc']?></textarea>
        </div>

        <button name="submitET" class="btn btn-primary" style="width: 25%">
            Submit
        </button>
      </form>

      </div>
      <!-- /AR -->

      <!-- MR -->
<?php if (isset($_GET['update'])): ?>
      <div class="tab-pane active" id="MR">

        <form action="./Include/profileET.inc.php?update=<?=$idrec?>" method="post" enctype="multipart/form-data">
          <div class="form-group">
          <i class="fas fa-book mr-1"></i>
            <label>Module<span class="text-red ml-1">*</span></label>
            <input type="text" name="module" class="form-control" placeholder="Nom du module" value="<?=$module?>">
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <i class="fas fa-file mr-1"></i>
                <label>Type<span class="text-red ml-1">*</span></label>
                  <select name="typeE" class="form-control select2" style="width: 100%;">
                  <option <?php if (!strcmp($typeE, 'Examin')) echo 'selected'; ?>>Examin</option>
                  <option <?php if (!strcmp($typeE, 'Test')) echo 'selected'; ?>>Test</option>
                  </select>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <i class="fas fa-file-code mr-1"></i>
                <label for="exampleInputFile" class="mr-2">Fichier</label>(Facultatif)
                <div class="custom-file">
                  <input type="file" name="attachment" class="custom-file-input" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group">
          <i class="fas fa-id-badge mr-1"></i>
            <label>Enseignant<span class="text-red ml-1">*</span></label>
            <input type="text" name="emailens" class="form-control" placeholder="Email" value="<?=$emailens?>">
          </div>

          <div class="form-group">
          <i class="fas fa-align-left mr-1"></i>
            <label>Description</label>
            <textarea name="desc" class="form-control" rows="3" placeholder="Enter ..."><?=$desc?></textarea>
          </div>

          <button name="submitET" class="btn btn-info" style="width: 25%">
              Update 
          </button>
        </form>

      </div>
<?php endif; ?>
      <!-- /MR -->

<?php require './Pages/settings.php'; ?>

    </div>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->

<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
