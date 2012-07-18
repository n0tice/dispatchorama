<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>get me to the news on time</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, width=device-width" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>

<?php
$id = $_GET['id'];
$lat = $_GET['lat'];
$long = $_GET['long'];
$currentloc = $_GET['currentloc'];
$radius = $_GET['radius'];
$transport = $_GET['transport'];
$n0tice_url="http://n0ticeapis.com/2/" . $id;
$string .= file_get_contents($n0tice_url); // get json content
$array = json_decode($string, true); //json decoder
?>

</head>
<body>
<div data-role="page" data-theme="b" id="jqm-home">

<div data-role="header" data-position="inline">
 <h1>scene details</h1>
</div>

<div data-role="content" data-fullscreen="true">
	<?php 
		echo "<h2>" . $array['headline'] . "</h2>"; 
		echo gmdate("j F, Y, g:i a", strtotime($array['created'])); 
		if ($array['updates'][0]['image']['medium']) {
			echo "<br><img src=\"" . $array['updates'][0]['image']['medium'] . "\">";
		}
		echo "<h4>Get me to " . $array['place']['name'] . "</h4>";
	?>
	<div data-role="controlgroup">
	<?php
		echo "<a href=\"directions.php?id=" . $id . "&transport=walking&currentloc=" . $currentloc . "\" data-role=\"button\" data-icon=\"info\">walking</a>";
		echo "<a href=\"directions.php?id=" . $id . "&transport=driving&currentloc=" . $currentloc . "\" data-role=\"button\" data-icon=\"info\">driving</a>";
		echo "<a href=\"directions.php?id=" . $id . "&transport=transit&currentloc=" . $currentloc . "\" data-role=\"button\" data-icon=\"info\">public transport</a>";
	?>
	</div>
</div>
	
</div>
</body>

</body>
</html>
