<?php

    require(dirname(__FILE__) . "/../includes/functions.php");

    $conn = dbConnect_new();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

	    if(!isset($_POST["passwd"]) || !isset($_POST["confirm"]) || !isset($_POST["logname"]))
		internalErrorRedirect("/register.php");

            $passwd = $name = $confirm = "";
	    $schaf = 0;

            $passwd = $_POST["passwd"];
            $confirm = $_POST["confirm"];
            $logname = $_POST["logname"];

            if (sempty($passwd) || sempty($logname) || sempty($confirm) || $confirm !== $passwd)
                internalErrorRedirect("/register.php");
            else {

		$previous = dbQuery_new($conn, "SELECT * FROM users WHERE username = :username;",
                                ["username" => $logname]);
	        if(!empty($previous)) {
        	        popupAlert("Whoops! A user with the same username already exists");
                	redirectTo("/register.php");
 		}


                $result = dbQuery_new($conn, "INSERT INTO users SET
                                      username=:name,
                                      password=:ph", [
                                              "name" => $logname,
                                              "ph" => password_hash($passwd, PASSWORD_DEFAULT),
					]

                );

                popupAlert("Success! You can now log in");
                redirectTo("/login.php");

	    }

    }

    render("register_form.php", ["fullname" => getFullName($conn)]);
?>

