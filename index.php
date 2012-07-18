<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>get me to the news on time</title>
<?php
  $cache = '';
  if(isset($_GET['eraseCache'])){
    echo '<meta http-equiv="Cache-control" content="no-cache">';
    echo '<meta http-equiv="Expires" content="-1">';
    $cache = '?'.time();
  }
?><meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="user-scalable=no, width=device-width" />
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.css" />
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.1.1/jquery.mobile-1.1.1.min.js"></script>		
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="http://gmaps-samples-v3.googlecode.com/svn/trunk/geolocate/geometa.js"></script>
<style type="text/css">
  *, html { margin:0; padding:0 }
  div#info { width:100%; text-align:left; left:0; }
  .lightBox {
    padding:2px;
  }
</style>
<script type="text/javascript">
  var map;
  function initialise() {
    var latlng = new google.maps.LatLng(-25.363882,131.044922);
    var myOptions = {
      zoom: 4,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.TERRAIN,
      disableDefaultUI: true
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    prepareGeolocation();
    doGeolocation();
  }

  function doGeolocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(positionSuccess, positionError);
    } else {
      positionError(-1);
    }
  }

  function positionError(err) {
    var msg;
    switch(err.code) {
      case err.UNKNOWN_ERROR:
        msg = "Unable to find your location";
        break;
      case err.PERMISSION_DENINED:
        msg = "Permission denied in finding your location";
        break;
      case err.POSITION_UNAVAILABLE:
        msg = "Your location is currently unknown";
        break;
      case err.BREAK:
        msg = "Attempt to find location took too long";
        break;
      default:
        msg = "Location detection not supported in browser";
    }
    document.getElementById('info').innerHTML = msg;
  }

  function positionSuccess(position) {
    // Centre the map on the new location
    var coords = position.coords || position.coordinate || position;
    var latLng = new google.maps.LatLng(coords.latitude, coords.longitude);
    map.setCenter(latLng);
    map.setZoom(12);
    var marker = new google.maps.Marker({
	    map: map,
	    position: latLng,
	    title: 'You are here!'
    });
    document.getElementById('info').innerHTML = 'Looking for <b>' +
        coords.latitude + ', ' + coords.longitude + '</b>...';

    // And reverse geocode.
    (new google.maps.Geocoder()).geocode({latLng: latLng}, function(resp) {
		  var place = "You're around here somewhere!";
		  if (resp[0]) {
			  var bits = [];
			  for (var i = 0, I = resp[0].address_components.length; i < I; ++i) {
				  var component = resp[0].address_components[i];
				  //if (contains(component.types, 'political')) {
					  bits.push('<b>' + component.short_name + '</b>');
					//}
				}
				if (bits.length) {
					place = '<h3>We found you here:</h3><br>' + bits.join(', ') + '<br><br><h3>Dispatch me within</h3> <br><br> ' + '<a href=\"news-near-here.php?' + 'lat=' + coords.latitude + '&long=' + coords.longitude + '&radius=0.5&label=all\" data-role=\"button\"><b>5 minutes of here</b></a><br><br>' + ' <a href=\"news-near-here.php?' + 'lat=' + coords.latitude + '&long=' + coords.longitude + '&radius=8&label=all\" data-role=\"button\"><b>30 to 60 minutes of here</b></a>';
       
				}
				marker.setTitle(resp[0].formatted_address);
			}
			document.getElementById('info').innerHTML = place;
	  });
  }

  function contains(array, item) {
	  for (var i = 0, I = array.length; i < I; ++i) {
		  if (array[i] == item) return true;
		}
		return false;
	}

</script>
</head>
<body onload="initialise()">
<div data-role="page" data-theme="b" id="jqm-home">
	<div data-role="header" data-position="inline">
		<h1>dispatchorama</h1>
	</div>

	<div data-role="content" data-fullscreen="true">

	  <div id="map_canvas"></div>
	  <div id="info" class="lightbox" data-role="controlgroup" data-type="horizontal">Detecting your location...</div>

	</div>


</div>

</body>
</html>
