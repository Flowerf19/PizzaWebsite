<?php
require_once('Lib/intialize.php');
// Unset all of the session variables
$_SESSION = [];
// Destroy the session
session_destroy();
// Redirect to the login page or any other desired page
header("Location: index.php");
exit;
?>
