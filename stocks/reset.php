<?php 
require_once("connect.php");
$sqlCommand = "TRUNCATE stock_price_history;";
$_1 = 				"TRUNCATE stock_user_history;";
$_2 = 				"TRUNCATE stock_all_user_hist;";
$_3 = 				"UPDATE stock_year set current=1 where id=1;";
$_4 = 				"UPDATE stock_year set current=null where id!=1;";
$_5 = 				"UPDATE stock_user set current_holdings=100000;";
$_6 = 				"INSERT INTO stock_price_history (stockId, price) SELECT id, price FROM stock_stocks;";
$_7 = 				"UPDATE stock_price_history set yearId=1;";
$_8 = 				"INSERT INTO stock_user_history (userId, total) SELECT id, current_holdings FROM stock_user;";
$_9 = 				"UPDATE stock_user_history set yearId=1;";
$_10 = 				"INSERT INTO stock_all_user_hist (min, max, yearId) VALUES(100000, 100000, 1);";
$query = mysql_query($sqlCommand) or die (mysql_error());
$query = mysql_query($_1) or die (mysql_error());
$query = mysql_query($_2) or die (mysql_error());
$query = mysql_query($_3) or die (mysql_error());
$query = mysql_query($_4) or die (mysql_error());
$query = mysql_query($_5) or die (mysql_error());
$query = mysql_query($_6) or die (mysql_error());
$query = mysql_query($_7) or die (mysql_error());
$query = mysql_query($_8) or die (mysql_error());
$query = mysql_query($_9) or die (mysql_error());
$query = mysql_query($_10) or die (mysql_error());
?>