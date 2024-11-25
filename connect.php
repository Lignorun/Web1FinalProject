<?php
$servername = "localhost";
$dbname = "game_db";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>