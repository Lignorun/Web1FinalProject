<?php
$servername = "localhost";   // MySQL server
$username = "root";          // MySQL username (default in XAMPP is root)
$password = "";              // MySQL password (default in XAMPP is empty)
$dbname = "game_db";       // Your database name

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
