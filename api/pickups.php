<?php

if(!defined("IN_API"))
	die("Access Denied");

if($role != "driver")
	die("Access Denied");

$pickups = array();

$sql = $db->prepare("SELECT pickups.id, first, last, phone, pickups.lat, pickups.lng FROM pickups JOIN users ON pickups.rider=users.id");
$sql->execute();
$sql->bind_result($id, $first, $last, $phone, $lat, $lng);
while($sql->fetch()) {
	$pickups[] = array(
		"id" => $id,
		"first" => $first,
		"last" => $last,
		"phone" => $phone,
		"lat" => $lat,
		"lng" => $lng,
	);
}
$sql->close();

echo json_encode($pickups);

?>