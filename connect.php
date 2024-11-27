<?php
$servername = "localhost";
$dbname = "quiz_db";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>


