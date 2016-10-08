<?php

require("constants.php");

set_globals();

function db_connect() {
    $dsn = "mysql:host=" . $GLOBALS["MYSQL_HOSTNAME"] . ";dbname=" . $GLOBALS["MYSQL_DBNAME"] . ";charset=utf8";
    $opts = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_ERRMODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $conn = new PDO($dsn, $GLOBALS["MYSQL_PASSWORD"], $GLOBALS["MYSQL_PASSWORD"], $opts);
    return $conn;
}
function db_query($conn, $query, $values = array()) {
    if (isset($values)) {
        $stmt = $conn->prepare($query);
        $stmt->execute($values);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    else {
        $stmt = $conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
