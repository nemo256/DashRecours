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

<script>
  $(document).ready(function(){
  var options="";
  $("#select1").on('change',function(){
      var value=$(this).val();
      if(value=="Etudiant")
      {
          options='<div class="row">'
+'          <div class="col-sm-6">'
+'            <div class="form-group">'
+'              <i class="fas fa-graduation-cap mr-2"></i><label>Spécialité<span class="text-red ml-1">*</span></label>'
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
+'             <i class="fas fa-users mr-2"></i><label>Groupe<span class="text-red ml-1">*</span></label>'
+'             <div class="input-group mb-3">'
+'               <input type="text" name="groupe" class="form-control" placeholder="07" value="">'
+'              </div>'
+'            </div>'
+'          </div>'
+'        </div>';

          $("#myOptions1").html(options);
      }
      else if(value=="Enseignant")
      {
          options='<div class="row">'
+'          <div class="col-sm-6">'
+'            <div class="form-group">'
              +'    <i class="fas fa-user-graduate mr-1"></i><label>Diplôme<span class="text-red ml-1">*</span></label>'
              +'    <div class="input-group">'
              +'      <input type="text" name="dep" class="form-control" placeholder="Licence BioInformatique" value="">'
              +'    </div>'
              +'  </div>'
              +'</div>'
+'              <div class="col-sm-6">'
              +'  <div class="form-group">'
              +'    <i class="fas fa-layer-group mr-1"></i><label>Grade<span class="text-red ml-1">*</span></label>'
              +'    <select name="grade" class="form-control select2bs4">'
              +'      <option selected="selected" value="">Choisissez votre grade</option>'
              +'      <option>MAA</option>'
              +'      <option>MAB</option>'
              +'      <option>MCA</option>'
              +'      <option>MCB</option>'
              +'      <option>PROF</option>'
              +'    </select>'
              +'  </div>'
            +'  </div>'
          +'  </div>';
          $("#myOptions1").html(options);
      }
      else
      {
          options=""
          $("#myOptions1").html(options);
      }
    });
  });
</script>


    <div class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
<?php if (isset($_GET['update']) || isset($_GET['view'])): ?>
          <li class="nav-item"><a class="nav-link <?php if (!isset($_GET['view']) && !isset($_GET['update'])) echo 'active'; ?>" href="./profile.php">Liste Des Utilisateurs</a></li>
<?php else: ?>
          <li class="nav-item"><a class="nav-link <?php if (!isset($_GET['view']) && !isset($_GET['update'])) echo 'active'; ?>" href="#LU" data-toggle="tab">Liste Des Utilisateurs</a></li>
<?php endif; ?>
<?php if (isset($_GET['view'])): ?>
          <li class="nav-item"><a class="nav-link active" href="#VU" data-toggle="tab">Voir Utilisateur</a></li>
<?php endif; ?>
<?php if (isset($_GET['update'])): ?>
          <li class="nav-item"><a class="nav-link active" href="#MU" data-toggle="tab">Modifier Un Utilisateur</a></li>
<?php endif; ?>
          <li class="nav-item"><a class="nav-link" href="#AU" data-toggle="tab">Ajouter Un Utilisateur</a></li>
          <li class="nav-item"><a class="nav-link" href="#PR" data-toggle="tab">Paramètres</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">

          <!-- LU -->
          <div class="<?php if (!isset($_GET['view']) && !isset($_GET['update'])) echo 'active'; ?> tab-pane" id="LU">

<!-- Check if there are no users -->
<?php if (empty($users)): ?>
        <div class="callout callout-info">
          <h5>Aucun Utilisateur!</h5>

          <p>Vous pouvez cliquer sur ajouter un utilisateur pour ajouter un nouveau utilisateur.</p>
        </div>
<?php else: ?>
  <table id="dataTable" class="table table-sm table-striped table-bordered projects">
      <thead>
          <tr>
              <th class="text-center" style="width: 1%">Photo</th>
              <th class="text-center" style="width: 8%">Nom</th>
              <th class="text-center" style="width: 8%">Prénom</th>
              <th class="text-center" style="width: 20%">Email</th>
              <th class="text-center" style="width: 8%">Type</th>
              <th class="text-center" style="width: 20%">Action</th>
          </tr>
      </thead>
      <tbody>
<?php foreach ($users as $user):?>
          <tr>
<?php 
if ($user['type'] == 'Etudiant')
  $userInfo = new etudiant($user['id']);
elseif ($user['type'] == 'Enseignant')
  $userInfo = new enseignant($user['id']);
if (isset($userInfo))
  $userInfo = $userInfo->getInfo();
?>
          <td class="text-center">
            <img class="profile-user-img img-fluid img-circle"
            style="width: 47px; height: 45px; margin-top: -6px; margin-bottom: -4px"
            src="<?php echo 'Pics/'.$userInfo['photo'].'?t='.time(); ?>"
            alt="User profile picture">
          </td>
            <td class="text-center"><?=$userInfo['nom']?></td>
            <td class="text-center"><?=$userInfo['prenom']?></td>
            <td class="text-center"><?=$userInfo['email']?></td>
            <td class="text-center"><?=$user['type']?></td>
            <td class="project-actions text-center">
              <a class="btn btn-primary btn-sm" href="./profile.php?view=<?=$userInfo['id']?>">
                <i class="fas fa-folder"></i>
               </a>
               <a class="btn btn-info btn-sm" href="./profile.php?update=<?=$userInfo['id']?>">
                <i class="fas fa-pencil-alt"></i>
               </a>
               <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDeleteUser<?php echo $userInfo['id']; ?>">
                <i class="fas fa-trash"></i>
               </button>

               <!-- Modal -->
               <div class="modal fade" id="modalDeleteUser<?php echo $userInfo['id']; ?>">
                 <div class="modal-dialog">
                   <div class="modal-content bg-danger">
                     <div class="modal-header">
                       <h4 class="modal-title">Supprimer</h4>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                       </button>
                     </div>
                     <div class="modal-body">
                     <p>Voulez-vous vraiment supprimer cette Utilisateur '<?=$userInfo['nom']?>'?</p>
                     </div>
                     <div class="modal-footer justify-content-between">
                       <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                       <a class="btn btn-outline-light" href="./Include/profileADM.inc.php?delete=<?=$userInfo['id']?>">Continuer</a>
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
      <!-- /LU -->

      <!-- VU -->
<?php if (isset($_GET['view'])): ?>
      <div class="active tab-pane" id="VU">
        <div class="row">
          <div class="col-sm-6">
            <strong><i class="fas fa-poll-h mr-2"></i>Nom</strong>
            <p class="text-muted mt-1"><?=$viewUser['nom']?></p>
            <hr>
            <strong><i class="fas fa-poll-h mr-2"></i>Prenom</strong>
            <p class="text-muted mt-1"><?=$viewUser['prenom']?></p>
          </div>
<?php if (empty($viewUser['photo']) || $viewUser['photo'] == '<null>') $viewUser['photo'] = 'account2.png'; ?>
          <div class="col-sm-6 text-center">
            <img class="profile-user-img img-fluid img-circle"
            style="width: 160px; height: 150px"
            src="./Pics/<?=$viewUser['photo']?>"
            alt="User profile picture">
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-6">
            <strong><i class="fas fa-id-card mr-2"></i>Matricule</strong>
            <p class="text-muted mt-1"><?=$viewUser['matricule']?></p>
          </div>
          <div class="col-sm-6">
            <strong><i class="fas fa-venus-mars mr-2"></i>Sexe</strong>
            <p class="text-muted mt-1"><?=$viewUser['sexe']?></p>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-6">
<?php if (!empty($viewUser['speciality'])): ?>
          <strong><i class="fas fa-graduation-cap mr-1"></i>Spécialité</strong>
            <p class="text-muted"><?=$viewUser['speciality']?></p>
<?php elseif (!empty($viewUser['grade'])): ?>
            <strong><i class="fas fa-layer-group mr-1"></i>Grade</strong>
            <p class="text-muted"><?=$viewUser['grade']?></p>
<?php endif; ?>
          </div>
          <div class="col-sm-6">
<?php if (!empty($viewUser['groupe'])): ?>
            <strong><i class="fas fa-users mr-1"></i>Groupe</strong>
            <p class="text-muted"><?=$viewUser['groupe']?></p>
<?php elseif (!empty($viewUser['deplome'])): ?>
            <strong><i class="fas fa-user-graduate mr-1"></i>deplome</strong>
            <p class="text-muted"><?=$viewUser['deplome']?></p>
<?php endif; ?>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-sm-6 align-items-center text-center justify-content-center" style="margin-left: -15px">
            <a style="width: 90%; font-size: 20px" class="btn btn-info" href="./profile.php?update=<?=$viewUser['id']?>">
              <i class="fas fa-pencil-alt" style="margin-right: 4px"></i>
              Modifier 
            </a>
          </div>
          <div class="col-sm-6 align-items-center text-center justify-content-center" style="margin-left: 15px">
            <button type="button" style="width: 90%; font-size: 20px" class="btn btn-danger" data-toggle="modal" data-target="#modalDeleteVUser<?php echo $viewUser['id'];?>">
              <i class="fas fa-trash" style="margin-right: 4px"></i>
              Supprimer 
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalDeleteVUser<?php echo $viewUser['id'];?>">
              <div class="modal-dialog">
                <div class="modal-content bg-danger">
                  <div class="modal-header">
                    <h4 class="modal-title">Suppression</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                  <p>Voulez-vous vraiment supprimer cette utilisateur '<?=$viewUser['nom']?>'?</p>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-outline-light" href="./Include/profileADM.inc.php?delete=<?=$viewUser['id']?>">Supprimer</a>
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
<!-- /VU -->

    <!-- AU -->
    <div class="tab-pane" id="AU">
      <form id="formADM" action="./Include/profileADM.inc.php" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <i class="fas fa-poll-h mr-2"></i>
              <label>Nom<span class="text-red ml-1">*</span></label>
              <input type="text" name="nom" id="nom" class="form-control" placeholder="Nom" value="<?=$_GET['nom']?>">
            </div>
            <div id="errorNom" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
            <div class="form-group">
              <i class="fas fa-poll-h mr-2"></i>
              <label>Prenom<span class="text-red ml-1">*</span></label>
              <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Prenom" value="<?=$_GET['prenom']?>">
            </div>
            <div id="errorPrenom" class="text-red text-sm ml-1 mb-3" style="margin-top: -12px"></div>
          </div>
          <div class="col-sm-6 text-center">
            <!-- Photo -->
            <input id="fileInput1" type="file" name="file" class="file1" style="visibility: hidden; position: absolute;">
            <button type="button" class="browse1 btn btn-lg mt-1">
            <img class="profile-user-img img-fluid img-circle"
            style="width: 160px; height: 150px"
            src="./Icons/account2.png"
            alt="User profile picture"
            id="preview1">
            </button>
            <!-- /Photo -->
          </div>
        </div>

        <div class="row" style="margin-top: -10px">
          <div class="col-sm-6">
            <div class="form-group">
              <i class="fas fa-id-card mr-2"></i>
              <label>Matricule<span class="text-red ml-1">*</span></label>
              <input type="text" name="matricule" id="matricule" class="form-control" placeholder="Matricule" value="<?=$_GET['matricule']?>">
            </div>
            <div id="errorMatricule" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
          </div>
          <div class="col-sm-6">
          </div>
        </div>

      <div class="row">
        <div class="col-sm-6">
        <div class="form-group">
          <i class="fas fa-user mr-2"></i><label>Type Utilisateur<span class="text-red ml-1">*</span></label>
          <select name="TU" id="select1" class="form-control select2bs4">
            <option selected="selected">Choisissez le type d'utilisateur</option>
            <option value="Etudiant">Etudiant</option>
            <option value="Enseignant">Enseignant</option>
          </select>
        </div>
        <div id="errorTU" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
        </div>
        <div class="col-sm-6">
<?php if (isset($_GET['sex'])) $sex = $_GET['sex']; ?>
          <i class="fas fa-venus-mars mr-2"></i><label class="mb-3">Sexe<span class="text-red ml-1">*</span></label>
          <div class="form-group clearfix ml-4">
            <div class="icheck-primary d-inline mr-2">
              <input type="radio" id="radioPrimary1" name="sexe" value="Male"<?php if (!strcmp($sex, 'Male')) echo 'checked'; ?>>
              <label for="radioPrimary1">
                Male
              </label>
            </div>
            <div class="icheck-primary d-inline mr-2">
              <input type="radio" id="radioPrimary2" name="sexe" value="Female"<?php if (!strcmp($sex, 'Female')) echo 'checked'; ?>>
              <label for="radioPrimary2">
                Female
              </label>
            </div>
            <div class="icheck-primary d-inline mr-2">
              <input type="radio" id="radioPrimary3" name="sexe" value="Autre"<?php if (!strcmp($sex, 'Autre')) echo 'checked'; ?>>
              <label for="radioPrimary3">
                Autre 
              </label>
            </div>
          </div>
        <div id="errorSex" class="text-red text-sm mb-2" style="margin-top: -12px; margin-left: 20px"></div>
        </div>
      </div>

<!-- this is extended through AJAX on the script in header file! -->
        <div id="myOptions1"> 
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <i class="fas fa-key mr-2"></i><label>Mot de passe<span class="text-red ml-1">*</span></label>
              <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Entrez un mot de passe" value="">
            </div>
          <div id="errorPwd" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <i class="fas fa-key mr-2"></i><label>Confirmer Mot de passe<span class="text-red ml-1">*</span></label>
              <input type="password" name="pwd2" id="pwd2" class="form-control" placeholder="Confirmer votre mot de passe" value="">
            </div>
          <div id="errorPwd2" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
          </div>
        </div>

        <button name="submit" class="btn btn-primary mt-3" style="width: 25%">
            Submit
        </button>
      </form>
    </div>
    <!-- /AU -->

    <!-- MU -->
<?php if (isset($_GET['update'])): ?>
      <div class="tab-pane active" id="MU">
      <form id="formADMM" action="./Include/profileADM.inc.php?update=<?=$_GET['update']?>" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <i class="fas fa-poll-h mr-2"></i>
              <label>Nom<span class="text-red ml-1">*</span></label>
              <input type="text" name="nom" id="nomM"class="form-control" placeholder="Nom" value="<?=$viewUser['nom']?>">
            </div>
            <div id="errorNomM" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
            <div class="form-group">
              <i class="fas fa-poll-h mr-2"></i>
              <label>Prenom<span class="text-red ml-1">*</span></label>
              <input type="text" name="prenom" id="prenomM" class="form-control" placeholder="Prenom" value="<?=$viewUser['prenom']?>">
            </div>
            <div id="errorPrenomM" class="text-red text-sm ml-1 mb-3" style="margin-top: -12px"></div>
          </div>
          <div class="col-sm-6 text-center">
            <!-- Photo -->
            <input id="fileInput2" type="file" name="file" class="file2" style="visibility: hidden; position: absolute;">
            <button type="button" class="browse2 btn btn-lg mt-1">
<?php if (empty($viewUser['photo']) || $viewUser['photo'] == '<null>') $viewUser['photo'] = 'account2.png'; ?>
            <img class="profile-user-img img-fluid img-circle"
            style="width: 160px; height: 150px"
            src="./Pics/<?=$viewUser['photo']?>"
            alt="User profile picture"
            id="preview2">
            </button>
            <!-- /Photo -->
            <input type="hidden" name="photo" value="<?=$viewUser['photo']?>">
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <i class="fas fa-id-card mr-2"></i>
              <label>Matricule<span class="text-red ml-1">*</span></label>
              <input type="text" name="matricule" id="matriculeM" class="form-control" placeholder="Matricule" value="<?=$viewUser['matricule']?>">
            </div>
            <div id="errorMatriculeM" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
          </div>
        </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <i class="fas fa-user mr-2"></i><label>Type Utilisateur<span class="text-red ml-1">*</span></label>
            <select id="select2" class="form-control select2bs4 " disabled>
              <option value="Etudiant" <?php if ($type == 'Etudiant') echo 'selected'; ?>>Etudiant</option>
              <option value="Enseignant" <?php if ($type == 'Enseignant') echo 'selected'; ?>>Enseignant</option>
            </select>
            <input type="hidden" name="TU" value="<?=$type?>">
          </div>
        <div id="errorTUM" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
        </div>
        <div class="col-sm-6">
          <i class="fas fa-venus-mars mr-1"></i>
          <label class="mb-3">
            Sexe<span class="text-red ml-1">*</span>
          </label>
          <div class="form-group clearfix ml-4">
            <div class="icheck-primary d-inline mr-2">
              <input type="radio" id="radio1" name="sexe" value="Male"<?php if ($viewUser['sexe'] == 'Male') echo 'checked'; ?>>
              <label for="radio1">
                Male
              </label>
            </div>
            <div class="icheck-primary d-inline mr-2">
              <input type="radio" id="radio2" name="sexe" value="Female"<?php if ($viewUser['sexe'] == 'Female') echo 'checked'; ?>>
              <label for="radio2">
                Female
              </label>
            </div>
            <div class="icheck-primary d-inline mr-2">
              <input type="radio" id="radio3" name="sexe" value="Autre"<?php if ($viewUser['sexe'] == 'Autre') echo 'checked'; ?>>
              <label for="radio3">
                Autre 
              </label>
            </div>
          </div>
        <div id="errorSexM" class="text-red text-sm mb-2" style="margin-top: -12px; margin-left: 20px"></div>
        </div>
      </div>

<?php if ($type == 'Etudiant'): ?>
        <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <i class="fas fa-graduation-cap mr-2"></i><label>Spécialité<span class="text-red ml-1">*</span></label>
            <select name="spc" class="form-control select2bs4">
              <option <?php if ($viewUser['speciality'] == 'L1-MI') echo 'selected'; ?>>L1-MI</option>
              <option <?php if ($viewUser['speciality'] == 'L2-INFO') echo 'selected'; ?>>L2-INFO</option>
              <option <?php if ($viewUser['speciality'] == 'L3-ISIL') echo 'selected'; ?>>L3-ISIL</option>
              <option <?php if ($viewUser['speciality'] == 'L3-SI') echo 'selected'; ?>>L3-SI</option>
              <option <?php if ($viewUser['speciality'] == 'M1-ILTI') echo 'selected'; ?>>M1-ILTI</option>
              <option <?php if ($viewUser['speciality'] == 'M1-SIR') echo 'selected'; ?>>M1-SIR</option>
              <option <?php if ($viewUser['speciality'] == 'M1-TI') echo 'selected'; ?>>M1-TI</option>
              <option <?php if ($viewUser['speciality'] == 'M2-ILTI') echo 'selected'; ?>>M2-ILTI</option>
              <option <?php if ($viewUser['speciality'] == 'M2-SIR') echo 'selected'; ?>>M2-SIR</option>
              <option <?php if ($viewUser['speciality'] == 'M2-TI') echo 'selected'; ?>>M2-TI</option>
            </select>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
           <i class="fas fa-users mr-2"></i><label>Groupe<span class="text-red ml-1">*</span></label>
           <div class="input-group mb-3">
             <input type="text" name="groupe" class="form-control" placeholder="07" value="<?=$viewUser['groupe']?>">
            </div>
          </div>
        </div>
      </div>
<?php elseif ($type == 'Enseignant'): ?>
          <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
                  <i class="fas fa-user-graduate mr-2"></i><label>Diplôme<span class="text-red ml-1">*</span></label>
                  <div class="input-group">
                    <input type="text" name="dep" class="form-control" placeholder="Licence BioInformatique" value="<?=$viewUser['deplome']?>">
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <i class="fas fa-layer-group mr-2"></i><label>Grade<span class="text-red ml-1">*</span></label>
                  <select name="grade" class="form-control select2bs4">
                    <option <?php if ($viewUser['grade'] == 'MAA') echo 'selected'; ?>>MAA</option>
                    <option <?php if ($viewUser['grade'] == 'MAB') echo 'selected'; ?>>MAB</option>
                    <option <?php if ($viewUser['grade'] == 'MCA') echo 'selected'; ?>>MCA</option>
                    <option <?php if ($viewUser['grade'] == 'MCB') echo 'selected'; ?>>MCB</option>
                    <option <?php if ($viewUser['grade'] == 'PROF') echo 'selected'; ?>>PROF</option>
                  </select>
                </div>
              </div>
            </div>
<?php endif; ?>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <i class="fas fa-key mr-2"></i><label>Mot de passe<span class="text-red ml-1">*</span></label>
              <input type="password" name="pwd" id="pwdM" class="form-control" placeholder="Entrez un mot de passe" value="">
            </div>
          <div id="errorPwdM" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <i class="fas fa-key mr-2"></i><label>Confirmer Mot de passe<span class="text-red ml-1">*</span></label>
              <input type="password" name="pwd2" id="pwd2M" class="form-control" placeholder="Confirmer votre mot de passe" value="">
            </div>
          <div id="errorPwd2M" class="text-red text-sm ml-1 mb-2" style="margin-top: -12px"></div>
          </div>
        </div>

        <button name="submit" class="btn btn-primary mt-3" style="width: 25%">
            Submit
        </button>
      </form>
      </div>
<?php endif; ?>
    <!-- /MU -->

<?php require './Pages/settings.php'; ?>

    </div>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->

<script src="./Plugins/js/profileADM.js"></script>

<script>

// For image preview requires some javascript!
$(document).on("click", ".browse1", function() {
  var file = $(this).parents().find(".file1");
  file.trigger("click");
});
$("#fileInput1").change(function(e) {
  var fileName = e.target.files[0].name;
  $("#file1").val(fileName);

  var reader = new FileReader();
  reader.onload = function(e) {
    // get loaded data and render thumbnail.
    document.getElementById("preview1").src = e.target.result;
  };
  // read the image file as a data URL.
  reader.readAsDataURL(this.files[0]);
});

$(document).on("click", ".browse2", function() {
  var file = $(this).parents().find(".file2");
  file.trigger("click");
});
$("#fileInput2").change(function(e) {
  var fileName = e.target.files[0].name;
  $("#file2").val(fileName);

  var reader = new FileReader();
  reader.onload = function(e) {
    document.getElementById("preview2").src = e.target.result;
  };
  reader.readAsDataURL(this.files[0]);
});

</script>
