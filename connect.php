

<!-- $servername = "MAHIMNA_MEHTA";
$username = "root";
$password = "";
$dbname = "quiz_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} -->



<?php
$servername = "localhost";
$dbname = "quiz_db";

$conn = new mysqli($servername, NULL, NULL, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>