<?php

if(!defined("IN_API"))
	die("Access Denied");

$drivers = array();

$sql = $db->prepare("SELECT first, last, phone, lat, lng FROM users WHERE role='driver'");
$sql->execute();
$sql->bind_result($first, $last, $phone, $lat, $lng);
while($sql->fetch()) {
	$drivers[] = array(
		"first" => $first,
		"last" => $last,
		"phone" => $phone,
		"lat" => $lat,
		"lng" => $lng,
	);
}
$sql->close();

echo json_encode($drivers);

?>