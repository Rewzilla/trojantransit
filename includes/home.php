<?php

if(!defined("IN_MAIN"))
	die("Access Denied");

if(isset($_POST["submit"]) && isset($_SESSION["id"])) {

	if($role == "driver") {

		$sql = $db->prepare("UPDATE pickups SET complete=1 WHERE id=?");
		$sql->bind_param("i", $_POST["id"]);
		$sql->execute();
		$sql->close();

		?>
		<div class="alert alert-success">Pickup complete!  Redirecting <a href="/home">home</a>...</div>
		<script> setTimeout('document.location = "/home";', 2000); </script>
		<?php

	} else if($role == "rider") {

		$sql = $db->prepare("INSERT INTO pickups (rider, complete, lat, lng) VALUES (?, 0, ?, ?)");
		$sql->bind_param("idd", $_SESSION["id"], $_POST["lat"], $_POST["lng"]);
		$sql->execute();
		$sql->close();

		?>
		<div class="alert alert-success">Pickup request received!  Redirecting <a href="/home">home</a>...</div>
		<script> setTimeout('document.location = "/home";', 2000); </script>
		<?php

	}

} else {

	if($role == "driver") {

		?>
		<form action="#" method="POST">
			<div id="map"></div>
		</form>
		<?php

	} else if($role == "rider") {

		?>
		<form action="#" method="POST" onsubmit="fillPickupForm();">
			<div id="map"></div>
			<input type="text" name="lat" id="lat" hidden="true" value="0" />
			<input type="text" name="lng" id="lng" hidden="true" value="0" />
		</form>
		<?php

	} else {

		?>
		<div id="map"></div>
		<?php

	}

	?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxIwFQA0mojqxv2Cf_n1inoXzq6tBfrJ8&callback=initMap" async defer></script>
	<?php

	if($role == "driver") {
		?>
		<script>setInterval('postLatLng();', 2000);</script>
		<script>setInterval('updatePickups();', 2000);</script>
		<?php
	} else if($role == "rider") {
		?>
		<script>initPickupMarker();</script>
		<script>setInterval('updateDrivers();', 2000);</script>
		<?php
	} else if($role == "guest") {
		?>
		<script>setInterval('updateDrivers();', 2000);</script>
		<?php
	}

}

?>