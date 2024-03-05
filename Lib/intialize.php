<?php
require_once('SQL/Function.php');
function redirect_to($location) {
    header("Location: " . $location);
    exit;
}
session_start(); //turn on session

function authenticated() {
    // Kiểm tra xem người dùng đã được xác thực chưa
    if (!isset($_SESSION['authenticated']) || !$_SESSION['authenticated']) {
        header("Location: index.php");
        exit; // Chắc chắn dừng việc thực hiện mã PHP sau khi chuyển hướng
    }
}
?>