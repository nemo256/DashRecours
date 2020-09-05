<?php
  $thisFileName = basename(__FILE__);
  require_once (dirname(__FILE__) . '/Pages/header.php');
?>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <div class="card bg-light">
      <div class="card-body pt-4">
        <div class="row">
          <div class="col-7">
            <h2 class="lead"><b>Département d'informatique</b></h2>
            <ul class="ml-4 mb-0 fa-ul text-muted">
              <li class="pt-3"><span class="fa-li"><i class="fas fa-address-card"></i></span> <b>About: </b> Département d'informatique / Faculté des Sciences / Université de Boumerdes</li>
              <li class="pt-3"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> <b>Address: </b> Université de Boumerdes, Boumerdes, 35000</li>
              <li class="pt-3"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> <b>Phone #: </b> + 213 11 22 33 44</li>
            </ul>
          </div>
          <div class="col-5 text-center">
            <img src="./Icons/depINFO.jpeg" alt="user-avatar" class="profile-user-img img-circle img-fluid" style="width: 210px; height: 210px; margin-left: 7px; margin-right: -60px; margin-top: -10px; margin-bottom: -5px">
          </div>
        </div>
      </div>
    </div>

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?php
    require './Pages/footer.php';
?>
