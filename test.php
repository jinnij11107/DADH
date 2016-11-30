<html>
	<link rel="stylesheet" href="index.css" type="text/css" >


<?php
	include("phpManager/DBManager.php");
	
	$DBManager = new DBManager; 
	/*
	$DBManager->insertion("context/parsedChunqiu_new.txt", 1);
	$DBManager->insertion("context/parsedZuozhuan_new.txt", 2);
	$DBManager->insertion("context/parsedGongyang_new.txt", 3);
	$DBManager->insertion("context/parsedGongyang_new.txt", 4);*/
	/*
	similar_text("二年春，公會戎于潛。", "二年春，公會戎于潛。", $sim);
	echo $sim;
	*/
	//$DBManager->inesrtToCollections();
	
	/*
	$DBManager = new DBManager; 
	$DBManager->insertion("context\parsedGuliang_new.txt", 3);
	*/
	/*
	$result = $DBManager->queryIndex("雨");
	foreach ($result as $data) {
		echo $data['TITLE']."</br>";
		echo $data['CONTEXT']."</br>";
	}*/	

	//$DBManager->query_book(1);
	//$result = $DBManager->query_book(2);
	/*
	foreach ($result as $data) {
		
		echo $data['TITLE']."</br>";
	}*/
	/*
	$DBManager->query_book(3);
	$DBManager->query_book(4);
	$DBManager->query_book(5);*/
	
	
?>

</html>