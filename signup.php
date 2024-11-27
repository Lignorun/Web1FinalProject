<?php
// Start session at the top of the file to ensure session variables are accessible
session_start();

// Include connection and function files
require_once("connect.php");
require_once("function.php");

if (isset($_POST['signup'])) {
    // Sanitize and validate user input
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $inputpassword = mysqli_real_escape_string($conn, trim($_POST['password']));

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['msg'] = "Invalid email format";
        $_SESSION['class'] = "text-bg-danger";
        header("Location: signup.php");
        exit();
    }

    // Password hashing using password_hash (much more secure than md5)
    $password = password_hash($inputpassword, PASSWORD_DEFAULT);

    // Prepared statement to prevent SQL injection
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // Check if statement is prepared successfully
    if ($stmt === false) {
        die("Error in statement preparation: " . mysqli_error($conn));
    }

    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $password);

    // Execute the query and check for success
    if (mysqli_stmt_execute($stmt)) {
        // On successful signup, set a session message
        $_SESSION['msg'] = "You have Signed Up Successfully";
        $_SESSION['class'] = "text-bg-success";
        header("Location: index.php"); // Redirect to login page or dashboard
        exit();
    } else {
        // If there's an error, set the error session message
        $_SESSION['msg'] = "Sign Up failed. Please try again.";
        $_SESSION['class'] = "text-bg-danger";
        header("Location: signup.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz SignUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section class="main-section">
        <div class="container">
            <div class="row justify-content-center align-items-center" style="height:100vh;">
                <div class="col-md-7 col-lg-4">
                    <div class="box rounded">
                        <div class="img-2"></div>
                        <div class="login-box p-5">
                            <h2 class="pb-4">Sign Up</h2>

                            <?php
                            // Display success or error message
                            if (isset($_SESSION['msg'])) {
                                echo '<div class="alert ' . $_SESSION['class'] . '">' . $_SESSION['msg'] . '</div>';
                                unset($_SESSION['msg']);
                                unset($_SESSION['class']);
                            }
                            ?>

                            <form action="" method="post">
                                <div class="mb-4">
                                    <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
                                </div>
                                <div class="mb-4">
                                    <input type="email" class="form-control" placeholder="Enter Email address" name="email" required>
                                </div>
                                <div class="mb-4">
                                    <input type="password" class="form-control" placeholder="Enter Password" name="password" required>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary-1" name="signup">Sign Up</button>
                                </div>
                            </form>

                            <div class="py-4 text-center">
                                <a href="index.php" class="link">Login</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
