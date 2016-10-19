<html>
	<link rel="stylesheet" href="index.css" type="text/css" >


<?php
	include("phpManager/DBManager.php");

	$DBManager = new DBManager; 
	$DBManager->findBooksNumArray("雨");
	
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