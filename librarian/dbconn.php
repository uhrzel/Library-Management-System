<?php
session_start();
$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "arzelzolina10";
$database = "LMS";
// Create connection
$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $database);
// Check connection
if (!$conn) {
    echo "Connected unsuccessfully";
    die("Connection failed: " . mysqli_connect_error());
}
