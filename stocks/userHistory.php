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
	// Collect information about current user
	$sqlCommand = "SELECT * FROM stock_user WHERE userName = '" . $user ."';";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$row = mysql_fetch_assoc($query);
	if(empty($row) && $user != "csellers@stonybrook.edu") {
		header( 'Location: newUser.php' );
	}
	
	$name = $row['userName'];
	$userId = $row['id'];
	
	$i=0;
	$sqlCommand = "SELECT * FROM stock_user_history uh NATURAL JOIN stock_all_user_hist auh WHERE uh.userId=$userId";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	while($row = mysql_fetch_array($query))
		$userIn[$i++] = $row;
	
	
	$tMax = ($userIn[count($userIn)-1]["max"]);
	$tMin = ($userIn[count($userIn)-1]["min"]);
	
	$quart = round((($tMax-$tMin)/5), 2);
	
	
	for($i = 0; $i < 5; $i++) {
		if($i == 4)
			$sqlCommand = "SELECT COUNT(current_holdings) FROM stock_user WHERE current_holdings >= " . ($tMin + ($quart * $i)) . " AND current_holdings <= " . ($tMax + 1);
		else
			$sqlCommand = "SELECT COUNT(current_holdings) FROM stock_user WHERE current_holdings >= " . ($tMin + ($quart * $i)) . " AND current_holdings < " . ($tMin + ($quart * ($i+1)));
		$query = mysql_query($sqlCommand) or die (mysql_error());
		$row = mysql_fetch_assoc($query);
		$quarts[$i] = $row['COUNT(current_holdings)'];
	}
	
	$chartType = 1;
	
	if(isset($_GET['type']))
		$chartType=$_GET['type'];
	
	?>
<!DOCTYPE html>
<head>
	<script src="js/jquery.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/claro.css" />
</head>
<body>
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
   	<div class="span3">
   		<ul class="nav nav-list">
   			<li <?php if ($chartType == 1) echo 'class="active"'; ?>><a href="userHistory.php?type=1">Line Graph</a></li>
   			<li <?php if ($chartType == 2) echo 'class="active"'; ?>><a href="userHistory.php?type=2">Histogram</a></li>
   		</ul>
   	</div>
   	<div class="span8">
   		<?php if ($chartType == 1) : ?>
   		<h1>User History: <span class="sName"><?php echo $name ?></span></h1>
   		<?php endif; ?>
   		<?php if ($chartType == 2) : ?>
   		<h1>Current Holdings Histogram</h1>
   		<?php endif; ?>
		
		<div id="chartNode" style="width:600px;height:400px;"></div>
		<div id="legend"></div>
		</div>
		


		
		<!-- load dojo and provide config via data attribute -->
		<script type="text/javascript">
			djConfig = {
		        parseOnLoad: false,
		        isDebug: false,
		        modulePaths: {
                            "dojo": "https://ajax.googleapis.com/ajax/libs/dojo/1.6.0/dojo",
                            "dijit": "https://ajax.googleapis.com/ajax/libs/dojo/1.6.0/dijit",
                            "dojox": "https://ajax.googleapis.com/ajax/libs/dojo/1.6.0/dojox"
                        }
		    };
		</script>
		<script src="js/dojo.xd.js" 
				data-dojo-config="isDebug: true,parseOnLoad: true">
		</script>
		<script>
		
		var type = <?php if($chartType == 1) echo '"line"'; else echo '"hist"'; ?>;
		
			if(type == "line") {
				// Require the basic 2d chart resource: Chart2D
				dojo.require("dojox.charting.Chart2D");
				
				// Retrieve the Legend, Tooltip, and Magnify classes
				dojo.require("dojox.charting.widget.Legend");
				dojo.require("dojox.charting.action2d.Tooltip");
				dojo.require("dojox.charting.action2d.Magnify");
	
				// Require the theme of our choosing
				//"Claro", new in Dojo 1.6, will be used
				dojo.require("dojox.charting.themes.Claro");
				
				// Define the data
				var chartDataU = [<?php foreach ($userIn as $userI) echo $userI["total"] . ","; ?>];
				var chartDataMin = [<?php foreach ($userIn as $userI) echo $userI["min"] . ","; ?>];
				var chartDataMax = [<?php foreach ($userIn as $userI) echo $userI["max"] . ","; ?>];
				
				// When the DOM is ready and resources are loaded...
				dojo.ready(function() {
					
					// Create the chart within it's "holding" node
					var chart = new dojox.charting.Chart2D("chartNode");
	
					// Set the theme
					chart.setTheme(dojox.charting.themes.Claro);
	
					// Add the only/default plot 
					chart.addPlot("default", {
						type: "Lines",
						markers: true
					});
					
					// Add axes
					chart.addAxis("x", {labels: [<?php $i = 1; foreach ($userIn as $userI) : ?>{value: <?php echo $i++; ?>, text: "Year <?php echo $userI["yearId"] ?>"},<?php endforeach; ?>]});
					chart.addAxis("y", { min: 0, vertical: true, fixLower: "major", fixUpper: "major" });
	
					// Add the series of data
					chart.addSeries("User History",chartDataU, {stroke: "blue", fill: "lightblue"});
					chart.addSeries("Max History",chartDataMax, {stroke: "green", fill: "lightgreen"});
					chart.addSeries("Min History",chartDataMin, {stroke: "red", fill: "pink"});
					
					// Create the tooltip
					var tip = new dojox.charting.action2d.Tooltip(chart,"default");
					
					// Create the magnifier
					var mag = new dojox.charting.action2d.Magnify(chart,"default");
					
					// Render the chart!
					chart.render();
					
					// Create the legend
					var legend = new dojox.charting.widget.Legend({ chart: chart }, "legend");
				});
			}
			
			if(type == "hist") {
				
				// Require the basic 2d chart resource: Chart2D
			dojo.require("dojox.charting.Chart2D");

			// Require the theme of our choosing
			//"Claro", new in Dojo 1.6, will be used
			dojo.require("dojox.charting.themes.MiamiNice");
			
			// Define the data
			var chartData = [<?php foreach ($quarts as $q) echo $q . ","; ?>];
			
			// When the DOM is ready and resources are loaded...
			dojo.ready(function() {
				
				// Create the chart within it's "holding" node
				var chart = new dojox.charting.Chart2D("chartNode");

				// Set the theme
				chart.setTheme(dojox.charting.themes.MiamiNice);

				// Add the only/default plot 
				chart.addPlot("default", {
					type: "Columns",
					markers: true,
					gap: 5,
					animate:{duration: 1000}
				});
				
				// Add axes
				chart.addAxis("x", {labels: [{value: 1, text: "<?php echo $tMin; ?>"},
                                          {value: 2, text: "Quart 2"},
                                        {value: 3, text: "Quart 3"},
                                        {value: 4, text: "Quart 4"},
                                        {value: 5, text: "<?php echo $tMax; ?>"}]});
				chart.addAxis("y", { vertical: true, fixLower: "major", fixUpper: "major" });

				// Add the series of data
				chart.addSeries("Monthly Sales",chartData);

				// Render the chart!
				chart.render();
				
			});
			}
			
		</script>
  </body>
  </html>