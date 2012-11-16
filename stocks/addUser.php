<?php

$user = $_SERVER["REMOTE_USER"];
	require_once("connect.php");
	
	// Add the user to the system 
	
	$sqlCommand = "INSERT INTO stock_user (userName, current_holdings) VALUES ('" . $user ."', 100000);"; // Initial instance is $100,000
	$query = mysql_query($sqlCommand) or die (mysql_error());
	
	$userid = mysql_insert_id(); 
	
	$sqlCommand = "SELECT * FROM stock_year WHERE current = 1 ORDER BY id DESC";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$row = mysql_fetch_assoc($query);
	$currentYearId = $row['id'];
	
	$sqlCommand = "INSERT INTO stock_user_history (userId, total, yearId) VALUES ($userid, 100000, $currentYearId);"; // Initial instance is $100,000
	$query = mysql_query($sqlCommand) or die (mysql_error());
	
	header( 'Location: index.php' );
?>