  
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="./Plugins/js/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="./Plugins/js/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="./Plugins/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="./Plugins/js/Chart.js"></script>
<!-- Sparkline -->
<script src="./Plugins/js/sparkline.js"></script>
<!-- JQVMap -->
<script src="./Plugins/js/jqvmap/jquery.vmap.min.js"></script>
<script src="./Plugins/js/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="./Plugins/js/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="./Plugins/js/moment.min.js"></script>
<script src="./Plugins/js/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="./Plugins/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="./Plugins/js/summernote/summernote-bs4.min.js"></script>
<!-- DataTables -->
<script src="./Plugins/js/jquery.dataTables.min.js"></script>
<script src="./Plugins/js/dataTables.bootstrap4.min.js"></script>
<script src="./Plugins/js/dataTables.responsive.min.js"></script>
<script src="./Plugins/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="./Plugins/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo -->
<script src="./Plugins/js/dashboard.js"></script>
<script src="./Plugins/js/dashboard2.js"></script>
<script src="./Plugins/js/dashboard3.js"></script>
<!-- bs-custom-file-input -->
<script src="./Plugins/js/bs-custom-file-input.min.js"></script>
<!-- JS and Jquery for Photo previewing and generating charts -->

<script>

// For image preview requires some javascript!
$(document).on("click", ".browse", function() {
  var file = $(this).parents().find(".file");
  file.trigger("click");
});
$('input[type="file"]').change(function(e) {
  var fileName = e.target.files[0].name;
  $("#file").val(fileName);

  var reader = new FileReader();
  reader.onload = function(e) {
    // get loaded data and render thumbnail.
    document.getElementById("preview").src = e.target.result;
  };
  // read the image file as a data URL.
  reader.readAsDataURL(this.files[0]);
});

$(function () {

  // DATA TABLE

  $("#dataTable").DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "responsive": true,
    "columns": [
        { data: "#" },
        { data: "Nom" },
        { data: "Prenom" },
        { data: "Type" },
        { data: "Email" },
        { data: "Action" }
    ],
    "columnDefs": [{
      "targets": 5,
      "orderable": false,
    }]
  });

  // DATA TABLE FOR TRAFIC PAGE

  $("#trafficDataTable").DataTable({
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "responsive": true
  });

  // AREA CHART

  // Get context with jQuery using jQuery's .get() method.
  var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

  var areaChartData = {
    labels  : ['Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Fév', 'Mar', 'Avr', 'Mai'],
    datasets: [
      {
        label               : 'Recours Validé',
        backgroundColor     : 'rgb(139, 195, 74)',
        borderColor         : 'rgb(76, 175, 80)',
        pointRadius         : false,
        pointColor          : '#FF0000',
        pointStrokeColor    : 'rgba(255,0,0,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : [
          <?=$recoursValide['September']?>,
          <?=$recoursValide['October']?>,
          <?=$recoursValide['November']?>,
          <?=$recoursValide['December']?>,
          <?=$recoursValide['January']?>,
          <?=$recoursValide['February']?>,
          <?=$recoursValide['March']?>,
          <?=$recoursValide['April']?>,
          <?=$recoursValide['May']?>
        ]
      },
      {
        label               : 'Recours Refusé',
        backgroundColor     : 'rgb(255, 87, 34)',
        borderColor         : 'rgb(244, 67, 54)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : [
          <?=$recoursRefuse['September']?>,
          <?=$recoursRefuse['October']?>,
          <?=$recoursRefuse['November']?>,
          <?=$recoursRefuse['December']?>,
          <?=$recoursRefuse['January']?>,
          <?=$recoursRefuse['February']?>,
          <?=$recoursRefuse['March']?>,
          <?=$recoursRefuse['April']?>,
          <?=$recoursRefuse['May']?>
        ]
      },
      {
        label               : 'Recours Non Traité',
        backgroundColor     : 'rgb(255, 193, 7)',
        borderColor         : 'rgb(255, 152, 0)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : [
          <?=$recoursEnCours['September']?>,
          <?=$recoursEnCours['October']?>,
          <?=$recoursEnCours['November']?>,
          <?=$recoursEnCours['December']?>,
          <?=$recoursEnCours['January']?>,
          <?=$recoursEnCours['February']?>,
          <?=$recoursEnCours['March']?>,
          <?=$recoursEnCours['April']?>,
          <?=$recoursEnCours['May']?>
        ]
      },
    ]
  }

  var areaChartOptions = {
    maintainAspectRatio : true,
    responsive : true,
    legend: {
      display: true
    },
    scales: {
      xAxes: [{
        gridLines : {
          display : true,
        }
      }],
      yAxes: [{
        gridLines : {
          display : true,
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  var areaChart       = new Chart(areaChartCanvas, {
    type: 'line',
    data: areaChartData,
    options: areaChartOptions
  })

  // LINE CHART
  var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
  var lineChartOptions = $.extend(true, {}, areaChartOptions)
  var lineChartData = $.extend(true, {}, areaChartData)
  lineChartData.datasets[0].fill = false;
  lineChartData.datasets[1].fill = false;
  lineChartData.datasets[2].fill = false;
  lineChartOptions.datasetFill = false

  var lineChart = new Chart(lineChartCanvas, {
    type: 'line',
    data: lineChartData,
    options: lineChartOptions
  })

  // DONUT CHART
  // Get context with jQuery - using jQuery's .get() method.
  var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
  var donutData        = {
    labels: [
        'Recours Validé',
        'Recours Refusé',
        'Recours Non Traité',
    ],
    datasets: [
      {
        data: [<?=$nbrRecoursValide?>,<?=$nbrRecoursRefuse?>,<?=$nbrRecours?>],
        backgroundColor : ['rgb(139, 195, 74)', 'rgb(255, 87, 34)', 'rgb(255, 193, 7)'],
      }
    ]
  }
  var donutOptions     = {
    maintainAspectRatio : false,
    responsive : true,
  }
  // Create douhnut chart
  var donutChart = new Chart(donutChartCanvas, {
    type: 'doughnut',
    data: donutData,
    options: donutOptions
  })

  // PIE CHART 
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
  var pieData        = donutData;
  var pieOptions     = {
    maintainAspectRatio : false,
    responsive : true,
  }
  // Create pie chart
  var pieChart = new Chart(pieChartCanvas, {
    type: 'pie',
    data: pieData,
    options: pieOptions
  })

  // BAR CHART
  var barChartCanvas = $('#barChart').get(0).getContext('2d')
  var barChartData = $.extend(true, {}, areaChartData)
  var temp0 = areaChartData.datasets[0]
  var temp1 = areaChartData.datasets[1]
  barChartData.datasets[0] = temp1
  barChartData.datasets[1] = temp0

  var barChartOptions = {
    responsive              : true,
    maintainAspectRatio     : false,
    datasetFill             : false
  }

  var barChart = new Chart(barChartCanvas, {
    type: 'bar',
    data: barChartData,
    options: barChartOptions
  })

  // STACKED BAR CHART 
  var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
  var stackedBarChartData = $.extend(true, {}, barChartData)

  var stackedBarChartOptions = {
    responsive              : true,
    maintainAspectRatio     : false,
    scales: {
      xAxes: [{
        stacked: true,
      }],
      yAxes: [{
        stacked: true
      }]
    }
  }

  var stackedBarChart = new Chart(stackedBarChartCanvas, {
    type: 'bar',
    data: stackedBarChartData,
    options: stackedBarChartOptions
  })
})
</script>
</body>
</html>
