 <?php 

$db_host = "localhost";
// Place the username for the MySQL database here
$db_username = "tltsecure"; 
// Place the password for the MySQL database here
$db_pass = "0stric4e$"; 
// Place the name for the MySQL database here
$db_name = "tltsecure";

// Run the actual connection here 
mysql_connect("$db_host","$db_username","$db_pass") or die ("could not connect to mysql");
mysql_select_db("$db_name") or die ("no database");             
?>