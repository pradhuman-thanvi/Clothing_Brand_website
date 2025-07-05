<?php
$host = "sql200.infinityfree.com";
$user = "if0_39272233";
$pass = "WYi8QXtJ1hDdY1";
$dbname = "if0_39272233_thegirlyhouse"; // change to your actual DB name

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
