<?php

if(!defined("IN_API"))
	die("Access Denied");

if($role != "driver")
	die("Access Denied");

if(!isset($_POST["lat"]) || !isset($_POST["lng"]))
	die("Empty Update");

$id = isset($_SESSION["id"]) ? $_SESSION["id"] : 1;
$sql = $db->prepare("UPDATE users SET lat=?, lng=? WHERE id=?");
$sql->bind_param("ddi", $_POST["lat"], $_POST["lng"], $id);
$sql->execute();
$sql->close();

?>