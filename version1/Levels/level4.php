<?php
require_once("connect.php");
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['login_active'])) {
    header("Location: index.php");
    exit();
}

// Set the current level (this should be set earlier in the game)
$level = isset($_SESSION['level']) ? $_SESSION['level'] : 4; // Default to level 4 if not set

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check the answer submitted for this level
    $userAnswer = isset($_POST['answer']) ? $_POST['answer'] : '';
    
    // Assume the correct answer for this level (You can dynamically pull it from the database)
    $correctAnswer = 15; // Example: The correct answer to the math equation "8 + 7"

    // Check if the user's answer is correct
    if ((int)$userAnswer === $correctAnswer) {
        // Correct answer, increment the level
        $_SESSION['level']++;
        $_SESSION['msg'] = "Correct! Moving to the next level.";
        $_SESSION['class'] = "bg-success"; // Success message class
    } else {
        // Incorrect answer
        $_SESSION['msg'] = "Incorrect answer. Please try again!";
        $_SESSION['class'] = "bg-danger"; // Error message class
    }

    // Redirect to reload the page
    header("Location: level4.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level 4 - Quiz Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section class="main-section">

        <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="dashboard.php">Quiz</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Level 4</a>
                        </li>
                    </ul>

                    <div class="d-flex">
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container">

            <!-- Display session message if exists -->
            <?php if (isset($_SESSION['msg'])): ?>
                <div class="toast-container position-fixed bottom-0 end-0 p-3">
                    <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header <?php echo $_SESSION['class']; ?>">
                            <strong class="me-auto">Message</strong>
                            <button type="button" class="btn-close text-white" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body">
                            <?php
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                            ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <h2 class="pt-4">Level 4: Solve the equation</h2>
                <p><strong>Question:</strong> What is 8 + 7?</p>

                <div class="col-md-6">
                    <div class="card my-4 p-3">
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label for="answer">Your Answer:</label>
                                    <input type="number" class="form-control" id="answer" name="answer" required>
                                </div>

                                <button type="submit" class="btn btn-success mt-3">Submit Answer</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
