<?php 
  include 'includes/session.php';
  include 'includes/format.php'; 
  include 'includes/function.php'; 
?>
<?php 
  $today = date('Y-m-d');
  $year = date('Y');
  $select_days = 7;
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }
  if(isset($_GET['select_days'])){
    $select_days = $_GET['select_days'];
  }

  $conn = $pdo->open();
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Alert Messages -->
        <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>

        <!-- Small boxes (Stat box) -->
        <div class="row">
            <!-- Total Sales -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <!-- Total Sales -->
                        <?php
                            $totalSales = getTotalSales($conn);
                            echo "<h3>&#36; " . number_format_short($totalSales, 2) . "</h3>";
                        ?>
                        <p>Total Sales</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="book.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- Number of Products -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <!-- Number of Products -->
                        <?php
                            $numProducts = getNumberOfProducts($conn);
                            echo "<h3>" . $numProducts . "</h3>";
                        ?>
                        <p>Number of Products</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-barcode"></i>
                    </div>
                    <a href="student.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- Number of Users -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <!-- Number of Users -->
                        <?php
                            $numUsers = getNumberOfUsers($conn);
                            echo "<h3>" . $numUsers . "</h3>";
                        ?>
                        <p>Number of Users</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="return.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <!-- Sales Today -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <!-- Sales Today -->
                        <?php
                            $salesToday = getSalesToday($conn);
                            echo "<h3>&#36; " . number_format_short($salesToday, 2) . "</h3>";
                        ?>
                        <p>Sales Today</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money"></i>
                    </div>
                    <a href="borrow.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Monthly and Daily Sales Report -->
        <div class="row">
            <!-- Monthly Sales Report -->
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Monthly Sales Report</h3>
                        <div class="box-tools pull-right">
                          <form class="form-inline">
                            <div class="form-group">
                              <label>Select Year: </label>
                              <select class="form-control input-sm" id="select_year">
                                <?php
                                  for($i=2015; $i<=2065; $i++){
                                    $selected = ($i==$year)?'selected':'';
                                    echo "
                                      <option value='".$i."' ".$selected.">".$i."</option>
                                    ";
                                  }
                                ?>
                              </select>
                            </div>
                          </form>
                        </div>
                    </div>
                    
                    <div class="box-body">
                        <div class="chart">
                            <br>
                            <div id="legend" class="text-center"></div>
                            <canvas id="monthlyBarChart" style="height:350px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Daily Sales Report -->
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Daily Sales Report</h3>
                        <div class="box-tools pull-right">
                          <form class="form-inline">
                            <div class="form-group">
                              <label>Select Days: </label>
                              <select class="form-control input-sm" id="select_days">
                                <?php
                                  for($i=7; $i<=31; $i++){
                                    $selected = ($i==$select_days)?'selected':'';
                                    echo "
                                      <option value='".$i."' ".$selected.">".$i."</option>
                                    ";
                                  }
                                ?>
                              </select>
                            </div>
                          </form>
                        </div>
                    </div>
                    <div class="box-body">
                      <!-- Daily Sales Data -->
                      <?php
                          $dailySalesData = getDailySales($conn,$select_days);
                          if ($dailySalesData) {
                              echo "<p>Total Sales in the Last $$select_days Days: &#36; " . number_format_short($dailySalesData['total'], 2) . "</p>";
                              echo "<p>Number of Sales in the Last $select_days Days: " . $dailySalesData['count'] . "</p>";
                              $last7DaysSales = array();
                              $last7Days = array();
                              foreach ($dailySalesData['daily_sales'] as $date => $s) {

                                  array_push($last7DaysSales, $s);

                                  array_push($last7Days, $date);

                              }

                              $last7DaysSales = json_encode($last7DaysSales);
                              $last7Days = json_encode($last7Days);
                          } else {
                              echo "<p>No sales recorded in the last 7 days.</p>";
                          }
                      ?>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <br>
                            <div id="legend" class="text-center"></div>
                            <canvas id="dailyBarChart" style="height:350px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
      <!-- right col -->
    </div>

</div>
<!-- ./wrapper -->

<!-- Chart Data -->
<?php
  $months = array();
  $sales = array();
  for( $m = 1; $m <= 12; $m++ ) {
    try{
      $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE MONTH(sales_date)=:month AND YEAR(sales_date)=:year");
      $stmt->execute(['month'=>$m, 'year'=>$year]);
      $total = 0;
      foreach($stmt as $srow){
        $subtotal = $srow['price']*$srow['quantity'];
        $total += $subtotal;    
      }
      array_push($sales, round($total, 2));
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }

    $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
    $month =  date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month);
  }

  $months = json_encode($months);
  $sales = json_encode($sales);
?>
<!-- End Chart Data -->

<?php $pdo->close(); ?>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  var barChartCanvas = $('#monthlyBarChart').get(0).getContext('2d')
  var barChart = new Chart(barChartCanvas)
  var barChartData = {
    labels  : <?php echo $months; ?>,
    datasets: [
      {
        label               : 'SALES',
        fillColor           : 'rgba(60,141,188,0.9)',
        strokeColor         : 'rgba(60,141,188,0.8)',
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : <?php echo $sales; ?>
      }
    ]
  }
  //barChartData.datasets[1].fillColor   = '#00a65a'
  //barChartData.datasets[1].strokeColor = '#00a65a'
  //barChartData.datasets[1].pointColor  = '#00a65a'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  var myChart = barChart.Bar(barChartData, barChartOptions)
  document.getElementById('legend').innerHTML = myChart.generateLegend();
});
</script>
<script>
$(function(){
  var dailyBarChartCanvas = $('#dailyBarChart').get(0).getContext('2d');
  var dailyBarChart = new Chart(dailyBarChartCanvas);
  var dailyBarChartData = {
    labels  : <?php echo $last7Days; ?>,
    datasets: [
      {
        label               : 'SALES',
        fillColor           : 'rgba(60,141,188,0.9)',
        strokeColor         : 'rgba(60,141,188,0.8)',
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : <?php echo $last7DaysSales; ?>
      }
    ]
  };

  var dailyBarChartOptions = {
    scaleBeginAtZero        : true,
    scaleShowGridLines      : true,
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    scaleGridLineWidth      : 1,
    scaleShowHorizontalLines: true,
    scaleShowVerticalLines  : true,
    barShowStroke           : true,
    barStrokeWidth          : 2,
    barValueSpacing         : 5,
    barDatasetSpacing       : 1,
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    responsive              : true,
    maintainAspectRatio     : true
  };

  dailyBarChartOptions.datasetFill = false;
  var myDailyChart = dailyBarChart.Bar(dailyBarChartData, dailyBarChartOptions);
  document.getElementById('dailyLegend').innerHTML = myDailyChart.generateLegend();
});
</script>
<script>
$(function(){
  $('#select_year, #select_days').change(function(){
    var year = $('#select_year').val();
    var days = $('#select_days').val();
    var url = 'home.php?year=' + year + '&select_days=' + days;
    window.location.href = url;
  });
});
</script>
</body>
</html>
