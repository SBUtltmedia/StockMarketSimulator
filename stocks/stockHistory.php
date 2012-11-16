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
	
	// Collect information about the stocks we will be using
	$stocks;
	$i = 0;
	$sqlCommand = "SELECT s.name, s.id FROM stock_stocks s;";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	while($row = mysql_fetch_array($query))
		$stocks[$i++] = $row;
	
	$stockId = 1;
	
	if(isset($_GET['stockId']))
		$stockId=$_GET['stockId'];
	
	$i=0;
	$sqlCommand = "SELECT ph.stockId, s.name, ph.price as o1, ph.yearId, hpl.price o2 FROM stock_stocks s, stock_price_history ph LEFT JOIN stock_historical_price_list hpl ON ph.yearId=hpl.yearId and ph.stockId=hpl.stockId WHERE s.id=ph.stockId AND s.id=$stockId;";
	$query = mysql_query($sqlCommand) or die (mysql_error());
	while($row = mysql_fetch_array($query))
		$stocksP[$i++] = $row;

		
	
?>
<!DOCTYPE html>
<head>
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" href="css/claro.css" />
	<link href="css/bootstrap.min.css" rel="stylesheet">
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
   		<?php foreach ($stocks as $stock): ?>
   			<li class="stock <?php if($stock['id']==$stockId) echo "active"; ?>" alt="<?php echo $stock['id']; ?>"><a href="stockHistory.php?stockId=<?php echo $stock['id']; ?>"><?php echo $stock['name']; ?></a></li>
   			<?php endforeach; ?>
   		</ul>
   	</div>
   	<div class="span8">
   	<h1>Stock History: <span class="sName"><?php echo $stocks[$stockId-1]['name'] ?></span></h1>
		
		<div id="chartNode" style="width:600px;height:400px;"></div>
		<div id="legend"></div>
		</div>

		<!-- load dojo and provide config via data attribute -->
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
		
				dojo.require("dojox.charting.Chart2D");
				
				// Retrieve the Legend, Tooltip, and Magnify classes
				dojo.require("dojox.charting.widget.Legend");
				dojo.require("dojox.charting.action2d.Tooltip");
				dojo.require("dojox.charting.action2d.Magnify");
	
				// Require the theme of our choosing
				//"Claro", new in Dojo 1.6, will be used
				dojo.require("dojox.charting.themes.Claro");
				
				// Define the data
				var chartDataU = [<?php foreach ($stocksP as $stockd) echo $stockd["o1"]. ","; ?>];
				var chartDataH = [<?php foreach ($stocksP as $stockd) echo $stockd["o2"]. ","; ?>];
				
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
					chart.addAxis("x", {labels: [<?php $i = 1; foreach ($stocksP as $stockd) : ?>{value: <?php echo $i++; ?>, text: "Year <?php echo $stockd["yearId"] ?>"},<?php endforeach; ?>]});
					chart.addAxis("y", { min: 0, vertical: true, fixLower: "major", fixUpper: "major" });
	
					// Add the series of data
					chart.addSeries("Game Price",chartDataU, {stroke: "blue", fill: "lightblue"});
					chart.addSeries("Historical Price",chartDataH, {stroke: "green", fill: "lightgreen"});
					
					// Create the tooltip
					var tip = new dojox.charting.action2d.Tooltip(chart,"default");
					
					// Create the magnifier
					var mag = new dojox.charting.action2d.Magnify(chart,"default");
					
					// Render the chart!
					chart.render();
					
					// Create the legend
					var legend = new dojox.charting.widget.Legend({ chart: chart }, "legend");
				});
			
		</script>
  </body>
  </html>