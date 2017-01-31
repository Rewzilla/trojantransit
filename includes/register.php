
<?php

if(!defined("IN_MAIN"))
	die("Access Denied");

?>

<h1>Register</h1>

<?php die("Registration is currently disabled"); ?>

<?php

if(isset($_POST["submit"])) {

	if(empty($_POST["first"]) || empty($_POST["last"]) || empty($_POST["phone"])
	|| empty($_POST["email"]) || empty($_POST["username"]) || empty($_POST["password"])
	|| empty($_POST["confirm"])) {

		?>
		<div class="alert alert-danger">One or more required fields was empty</div>
		<?php

	} elseif ($_POST["password"] != $_POST["confirm"]) {

		?>
		<div class="alert alert-danger">Passwords did not match</div>
		<?php

	} else {

		$email = preg_replace("/[^a-zA-Z0-9\-_\.@]/", "", $_POST["email"]);
		$username = preg_replace("/[^a-zA-Z0-9]/", "", $_POST["username"]);
		$password = hash("sha512", $_POST["password"]);
		$role = "rider";
		$active = 1;
		$first = preg_replace("/[^a-zA-Z0-9]/", "", $_POST["first"]);
		$last = preg_replace("/[^a-zA-Z0-9]/", "", $_POST["last"]);
		$phone = preg_replace("/[^a-zA-Z0-9\-\(\)]/", "", $_POST["phone"]);

		$sql = $db->prepare("INSERT INTO users (username, email, password, role, active, phone, first, last) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$sql->bind_param("ssssisss", $username, $email, $password, $role, $active, $phone, $first, $last);
		$sql->execute();
		$sql->close();

		?>
		<div class="alert alert-success">Your account has been registered. Please <a href="/login">login</a>.</div>
		<?php

	}

}

?>

<form action="#" method="POST">
		<div class="form-group">
			<label for="first">First name</label>
			<input type="text" name="first" class="form-control" id="first" pattern="[a-zA-Z\- ]+" required />
		</div>
		<div class="form-group">
			<label for="last">Last name</label>
			<input type="text" name="last" class="form-control" id="last" pattern="[a-zA-Z\- ]+" required />
		</div>
		<div class="form-group">
			<label for="phone">Phone</label>
			<input type="text" name="phone" class="form-control" id="phone" pattern"[0-9\-\(\) ]+" required />
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" name="email" class="form-control" id="email" pattern="[a-zA-Z0-9\-\._]+@(trojans\.|pluto\.)?dsu.edu" placeholder="(DSU email)" required />
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" name="username" class="form-control" id="username" pattern="[a-z0-9]+" placeholder="(DSU username)" required />
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" class="form-control" id="password" required />
		</div>
		<div class="form-group">
			<label for="confirm">Confirm</label>
			<input type="password" name="confirm" class="form-control" id="confirm" required />
		</div>
		<button name="submit" type="submit" class="btn btn-default">Register</button>
</form>
