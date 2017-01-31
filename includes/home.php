<?php

if(!defined("IN_MAIN"))
	die("Access Denied");

?>

<div id="map"></div>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxIwFQA0mojqxv2Cf_n1inoXzq6tBfrJ8&callback=initMap" async defer></script>

<script>
setInterval('updateDrivers();', 2000);
</script>