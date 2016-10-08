<?php

require("../includes/functions.php");

$conn = dbConnect_new();

if(isset($_POST["getMes"]) && isset($_POST["CID"]))
{
	echo(json_encode(getMessages($conn, $_POST["CID"])));
}
else if(isset($_POST["CID"]) && isset($_POST["UID"]) && isset($_POST["Mes"]) && !sempty($_POST["Mes"]))
{
	echo json_encode(sendMessage($conn, $_POST["CID"], $_POST["UID"], $_POST["Mes"]));
}

?>
