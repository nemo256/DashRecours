<?php

  $thisFileName = basename(__FILE__);

  require_once (dirname(__FILE__) . '/Pages/header.php');
  require_once (dirname(__FILE__) . '/Classes/Recours.php');

  for ($m = 1; $m <= 12; $m++)
  {
    $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
    $recoursTotale[$month] = 0;
  }

  $rec = new recours(-1);

  foreach ($rec->getAllrecours() as $key => $row)
    $recoursTotale[$row['dateR']]++;


?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-purple" style="bg-color: #F39C12;">
              <div class="inner">
                <h3><?=$nbrEtudiant?></h3>
                <p>Nombre<br>&Eacute;tudiants</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-people"></i>
              </div>
<?php if ($_SESSION['TU'] == 'Administrateur'): ?>
              <a href="./trafic.php" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
<?php endif; ?>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-indigo">
              <div class="inner">
                <h3><?=$nbrEnseignant?></h3>
                <p>Nombre<br>Enseignants</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-contact"></i>
              </div>
<?php if ($_SESSION['TU'] == 'Administrateur'): ?>
              <a href="./trafic.php" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
<?php endif; ?>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-blue">
              <div class="inner">
                <h3><?=$nbrUtilisateur?></h3>
                <p>Inscriptions<br>Utilisateurs</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
<?php if ($_SESSION['TU'] == 'Administrateur'): ?>
              <a href="./trafic.php" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
<?php endif; ?>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-pink">
              <div class="inner">
                <h3><?=$nbrVisiteur?></h3>
                <p>Nombre<br>Visiteurs</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-body"></i>
              </div>
<?php if ($_SESSION['TU'] == 'Administrateur'): ?>
              <a href="./trafic.php" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
<?php endif; ?>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$nbrAdministrateur?></h3>
                <p>Nombre<br>Administrateurs</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
<?php if ($_SESSION['TU'] == 'Administrateur'): ?>
              <a href="./trafic.php" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
<?php endif; ?>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$nbrRecours?></h3>
                <p>Nombre Totale<br>des Recours</p>
              </div>
              <div class="icon">
                <i class="ion ion-document-text"></i>
              </div>
<?php if ($_SESSION['TU'] == 'Administrateur'): ?>
              <a href="./trafic.php" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
<?php endif; ?>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=$nbrRecoursValidePerc?><sup style="font-size: 22px">%</sup></h3>
                <p>Recours<br>Valid&eacute;</p>
              </div>
              <div class="icon">
                <i class="ion ion-checkmark-circled"></i>
              </div>
<?php if ($_SESSION['TU'] == 'Administrateur'): ?>
              <a href="./trafic.php" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
<?php endif; ?>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?=$nbrRecoursRefusePerc?><sup style="font-size: 22px">%</sup></h3>
                <p>Recours<br>Refus&eacute;</p>
              </div>
              <div class="icon">
                <i class="ion ion-close-circled"></i>
              </div>
<?php if ($_SESSION['TU'] == 'Administrateur'): ?>
              <a href="./trafic.php" class="small-box-footer">Plus d'info <i class="fas fa-arrow-circle-right"></i></a>
<?php endif; ?>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-stats-bars mr-1"></i>
                    Statut Des Recours
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong>Recours: 1 Sep, 2019 - 30 Mai, 2020</strong>
                    </p>
                    <div class="chart">
                      <!-- Rec Chart Canvas -->
                      <canvas id="recChart" height="180"></canvas>
                    </div>
                    <!-- /.chart-responsive -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-4">
                    <p class="text-center">
                      <strong>&Eacute;tats des recours</strong>
                    </p>

                    <div class="progress-group">
                      Recours Totale
                      <span class="float-right"><b><?=$nbrRecours?></b>/<?=$nbrRecours?></span>
                      <div class="progress progress-sm">
                        <div class="progress-bar bg-info" style="width: 100%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->

                    <div class="progress-group">
                      Recours Valid&eacute;
<span class="float-right"><b><?=$nbrRecoursValide?></b>/<?=$nbrRecours?></span>
                      <div class="progress progress-sm">
                      <div class="progress-bar bg-success" style="width: <?=$nbrRecoursValidePerc?>%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      <span class="progress-text">Recours Refus&eacute;</span>
                      <span class="float-right"><b><?=$nbrRecoursRefuse?></b>/<?=$nbrRecours?></span>
                      <div class="progress progress-sm">
                      <div class="progress-bar bg-danger" style="width: <?=$nbrRecoursRefusePerc?>%"></div>
                      </div>
                    </div>

                    <!-- /.progress-group -->
                    <div class="progress-group">
                      Recours En Progrès 
                      <span class="float-right"><b><?=$nbrRecoursEnCours?></b>/<?=$nbrRecours?></span>
                      <div class="progress progress-sm">
                      <div class="progress-bar bg-warning" style="width: <?=$nbrRecoursEnCoursPerc?>%"></div>
                      </div>
                    </div>
                    <!-- /.progress-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->


        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                    <i class="ion ion-stats-bars mr-1"></i>
                    Status Des Utilisateurs
                </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="chart">
                  <!-- Rec Chart Canvas -->
                  <canvas id="radarChart" height="200"></canvas>
                </div>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->

          </section>
          <!-- /.Left col -->
          <section class="col-lg-5 connectedSortable">
    
            <!-- Calendar -->
            <div class="card bg-gradient-success">
              <div class="card-header border-0">

                <h3 class="card-title">
                  <i class="far fa-calendar-alt mr-1"></i>
                  Calendrier
                </h3>
                <!-- tools card -->
                <div class="card-tools">
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
                <div id="calendar" style="width: 100%"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

              <!-- /.card-body -->
              <div class="d-none">
                    <div id="sparkline-1"></div>
                  <!-- ./col -->
                    <div id="sparkline-2"></div>
                  <!-- ./col -->
                    <div id="sparkline-3"></div>
                  <!-- ./col -->
              </div>
                <!-- /.row -->
            <!-- /.card -->

          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<script>
$(function () {
  'use strict'

  // The Calendar
  $('#calendar').datetimepicker({
    format: 'L',
    inline: true
  })

  // AREA CHART (Recours Totale)
  var recChartCanvas = $('#recChart').get(0).getContext('2d')

  var recChartData = {
    labels  : ['Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai'],
    datasets: [
      {
        label               : 'Recours Totale',
        backgroundColor     : 'rgb(100, 181, 246)',
        borderColor         : 'rgb(63, 81, 181)',
        data                : [
          <?=$recoursTotale['September']?>,
          <?=$recoursTotale['October']?>,
          <?=$recoursTotale['November']?>,
          <?=$recoursTotale['December']?>,
          <?=$recoursTotale['January']?>,
          <?=$recoursTotale['February']?>,
          <?=$recoursTotale['March']?>,
          <?=$recoursTotale['April']?>,
          <?=$recoursTotale['May']?>
        ]
      },
    ]
  }

  var recChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    elements: {
      point: {
        hoverBackgroundColor: 'rgb(63, 81, 181)',
        radius: 5,
        hoverRadius: 10,
      },
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: false
        }
      }],
      yAxes: [{
        gridLines: {
          display: false
        }
      }]
    }
  }

  var recChart = new Chart(recChartCanvas, {
    type: 'line',
    data: recChartData,
    options: recChartOptions
  })
})
</script>
<script>
$(function () {
  'use strict'

  var radarChartCanvas = $('#radarChart').get(0).getContext('2d')

  var radarChartData = {
    labels   : ["𝗘𝗻𝘀𝗲𝗶𝗴𝗻𝗮𝗻𝘁𝘀","𝗘𝘁𝘂𝗱𝗶𝗮𝗻𝘁𝘀","𝗔𝗱𝗺𝗶𝗻𝗶𝘀𝘁𝗿𝗮𝘁𝗲𝘂𝗿𝘀","𝗩𝗶𝘀𝗶𝘁𝗲𝘂𝗿𝘀"],
    datasets : [
      { 
        label: "Users",
        fill : 'origin',
        data : 
        [
          <?=$nbrEnseignant?>,
          <?=$nbrEtudiant?>,
          <?=$nbrAdministrateur?>,
          <?=$nbrVisiteur?>
        ] 
      },
    ]
  }

  var radarChartOptions = {
    responsive: true,
    legend: false,
    spanGaps: true,
    elements: {
      line: {
        backgroundColor: 'rgb(225, 190, 231)',
        borderColor: 'rgb(171, 71, 188)'
      },
      point: {
        backgroundColor: 'rgb(171, 71, 188)',
        hoverBackgroundColor: 'rgb(186, 104, 200)',
        radius: 5,
        hoverRadius: 10,
      },
    },
    scale: {
      ticks: {
          beginAtZero: true,
          stepSize: 4
      }
    }
  }

  var radarChart = new Chart(radarChartCanvas, {
    type: 'radar',
    data: radarChartData,
    options: radarChartOptions
  })
})
</script>
<?php
    require_once ('./Pages/footer.php');
?>
