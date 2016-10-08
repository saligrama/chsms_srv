<?php

    require("config.php");

    $result = json_encode(dbQuery("SELECT * FROM users WHERE id = :uid", ["uid" => $uid]));

    $filename = 'user' . uniqid() . '.json';
    
    $fp = fopen($filename, 'w');
    fwrite($fp, $result);
    fclose();

    header('Location: /' . $filename);

?>
