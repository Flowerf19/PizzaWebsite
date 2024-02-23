<?php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "pizzawebsite");

function db_connect() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    return $connection;
}

/******
 * Mở kết nối đến cơ sở dữ liệu
 */
$db = db_connect();

function db_disconnect($connection) {
    if (isset($connection)) {
        mysqli_close($connection);
    }
}

function confirm_query_result($result)
{
    global $db;
    if (!$result) {
        echo mysqli_error($db);
        db_disconnect($db);
        exit;
    } else {
        return $result;
    }
}
