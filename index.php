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
	<script type="text/javascript" src="js/content.js?version=1.0"></script>
</head>

<style type=text/css> 
	body { font-family:微軟正黑體; }
</style>



<script>
	//--	layout object
var layout = null;
var myCookie = null;
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
		console.log(event.target);
		console.log($("a" + event.target.className.replace('btn-default', '').replace('btn', '').replace(/\s+/g,"."))[0]);
		console.log( "a" + event.target.className.replace('btn-default', '').replace('btn', '').replace(/\s+/g,".") );
		var target = $("a" + event.target.className.replace('btn-default', '').replace('btn', '').replace(/\s+/g,"."))[0];




		//var target = $("a" + event.target.className.replace('btn-dafault', '').replace('btn-primary', '').replace('btn', '').replace('btn-xs', '').replace(/\s+/g,"."))[0];
		$(target).trigger('click');
	};
};


	//*****************************************
	//*										  *
	//*										  *
	//*				  cookie				  *
	//*										  *
	//*										  *
	//*****************************************

function MyCookie() {

	this.recover = false;

	this.getCookieByKey = function (key) {
		if( document.cookie.length==0 )   return false;
		var i=document.cookie.search(key+'=');
		if( i==-1 )   return false;
		i+=key.length+1;
		var j=document.cookie.indexOf(';', i);
		if( j==-1 )   j=document.cookie.length;
		return document.cookie.slice(i,j);
	};

	this.getCookie = function () {
		return document.cookie;
	}

	this.deleteCookie = function (key) {
		
		this.setCookie(key, '', -2000);
	};

	this.setCookie = function (key, value, expire)	{
		var ck=key +'='+ value;
		if( expire )
		{
			var epr=new Date();
			epr.setTime(epr.getTime()+ expire*1000 );
			ck+=';expires='+ epr.toUTCString();
		}
		document.cookie=ck;
	};

	this.recoverBookcase = function() {
		if( this.getCookieByKey("bookcase") == false ) return;
		var temp = this.getCookieByKey("bookcase").split(",");
		console.log(temp);
		for(i = 1; i < $checked.length; i ++) {
			if(temp[i] == "true")	 {
				$("input:checkbox")[i-1].checked = true;
			}
		}
		$('#showPageButton').click();
		
	};

	this.recoverQuery = function() {
		if( this.getCookieByKey("query") == false ) return;
		var query = this.getCookieByKey("query");
		$("#query")[0].value = query;
		$("#searchBar").submit();
		myCookie.recover = false;
	};

	this.recoverAction = function() {
		if( this.getCookieByKey("action") == false ) return;
		var action = this.getCookieByKey("action");
		$(action)[0].click()
	};

	this.recover = function() {
		this.recover = true;
		myCookie.recoverBookcase();
		myCookie.recoverQuery();
		myCookie.recoverAction();
	}
}

$( document ).ready(function() {
	layout = new Layout();
	myCookie = new MyCookie();
	(function () {
		$('#test')[0].click();
		/*
		if (confirm("是否回覆上次瀏覽狀態?") == true) {
			console.log('recover');
			myCookie.recover = true;
			myCookie.recoverBookcase();
			myCookie.recoverQuery();
			myCookie.recoverAction();
		}*/


	})();

});

window.onbeforeunload = function () {
	myCookie.setCookie("bookcase", $checked);
	/*
	var slideArray = [];
	var slideBar = $('.nav-sidebar');
	for(var i in slideBar) {
		slideArray.push( $(slideBar[i]).scrollTop() );
	}
	alert(slideArray);*/

};

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

	myCookie.setCookie("action", classSelector);
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
			layout.changeHitEntryColor($temp);
			if( $blockArray[i] == parentBlock ) {
				var a = $(parentBlock.parentElement).offset().top;
				var b = $( $temp[0] ).offset().top;
				
				if(a > b || (b - a) >  layout.height) {
					$anchorArray[i] = $( $temp[0] ).offset().top;
				} else {
					$anchorArray[i] = null;
				}
			} else {
				$anchorArray[i] = $( $temp[0] ).offset().top ;
			}
		}
		else {
			//--	沒有找到
			var timeTarget = classSelector.split(".")[1].split("-")[1];
			var flag = false;
			for(j = $blockArray[i].lastElementChild.childNodes.length - 1; j >= 0; j --) {

				$timeHref = $blockArray[i].lastElementChild.childNodes[j].hash.split(" ");
				if( timeTarget > $timeHref[1].split("-")[1] ) {
					layout.changeMissEntryColorBottom($blockArray[i].lastElementChild.childNodes[j]);
					if( typeof $blockArray[i].lastElementChild.childNodes[j+1] === "undefined" ) {
						$anchorArray[i] = $($blockArray[i].lastElementChild.childNodes[$blockArray[i].lastElementChild.childNodes.length-1]).offset().top;
						layout.changeMissEntryColorBottom($blockArray[i]);
					} else {
						$anchorArray[i] = $($blockArray[i].lastElementChild.childNodes[j+1]).offset().top;
					}
					flag = true;
					break;
				}else if(j == 0 && flag == false) {
					layout.changeMissEntryColorTop( $blockArray[i].lastElementChild.childNodes[0] );
					$anchorArray[i] = $($blockArray[i].lastElementChild.childNodes[0]).offset().top;
				}
			}
		}
	}
	
	//--	移動到該位置
	var window_gap = $($(".nav-sidebar")[0]).offset().top;
	for(var i = 0; i < $anchorArray.length; i ++) {
		if( $anchorArray[i] == null) continue;
		$($(".nav-sidebar")[i]).animate({
			scrollTop: $( $(".nav-sidebar")[i] ).scrollTop() + $anchorArray[i] - $($(".nav-sidebar")[i]).offset().top -200
		}, 600);
	}
	
	//--	對應春秋的條目
	findCgunqiuByIndex(classSelector, parentBlock.className.split(" ")[3]);
}
</script>

<body>
	<!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
    	<div class="container-fluid" style='height:40px'>
        	<div class="navbar-header" style='height:40px'>
          		<a class="navbar-brand" href="index.php">春秋對讀系統</a>
        	</div>
			<div class="navbar-header" style='height:40px'>
          		<a class="navbar-brand" target="_blank" href="intro.html">系統介紹</a>
        	</div>
			<!--
			<div class="navbar-header" style='height:40px'>
          		<a id='systemIntro' class="navbar-brand" href data-toggle="modal" data-target="#Intro">系統說明書</a>
        	</div>
			-->
							<!-- <h5>請勾選欲顯示書目<h5> -->
			<div class="navbar-right" style="margin-top:5px;margin-right:2px">
				<span id="books" >
					<label style="font-size:14px" class="checkbox-inline"><input type="checkbox" value="1" >左傳</label>
					<label style="font-size:14px" class="checkbox-inline"><input type="checkbox" value="2" >公羊傳</label>
					<label style="font-size:14px" class="checkbox-inline"><input type="checkbox" value="3" >穀梁傳</label>
					<button id='showPageButton' type="button" class="btn btn-primary" onclick="show_page(this.parentElement)" >選擇文本</button>
				</span>
			</div>
			
		</div>

		<div class="container-fluid">
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
				<div class="navbar-right" >
					<form id="searchBar" class="navbar-form navbar-rigth" style="margin-right:2px">
						<input id="query" type="text" class="form-control" placeholder="搜尋...">
						<button type='submit' class="btn btn-default">全文檢索</button>
					</form>
				</div>

        	</div>
      	</div>
    </nav>
<!--
	<div class="modal fade" id="Intro" tabindex="-1" role="dialog" aria-labelledby="userBookcaseLabel" aria-hidden="true">
		<div class="modal-dialog" style='height:90%;'>
			<div class="modal-content" style='height:90%;'>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="userBookcaseLabel">系統說明書</h4>
				</div>

				<div class="modal-body" style='height:85%;'>
					
				</div>


				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	-->

    <!-- Show 選擇年號 -->
    


	<div id="simpleYear" class="dropdown">
		<!-- <button class="btn btn-default" onclick="console.log(myCookie.getCookie());" >顯示cookie</button> -->


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

		<button class="btn btn-warning" style='float:right;margin-right:10px' onclick="layout.showQueryRow();" >檢索頁面--></button>
		

		<!-- Button trigger modal -->
		<button type="button" id='test' class="btn btn-primary btn-lg hidden" data-toggle="modal" data-target="#recoverContent" >
			Launch demo modal
		</button>

		<!-- Modal -->
		<div class="modal fade" id="recoverContent" tabindex="-1" role="dialog" aria-labelledby="recoverContentLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title" id="recoverContentLabel">Hello</h4>
					</div>
					<div class="modal-body">
						<p>在上次離開後，本系統有幫您做紀錄</p>
						<p>是否要回復上次瀏覽狀態?</p>
						<hr>
						<!--
						<p>When leaving, system had saved your last record.</p>
						<p>Would you like to recover record for you?</p> -->
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal" onclick='myCookie.recover();'>Recover</button>
					</div>
				</div>
			</div>
		</div>
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
								<div>
									<h4>檢索結果 : </h4>
									<button type="button" class="btn btn-warning" style='float:right;margin-right:10px' onclick="layout.showBookRow()" ><--對讀頁面</button>
								</div>
								
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
								<h1 style='margin-left:40%;' >沒有任何搜尋結果</h1>
								<h4 style='margin-left:30%;' >若要使用全文檢索，請在右上角的搜尋欄位中輸入欲檢索的關鍵字並按下Enter</h4>
							</ul>
						</div>
					</div>
				</div>
			</div>


    </div>
</body>


<script>
	$('body').on('submit', '#searchBar', function(event, flag) {
	event.preventDefault();
	layout.cleanQueryResult();
	$.get( "ajaxQuery.php", { query: $('#query')[0].value, flag: $checked } )
		.done(function( data ) {
		var result = JSON.parse(data);
		if( result.length != 0 ) {
			buildQueryResult(result);
		} else {
			$("#queryDiv").empty();
			$("#querySidebar").append("<h1 style='margin-left:40%;' >沒有任何搜尋結果</h1>");
			$("#querySidebar").append("<h4 style='margin-left:30%;' >若要使用全文檢索，請在右上角的搜尋欄位中輸入欲檢索的關鍵字並按下Enter</h4>");
		}
		
	});
	myCookie.setCookie("query", $('#query')[0].value);
	if(myCookie.recover != true) {
		layout.showQueryRow();
	}
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
	buildYearAnalysisChart($queryHash);
	buildYearAnalysis($queryHash);

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
			
			//$(temp).append("<button style='margin-bottom:5px' type='button' class='btn btn-primary btn-xs " + $queryHash[i][j].timeClass + "' aria-label='Left Align' onclick='layout.findResultInBook(event)'><<</button>");
			$(temp).append("<strong class='" + $queryHash[i][j].timeClass + "' > " + $queryHash[i][j].oriTimeString + "</strong>");
			$(temp).append("<button type='button' style='margin-left:5px' class='btn btn-default " + $queryHash[i][j].timeClass + "' onclick='layout.findResultInBook(event);' aria-label='Left Align'><<在對讀頁面中呈現</button >");
			
			var groupList = document.createElement("lu");
			groupList.className = "list-group";
			groupList.style="margin-bottom:5px";
			for(var k in $queryHash[i][j]) {
				if($queryHash[i][j][k].constructor == String().constructor)
					continue;
				//$(groupList).append("<div class='well well-sm' style='margin-bottom: 0px'>" + getBookName($queryHash[i][j][k].bookcaseId) + "</div>");
				$(groupList).append("<h4>" + getBookName($queryHash[i][j][k].bookcaseId) + "</h4>");
				var block = "<li style='margin-bottom:5px;' class='list-group-item queryText'>" + $queryHash[i][j][k].context.replace($("#query")[0].value,"<kbd style='background-color: #5F5F3F'>" + $("#query")[0].value + "</kbd>" ); + "</li>";
				$(groupList).append(block);
			}
			$(temp).append(groupList);
		}	

	}

	function buildYearAnalysisChart ($queryHash) {
		$('#querySidebar').append("<canvas id='secondChart' width='100%' height='20%'></canvas>");
		var $yearNumArray = queryHashToArray($queryHash);
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
	}

	function queryHashToArray ($queryHash) {
		var flag = [];
		var result = [];
		var temp = ["隱公", "桓公", "莊公", "閔公", "僖公", "文公", "宣公", "成公", "襄公", "昭公", "定公", "哀公"];
		for(var i in $queryHash ) {
			if( flag[$queryHash[i].dateChNorm.substr(1, 2)] == undefined) flag[$queryHash[i].dateChNorm.substr(1, 2)] = 0;
		}
		for(var i in $queryHash) {
			flag[$queryHash[i].dateChNorm.substr(1, 2)] += ( ObjectLength($queryHash[i]) - 1 );
		}
		for(var i in temp) {
			result.push(flag[ temp[i] ]);
		}
		return result;
	}
	function buildYearAnalysis($queryHash) {
		$("#yearListGroup").empty();				//--	reset

		for(var i in $queryHash) {
			var panel = "<div class='panel panel-default " + i + "'><div class='panel-heading' role='tab' id='heading" + i + "'><h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#collapse" + i + "' aria-expanded='false' aria-controls='collapse" + i + "'>" + $queryHash[i].dateChNorm + "(" + (ObjectLength($queryHash[i])-1) + ")</a></h4></div></div>";
			var headingId = "heading" + i;
			var collapseId = "collapse" + i;
			$("#yearListGroup").append(panel);
			panel = $("#yearListGroup").find("." + i)[0];
			$(panel).append("<div id='" + collapseId + "' class='panel-collapse collapse' role='tabpanel' aria-labelledby='" + headingId + "'>");
			var collapse = $(panel).find("#" + collapseId);
			
			//******************* TODO 用超爛的方法解決 array reverse的問題 *******************************
			var a = [];
			for(var j in $queryHash[i]) {
				a.unshift(j);
			}

			for(var j in a) {
				j = a[j];

				if($queryHash[i][j].constructor == String().constructor) continue;
			
				var panelBody="<div class='panel-body'><a href='#' class='" + $queryHash[i][j].timeClass + "' onclick='moveAnchorForQuery(event)'>" + $queryHash[i][j].oriTimeString + "(" + $queryHash[i][j].length +  ")</a></div>";
				
				$(collapse).append(panelBody);
			}	
		}
	}

	function ObjectLength ( object ) {
		var length = 0;
		for( var key in object ) {
			if( object.hasOwnProperty(key) ) {
				++length;
			}
		}
		return length;
	};

	function getYear (input) {
		return input.split("-")[0];
	};

	function getYearAndMonth (input) {
		return input.split("-")[0] + input.split("-")[1];
	};

	function getClassYear (input) {
		return input.yearStart.split('-')[0] + "-" + input.yearStart.split('-')[1];
	};

	function getMonthOrSeason (input) {
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


	};

	function getBookName (input) {
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

	};

	
}
function moveAnchorForQuery (event) {
		var target = $('#querySidebar').find("strong." + event.target.className.replace(/\s+/g,"."));
		var h = target.offset().top;
		$($("#querySidebar")[0]).animate({
				scrollTop: $( $("#querySidebar")[0] ).scrollTop() + h - $($("#querySidebar")[0]).offset().top - 20
			}, 600);
		layout.cleanHitEntryColor();
		layout.changeHitEntryColor( $(target[0].nextElementSibling).find('li') );
	};


</script>