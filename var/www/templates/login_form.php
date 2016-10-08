<!DOCTYPE html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="./styles/general.css">
<script src="./scripts/general.js"></script>

<head>

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login</title>

<style>

.form-control {
	max-width: 400px;
}

.inline_alert {
	margin-left: -5px;
}

.main {
	padding: 50px 60px;
}

.panel {
	max-width: 400px;
	margin: auto;
}

.panel-heading {
	margin-left: -15px;
	margin-right: -15px;
}

</style>

</head>


<body>
<div class="main">
	<div class="container-fluid panel panel-default">
		<div class="panel-heading">User Login</div>
		<div class="panel-body">
			<form id="input_form" action="" method="post">
				<div class="form-group">
					<label for="logname">Username</label>
        				<input type="text" class="form-control" id="logname" name="logname" placeholder="username" autofocus>
				</div>
				<div class="form-group">
					<label for="passwd">Password</label>
					<input type="password" class="form-control" name="passwd" id="passwd" placeholder="password">
				</div>
			</form>
			<div class="row inline_alert">
				<?php
				if($error) {
					if($error > 1)
						inlineAlert(0, 12, " Wrong email or password");
					else
						inlineAlert(0, 12, " Please enter an email and password");
				}
				?>
			</div>
		</div>
		<div class="panel-footer">
			<button type="submit" name="login" class="btn btn-primary text-center" form="input_form">Login</button>
		</div>
	</div>
</div>

</body>


</html>

