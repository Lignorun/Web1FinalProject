<?php
require_once("connect.php");
session_start();

// Check if login is being submitted
if (isset($_POST['login'])) {

    // Sanitize user input
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $inputpassword = mysqli_real_escape_string($conn, trim($_POST['password']));

    // Check if database connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // SQL query to check for user email
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        die("SQL query preparation failed: " . mysqli_error($conn));
    }

    // Bind parameters to the SQL query
    mysqli_stmt_bind_param($stmt, "s", $email);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the query was successful
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Verify the password using password_verify
        if (password_verify($inputpassword, $row['password'])) {
            // Set session variables for user info
            $_SESSION['user_id'] = $row["user_id"]; // Assuming user_id is in the database
            $_SESSION['username'] = $row["username"]; // Store username in session
            $_SESSION['login_active'] = true;  // Set login session to active
            $_SESSION['msg'] = "Welcome to Dashboard";
            $_SESSION['class'] = "text-bg-success";
            header("Location: dashboard.php");
            exit();
        } else {
            // Incorrect password
            $_SESSION['msg'] = "Incorrect password";
            $_SESSION['class'] = "text-bg-danger";
            header("Location: index.php");
            exit();
        }
    } else {
        // No account found with the provided email
        $_SESSION['msg'] = "No account found with this email";
        $_SESSION['class'] = "text-bg-danger";
        header("Location: index.php");
        exit();
    }
}
?>
