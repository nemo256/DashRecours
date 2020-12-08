<?php

require_once ('.workingDir.info.php');
basename(dirname(__FILE__)) != $projectDir ?
  $level = 2 :
  $level = 1;
require_once (dirname(__FILE__, $level) . '/Include/main.php');
if (basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"]))
  redirect (
    $GLOBALS['MSG']['AD'], 
    'danger', 
    $GLOBALS['LOC']['P'], 
    '?accessDenied'
  );

?>

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
          <table class="table table-responsive table-striped table-bordered projects">
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

      <form id="formET" action="./Include/profileET.inc.php" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
            <i class="fas fa-book mr-1"></i>
              <label>Module<span class="text-red ml-1">*</span></label>
              <select name="module" id="module" class="form-control js-module" style="width: 100%;">
                <option value="<?=$_GET['mod']?>"><?=$_GET['mod']?></option>

<?php
$modules = file('./Data/Modules.txt');
  foreach ($modules as $line): ?>
    <option value="<?php echo $line; ?>"><?php echo $line; ?></option>
<?php endforeach; ?>

              </select>
            </div>
            <div id="errorModule" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
            <i class="fas fa-tags mr-1"></i>
              <label>Semestre<span class="text-red ml-1">*</span></label>
              <select name="semestre" id="semestre" class="form-control select2bs4" style="width: 100%;">
                <option value="Impair">Impair</option>
                <option value="Paire">Paire</option>
              </select>
            </div>
            <div id="errorSemestre" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <i class="fas fa-file mr-1"></i>
              <label>Type<span class="text-red ml-1">*</span></label>
                <select name="typeE" id="typeE" class="form-control select2bs4" style="width: 100%;">
                  <option value="Examin">Examen</option>
                  <option value="Test">Test</option>
                </select>
            </div>
          <div id="errorTypeE" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
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
          <input type="text" name="emailens" id="emailens" class="form-control" placeholder="Email" value="<?=$_GET['mailens']?>">
        </div>
        <div id="errorEmailens" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>

        <div class="form-group">
        <i class="fas fa-align-left mr-1"></i>
          <label>Description</label>
          <textarea name="desc" id="desc" class="form-control" rows="3" placeholder="Entrer..."><?=$_GET['descc']?></textarea>
        </div>
        <div id="errorDesc" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>

        <button name="submitET" class="btn btn-primary btn-lg mt-2">
            Soumettre 
        </button>
      </form>

      </div>
      <!-- /AR -->

      <!-- MR -->
<?php if (isset($_GET['update'])): ?>
      <div class="tab-pane active" id="MR">

        <form id="formET2" action="./Include/profileET.inc.php?update=<?=$idrec?>" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
            <i class="fas fa-book mr-1"></i>
              <label>Module<span class="text-red ml-1">*</span></label>
              <select name="module" id="module" class="form-control js-module" style="width: 100%;">
                <option value="<?=$module?>"><?=$module?></option>

<?php
$modules = file('./Data/Modules.txt');
  foreach ($modules as $line): ?>
    <option value="<?php echo $line; ?>"><?php echo $line; ?></option>
<?php endforeach; ?>

              </select>
            </div>
            <div id="errorModule2" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
            <i class="fas fa-tags mr-1"></i>
              <label>Semestre<span class="text-red ml-1">*</span></label>
              <select name="semestre" id="semestre2" class="form-control select2bs4" style="width: 100%;">
                <option value="Impair">Impair</option>
                <option value="Paire">Paire</option>
              </select>
            </div>
            <div id="errorSemestre2" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
          </div>
        </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <i class="fas fa-file mr-1"></i>
                <label>Type<span class="text-red ml-1">*</span></label>
                  <select name="typeE" id="typeE2" class="form-control select2bs4" style="width: 100%;">
                  <option <?php if (!strcmp($typeE, 'Examin')) echo 'selected'; ?>>Examen</option>
                  <option <?php if (!strcmp($typeE, 'Test')) echo 'selected'; ?>>Test</option>
                  </select>
              </div>
            <div id="errorTypeE2" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
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
            <input type="text" name="emailens" id="emailens2" class="form-control" placeholder="Email" value="<?=$emailens?>">
          </div>
          <div id="errorEmailens2" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>

          <div class="form-group">
          <i class="fas fa-align-left mr-1"></i>
            <label>Description</label>
            <textarea name="desc" id="desc2" class="form-control" rows="3" placeholder="Entrer..."><?=$desc?></textarea>
          </div>
          <div id="errorDesc2" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>

          <button name="submitET" class="btn btn-info btn-lg mt-2">
              Modifier
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

<script src="./Plugins/js/profileET.js"></script>

<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
