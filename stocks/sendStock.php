<?php
require_once("connect.php");

$user = $_SERVER["REMOTE_USER"];

// Collect information about current user
$sqlCommand = "SELECT * FROM stock_user WHERE userName = '" . $user ."';";
$query = mysql_query($sqlCommand) or die (mysql_error());
$row = mysql_fetch_assoc($query);
$holdings = $row['current_holdings'];
$userId = $row['id'];

// Get the current year
$sqlCommand = "SELECT * FROM stock_year WHERE current=1 ORDER BY id DESC LIMIT 1";
$query = mysql_query($sqlCommand) or die (mysql_error());
$row = mysql_fetch_assoc($query);
$currentYear = $row['year'];

// Get the list of stocks
$stocks;
$i = 0;
$sqlCommand = "SELECT * FROM stock_stocks;";
$query = mysql_query($sqlCommand) or die (mysql_error());
while($row = mysql_fetch_array($query))
	$stocks[$i++] = $row;

// Now we need stock inputs
$submissions;
$i = 0;
foreach ($_POST as $key => $value) {
     $submissions[$i++]= intval($value);
}

//var_dump($submissions);

$reduction_amount = $holdings/10;

$j=0;
$sqlCommand = "SELECT * FROM stock_transaction WHERE userId = " . $userId . " AND year = $currentYear;";
$query = mysql_query($sqlCommand) or die (mysql_error());
if(mysql_num_rows($query) > 0) {
	while($row = mysql_fetch_array($query))
		$userShares[$row['stockId']] = $row['transactionPct'];
}
	
//echo $reduction_amount;
// Go through each submission and make transaction
$i = 0;
foreach($submissions as $submission) {
	if($submission != 0) {
		$stockToUse = $stocks[$i];
		$stock_price = $stockToUse['price'];
		$share_amount = (($submission/10) * $reduction_amount) / $stock_price;
		$share_amount = round($share_amount, 2);
		if($userShares[($i + 1)]) { // Update the users current stock holdings
			$sqlCommand = "UPDATE stock_transaction SET transactionPct=" . ($submission/10) .", transAmount=$share_amount WHERE userId=$userId AND stockId=" . ($i+1) . " AND year=$currentYear;";
		}
		// Build the sql command string for inserting transaction
		else {
			$sqlCommand = "INSERT INTO stock_transaction (userId, stockId, transactionPct, transAmount, year) SELECT u.id, s.id, " . ($submission/10) .", " . $share_amount . ", " . $currentYear . " FROM stock_user u, stock_stocks s WHERE u.userName = '" .
			$user . "' AND s.name = '" . $stockToUse['name'] ."'";
		}
		//echo $sqlCommand;
		// Execute the query here now
		$query = mysql_query($sqlCommand) or die (mysql_error());
		print_r("You now have " . $share_amount . " shares of " . $stockToUse['name'] . "! </br>");
	}
	// We still need to see if the user sold all his previous holdings
	else {
		if($userShares[($i + 1)]) {// The user has gotten rid of that stock
			$sqlCommand = "DELETE FROM stock_transaction WHERE userId=$userId AND stockId=" . ($i+1) . " AND year=$currentYear;";
			$query = mysql_query($sqlCommand) or die (mysql_error());
		}
	}
	$i++;
}


// close mysql connection
mysql_close(); 

?>
<a href="index.php">Go Back</a>