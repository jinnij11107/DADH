<!DOCTYPE html>
<html lang="zh-TW">
<?php 
	include("phpManager/DBManager.php");
	$DBManager = new DBManager; 
?>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />

    <title>春秋對讀系統</title>
    
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/main.css" rel="stylesheet">
	<link href="index.css" rel="stylesheet">
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/highlight.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!-- jQuery chart bar ) -->
	<script src="js/Chart.bundle.js"></script>
	
	<!-- myFunction -->
	
	<script type="text/javascript" src="js/query.js"></script>
	
	
</head>

<style type=text/css> 
	body { font-family:微軟正黑體; }
</style>



<body>


	<!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
    	<div class="container-fluid">
        	<div class="navbar-header">
          		<a class="navbar-brand" href="index.php">春秋對讀系統</a>
        	</div>
        	<div id="navbar" class="navbar-collapse collapse">

          		<form class="navbar-form navbar-right" action="query.php" method="GET">
            		<input type="text" name="query" class="form-control" placeholder=" <?php $_GET['query'] ?> ">
          		</form>
				
        	</div>
      	</div>
    </nav>

	    <!-- Main board -->
    <div class="container-fluid" >
    	<div class="row">
			<div class="col-sm-3">	
				<h1>檢索結果</h1>
			
				<div role="tabpanel">
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#yearList" aria-controls="yearList" role="tab" data-toggle="tab">君主年分</a></li>
					<li role="presentation"><a href="#seasonList" aria-controls="seasonList" role="tab" data-toggle="tab">季節</a></li>
					<li role="presentation"><a href="#monthList" aria-controls="monthList" role="tab" data-toggle="tab">月份</a></li>
					<li role="presentation"><a href="#bookList" aria-controls="bookList" role="tab" data-toggle="tab">文本</a></li>
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">
					<div role="tabpanel" class="tab-pane active panel-body" id="yearList" >
						<h3><strong>依照君主年分</strong></h3>
						<ul>
							<?php $DBManager->groupByYear($_GET['query'], 1); ?>
						</ul>
					</div>
					<div role="tabpanel" class="tab-pane panel-body" id="seasonList">
						<h3><strong>依照季節</strong></h3>
						<ul>
							<?php $DBManager->groupByYear($_GET['query'], 2); ?>
						</ul>
					</div>
					<div role="tabpanel" class="tab-pane panel-body" id="monthList">
						<h3><strong>依照月份</strong></h3>
						<ul>
							<?php $DBManager->groupByYear($_GET['query'], 3); ?>
						</ul>
					</div>
					<div role="tabpanel" class="tab-pane panel-body" id="bookList">
						<h3><strong>依照文本</strong></h3>
						<ul>
							<?php $DBManager->groupByYear($_GET['query'], 4); ?>
						</ul>
					</div>
				  </div>
				</div>
			</div>
					
			<div class="col-sm-9 col-md-9  main" >
				<canvas id="secondChart" width="100%" height="25%"></canvas>
				<script>
					var $yearNumArray = <?php echo $DBManager->findYearNumsArray($_GET['query']); ?>;
					var data = {
						labels: ["隱公", "桓公", "莊公", "閔公", "僖公", "文公", "宣公", "成公", "襄公", "昭公", "定公", "哀公"],
						datasets: [
							{
								label: "nums",
								backgroundColor: 'rgba(255, 206, 86, 0.2)',
								borderColor: 'rgba(255, 206, 86, 1)', 
								borderWidth: 2,
								data: $yearNumArray,
							}
						]
					};
					var myBarChart = new Chart($("#secondChart"), {
						type: 'bar',
						data: data,
						options: {
							 title: {
								display: true,
								text: '君主年代檢索統計'
							},
							scales: {
								xAxes: [{
									stacked: true,
									categoryPercentage: 0.5,
									barPercentage: 1, 
								}],
								yAxes: [{
									stacked: true
								}]
							}
						}
					});
				</script>
				<ul class="nav nav-sidebar" style="width:100%;height:100%;">
					<?php $DBManager->queryIndexAndSet($_GET['query']); ?>
				</ul>
			</div>
	    </div>
    </div>
<body>

