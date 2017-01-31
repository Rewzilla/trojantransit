
<?php

if(!defined("IN_MAIN"))
	die("Access Denied");

?>

<h1>Login</h1>

<?php

if(isset($_POST["submit"])) {

	$sql = $db->prepare("SELECT id FROM users WHERE username=? and password=?");
	$sql->bind_param("ss", $_POST["username"], hash("sha512", $_POST["password"]));
	$sql->execute();
	$sql->store_result();
	if($sql->num_rows > 0) {

		$sql->bind_result($id);
		$sql->fetch();
		$_SESSION["id"] = $id;
		?>
		<div class="alert alert-success">Login successful.  Redirecting <a href="/home">home</a>...</div>
		<script> document.location = "/home"; </script>
		<?php

	} else {

		?>
		<div class="alert alert-danger">Incorrect username or password</div>
		<?php

	}

}

?>

<form action="#" method="POST">
	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" class="form-control" required />
	</div>
	<div class="form-group">
		<label for="password">Password</label>
		<input type="password" name="password" id="password" class="form-control" required />
	</div>
	<button type="submit" name="submit">Login</button>
</form>

