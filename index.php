<?php

define('IN_MAIN', true);

include("config.php");

$db = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_db);
if(mysqli_connect_errno())
	die("Database Error");

session_start();

if(!isset($_SESSION["id"])) {

	$role = "guest";

} else {

	$sql = $db->prepare("SELECT role FROM users WHERE id=?");
	$sql->bind_param("i", $_SESSION["id"]);
	$sql->execute();
	$sql->bind_result($role);
	$sql->fetch();
	$sql->close();

	$sql = $db->prepare("UPDATE users SET last_active=NOW() WHERE id=?");
	$sql->bind_param("i", $_SESSION["id"]);
	$sql->execute();
	$sql->close();

}

switch($role) {
	case "guest":
		$menu = array("home", "register", "login", "about"); break;
	case "rider":
		$menu = array("home", "logout", "about"); break;
	case "driver":
		$menu = array("home", "logout", "about"); break;
	default:
		$menu = array("home", "register", "login", "about");
}

if(!isset($_GET["page"])) {
	$page = "home";
} else {
	$page = preg_replace("/[^a-zA-Z0-9_\-]/", "", $_GET["page"]);
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Trojan Transit">
	<meta name="author" content="Andrew Kramer">

	<title>Trojan Transit</title>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/geo.js"></script>
	<link rel="stylesheet" href="css/main.css">

</head>

<body>

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Trojan Transit</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<?php foreach($menu as $item) { ?>
					<li><a href="/<?php echo $item; ?>"><?php echo ucfirst($item); ?></a></li>
					<?php }	?>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="main">
			<?php include("includes/" . $page . ".php"); ?>
		</div>
	</div>

</body>

</html>