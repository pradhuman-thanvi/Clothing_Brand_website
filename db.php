<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "thegirlyhouse"; // change to your actual DB name

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
