<?php

require(dirname(__FILE__) . "/../includes/functions.php");

$conn = dbConnect_new();

$error = 0;

if(empty(dbQuery_new($conn, "SELECT * FROM users;")))
	redirectTo("register.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST["login"])) {

		if(!isset($_POST["passwd"]) || !isset($_POST["logname"]))
			internalErrorRedirect("/login.php");
		elseif(sempty($_POST["passwd"]) || sempty($_POST["logname"]))
			$error = 1;
		else {
			$username = $_POST["logname"];
			$passwd = $_POST["passwd"];

			$result = dbQuery_new($conn, "SELECT UID, password FROM users WHERE username = :name", ["name" => $username]);

			if(empty($result)) {
				$error = 2;
				render("login_form.php", ["error" => $error, "fullname" => 0]);
				exit;
			}

			$row = $result[0];

			if(!password_verify($passwd, $row['password'])) {
				$error = 2;
				render("login_form.php", ["error" => $error, "fullname" => 0]);
				exit;
			}

			session_start();
			$_SESSION['UID'] = $row['UID'];
			$_SESSION['starttime'] = time();

			redirectTo("hack.php?CID=1");
		}
	}
}

render("login_form.php", ["error" => $error]);

?>

