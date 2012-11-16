<html>
<?php

//echo "pull 1<br />"; 
 require_once("connect.php");
/*
 * Recalculate stock prices
 */
 // Get current year and stocks info
  
$sqlCommand = "SELECT * FROM stock_year WHERE current = 1 ORDER BY id DESC";
$query = mysql_query($sqlCommand) or die (mysql_error());
$row = mysql_fetch_assoc($query);
$currentYearId = $row['id'];
$currentYear = $row['year'];
// Get the list of stocks
$stocks;
$i = 0;
$sqlCommand = "SELECT * FROM stock_stocks;";
$query = mysql_query($sqlCommand) or die (mysql_error());
while($row = mysql_fetch_array($query))
	$stocks[$i++] = $row;

// Get the number of users in the system
$sqlCommand = "SELECT * FROM stock_stocks;";
$query = mysql_query($sqlCommand) or die (mysql_error());
$amountOfUsers = mysql_num_rows($query);
 

 // Gather historcal price percentage change
$stocks_percent_change; 
$i= 0;
$sqlCommand = "SELECT * FROM stock_historical_change WHERE yearId = " . ($currentYearId + 1) . " ORDER BY stockId ASC;";
//echo $sqlCommand;
$query = mysql_query($sqlCommand) or die (mysql_error());
while($row = mysql_fetch_array($query))
	$stocks_percent_change[$i++] = $row;


 // Calculate user differences in stock share holdings
 // TODO:Calculate user differences in stock share holdings
 $extraUserChange = 0;
 $currYearTotals;
 $prevYearTotals;
 $i= 0;
 $sqlCommand = "SELECT stockId, SUM(transAmount) FROM stock_transaction WHERE year = ". $currentYear . " GROUP BY stockId";
$query = mysql_query($sqlCommand) or die (mysql_error());
while($row = mysql_fetch_array($query))
		$currYearTotals[$row['stockId']] = $row['SUM(transAmount)'];

//var_dump($currYearTotals);

 
 // Recalculate and update stocks with new prices
$newPrice;
$prices;
for($i = 0; $i < count($stocks_percent_change); $i++) {
	$stockChange = $stocks[$i];
	$stockPer = $stocks_percent_change[$i];
	$divAmount = $stockPer['percentageChange'] / 100;
	$addAmount = $stockChange['price'] * $divAmount;
	$newPrice = $stockChange['price'] + $addAmount;
	
	$prev = 0;
	$curr = 0;
	
	if($currYearTotals[$i+1]){
		$curr = $currYearTotals[$i+1];
	}
	if($prevYearTotals[$i]){
		$prev = $prevYearTotals[$i+1];
	}
	$retAmount = (($curr - $prev) / $amountOfUsers) * 0.1;
	$historical = round($newPrice,2);
	
	$prices[$i] = round($newPrice + $retAmount, 2);
	
	$sqlCommand = "UPDATE stock_stocks SET price=" . $prices[$i] . " WHERE id=" . $stockChange['id'];
	$query = mysql_query($sqlCommand) or die (mysql_error());
	
	$sqlCommand = "INSERT INTO stock_price_history (stockId, price, yearId) VALUES (" . $stockChange['id'] . ", " . $prices[$i] . ", " . ($currentYearId+1) . ")";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	
	// For display purposes of seeing price change
	echo($prices[$i] . "<br />");
} 

 
 /*
  * Update user holdings and new year information
  */
  
 // Get a list of users so you can access their ID

$userIds;
$i = 0;
$sqlCommand = "SELECT * FROM stock_user;";
$query = mysql_query($sqlCommand) or die (mysql_error());
while($row = mysql_fetch_array($query))
	$userIds[$i++] = $row['id'];

 // Update users current holdings based on stock shares and newly calculated prices
 $userShares;
 $userHoldings = 0;
 for($i = 0; $i < count($userIds); $i++) {
 	// Get the users previous transactions
 	$j=0;
 	$sqlCommand = "SELECT * FROM stock_transaction WHERE userId = " . $userIds[$i] . " AND year = $currentYear;";
	//echo $sqlCommand;
	$query = mysql_query($sqlCommand) or die (mysql_error());
	if(mysql_num_rows($query) > 0) {
		while($row = mysql_fetch_array($query))
			$userShares[$j++] = $row;
		
		foreach($userShares as $userShare) {
			$addAmount = $userShare['transAmount'] * $prices[$userShare['stockId']-1];
			//echo $addAmount . "<br />";
			$userHoldings += round($addAmount, 2);
		}
			//echo $userHoldings . "<br />";
			
		$sqlCommand = "UPDATE stock_user SET current_holdings=$userHoldings WHERE id=" . $userIds[$i];
	$query = mysql_query($sqlCommand) or die (mysql_error());
	
	$sqlCommand = "INSERT INTO stock_user_history(userId, total, yearId) VALUES (" . $userIds[$i] . ", $userHoldings, " . ($currentYearId+1) . ")";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	
	$userHoldings = 0;
	}
	
	
 }
 
 $sqlCommand = "SELECT MIN(current_holdings), MAX(current_holdings) FROM stock_user";
 $query = mysql_query($sqlCommand) or die (mysql_error());
 $row = mysql_fetch_assoc($query);
 
 $highest = $row['MAX(current_holdings)'];
 $lowest = $row['MIN(current_holdings)'];
 
 
 $sqlCommand = "INSERT INTO stock_all_user_hist(max, min, yearId) VALUES ($highest, $lowest, " . ($currentYearId+1) . ")";
$query = mysql_query($sqlCommand) or die (mysql_error());
 
 
 
 // Insert new news articles (should probably be calling file that contains each years articles)
  // TODO: Insert new news articles (should probably be calling file that contains each years articles)

 
 // Update the current year
// TODO: Update the current year
$sqlCommand = "UPDATE stock_year SET current=NULL WHERE id=$currentYearId";
$query = mysql_query($sqlCommand) or die (mysql_error());
$sqlCommand = "UPDATE stock_year SET current=1 WHERE id=" . ($currentYearId+1);
$query = mysql_query($sqlCommand) or die (mysql_error());

if(($currentYearId +1) == 2) {	// Second year of the simulation
	$sqlCommand = "INSERT INTO stock_stocks (id, name, price) VALUES (13, 'General Electric', 196.5);";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$sqlCommand = "INSERT INTO stock_price_history (stockId, price, yearId) VALUES (13, 196.5, 2)";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$sqlCommand = "INSERT INTO stock_stocks (id, name, price) VALUES (14, 'Dupont', 131.475);";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$sqlCommand = "INSERT INTO stock_price_history (stockId, price, yearId) VALUES (14, 131.475, 2)";
	$query = mysql_query($sqlCommand) or die (mysql_error());
}
if(($currentYearId +1) == 3) {	// Second year of the simulation
	$sqlCommand = "INSERT INTO stock_stocks (id, name, price) VALUES (15, 'Radio Corporation of America', 64.75);";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$sqlCommand = "INSERT INTO stock_price_history (stockId, price, yearId) VALUES (15, 64.75, 3)";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$sqlCommand = "INSERT INTO stock_stocks (id, name, price) VALUES (16, 'Proctor and Gamble', 112);";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$sqlCommand = "INSERT INTO stock_price_history (stockId, price, yearId) VALUES (16, 112, 3)";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$sqlCommand = "INSERT INTO stock_stocks (id, name, price) VALUES (17, 'International Business Machines', 118.125);";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$sqlCommand = "INSERT INTO stock_price_history (stockId, price, yearId) VALUES (17, 118.125, 3)";
	$query = mysql_query($sqlCommand) or die (mysql_error());
}
?>
</html>