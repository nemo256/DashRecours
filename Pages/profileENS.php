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
            style="width: 110px; height: 100px"
            src="<?php echo $photo . '?t=' . time(); ?>"
            alt="User profile picture">

                 <h3 class="profile-username"><?php echo $info['nom'] . ' ' . $info['prenom']; ?></h3>

<?php if ($info['sexe']== "Male"): ?>
          <p class="text-muted" style="margin-top: -5px">Enseignant</p>
<?php elseif ($info['sexe'] == "Female"): ?>
          <p class="text-muted" style="margin-top: -5px">Enseignante</p>
<?php endif; ?>
          </div>

          <div class="col-md-9">
          <ul class="list-group list-group-unbordered mb-1 mt-2">
            <li class="list-group-item">
              <b>Matricule</b> <a class="float-right"><?=$info['matricule']?></a>
            </li>
            <li class="list-group-item">
              <b>Grade</b> <a class="float-right"><?=$info['grade']?></a>
            </li>
            <li class="list-group-item">
            <b>Recours Reçu</b> <a class="float-right"><?=$nbrRecours?></a>
            </li>
          </ul>
          </div>
         </div>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->


      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills" >
<?php if (isset($_GET['view'])): ?>
            <li class="nav-item"><a class="nav-link" href="./profile.php">Recours Non Traités</a></li>
<?php else: ?>
            <li class="nav-item"><a class="nav-link active" href="#RNT" data-toggle="tab">Recours Non Traités</a></li>
<?php endif; ?>
            <li class="nav-item"><a class="nav-link" href="#RV" data-toggle="tab">Recours Validé</a></li>
            <li class="nav-item"><a class="nav-link" href="#RR" data-toggle="tab">Recours Refusé</a></li>
<?php if (isset($_GET['view'])): ?>
            <li class="nav-item"><a class="nav-link active" href="#VR" data-toggle="tab">Voir Recours</a></li>
<?php endif; ?>
            <li class="nav-item"><a class="nav-link" href="#PR" data-toggle="tab">Paramètres</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">

<?php if (!isset($_GET['view'])): ?>
  <!-- RNT -->
  <div class="active tab-pane" id="RNT">
<?php else: ?>
  <div class="tab-pane" id="RNT">
<?php endif; ?>

<!-- Check if there are no recours -->
<?php if (empty($recNonTreated)): ?>
    <div class="callout callout-info">
      <h5>Aucun recours reçu!</h5>

      <p>Vous n'avez reçu aucun recours.</p>
    </div>

<?php else: ?>
    <table class="table table-striped table-bordered projects">
      <thead>
        <tr>
          <th style="width: 1%" class="text-center">Photo</th>
          <th style="width: 10%" class="text-center">Nom</th>
          <th style="width: 10%" class="text-center">Prénom</th>
          <th style="width: 15%" class="text-center">Spécialité</th>
          <th style="width: 5%" class="text-center">Groupe</th>
          <th style="width: 20%" class="text-center">Status</th>
          <th style="width: 20%" class="text-center">Action</th>
        </tr>
      </thead>
<!-- Selecting everything from 'recours' table -->
      <tbody>
<?php foreach ($recNonTreated as $recours):?>
        <tr>
<?php 
  $ET = new etudiant($recours['idet']);
  $ET = $ET->getInfo();
?>
          <td>
            <img class="profile-user-img img-fluid img-circle"
            style="width: 47px; height: 45px; margin-top: -6px; margin-bottom: -4px"
            src="<?php echo 'Pics/'.$ET['photo'].'?t='.time(); ?>"
            alt="User profile picture">
          </td>
          <td class="text-center"><?=$ET['nom']?></td>
          <td class="text-center"><?=$ET['prenom']?></td>
          <td class="text-center"><?=$ET['speciality']?></td>
          <td class="text-center"><?=$ET['groupe']?></td>
          <td class="project-state">
            <span class="badge badge-<?php if ($recours['status'] == 'En Cours') echo 'info'; elseif ($recours['status'] == 'Refus&eacute;') echo 'danger'; elseif ($recours['status'] == 'Valid&eacute;') echo 'success'; ?>"><?php if ($recours['status']== 'En Cours') echo 'Non traité'; else echo $recours['status']; ?></span>
          </td>
          <td class="project-actions text-center">

            <a class="btn btn-primary btn-sm" href="./profile.php?view=<?=$recours['id']?>">
              <i class="fas fa-folder"></i>
            </a>

            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalValide<?php echo $recours['id'];?>">
              <i class="fas fa-check"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalValide<?php echo $recours['id'];?>">
              <div class="modal-dialog">
                <div class="modal-content bg-success">
                  <div class="modal-header">
                    <h4 class="modal-title">Validation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir valider ce recours?</p>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-outline-light" href="./Include/profileENS.inc.php?validate=<?=$recours['id']?>">Valider</a>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalRefuse<?php echo $recours['id'];?>">
              <i class="fas fa-times"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalRefuse<?php echo $recours['id'];?>">
              <div class="modal-dialog">
                <div class="modal-content bg-danger">
                  <div class="modal-header">
                    <h4 class="modal-title">Refus</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir refuser ce recours?</p>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-outline-light" href="./Include/profileENS.inc.php?refuse=<?=$recours['id']?>">Refuser</a>
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
  <!-- /RNT -->

  <!-- RV -->
  <div class="tab-pane fade" id="RV">

<!-- Check if there are no recours -->
<?php if (empty($recValidated)): ?>
    <div class="callout callout-info">
      <h5>Aucun recours!</h5>

      <p>Vous n'avez encore validé aucun recours.</p>
    </div>

<?php else: ?>
    <table class="table table-striped table-bordered projects">
      <thead>
        <tr>
          <th style="width: 1%" class="text-center">Photo</th>
          <th style="width: 10%" class="text-center">Nom</th>
          <th style="width: 10%" class="text-center">Prénom</th>
          <th style="width: 15%" class="text-center">Spécialité</th>
          <th style="width: 5%" class="text-center">Groupe</th>
          <th style="width: 20%" class="text-center">Status</th>
          <th style="width: 20%" class="text-center">Action</th>
        </tr>
      </thead>
<!-- Selecting everything from 'recours' table -->
      <tbody>
<?php foreach ($recValidated as $recours):?>
        <tr>
<?php 
  $ET = new etudiant($recours['idet']);
  $ET = $ET->getInfo();
?>
          <td>
            <img class="profile-user-img img-fluid img-circle"
            style="width: 47px; height: 45px; margin-top: -6px; margin-bottom: -4px"
            src="<?php echo 'Pics/'.$ET['photo'].'?t='.time(); ?>"
            alt="User profile picture">
          </td>
          <td class="text-center"><?=$ET['nom']?></td>
          <td class="text-center"><?=$ET['prenom']?></td>
          <td class="text-center"><?=$ET['speciality']?></td>
          <td class="text-center"><?=$ET['groupe']?></td>
          <td class="project-state">
            <span class="badge badge-<?php if ($recours['status'] == 'En Cours') echo 'info'; elseif ($recours['status'] == 'Refus&eacute;') echo 'danger'; elseif ($recours['status'] == 'Valid&eacute;') echo 'success'; ?>"><?php if ($recours['status']== 'En Cours') echo 'Non traité'; else echo $recours['status']; ?></span>
          </td>
          <td class="project-actions text-center">

            <a class="btn btn-primary btn-sm" href="./profile.php?view=<?=$recours['id']?>">
              <i class="fas fa-folder"></i>
            </a>

            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalRefuse<?php echo $recours['id'];?>">
              <i class="fas fa-times"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalRefuse<?php echo $recours['id'];?>">
              <div class="modal-dialog">
                <div class="modal-content bg-danger">
                  <div class="modal-header">
                    <h4 class="modal-title">Refus</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir refuser ce recours?</p>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-outline-light" href="./Include/profileENS.inc.php?refuse=<?=$recours['id']?>">Refuser</a>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <!-- Deletion! -->
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete<?php echo $recours['id'];?>">
              <i class="fas fa-trash"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalDelete<?php echo $recours['id'];?>">
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
                    <a class="btn btn-outline-light" href="./Include/profileENS.inc.php?delete=<?=$recours['id']?>">Supprimer</a>
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
  <!-- /RV -->

  <!-- RR -->
  <div class="tab-pane" id="RR">

<!-- Check if there are no recours -->
<?php if (empty($recRefused)): ?>
    <div class="callout callout-info">
      <h5>Aucun recours!</h5>

      <p>Vous n'avez encore refusé aucun recours.</p>
    </div>

<?php else: ?>
    <table class="table table-striped table-bordered projects">
      <thead>
        <tr>
          <th style="width: 1%" class="text-center">Photo</th>
          <th style="width: 10%" class="text-center">Nom</th>
          <th style="width: 10%" class="text-center">Prénom</th>
          <th style="width: 15%" class="text-center">Spécialité</th>
          <th style="width: 5%" class="text-center">Groupe</th>
          <th style="width: 20%" class="text-center">Status</th>
          <th style="width: 20%" class="text-center">Action</th>
        </tr>
      </thead>
<!-- Selecting everything from 'recours' table -->
      <tbody>
<?php foreach ($recRefused as $recours):?>
        <tr>
<?php 
  $ET = new etudiant($recours['idet']);
  $ET = $ET->getInfo();
?>
          <td>
            <img class="profile-user-img img-fluid img-circle"
            style="width: 47px; height: 45px; margin-top: -6px; margin-bottom: -4px"
            src="<?php echo 'Pics/'.$ET['photo'].'?t='.time(); ?>"
            alt="User profile picture">
          </td>
          <td class="text-center"><?=$ET['nom']?></td>
          <td class="text-center"><?=$ET['prenom']?></td>
          <td class="text-center"><?=$ET['speciality']?></td>
          <td class="text-center"><?=$ET['groupe']?></td>
          <td class="project-state">
            <span class="badge badge-<?php if ($recours['status'] == 'En Cours') echo 'info'; elseif ($recours['status'] == 'Refus&eacute;') echo 'danger'; elseif ($recours['status'] == 'Valid&eacute;') echo 'success'; ?>"><?php if ($recours['status']== 'En Cours') echo 'Non traité'; else echo $recours['status']; ?></span>
          </td>
          <td class="project-actions text-center">

            <a class="btn btn-primary btn-sm" href="./profile.php?view=<?=$recours['id']?>">
              <i class="fas fa-folder"></i>
            </a>

            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalValide<?php echo $recours['id'];?>">
              <i class="fas fa-check"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalValide<?php echo $recours['id'];?>">
              <div class="modal-dialog">
                <div class="modal-content bg-success">
                  <div class="modal-header">
                    <h4 class="modal-title">Validation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir valider ce recours?</p>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-outline-light" href="./Include/profileENS.inc.php?validate=<?=$recours['id']?>">Valider</a>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <!-- Deletion! -->
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDelete<?php echo $recours['id'];?>">
              <i class="fas fa-trash"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalDelete<?php echo $recours['id'];?>">
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
                    <a class="btn btn-outline-light" href="./Include/profileENS.inc.php?delete=<?=$recours['id']?>">Supprimer</a>
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
  <!-- /RR -->

      <!-- VR -->
<?php if (isset($_GET['view'])): ?>
      <div class="active tab-pane" id="VR">
        <div class="row">
          <div class="col-sm-6">
            <strong><i class="fas fa-user mr-2"></i>Nom Complet</strong>
            <p class="text-muted mt-1"><?php echo $ETV['nom'] . ' ' . $ETV['prenom']; ?></p>
          </div>
          <div class="col-sm-6">
            <strong><i class="fas fa-id-card mr-2"></i>Matricule</strong>
            <p class="text-muted mt-1"><?=$ETV['matricule']?></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-6">
            <strong><i class="fas fa-chalkboard mr-2"></i>Speciality</strong>
            <p class="text-muted mt-1"><?=$ETV['speciality']?></p>
          </div>
          <div class="col-sm-6">
            <strong><i class="fas fa-chalkboard-teacher mr-2"></i>Groupe</strong>
            <p class="text-muted mt-1"><?=$ETV['groupe']?></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-6">
            <strong><i class="fas fa-book mr-2"></i>Module</strong>
            <p class="text-muted mt-1"><?=$viewRec['module']?></p>
          </div>
          <div class="col-sm-6">
            <strong><i class="fas fa-book-open mr-2"></i>Type d'evaluation</strong>
            <p class="text-muted mt-1"><?=$viewRec['typeE']?></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-6">
            <strong><i class="far fa-file-alt mr-2"></i>Status</strong>
            <p>
            <span class="badge badge-<?php if ($viewRec['status'] == 'En Cours') echo 'info'; elseif ($viewRec['status'] == 'Refus&eacute;') echo 'danger'; elseif ($viewRec['status'] == 'Valid&eacute;') echo 'success'; ?> mt-2"><?php if ($viewRec['status']== 'En Cours') echo 'Non traité'; else echo $viewRec['status']; ?></span>
</p>
          </div>
          <div class="col-sm-6">
            <strong><i class="fas fa-file-code mr-2"></i>Fichier</strong>
            <p class="text-muted mt-2">
<?php if (empty($viewRec['attachment'])): ?>
              No files attached
<?php else: ?>
              <a class="btn btn-sm bg-indigo" href="./Files/<?=$viewRec['attachment']?>" download>
                <i class="fas fa-download mr-1"></i>
                Download
              </a>
<?php endif; ?>
            </p>
          </div>
        </div>
        <hr>
        <strong><i class="far fa-file-alt mr-1"></i>Description</strong>
        <p class="text-muted mt-2"><?php if (empty($viewRec['description'])) echo 'No description'; else echo $viewRec['description']; ?></p>
        <hr>
        <div class="row">
          <div class="col-sm-6 align-items-center text-center justify-content-center" style="margin-left: -15px">
<?php if (!strcmp($viewRec['status'], 'Valid&eacute;')): ?>
            <button type="button" style="width: 90%; font-size: 20px" class="btn btn-success disabled">
<?php else: ?>
            <button type="button" style="width: 90%; font-size: 20px" class="btn btn-success" data-toggle="modal" data-target="#modalValidatee<?php echo $viewRec['id'];?>">
<?php endif; ?>
              <i class="fas fa-check" style="margin-right: 4px"></i>
              Validé 
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalValidatee<?php echo $viewRec['id'];?>">
              <div class="modal-dialog">
                <div class="modal-content bg-success">
                  <div class="modal-header">
                    <h4 class="modal-title">Validation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir valider ce recours?</p>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-outline-light" href="./Include/profileENS.inc.php?validate=<?=$viewRec['id']?>">Valider</a>
                  </div>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
          </div>
          <div class="col-sm-6 align-items-center text-center justify-content-center" style="margin-left: 15px">
<?php if (!strcmp($viewRec['status'], 'Refus&eacute;')): ?>
            <button type="button" style="width: 90%; font-size: 20px" class="btn btn-danger disabled">
<?php else: ?>
            <button type="button" style="width: 90%; font-size: 20px" class="btn btn-danger" data-toggle="modal" data-target="#modalRefusee<?php echo $viewRec['id'];?>">
<?php endif; ?>
              <i class="fas fa-times" style="margin-right: 4px"></i>
              Refusé 
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalRefusee<?php echo $viewRec['id'];?>">
              <div class="modal-dialog">
                <div class="modal-content bg-danger">
                  <div class="modal-header">
                    <h4 class="modal-title">Refus</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir refuser ce recours?</p>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-outline-light" href="./Include/profileENS.inc.php?refuse=<?=$viewRec['id']?>">Refuser</a>
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
      <!-- /VR -->
<?php endif; ?>

<?php require './Pages/settings.php'; ?>
    </div>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
