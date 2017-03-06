<?php

    include("phpManager/DBManager.php");
	$DBManager = new DBManager; 
    echo json_encode($DBManager->queryAjax($_GET['query'], $_GET['flag']) );
    
?>