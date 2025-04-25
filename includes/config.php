<?php
// Database configuration
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "podplay_db";

// Create database connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Base URL
define('BASE_URL', 'http://localhost/podplay/');
?>
