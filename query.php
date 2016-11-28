<!DOCTYPE html>
<html lang="zh-TW">
<?php 
	include("phpManager/DBManager.php");
	$DBManager = new DBManager; 
	$check = $_GET['checkbox-book'];
	$flag = [false, false, false, false, true];
	if(count($check) <= 1) {
		//全選
		$flag = [true, true, true, true, true];
	} else {
		foreach($check as $key=>$value) {
			$flag[$value] = true;
		}
	}
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



<body style="padding-top: 70px" >
	<!-- Static navbar -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation" >
    	<div class="container-fluid">
        	<div class="navbar-header">
          		<a class="navbar-brand" href="index.php">春秋對讀系統</a>
        	</div>
			
			<div class = "row">
				<div class="col-lg-4" >
					<span style="font-size:16px" >現有的檢索文本 :</span>
					<form action="query.php" method="GET">
						<label style="font-size:16px" class="checkbox-inline">
						  <input class="checkbox-book" name="checkbox-book[]" type="checkbox" value="0" <?php if($flag[0] == true) echo "checked"?> >春秋
						</label>
						<label style="font-size:16px" class="checkbox-inline">
						  <input class="checkbox-book" name="checkbox-book[]" type="checkbox" value="1" <?php if($flag[1] == true) echo "checked"?> >左傳
						</label>
						<label style="font-size:16px" class="checkbox-inline">
						  <input class="checkbox-book" name="checkbox-book[]" type="checkbox" value="2" <?php if($flag[2] == true) echo "checked"?> >公羊傳
						</label>
						<label style="font-size:16px" class="checkbox-inline">
						  <input class="checkbox-book" name="checkbox-book[]" type="checkbox" value="3" <?php if($flag[3] == true) echo "checked"?> >穀梁傳
						</label>
						
						<label style="font-size:16px" class="checkbox-inline hidden">
						  <input class="checkbox-book" name="checkbox-book[]" type="checkbox" value="4" checked>
						</label>
						<input type="text" name="query" class="form-control hidden" value="<?php echo $_GET['query']; ?>" >
						
						<button type="submit" class="btn btn-default btn-sm" style="margin-left:12px;" >
							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</button>
					</form>
				</div>
				
				
				
				<form class="navbar-form navbar-right" action="query.php" method="GET">
					<input type="text" name="query" class="form-control" placeholder=" <?php echo $_GET['query']; ?> ">
				</form>
			</div>

      	</div>
    </nav>

	    <!-- Main board -->
    <div class="container-fluid" >
    	<div class="row">
			<div class="col-sm-3 col-md-3" >	
				<div style='width:24%;height:800px;position:fixed;overflow-y:scroll' >
					<h1>檢索結果 : <?php echo $_GET['query']; ?></h1>
				
					<div role="tabpanel" >
					  <!-- Nav tabs -->
					  <ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#yearList" aria-controls="yearList" role="tab" data-toggle="tab">君主年份</a></li>
						<li role="presentation"><a href="#seasonList" aria-controls="seasonList" role="tab" data-toggle="tab">季節</a></li>
						<li role="presentation"><a href="#monthList" aria-controls="monthList" role="tab" data-toggle="tab">月份</a></li>
						
					  </ul>

					  <!-- Tab panes -->
					  <div class="tab-content">
						<div role="tabpanel" class="tab-pane active panel-body" id="yearList" >
							<h3><strong>依照君主年份</strong></h3>
							<ul>
								<?php $DBManager->groupBy($_GET['query'], 1, $flag); ?>
							</ul>
						</div>
						<div role="tabpanel" class="tab-pane panel-body" id="seasonList">
							<h3><strong>依照季節</strong></h3>
							<ul>
								<?php $DBManager->groupBy($_GET['query'], 2, $flag); ?>
							</ul>
						</div>
						<div role="tabpanel" class="tab-pane panel-body" id="monthList">
							<h3><strong>依照月份</strong></h3>
							<ul>
								<?php $DBManager->groupBy($_GET['query'], 3, $flag); ?>
							</ul>
						</div>
<!--
						<div role="tabpanel" class="tab-pane panel-body" id="bookList">
							<h3><strong>依照文本</strong></h3>
							<ul>
								<?php //$DBManager->groupBy($_GET['query'], 4, $flag); ?>
							</ul>
						</div>
-->
					  </div>
					</div>
				</div>
			</div>
					
			<div class="col-sm-9 col-md-9  main" >
				<canvas id="secondChart" width="100%" height="25%"></canvas>
				<script>
					var $yearNumArray = <?php echo $DBManager->findYearNumsArray($_GET['query'], $flag); ?>;
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
								text: '君主年份檢索統計'
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
					<?php $DBManager->queryIndexAndSet($_GET['query'], $flag); ?>
				</ul>
			</div>
	    </div>
    </div>
<body>

