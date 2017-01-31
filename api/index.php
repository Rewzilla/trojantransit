<?php

if(defined("IN_API"))
	die("Recursion Blocked");

define("IN_API", true);

include("../config.php");

$db = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_db);
if(mysqli_connect_errno())
	die("Database Error");

if(!isset($_GET["page"])) {
	$page = "404";
} else {
	$page = preg_replace("/[^a-zA-Z0-9_\-]/", "", $_GET["page"]);
}

include($page . ".php");

?>