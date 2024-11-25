<?php
require_once("connect.php");
require_once("function.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login_active'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id']; // User ID from session
$level = 1; // Default to level 1, but this will be dynamic
$lives = 6; // Starting lives

// Get the current level from session
if (isset($_SESSION['level'])) {
    $level = $_SESSION['level']; // Set the level from session
} else {
    $_SESSION['level'] = 1; // Default to level 1
}

// Handle form submission for game logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the answers from the form submission
    $userAnswers = $_POST['answers']; // Answers submitted by the user
    
    // Check if answers are correct for the current level
    $correctAnswers = checkAnswersForLevel($level, $userAnswers);

    // Assuming at least 3 correct answers are required to pass the level
    if ($correctAnswers >= 3) {
        // If the user has passed the level, increment the level
        $_SESSION['level']++;

        // Store the result (for example in a results table)
        $stmt = $conn->prepare("INSERT INTO game_results (user_id, result, lives_used, level) VALUES (?, 'completed', ?, ?)");
        $stmt->bind_param('iii', $user_id, $lives, $level);
        $stmt->execute();

        // If the user completes level 6, the game ends
        if ($_SESSION['level'] > 6) {
            header("Location: game_over.php"); // Redirect to game over page
            exit();
        }

        // Redirect to the next level
        header("Location: level" . $_SESSION['level'] . ".php"); // Redirect dynamically to the next level
        exit();
    } else {
        // Incorrect answers, notify the user
        echo "You need more correct answers to move to the next level.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level <?php echo $level; ?> - Quiz Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <section class="main-section">
        <div class="container">
            <h1>Level: <?php echo $level; ?> | Lives Remaining: <?php echo $lives; ?></h1>

            <form method="POST">
                <?php
                // Display different content based on the level
                $sql = "SELECT * FROM questions WHERE level = $level";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $question_id = $row['qid'];
                        echo "<h3>" . $row['question'] . "</h3>";

                        // Fetch answers for the question
                        $sql_answers = "SELECT * FROM answers WHERE question_id = $question_id";
                        $result_answers = mysqli_query($conn, $sql_answers);

                        if (mysqli_num_rows($result_answers) > 0) {
                            while ($answer = mysqli_fetch_assoc($result_answers)) {
                                echo "<div class='form-check'>";
                                echo "<input type='radio' class='form-check-input' name='answers[$question_id]' value='" . $answer['aid'] . "'> " . $answer['answer'] . "<br>";
                                echo "</div>";
                            }
                        }
                    }
                } else {
                    echo "<p>No questions available for this level.</p>";
                }
                ?>

                <button type="submit" class="btn btn-success">Submit Answers</button>
            </form>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
