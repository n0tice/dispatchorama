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
$lat = $_GET['lat'];
$long = $_GET['long'];
$currentloc = $_GET['lat'] . "," . $_GET['long'];
$radius = $_GET['radius'];
if ($_GET['label'] == "all") {
	$n0tice_q = "*";
	$twitter_q = "*";
} elseif ($_GET['label'] == "protest")  {
	$n0tice_q = "protest,demonstration,march";
	$twitter_q = "protest";
} elseif ($_GET['label'] == "music")  {
	$n0tice_q = "music,festival,fun";
	$twitter_q = "music";
} elseif ($_GET['label'] == "art")  {
	$n0tice_q = "art,streetart,film,gallery,graffiti,photography";
	$twitter_q = "art";
} elseif ($_GET['label'] == "bad")  {
	$n0tice_q = "crime,police,accident,fire,injury,arrest,arrested";
	$twitter_q = "police";
} elseif ($_GET['label'] == "weather")  {
	$n0tice_q = "rain,snow,sunny,hail,lightning,storm,sky";
	$twitter_q = "weather";
} else {
	$n0tice_q = $_GET['label'];
	$twitter_q = $_GET['label'];
}
$n0tice_url="http://n0ticeapis.com/2/search?latitude=" . $lat . "&longitude=" . $long . "&radius=" . $radius . "&q=" . $n0tice_q;
$string .= file_get_contents($n0tice_url); // get json content
$array = json_decode($string, true); //json decoder
$twitter_url="http://search.twitter.com/search.json?q=" . $twitter_q . "&geocode=" . $lat . "," . $long . "," . $radius . "mi&rpp=100&result_type=mix";
$twitter_string .= file_get_contents($twitter_url); // get json content
$twitter_array = json_decode($twitter_string, true); //json decoder
?>

</head>
<body>
<div data-role="page" data-theme="b" id="jqm-home">

<div data-role="header" data-position="inline">
   <a href='#' class='ui-btn-left' data-icon='arrow-l' onclick="history.back(); return false">back</a><h1>dispatchorama</h1><a href="index.php" data-icon="home" class="ui-btn-right" data-iconpos="notext"></a>
</div>

<div data-role="content" data-fullscreen="true">
<div data-role="navbar">
		<ul>
			<?php 
			$navlink = "news-near-here.php?lat=$lat&long=$long&radius=$radius&amp;currentloc=$currentloc&q=$tags";
			#echo $navlink . "<br>";
			#echo $n0tice_url . "<br>";
			#echo $twitter_url . "<br>";
			echo "<li><a href=\"" . $navlink . "&label=all\"";
			if($_GET['label'] == "all") { echo " class=\"ui-btn-active\"";} 
			echo ">all</a></li>";

			echo "<li><a href=\"" . $navlink . "&label=protest\"";
			if($_GET['label'] == "protest") { echo " class=\"ui-btn-active\"";} 
			echo ">protests</a></li>";

			echo "<li><a href=\"" . $navlink . "&label=music\"";
			if($_GET['label'] == "music") { echo " class=\"ui-btn-active\"";} 
			echo ">music</a></li>";

			echo "<li><a href=\"" . $navlink . "&label=art\"";
			if($_GET['label'] == "art") { echo " class=\"ui-btn-active\"";} 
			echo ">art</a></li>";

			echo "<li><a href=\"" . $navlink . "&label=bad\"";
			if($_GET['label'] == "bad") { echo " class=\"ui-btn-active\"";} 
			echo ">bad news</a></li>";

			echo "<li><a href=\"" . $navlink . "&label=weather\"";
			if($_GET['label'] == "weather") { echo " class=\"ui-btn-active\"";} 
			echo ">weather</a></li>";

			?>
		</ul>
		<form action="<?php echo "news-near-here.php?lat=$lat&long=$long&radius=$radius&amp;currentloc=$currentloc"; ?>" method="get">
			<div data-role="fieldcontain" class="ui-hide-label">
			<input type="search" name="label" id="search-basic" value=""  placeholder="terms,comma-separated" />
			</div>
		</form>
	</div><!-- /navbar -->
	
	
	<?php
	#echo $n0tice_url;
	$i = 0; 
	foreach ($array['results'] as $v) {
		echo "<ul data-role=\"listview\" data-inset=\"true\" data-theme=\"c\" data-dividertheme=\"b\"><li>";
		echo "<a href=\"itempage.php?id=";
		echo $array['results'][$i]['id'];
		echo "&currentloc=" .$currentloc. "\" data-rel=\"dialog\" data-transition=\"pop\">";
		echo $array['results'][$i]['headline'];
		echo "</a></li>";
		echo "</ul>";	
		$i++;
	}
	#echo $twitter_url;
	$i = 0; 
	foreach ($twitter_array['results'] as $v) {
		if ($twitter_array['results'][$i]['geo']['type'] == 'Point') {
			echo "<ul data-role=\"listview\" data-inset=\"true\" data-theme=\"c\" data-dividertheme=\"b\"><li>";
			echo "<a href=\"itempage-tweet.php?id=";
			echo $twitter_array['results'][$i]['id'];
			echo "&currentloc=" .$currentloc. "&lat=" . $twitter_array['results'][$i]['geo']['coordinates'][0] . "&long=" . $twitter_array['results'][$i]['geo']['coordinates'][1] . "\" data-rel=\"dialog\" data-transition=\"pop\">";
			echo $twitter_array['results'][$i]['text'];
			echo "</a></li>";
			echo "</ul>";	
		}
	$i++;
	}
	?>
	</fieldset>
	</div>
	
</div>
</body>

</body>
</html>
