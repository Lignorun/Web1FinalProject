<?php

function sanitize($input) {
  global $conn; // Assuming $conn is the connection object
  return mysqli_real_escape_string($conn, trim($input)); // Sanitizing input
}

