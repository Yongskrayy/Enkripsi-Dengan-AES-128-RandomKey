<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'taaes';

// Create connection
$connect = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";
?>