
<?php

if(!defined("IN_MAIN"))
	die("Access Denied");

if(!isset($_SESSION["id"]))
	die("Access Denied");

?>

<h1>Ride</h1>

<?php

if(isset($_POST["submit"])) {

	$complete = 0;
	$sql = $db->prepare("INSERT INTO pickups (rider, complete, lat, lng) VALUES (?, ?, ?, ?)");
	$sql->bind_param("iidd", $_SESSION["id"], $complete, $_POST["lat"], $_POST["lng"]);
	$sql->execute();
	$sql->close();

	?>
	<div class="alert alert-success">Pickup request received!  Redirecting <a href="/home">home</a>...</div>
	<script> setTimeout('document.location = "/home";', 2000); </script>
	<?php

} else {

	?>
	<form action="#" method="POST" onsubmit="fillPickupForm();">
		<div id="map"></div>
		<input type="text" name="lat" id="lat" hidden="true" value="0" />
		<input type="text" name="lng" id="lng" hidden="true" value="0" />
	</form>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxIwFQA0mojqxv2Cf_n1inoXzq6tBfrJ8&callback=initMap" async defer></script>
	<script>initPickupMarker();</script>
	<?php

}

?>