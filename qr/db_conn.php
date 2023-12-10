<?php

$sname = "localhost";
$uname = "root";
$password = "arzelzolina10";

$db_name = "qrcodedb";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
	exit();
}
