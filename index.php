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



<script>
	//--	layout object
var layout = null;
function Layout() {
	this.height = document.body.scrollHeight - 135;

	//*****************************************
	//*										  *
	//*										  *
	//*				  action				  *
	//*										  *
	//*										  *
	//*****************************************
	
	//--	change the background color for hit entry
	this.changeHitEntryColor = function($targetArray) {
		for(var i = 0; i < $targetArray.length; i ++) {
			$($targetArray[i]).attr("style", "background-color:palegoldenrod");
			$($targetArray[i]).attr("class", $($targetArray[i]).attr("class") + " taged");
		}
	};
	//--	clear the background color for hit entry
	this.cleanHitEntryColor = function() {
		var tagedArray = $(".taged");
		for(var i = 0; i < tagedArray.length; i ++) {
			$(tagedArray[i]).removeClass("taged");
			$(tagedArray[i]).attr("style", "background-color:white;color:rgb(0, 0, 0)");
		}
	};
	//--	change the bottom red line for miss entry
	this.changeMissEntryColorBottom = function( missEntry) {
		$(missEntry).attr('style', 'color:rgb(0, 0, 0);border-bottom-color:red;border-bottom-width:5px');
		$(missEntry).attr('class', missEntry.className + " miss");
	};
	//--	change the top red line for miss entry
	this.changeMissEntryColorTop = function( missEntry) {
		$(missEntry).attr('style', 'color:rgb(0, 0, 0);border-top-color:red;border-top-width:5px');
		$(missEntry).attr('class', missEntry.className + " miss");
	};
	
	//--	clean the red linr for miss entry
	this.cleanMissEntryColor = function() {
		var tagedArray = $(".miss");
		for(var i = 0; i < tagedArray.length; i ++) {
			$(tagedArray[i]).removeClass("miss");
			$(tagedArray[i]).attr("style", "color:rgb(0, 0, 0)");
		}
	};
	
	//--	show book row
	this.showBookRow = function() {
		$("#queryRow").hide();
		$("#simpleYear").show();
		$("#bookRow").show();
	};
	
	//--	show query row
	this.showQueryRow = function() {
		$("#bookRow").hide();
		$("#simpleYear").hide();
		$("#queryRow").show();
	};
	//--	clean query result
	this.cleanQueryResult = function() {
		$("#querySidebar").empty();
	};

	//--	query result to book
	this.findResultInBook = function(event) {
		this.showBookRow();
		var target = $("a" + event.target.className.replace('btn-primary', '').replace('btn', '').replace('btn-xs', '').replace(/\s+/g,"."))[0];
		console.log(target);
		console.log("a" + event.target.className.replace('btn-primary', '').replace('btn', '').replace('btn-xs', '').replace(/\s+/g,".") );
		console.log("======");
		$(target).trigger('click');
	};
};

$( document ).ready(function() {
	layout = new Layout();

});

</script>

<script type="text/javascript">

function moveAnchor(event) {
	
	var parentBlock = event.target.parentElement.parentElement;
	//--	更改年號標記
	changeYearName(parentBlock.getAttribute("name"));
	layout.cleanHitEntryColor();
	layout.cleanMissEntryColor();
	
	var $timeArray = event.target.className.split(" ");//0 is text, >= 1 is time
	var classSelector = "";
	for(var i = 2; i < $timeArray.length; i ++) classSelector += "a." + $timeArray[i] + ", ";
	classSelector = classSelector.substr(0, classSelector.length - 2);
	classSelector += ".text";
	
	var $blockArray = $("." + parentBlock.className.split(" ")[3] + ".block");
	var $anchorArray = [];
	for(var i = 0; i < $blockArray.length; i ++) {
		$anchorArray.push(0);
	}
	
	//--	從中尋找並標上顏色
	for(var i = 0; i < $blockArray.length; i ++) {
		var $temp = $( $blockArray[i].lastElementChild ).find(classSelector);
		
		if( $temp.length > 0) {
			if( classSelector.split(" ").length == 1) {
				var $onlyArray = [];
				for(var k = 0; k < $temp.length; k ++) {
					if( $temp[k].className.split(" ").length == 3 ) {
						$onlyArray.push($temp[k]);
					}
				}
				if($onlyArray.length > 0) $temp = $onlyArray;
			}
			
			//--	有找到
			changeBackGroundColor($temp);
			if( $blockArray[i] == parentBlock) {
				$anchorArray[i] = 200 + $(parentBlock.parentElement).offset().top;
			} else {
				$anchorArray[i] = $( $temp[0] ).offset().top ;
			}
		}
		else {
			//--	沒有找到
			var timeTarget = classSelector.split(".")[1].split("-")[1];
			var flag = false;
			for(j = $blockArray[i].lastElementChild.childNodes.length - 1; j >= 0; j --) {

				console.log($blockArray[i].lastElementChild);
				$timeHref = $blockArray[i].lastElementChild.childNodes[j].hash.split(" ");
				if( timeTarget > $timeHref[1].split("-")[1] ) {
					$($blockArray[i].lastElementChild.childNodes[j]).attr('style', 'color:rgb(0, 0, 0);border-bottom-color:red;border-bottom-width:5px');
					$($blockArray[i].lastElementChild.childNodes[j]).attr('class', $blockArray[i].lastElementChild.childNodes[j].className + " miss");
					if( typeof $blockArray[i].lastElementChild.childNodes[j+1] === "undefined" ) {
						$anchorArray[i] = $($blockArray[i].lastElementChild.childNodes[$blockArray[i].lastElementChild.childNodes.length-1]).offset().top;
						$($blockArray[i]).attr('style', 'border-bottom-color:red;border-bottom-width:5px');
						$($blockArray[i]).attr('class', $blockArray[i].className + " miss");
					} else {
						$anchorArray[i] = $($blockArray[i].lastElementChild.childNodes[j+1]).offset().top;
					}
					flag = true;
					break;
				}else if(j == 0 && flag == false) {
					$($blockArray[i].lastElementChild.childNodes[0]).attr('style', 'color:rgb(0, 0, 0);border-top-color:red;border-top-width:5px');
					$($blockArray[i].lastElementChild.childNodes[0]).attr('class', $blockArray[i].lastElementChild.childNodes[j].className + " miss");
					$anchorArray[i] = $($blockArray[i].lastElementChild.childNodes[0]).offset().top;
				}
			}
		}
	}
	
	//--	移動到該位置
	var window_gap = $($(".nav-sidebar")[0]).offset().top;
	for(var i = 0; i < $anchorArray.length; i ++) {
		$($(".nav-sidebar")[i]).animate({
			scrollTop: $( $(".nav-sidebar")[i] ).scrollTop() + $anchorArray[i] - $($(".nav-sidebar")[i]).offset().top -200
		}, 600);
	}
	
	//--	對應春秋的條目
	findCgunqiuByIndex(classSelector, parentBlock.className.split(" ")[3]);
	
	function changeBackGroundColor( $targetArray ) {
		for(var i = 0; i < $targetArray.length; i ++) {
			$($targetArray[i]).attr("style", "background-color:palegoldenrod");
			$($targetArray[i]).attr("class", $($targetArray[i]).attr("class") + " taged");
		}
	}
	function clearTagedArray() {
		var tagedArray = $(".taged");
		for(var i = 0; i < tagedArray.length; i ++) {
			$(tagedArray[i]).removeClass("taged");
			$(tagedArray[i]).attr("style", "background-color:white;color:rgb(0, 0, 0)");
		}
	}
	
	function clearMissArray() {
		var tagedArray = $(".miss");
		for(var i = 0; i < tagedArray.length; i ++) {
			$(tagedArray[i]).removeClass("miss");
			$(tagedArray[i]).attr("style", "color:rgb(0, 0, 0)");
		}
	}
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
						<ul class="dropdown-menu" >
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
						<ul class="dropdown-menu" >
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
				<div class="row" style="margin-top:5px">
					<button type="button" class="btn btn-primary" onclick="layout.showBookRow()" >對讀頁面</button>
					<button type="button" class="btn btn-primary" onclick="layout.showQueryRow()" >檢索頁面</button>

					<span id="books" >
						<button type="button" class="btn btn-primary" onclick="show_page(this.parentElement)" >切換文本</button>
						<label style="font-size:14px" class="checkbox-inline">
						<input type="checkbox" value="1" >左傳
						</label>
						<label style="font-size:14px" class="checkbox-inline">
						<input type="checkbox" value="2" >公羊傳
						</label>
						<label style="font-size:14px" class="checkbox-inline">
						<input type="checkbox" value="3" >穀梁傳
						</label>
					</span>
							
					<form id="searchBar" class="navbar-form navbar-right" style="margin-right:2px">
						<input id="query" type="text" class="form-control" placeholder="搜尋...">
					</form>

				</div>	
        	</div>

      	</div>
    </nav>

    <!-- Show 選擇年號 -->
    


	<div id="simpleYear" class="dropdown">
		<span id="year" class="label label-primary" style="margin-left:5px;font-size:18px"> 
			魯隱公元年
		</span>
		
		<button  class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true" style="margin-left:5px;margin-bottom:5px">
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
		<span id="spanTitle" ><span class='glyphicon glyphicon-tag' aria-hidden='true'></span>元年，春，王正月。</span>
	</div>

    <!-- Main board -->
    <div class="container-fluid" >
    	<div class="row" id = 'bookRow' >
    		<div id="main">
				<div class="col-sm-12 col-md-12">
					<div class="row">
					    <div class="book col-sm-12 content">
							<h1 class="page-header" style="font-size:24px" >春秋</h1>
							<ul class="nav nav-sidebar" style="width:100%;height:200px;overflow-x:auto;overflow-y:auto;">
							    <?php $DBManager->queryAndSet(1);?>
							</ul>
						</div>
						
						<div class="book col-sm-4 content hidden">
							<h1 class="page-header" style="font-size:24px" >左傳</h1>
							<ul class="nav nav-sidebar" style="height:610px;overflow-x:auto;overflow-y:auto;">
							    <?php $DBManager->queryAndSet(2);?>
							</ul>
						</div>
						
						<div class="book col-sm-4 content hidden">
							<h1 class="page-header" style="font-size:24px" >公羊傳</h1>
							<ul class="nav nav-sidebar" style="height:610px;overflow-x:auto;overflow-y:auto;">
							    <?php $DBManager->queryAndSet(3);?>
							</ul>
						</div>
						
						<div class="book col-sm-4 content hidden">
							<h1 class="page-header" style="font-size:24px" >穀梁傳</h1>
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
		
		<div class="row" id = "queryRow" hidden>
			<div id="main">
				<div class="col-sm-12 col-md-12">
					<div id="queryContainer" class="row" >
						<div class="col-sm-3 col-md-3">
							<div id='queryDiv' style='width:24%;height:800px;position:fixed;overflow-y:scroll' >
								<h4>檢索結果 : </h4>
								<div role="tabpanel" >
								  <!-- Nav tabs -->
									<ul class="nav nav-tabs" role="tablist">
										<li role="presentation" class="active"><a href="#yearList" aria-controls="yearList" role="tab" data-toggle="tab">時間</a></li>
									</ul>
									<div class="tab-content">
										<div role='tabpanel' class='tab-pane active panel-body' id="yearList" >
											<div id='yearListGroup' class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-9 col-md-9">
							<ul id="querySidebar" class="nav nav-sidebar" style='width:100%;height:600px;overflow-x:auto;overflow-y:auto;'>
							</ul>
						</div>
					</div>
				</div>
			</div>


    </div>
</body>


<script>
	$('body').on('submit', '#searchBar', function(event) {
	
	console.log( $checked );
	event.preventDefault();
	layout.cleanQueryResult();
	$.get( "ajaxQuery.php", { query: $('#query')[0].value, flag: $checked } )
		.done(function( data ) {
		var result = JSON.parse(data);
		console.log(result);
		buildQueryResult(result);
	});

	layout.showQueryRow();
	
});

function buildQueryResult(result) {
	var $queryHash = [];

	for(var i in result) {
		$queryHash[ getYear(result[i].yearStart) ] = [];
		$queryHash[ getYear(result[i].yearStart) ].dateChNorm = result[i].title;
	}
	

	for(var i in result) {
		var targetYear = getYear(result[i].yearStart);
		if( $queryHash[ targetYear ] != undefined) {
			if( $queryHash[targetYear][getYearAndMonth(result[i].yearStart)] != undefined ) {
				$queryHash[targetYear][getYearAndMonth(result[i].yearStart)].push(result[i]);
			} else {
				$queryHash[targetYear][getYearAndMonth(result[i].yearStart)] = [];
				$queryHash[targetYear][getYearAndMonth(result[i].yearStart)].push(result[i]);
				$queryHash[targetYear][getYearAndMonth(result[i].yearStart)].oriTimeString = getMonthOrSeason(result[i]);
				$queryHash[targetYear][getYearAndMonth(result[i].yearStart)].timeClass = getClassYear(result[i]);
			}
		}
	}
	console.log($queryHash);

	for(var i in $queryHash ) {
		var panelHeading = "<div class='panel panel-default queryBlock " + $queryHash[i].dateChNorm + "'><div class='title panel-heading' style='background-color:lightsteelblue;font-size:16pt;'>" + $queryHash[i].dateChNorm + "</div><div class='panel-body'></div></div>";
		$("#querySidebar").append(panelHeading);
		var temp = $("#querySidebar").find("." + $queryHash[i].dateChNorm + ".queryBlock")[0].lastElementChild;
		//******************* TODO 用超爛的方法解決 array reverse的問題 *******************************
		var a = [];
		for(var j in $queryHash[i]) {
			a.unshift(j);
		}

		for(var j in a) {
			j = a[j];
			if($queryHash[i][j].constructor != Array().constructor)
				continue;
			
			$(temp).append("<button style='margin-bottom:10px' type='button' class='btn btn-primary btn-xs " + $queryHash[i][j].timeClass + "' aria-label='Left Align' onclick='layout.findResultInBook(event)'><<</button>");
			$(temp).append("<strong class='" + $queryHash[i][j].timeClass + "' > " + $queryHash[i][j].oriTimeString + "</strong>");
			
			var groupList = document.createElement("lu");
			groupList.className = "list-group";
			for(var k in $queryHash[i][j]) {
				if($queryHash[i][j][k].constructor == String().constructor)
					continue;
				$(groupList).append("<div class='well well-sm' style='margin-bottom: 0px'>" + getBookName($queryHash[i][j][k].bookcaseId) + "</div>");
				var block = "<li style='margin-bottom:10px' class='list-group-item queryText'>" + $queryHash[i][j][k].context.replace($("#query")[0].value,"<kbd style='background-color: #5F5F3F'>" + $("#query")[0].value + "</kbd>" ); + "</li>";
				$(groupList).append(block);
			}
			$(temp).append(groupList);
		}	

	}






	function getYear(input) {
		return input.split("-")[0];
	}

	function getYearAndMonth(input) {
		return input.split("-")[0] + input.split("-")[1];
	}

	function getClassYear(input) {
		return input.yearStart.split('-')[0] + "-" + input.yearStart.split('-')[1];
	}

	function getMonthOrSeason(input) {
		var monthStart = input.yearStart.split("-")[1];
		var monthEnd = input.yearEnd.split("-")[1];

		if(input.yearStart == input.yearEnd) {
			
			switch(monthStart) {
				case '01':
					return "一月";
				break;
				case '02':
					return "二月";
				break;
				case '03':
					return "三月";
				break;
				case '04':
					return "四月";
				break;
				case '05':
					return "五月";
				break;
				case '06':
					return "六月";
				break;
				case '07':
					return "七月";
				break;
				case '08':
					return "八月";
				break;
				case '09':
					return "九月";
				break;
				case '10':
					return "十月";
				break;
				case '11':
					return "十一月";
				break;
				case '12':
					return "十二月";
				break;
			}

		} else {
			switch(monthStart + monthEnd) {
				case '0103':
					return "春";
				break;
				case '0406':
					return "夏";
				break;
				case '0709':
					return "秋";
				break;
				case '1012':
					return "冬";
				break;

			}

		}


	}
	function getBookName(input) {
		switch(input) {
			case '1':
				return "春秋";
			break;
			case '2':
				return "左傳";
			break;
			case '3':
				return "公羊傳";
			break;
			case '4':
				return "穀梁傳";
			break;
		}

	}
}

</script>
