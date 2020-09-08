<?php

$thisFileName = basename(__FILE__);
require_once (dirname(__FILE__) . '/Pages/header.php');

?>

<!-- Main content -->
<section class="content mt-3">
  <div class="container-fluid">

    <div class="card card-info">
      <div class="card-header">
        <h3 class="card-title"><b>Flux de trafic</b></h3>
      </div>
      <div class="card-body">
<!-- Check if there are no recours -->
<?php if (empty($recs)): ?>
        <div class="callout callout-info">
          <h5>Aucun Recours!</h5>

          <p>Aucun recours n'a été soumis par les étudiants.</p>
        </div>
<?php else: ?>
  <table id="trafficDataTable" class="table table-sm table-striped table-bordered projects">
      <thead>
          <tr>
              <th style="width: 1%">#</th>
              <th style="width: 18%">Module</th>
              <th style="width: 18%">Etudiant</th>
              <th style="width: 18%">Enseignant</th>
              <th style="width: 18%">Status</th>
          </tr>
      </thead>
      <tbody>
<?php foreach ($recs as $rec):?>
          <tr>
<?php 
$ET  = new etudiant($rec['idet']);
$ENS = new enseignant($rec['idens']);

$ET  = $ET->getInfo();
$ENS = $ENS->getInfo();
?>
            <td class="text-center"><?=$rec['id']?></td>
            <td class="text-center"><?=$rec['module']?></td>
            <td class="text-center"><?=$ET['nom']?></td>
            <td class="text-center"><?=$ENS['nom']?></td>
            <td class="project-state">
              <span class="badge badge-<?php if ($rec['status'] == 'En Cours') echo 'warning'; elseif ($rec['status'] == 'Refus&eacute;') echo 'danger'; elseif ($rec['status'] == 'Valid&eacute;') echo 'success'; ?>"><?=$rec['status']?></span>
            </td>
         </tr>
<?php endforeach; ?>
      </tbody>
  </table>
<?php endif; ?>
      </div> <!-- card-body -->
    </div> <!-- card -->

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<?php
    require './Pages/footer.php';
?>
