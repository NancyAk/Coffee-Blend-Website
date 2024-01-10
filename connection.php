<?php
// Connect to the database
$host = "YourHost";
$username = "Yourusername";
$password = "YourPassword";
$database = "DatabaseName";

$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
