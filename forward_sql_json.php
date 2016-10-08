<?php

    require("functions.php");

    $uid = $_GET["uid"];

    $conn = db_connect();
    $result = db_query($conn, "SELECT * FROM users WHERE id = :uid", ["uid" => $uid]);

    $arr = [];
    foreach($result as $row) {
	$arr[] = $row;
    }

    $filename = 'user' . uniqid() . '.json';
    
    $fp = fopen('/var/www/public/' . $filename, 'w');
    fwrite($fp, json_encode($arr));
    fclose($fp);

    header('Location: /' . $filename);

?>
