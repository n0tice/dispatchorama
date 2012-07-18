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
$twitter_url = "https://api.twitter.com/1/statuses/show.json?id=" . $id  . "&amp;include_entities=true";

$curl_handle=curl_init();
curl_setopt($curl_handle, CURLOPT_URL,$twitter_url);
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_USERAGENT, 'dispatchorama');
$query = curl_exec($curl_handle);
curl_close($curl_handle);

#$twitter_string = file_get_contents($twitter_url, true); // get json content
$twitter_array = json_decode($query, true); //json decoder
?>

</head>
<body>
<div data-role="page" data-theme="b" id="jqm-home">

<div data-role="header" data-position="inline">
<h1>scene details</h1>
</div>

<div data-role="content" data-fullscreen="true">
	<?php 
	#echo $query;
		echo "<h2>" . $twitter_array['text'] . "</h2>"; 
		echo $twitter_array['created_at'] . "<br><br>"; 
		echo "<a href=\"" . $twitter_array['entities']['urls'][0]['expanded_url'] . "\">" . $twitter_array['entities']['urls'][0]['display_url'] . "</a>";
		echo "<h4>Get me to " . $twitter_array['place']['full_name'] . "</h4>";
	?>
	<div data-role="controlgroup">
	<?php
		echo "<a href=\"directions-tweet.php?id=" . $id . "&transport=walking&currentloc=" . $currentloc . "&lat=" . $twitter_array['geo']['coordinates'][0] . "&long=" . $twitter_array['geo']['coordinates'][1] . "\" data-role=\"button\" data-icon=\"info\">walking</a>";
		echo "<a href=\"directions-tweet.php?id=" . $id . "&transport=driving&currentloc=" . $currentloc . "&lat=" . $twitter_array['geo']['coordinates'][0] . "&long=" . $twitter_array['geo']['coordinates'][1] . "\" data-role=\"button\" data-icon=\"info\">driving</a>";
		echo "<a href=\"directions-tweet.php?id=" . $id . "&transport=transit&currentloc=" . $currentloc . "&lat=" . $twitter_array['geo']['coordinates'][0] . "&long=" . $twitter_array['geo']['coordinates'][1] . "\" data-role=\"button\" data-icon=\"info\">public transport</a>";
	?>
	</div>
</div>		
	
</div>
</body>

</body>
</html>
