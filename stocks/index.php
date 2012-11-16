<?
//print_r($_SERVER);
//print $_SERVER["HTTP_SHIB_EP_ORGUNITDN"];
$user = $_SERVER["REMOTE_USER"];
	require_once("connect.php");
	
	setlocale(LC_MONETARY, 'en_US');
	$sqlCommand = "SELECT * FROM stock_year WHERE current = 1 ORDER BY id DESC";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$row = mysql_fetch_assoc($query);
	
		$currentYearId = $row['id'];
		$currentYear = $row['year'];
	
	
	$sqlCommand = "SELECT * FROM stock_year WHERE id = " . ($currentYearId - 1) . " ORDER BY id DESC";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$row = mysql_fetch_assoc($query);
	$prevYear = NULL;
	$prevYearId = NULL;
	if(!empty($row)) {
		$prevYear = $row['year'];
		$prevYearId = $row['id'];
	}
	
	// Collect information about current user
	$sqlCommand = "SELECT * FROM stock_user WHERE userName = '" . $user ."';";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$row = mysql_fetch_assoc($query);
	if(empty($row) && $user != "csellers@stonybrook.edu") {
		header( 'Location: newUser.php' );
	}
	
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
	
	// If the user has invested before in this year...
	$investBefore = false;
	$sqlCommand = "SELECT * FROM stock_transaction WHERE userId = " . $userId . " AND year = $currentYear;";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	if(mysql_num_rows($query) > 0) {
		while($row = mysql_fetch_array($query))
			$userShares[$row['stockId']] = $row['transactionPct'];
		$investBefore = true;
	}
	
	$reduceAmount = round(($maxHoldings / 10), 2);
	
	if($investBefore) {
		foreach($userShares as $userShare) {
			$holdings -= $userShare['transactionPct'] * $reduceAmount;
		}
	}
	/*
	 * 
	 * This chunk is for previous earnings
	 * 
	 */
	 if($prevYear != NULL) {
	 	$i = 0;
	 	$sqlCommand = "SELECT ss.name, st.transAmount, ph.price as o1, ss.price as o2 FROM stock_transaction st" .
	 	" NATURAL JOIN stock_price_history ph LEFT JOIN stock_stocks ss on st.stockId=ss.id" . 
	 	" WHERE st.userId = " . $userId . " AND st.year = " . $prevYear . " AND ph.yearId=" . $prevYearId . " AND st.stockId=ss.id;";
		$query = mysql_query($sqlCommand) or die (mysql_error());
		if(mysql_num_rows($query) > 0) {
			while($row = mysql_fetch_array($query))
				$prevShares[$i++] = $row;
		}
		
		
	 }
	 /*
	  * 
	  * 
	  */
	
	$holdings = round($holdings, 2);
	
	if($holdings < 0)
		$holdings = 0;
	
?>
<!DOCTYPE html>
<head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body onload="document.form1.reset();">
	<div class="navbar navbar-inverse navbar-static-top">
      <div class="navbar-inner">

        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          </a>
          <a class="brand" href="#">Welcome, <?php echo $name; ?></a>
          <a class="brand" href="index.php">Invest</a>
          <a class="brand" href="stockHistory.php">Stock History</a>
          <a class="brand" href="userHistory.php">User History</a>
          <span class="pull-right"><a href="../Shibboleth.sso/Logout" class="btn btn-primary btn-large">Logout</a></span>
         </div>
      </div>
 </div> 
   
   <div class="container">
   	&nbsp;&nbsp;&nbsp;
   	<div class="row">
        <div class="span8">
			<form name="form1" id="form1" action="sendStock.php" method="post">
				<h1>Current Holdings: $<span class="currentAmount"><?php echo $holdings; ?></span></h1>
				<p>(Use plus and minus symbols to change percentage)</p>
				<?php
					foreach($stocks as $stock):
				?>
				<p><span class="stockName"><?php echo ucfirst($stock['name']) ?></span><a id="minus" class="1" href="#">-</a>
					<input type="text" readonly="readdonly" value="<?php if($userShares[$stock['id']]) echo ($userShares[$stock['id']]*10); else echo "0"; ?>" class="1 noClickDisp" id="value" name="<?php echo $stock['id']?>" />%
					<a id="plus" class="1" href="#">+</a>
					<?php 
					echo 'Price per Share: <span id="priceperShare" class="' . $stock['price'] . '">' . money_format('%(#10n', $stock['price']) . '</span>'; 
					?>
				</p>
				<?php endforeach; ?>
				<input type="submit" value="Submit" />
			</form>
		</div>
		<div class="span3">
			<h1>Earnings</h1>
			<table>
				<?php if(isset($prevShares)) {
					foreach($prevShares as $pShare) : ?>
						<tr><td><?php echo $pShare['name'] ?></td><td><?php 
						$currYearPull = $pShare['o2'] * $pShare['transAmount'];
						$lastYearPull = $pShare['o1'] * $pShare['transAmount'];
						$preTotal = round(($currYearPull - $lastYearPull), 2);
						if($preTotal > 0)
							$green = true;
						else
							$green = false;
						echo '<span ';
						if($green)
							echo 'style="color:#0f0">';
						else {
							echo 'style="color:#f00">';
						}
						echo money_format('%(#10n', $preTotal);
						echo "</span>";
						 ?></td></tr>
					<?php endforeach; } ?>
			</table>
		</div>
	</div>
	
	<?php

	$sqlCommand = "SELECT SUM(t.transAmount), s.name, t.stockId FROM stock_user u, stock_stocks s, stock_transaction t WHERE u.userName = '" . $user . "' AND u.id = t.userId AND s.id = t.stockId AND year="
	 . $currentYear . " GROUP BY t.stockId";
		//echo $sqlCommand;
		// Execute the query here now
		$query = mysql_query($sqlCommand) or die (mysql_error());
		
		while($row = mysql_fetch_array($query)){
		echo "Total ". $row['name']. " = ". $row['SUM(t.transAmount)'] . " shares";
		echo "<br />";
	}
	?>
	</div>
	
	
	<!-- Scripts !-->
	<script type="text/javascript">
		$(function(){
			
		var allValue = $(".currentAmount");
		var maxAmount = <?php echo $maxHoldings ?>;
		// amount to reduce by needs to be constant
		var amountToReduce = maxAmount / 10;
			
	    function incrementValue(increment, idClass){
	    	alert(idClass);
	    	var valueElement = $("#value." + idClass);
	        valueElement.text(Math.max(parseFloat(valueElement.attr("value")) + increment, 0));
	        return false;
	    }
	
	    $('#plus.1, #plus.2, #plus.3, #plus.4').bind("click", function(){
	    	var valueElement = $(this).siblings("#value");
	    	if(parseFloat(allValue.text()) > 0 && parseFloat(valueElement.val()) < maxAmount) {
	        valueElement.val(Math.max(((parseFloat(valueElement.val())/10) + 1)*10, 0));
	        var priceperShare = parseFloat($(this).siblings("#priceperShare").attr("class"));
	        allValue.text((Math.max(parseFloat(allValue.text()) - amountToReduce, 0)).toFixed(3));
	       }
	        return false;
	    });
	
	    $('#minus.1, #minus.2, #minus.3, #minus.4').bind("click", function(){
	    	var valueElement = $(this).siblings("#value");
	    	if(parseFloat(valueElement.val()) > 0 && parseFloat(allValue.text()) <= maxAmount) {
	        valueElement.val(Math.max(((parseFloat(valueElement.val())/10) + -1)*10, 0));
	        var priceperShare = parseFloat($(this).siblings("#priceperShare").attr("class"));
	        allValue.text((Math.max(parseFloat(allValue.text()) + amountToReduce, 0)).toFixed(3));
	       }
	        return false;
	    });
	
	});

	</script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>