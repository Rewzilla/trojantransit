<?php

if(!defined("IN_MAIN"))
	die("Access Denied");

session_destroy();

?>

<h1>Logout</h1>

<div class="alert alert-success">Logged out.  Redirecting <a href="/home">home</a>...</div>
<script> document.location = "/home"; </script>