<?php

if(!defined("IN_API"))
	die("Access Denied");

$drivers = array();

$sql = $db->prepare("SELECT id, first, last, phone, lat, lng FROM users WHERE role='driver' and (now() - interval 5 minute) < last_active");
$sql->execute();
$sql->bind_result($id, $first, $last, $phone, $lat, $lng);
while($sql->fetch()) {
	$drivers[] = array(
		"id" => $id,
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