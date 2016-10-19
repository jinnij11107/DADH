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
	
	<!-- myFunction -->
	<script type="text/javascript" src="js/content.js"></script>
</head>

<style type=text/css> 
	body { font-family:微軟正黑體; }
</style>

<script type="text/javascript">

function moveAnchor() {
	
	var parentBlock = event.target.parentElement.parentElement.parentElement;
	var $timeArray = event.target.className.split(" ");//0 is text, >= 1 is time
	var classSelector = "";
	for(var i = 1; i < $timeArray.length; i ++) classSelector += "a." + $timeArray[i] + ", ";
	classSelector = classSelector.substr(0, classSelector.length - 2);
	var $blockArray = $("." + parentBlock.className.split(" ")[3]);
	var $anchorArray = [];
	for(var i = 0; i < $blockArray.length; i ++) {
		$anchorArray.push(0);
	}
	for(var i = 0; i < $blockArray.length; i ++) {
		var $temp = $( $blockArray[i] ).find(classSelector);
		if( $temp.length > 0) $anchorArray[i] = $( $temp[0] ).offset().top ;
		else {
			$anchorArray[i] = $( $blockArray[i] ).offset().top 
			missAlert( $($blockArray[i]) );
		}
	}
	var window_gap = $($(".nav-sidebar")[0]).offset().top;
	for(var i = 0; i < $anchorArray.length; i ++) {
		$($(".nav-sidebar")[i]).animate({
			scrollTop: $( $(".nav-sidebar")[i] ).scrollTop() + $anchorArray[i] - $($(".nav-sidebar")[i]).offset().top -60
		}, 600);
	}
	findCgunqiuByIndex(classSelector, parentBlock.className.split(" ")[3]);
}
</script>

<body>
	<!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
    	<div class="container-fluid">
        	<div class="navbar-header">
          		<a class="navbar-brand" href="index.php">春秋對讀系統</a>
        	</div>
        	<div id="navbar" class="navbar-collapse collapse">
         		<ul class="nav navbar-nav">
        		<li class="dropdown" >
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">隱公 <span class="caret"></span></a>
              		<ul class="dropdown-menu">
                		<li><a href="#魯隱公元年">元年</a></li>
                		<li><a href="#魯隱公二年">二年</a></li>
                		<li><a href="#魯隱公三年">三年</a></li>
		                <li><a href="#魯隱公四年">四年</a></li>
		                <li><a href="#魯隱公五年">五年</a></li>
		                <li><a href="#魯隱公六年">六年</a></li>
		                <li><a href="#魯隱公七年">七年</a></li>
		                <li><a href="#魯隱公八年">八年</a></li>
		                <li><a href="#魯隱公九年">九年</a></li>
		                <li><a href="#魯隱公十年">十年</a></li>
		                <li><a href="#魯隱公十一年">十一年</a></li>
		            </ul>
		        </li>
            	<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">桓公 <span class="caret"></span></a>
              		<ul class="dropdown-menu">
	                	<li><a href="#魯桓公元年">元年</a></li>
	                	<li><a href="#魯桓公二年">二年</a></li>
		                <li><a href="#魯桓公三年">三年</a></li>
		                <li><a href="#魯桓公四年">四年</a></li>
		                <li><a href="#魯桓公五年">五年</a></li>
		                <li><a href="#魯桓公六年">六年</a></li>
		                <li><a href="#魯桓公七年">七年</a></li>
		                <li><a href="#魯桓公八年">八年</a></li>
		                <li><a href="#魯桓公九年">九年</a></li>
		                <li><a href="#魯桓公十年">十年</a></li>
		                <li><a href="#魯桓公十一年">十一年</a></li>
		                <li><a href="#魯桓公十二年">十二年</a></li>
		                <li><a href="#魯桓公十三年">十三年</a></li>
		                <li><a href="#魯桓公十四年">十四年</a></li>
		                <li><a href="#魯桓公十五年">十五年</a></li>
		                <li><a href="#魯桓公十六年">十六年</a></li>
		                <li><a href="#魯桓公十七年">十七年</a></li>
		                <li><a href="#魯桓公十八年">十八年</a></li>
              		</ul>
            	</li>
            	<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">莊公<span class="caret"></span></a>
              		<ul class="dropdown-menu">
		                <li><a href="#魯莊公元年">元年</a></li>
		                <li><a href="#魯莊公二年">二年</a></li>
		                <li><a href="#魯莊公三年">三年</a></li>
		                <li><a href="#魯莊公四年">四年</a></li>
		                <li><a href="#魯莊公五年">五年</a></li>
		                <li><a href="#魯莊公六年">六年</a></li>
		                <li><a href="#魯莊公七年">七年</a></li>
		                <li><a href="#魯莊公八年">八年</a></li>
		                <li><a href="#魯莊公九年">九年</a></li>
		                <li><a href="#魯莊公十年">十年</a></li>
		                <li><a href="#魯莊公十一年">十一年</a></li>
		                <li><a href="#魯莊公十二年">十二年</a></li>
		                <li><a href="#魯莊公十三年">十三年</a></li>
		                <li><a href="#魯莊公十四年">十四年</a></li>
		                <li><a href="#魯莊公十五年">十五年</a></li>
		                <li><a href="#魯莊公十六年">十六年</a></li>
		                <li><a href="#魯莊公十七年">十七年</a></li>
		                <li><a href="#魯莊公十八年">十八年</a></li>
		                <li><a href="#魯莊公十九年">十九年</a></li>
		                <li><a href="#魯莊公二十年">二十年</a></li>
		                <li><a href="#魯莊公二十一年">二十一年</a></li>
		                <li><a href="#魯莊公二十二年">二十二年</a></li>
		                <li><a href="#魯莊公二十三年">二十三年</a></li>
		                <li><a href="#魯莊公二十四年">二十四年</a></li>
		                <li><a href="#魯莊公二十五年">二十五年</a></li>
		                <li><a href="#魯莊公二十六年">二十六年</a></li>
		                <li><a href="#魯莊公二十七年">二十七年</a></li>
		                <li><a href="#魯莊公二十八年">二十八年</a></li>
		                <li><a href="#魯莊公二十九年">二十九年</a></li>
		                <li><a href="#魯莊公三十年">三十年</a></li>
		                <li><a href="#魯莊公三十一年">三十一年</a></li>
		                <li><a href="#魯莊公三十二年">三十二年</a></li>
              		</ul>
            	</li>
            	<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">閔公<span class="caret"></span></a>
              		<ul class="dropdown-menu">
		                <li><a href="#魯閔公元年">元年</a></li>
		                <li><a href="#魯閔公二年">二年</a></li>
              		</ul>
            	</li>
            	<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">僖公<span class="caret"></span></a>
              		<ul class="dropdown-menu">
		                <li><a href="#魯僖公元年">元年</a></li>
		                <li><a href="#魯僖公二年">二年</a></li>
		                <li><a href="#魯僖公三年">三年</a></li>
		                <li><a href="#魯僖公四年">四年</a></li>
		                <li><a href="#魯僖公五年">五年</a></li>
		                <li><a href="#魯僖公六年">六年</a></li>
		                <li><a href="#魯僖公七年">七年</a></li>
		                <li><a href="#魯僖公八年">八年</a></li>
		                <li><a href="#魯僖公九年">九年</a></li>
		                <li><a href="#魯僖公十年">十年</a></li>
		                <li><a href="#魯僖公十一年">十一年</a></li>
		                <li><a href="#魯僖公十二年">十二年</a></li>
		                <li><a href="#魯僖公十三年">十三年</a></li>
		                <li><a href="#魯僖公十四年">十四年</a></li>
		                <li><a href="#魯僖公十五年">十五年</a></li>
		                <li><a href="#魯僖公十六年">十六年</a></li>
		                <li><a href="#魯僖公十七年">十七年</a></li>
		                <li><a href="#魯僖公十八年">十八年</a></li>
		                <li><a href="#魯僖公十九年">十九年</a></li>
		                <li><a href="#魯僖公二十年">二十年</a></li>
		                <li><a href="#魯僖公二十一年">二十一年</a></li>
		                <li><a href="#魯僖公二十二年">二十二年</a></li>
		                <li><a href="#魯僖公二十三年">二十三年</a></li>
		                <li><a href="#魯僖公二十四年">二十四年</a></li>
		                <li><a href="#魯僖公二十五年">二十五年</a></li>
		                <li><a href="#魯僖公二十六年">二十六年</a></li>
		                <li><a href="#魯僖公二十七年">二十七年</a></li>
		                <li><a href="#魯僖公二十八年">二十八年</a></li>
		                <li><a href="#魯僖公二十九年">二十九年</a></li>
		                <li><a href="#魯僖公三十年">三十年</a></li>
		                <li><a href="#魯僖公三十一年">三十一年</a></li>
		                <li><a href="#魯僖公三十二年">三十二年</a></li>
						<li><a href="#魯僖公三十三年">三十三年</a></li>
              		</ul>
            	</li>
            	<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">文公<span class="caret"></span></a>
              		<ul class="dropdown-menu">
		                <li><a href="#魯文公元年">元年</a></li>
		                <li><a href="#魯文公二年">二年</a></li>
		                <li><a href="#魯文公三年">三年</a></li>
		                <li><a href="#魯文公四年">四年</a></li>
		                <li><a href="#魯文公五年">五年</a></li>
		                <li><a href="#魯文公六年">六年</a></li>
		                <li><a href="#魯文公七年">七年</a></li>
		                <li><a href="#魯文公八年">八年</a></li>
		                <li><a href="#魯文公九年">九年</a></li>
		                <li><a href="#魯文公十年">十年</a></li>
		                <li><a href="#魯文公十一年">十一年</a></li>
		                <li><a href="#魯文公十二年">十二年</a></li>
		                <li><a href="#魯文公十三年">十三年</a></li>
		                <li><a href="#魯文公十四年">十四年</a></li>
		                <li><a href="#魯文公十五年">十五年</a></li>
		                <li><a href="#魯文公十六年">十六年</a></li>
		                <li><a href="#魯文公十七年">十七年</a></li>
		                <li><a href="#魯文公十八年">十八年</a></li>
              		</ul>
            	</li>
            	<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">宣公<span class="caret"></span></a>
              		<ul class="dropdown-menu">
		                <li><a href="#魯宣公元年">元年</a></li>
		                <li><a href="#魯宣公二年">二年</a></li>
		                <li><a href="#魯宣公三年">三年</a></li>
		                <li><a href="#魯宣公四年">四年</a></li>
		                <li><a href="#魯宣公五年">五年</a></li>
		                <li><a href="#魯宣公六年">六年</a></li>
		                <li><a href="#魯宣公七年">七年</a></li>
		                <li><a href="#魯宣公八年">八年</a></li>
		                <li><a href="#魯宣公九年">九年</a></li>
		                <li><a href="#魯宣公十年">十年</a></li>
		                <li><a href="#魯宣公十一年">十一年</a></li>
		                <li><a href="#魯宣公十二年">十二年</a></li>
		                <li><a href="#魯宣公十三年">十三年</a></li>
		                <li><a href="#魯宣公十四年">十四年</a></li>
		                <li><a href="#魯宣公十五年">十五年</a></li>
		                <li><a href="#魯宣公十六年">十六年</a></li>
		                <li><a href="#魯宣公十七年">十七年</a></li>
		                <li><a href="#魯宣公十八年">十八年</a></li>
              		</ul>
            	</li>
            	<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">成公<span class="caret"></span></a>
              		<ul class="dropdown-menu">
		                <li><a href="#魯成公元年">元年</a></li>
		                <li><a href="#魯成公二年">二年</a></li>
		                <li><a href="#魯成公三年">三年</a></li>
		                <li><a href="#魯成公四年">四年</a></li>
		                <li><a href="#魯成公五年">五年</a></li>
		                <li><a href="#魯成公六年">六年</a></li>
		                <li><a href="#魯成公七年">七年</a></li>
		                <li><a href="#魯成公八年">八年</a></li>
		                <li><a href="#魯成公九年">九年</a></li>
		                <li><a href="#魯成公十年">十年</a></li>
		                <li><a href="#魯成公十一年">十一年</a></li>
		                <li><a href="#魯成公十二年">十二年</a></li>
		                <li><a href="#魯成公十三年">十三年</a></li>
		                <li><a href="#魯成公十四年">十四年</a></li>
		                <li><a href="#魯成公十五年">十五年</a></li>
		                <li><a href="#魯成公十六年">十六年</a></li>
		                <li><a href="#魯成公十七年">十七年</a></li>
		                <li><a href="#魯成公十八年">十八年</a></li>
              		</ul>
            	</li>
            	<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">襄公<span class="caret"></span></a>
              		<ul class="dropdown-menu">
		                <li><a href="#魯襄公元年">元年</a></li>
		                <li><a href="#魯襄公二年">二年</a></li>
		                <li><a href="#魯襄公三年">三年</a></li>
		                <li><a href="#魯襄公四年">四年</a></li>
		                <li><a href="#魯襄公五年">五年</a></li>
		                <li><a href="#魯襄公六年">六年</a></li>
		                <li><a href="#魯襄公七年">七年</a></li>
		                <li><a href="#魯襄公八年">八年</a></li>
		                <li><a href="#魯襄公九年">九年</a></li>
		                <li><a href="#魯襄公十年">十年</a></li>
		                <li><a href="#魯襄公十一年">十一年</a></li>
		                <li><a href="#魯襄公十二年">十二年</a></li>
		                <li><a href="#魯襄公十三年">十三年</a></li>
		                <li><a href="#魯襄公十四年">十四年</a></li>
		                <li><a href="#魯襄公十五年">十五年</a></li>
		                <li><a href="#魯襄公十六年">十六年</a></li>
		                <li><a href="#魯襄公十七年">十七年</a></li>
		                <li><a href="#魯襄公十八年">十八年</a></li>
		                <li><a href="#魯襄公十九年">十九年</a></li>
		                <li><a href="#魯襄公二十年">二十年</a></li>
		                <li><a href="#魯襄公二十一年">二十一年</a></li>
		                <li><a href="#魯襄公二十二年">二十二年</a></li>
		                <li><a href="#魯襄公二十三年">二十三年</a></li>
		                <li><a href="#魯襄公二十四年">二十四年</a></li>
		                <li><a href="#魯襄公二十五年">二十五年</a></li>
		                <li><a href="#魯襄公二十六年">二十六年</a></li>
		                <li><a href="#魯襄公二十七年">二十七年</a></li>
		                <li><a href="#魯襄公二十八年">二十八年</a></li>
		                <li><a href="#魯襄公二十九年">二十九年</a></li>
		                <li><a href="#魯襄公三十年">三十年</a></li>
		                <li><a href="#魯襄公三十一年">三十一年</a></li>
              		</ul>
            	</li>
            	<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">昭公<span class="caret"></span></a>
              		<ul class="dropdown-menu">
		                <li><a href="#魯昭公元年">元年</a></li>
		                <li><a href="#魯昭公二年">二年</a></li>
		                <li><a href="#魯昭公三年">三年</a></li>
		                <li><a href="#魯昭公四年">四年</a></li>
		                <li><a href="#魯昭公五年">五年</a></li>
		                <li><a href="#魯昭公六年">六年</a></li>
		                <li><a href="#魯昭公七年">七年</a></li>
		                <li><a href="#魯昭公八年">八年</a></li>
		                <li><a href="#魯昭公九年">九年</a></li>
		                <li><a href="#魯昭公十年">十年</a></li>
		                <li><a href="#魯昭公十一年">十一年</a></li>
		                <li><a href="#魯昭公十二年">十二年</a></li>
		                <li><a href="#魯昭公十三年">十三年</a></li>
		                <li><a href="#魯昭公十四年">十四年</a></li>
		                <li><a href="#魯昭公十五年">十五年</a></li>
		                <li><a href="#魯昭公十六年">十六年</a></li>
		                <li><a href="#魯昭公十七年">十七年</a></li>
		                <li><a href="#魯昭公十八年">十八年</a></li>
		                <li><a href="#魯昭公十九年">十九年</a></li>
		                <li><a href="#魯昭公二十年">二十年</a></li>
		                <li><a href="#魯昭公二十一年">二十一年</a></li>
		                <li><a href="#魯昭公二十二年">二十二年</a></li>
		                <li><a href="#魯昭公二十三年">二十三年</a></li>
		                <li><a href="#魯昭公二十四年">二十四年</a></li>
		                <li><a href="#魯昭公二十五年">二十五年</a></li>
		                <li><a href="#魯昭公二十六年">二十六年</a></li>
		                <li><a href="#魯昭公二十七年">二十七年</a></li>
		                <li><a href="#魯昭公二十八年">二十八年</a></li>
		                <li><a href="#魯昭公二十九年">二十九年</a></li>
		                <li><a href="#魯昭公三十年">三十年</a></li>
		                <li><a href="#魯昭公三十一年">三十一年</a></li>
		                <li><a href="#魯昭公三十二年">三十二年</a></li>
		            </ul>
            	</li>
            	<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">定公<span class="caret"></span></a>
              		<ul class="dropdown-menu">
		                <li><a href="#魯定公元年">元年</a></li>
		                <li><a href="#魯定公二年">二年</a></li>
		                <li><a href="#魯定公三年">三年</a></li>
		                <li><a href="#魯定公四年">四年</a></li>
		                <li><a href="#魯定公五年">五年</a></li>
		                <li><a href="#魯定公六年">六年</a></li>
		                <li><a href="#魯定公七年">七年</a></li>
		                <li><a href="#魯定公八年">八年</a></li>
		                <li><a href="#魯定公九年">九年</a></li>
		                <li><a href="#魯定公十年">十年</a></li>
		                <li><a href="#魯定公十一年">十一年</a></li>
		                <li><a href="#魯定公十二年">十二年</a></li>
		                <li><a href="#魯定公十三年">十三年</a></li>
		                <li><a href="#魯定公十四年">十四年</a></li>
		                <li><a href="#魯定公十五年">十五年</a></li>
              		</ul>
            	</li>
            	<li class="dropdown">
              		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">哀公<span class="caret"></span></a>
              		<ul class="dropdown-menu">
		                <li><a href="#魯哀公元年">元年</a></li>
		                <li><a href="#魯哀公二年">二年</a></li>
		                <li><a href="#魯哀公三年">三年</a></li>
		                <li><a href="#魯哀公四年">四年</a></li>
		                <li><a href="#魯哀公五年">五年</a></li>
		                <li><a href="#魯哀公六年">六年</a></li>
		                <li><a href="#魯哀公七年">七年</a></li>
		                <li><a href="#魯哀公八年">八年</a></li>
		                <li><a href="#魯哀公九年">九年</a></li>
		                <li><a href="#魯哀公十年">十年</a></li>
		                <li><a href="#魯哀公十一年">十一年</a></li>
		                <li><a href="#魯哀公十二年">十二年</a></li>
		                <li><a href="#魯哀公十三年">十三年</a></li>
		                <li><a href="#魯哀公十四年">十四年</a></li>
		                <li><a href="#魯哀公十五年">十五年</a></li>
		                <li><a href="#魯哀公十六年">十六年</a></li>
		                <li><a href="#魯哀公十七年">十七年</a></li>
		                <li><a href="#魯哀公十八年">十八年</a></li>
		                <li><a href="#魯哀公十九年">十九年</a></li>
		                <li><a href="#魯哀公二十年">二十年</a></li>
		                <li><a href="#魯哀公二十一年">二十一年</a></li>
		                <li><a href="#魯哀公二十二年">二十二年</a></li>
		                <li><a href="#魯哀公二十三年">二十三年</a></li>
		                <li><a href="#魯哀公二十四年">二十四年</a></li>
		                <li><a href="#魯哀公二十五年">二十五年</a></li>
		                <li><a href="#魯哀公二十六年">二十六年</a></li>
		                <li><a href="#魯哀公二十七年">二十七年</a></li>
              		</ul>
            	</li>
          		</ul>

				<!-- <h5>請勾選欲顯示書目<h5> -->
				<span id="books">
				<button onclick="show_page(this.parentElement)">Submit</button>
				<label><input type="checkbox" value="左傳">左傳</label>
				<label><input type="checkbox" value="公羊傳">公羊傳</label>
				<label><input type="checkbox" value="穀梁傳">穀梁傳</label>
				<label><input type="checkbox" value="春秋經解">春秋經解</label>
				</span>
          		<form class="navbar-form navbar-right" action="query.php" method="GET">
            		<input type="text" name="query" class="form-control" placeholder="搜尋...">
          		</form>
				
        	</div>
      	</div>
    </nav>

    <!-- Show 選擇年號 -->
<!--
    <div class="container-fluid" id="age">
    	<h4 class="visible"> 年號：</h4>
    	<h4 class="hidden"> 年號：</h4>
    </div>
-->

	<div class="dropdown">
		<button  class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
			春秋條目&nbsp;
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" id='Ctitle' >
			<li role="presentation" class="dropdown-header">魯隱公元年</li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" >元年，春，王正月。</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" >三月，公及邾儀父盟于蔑。</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" >夏，五月，鄭伯克段于鄢。</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" >秋，七月，天王使宰咺來歸惠公仲子之賵。</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" >九月，及宋人盟于宿。</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" >冬，十有二月，祭伯來。</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" href="#" >公子益師卒。</a></li>
		</ul>
		<span id="spanTitle" >元年，春，王正月。</span>
	</div>


    <!-- Main board -->
    <div class="container-fluid" >
    	<div class="row">
    		<div id="main">
				<div class="col-sm-12 col-md-12">
					<div class="row">
					    <div class="book col-sm-12 content">
							<h1 class="page-header">春秋</h1>
							<ul class="nav nav-sidebar" style="width:100%;height:200px;overflow-x:auto;overflow-y:auto;">
							    <?php $DBManager->queryAndSet(1);?>
							</ul>
						</div>
						
						<div class="book col-sm-4 content hidden">
							<h1 class="page-header">左傳</h1>
							<ul class="nav nav-sidebar" style="height:610px;overflow-x:auto;overflow-y:auto;">
							    <?php $DBManager->queryAndSet(2);?>
							</ul>
						</div>
						
						<div class="book col-sm-4 content hidden">
							<h1 class="page-header">公羊傳</h1>
							<ul class="nav nav-sidebar" style="height:610px;overflow-x:auto;overflow-y:auto;">
							    <?php $DBManager->queryAndSet(3);?>
							</ul>
						</div>
						
						<div class="book col-sm-4 content hidden">
							<h1 class="page-header">穀梁傳</h1>
							<ul class="nav nav-sidebar" style="height:610px;overflow-x:auto;overflow-y:auto;">
							    <?php $DBManager->queryAndSet(4);?>
							</ul>
						</div>
						
						<div class="book col-sm-3 content hidden">
							<h1 class="page-header">春秋經解</h1>
							<ul class="nav nav-sidebar" style="height:610px;overflow-x:auto;overflow-y:auto;">
								<?php $DBManager->queryAndSet(5);?>
							</ul>
						</div>
					</div>
				</div>
			</div>
	    </div>
    </div>
</body>
