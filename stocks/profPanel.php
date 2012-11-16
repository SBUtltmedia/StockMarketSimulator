<?
//print_r($_SERVER);
//print $_SERVER["HTTP_SHIB_EP_ORGUNITDN"];
$user = $_SERVER["REMOTE_USER"];

if($user != "csellers@stonybrook.edu" && $user != "rihartmann@stonybrook.edu") {
		header( 'Location: index.php' );
	}
	require_once("connect.php");
	
	$sqlCommand = "SELECT * FROM stock_year WHERE current = 1 ORDER BY id DESC";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$row = mysql_fetch_assoc($query);
	$currentYearId = $row['id'];
	$currentYear = $row['year'];
	// Collect information about current user
	$sqlCommand = "SELECT * FROM stock_user WHERE userName = '" . $user ."';";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	
	$holdings = $row['current_holdings'];
	$maxHoldings = $holdings;
	$name = $row['userName'];
	$userId = $row['id'];
	
	// Collect information about the stocks we will be using
	$stocks;
	$i = 0;
	$sqlCommand = "SELECT * FROM stock_stocks;";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	while($row = mysql_fetch_array($query))
		$stocks[$i++] = $row;
	
	$allUse;
	$i = 0;
	$sqlCommand = "SELECT * FROM stock_user ORDER BY current_holdings DESC;";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	while($row = mysql_fetch_array($query))
		$allUse[$i++] = $row;
	
	
?>
<!DOCTYPE html>
<head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body onload="document.form1.reset();">   
   <div class="container">
   	&nbsp;&nbsp;&nbsp;
   	<div class="row">
       <div class="span1">
<form action="changeYear.php">
	<input type="submit" value="Next Year" />
</form>
</div> 
<div class="span4">
<table>
	<tr><td>Current Stock Prices</td></tr>
	<?php foreach($stocks as $stock) : ?>
		<tr><td><?php echo $stock['name']; ?></td><td><?php echo $stock['price']; ?></td></tr>
		<?php endforeach; ?>
</table>
</div class="span4">
<table>
	<tr><td>All Students and Prices</td></tr>
	<?php foreach($allUse as $aU) : ?>
		<tr><td><?php echo $aU['userName']; ?></td><td><?php echo $aU['current_holdings']; ?></td></tr>
		<?php endforeach; ?>
</table>

</div>
</div>
</body>
</html>

