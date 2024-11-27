

// Check if the user is logged in
if (!isset($_SESSION['login_active'])) {
    header("Location: index.php");
    exit();
}

// Initialize level and lives
$level = isset($_SESSION['level']) ? $_SESSION['level'] : 1; // Default to level 1
$lives = isset($_SESSION['lives']) ? $_SESSION['lives'] : 6; // Default to 6 lives

// Handle game logic when form is submitted
// Define the checkAnswersForLevel function
function checkAnswersForLevel($level, $answers) {
  global $conn; // Make sure $conn is accessible inside this function
  $correctAnswers = 0; // Counter for correct answers

  // Fetch the correct answers for the given level
  $sql = "SELECT * FROM questions WHERE level = ?"; // Assuming the `level` field exists in the `questions` table
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $level); // Bind level as an integer
  $stmt->execute();
  $result = $stmt->get_result();

  // Loop through each question and compare the user's answer with the correct answer
  while ($row = $result->fetch_assoc()) {
      // Assuming `answers` is an associative array with question ID as the key
      // and the user's answer as the value
      $question_id = $row['qid'];
      $correct_answer = $row['correct_answer']; // Assuming `correct_answer` is a column in `questions` table

      // Compare the user's answer with the correct answer
      if (isset($answers[$question_id]) && $answers[$question_id] == $correct_answer) {
          $correctAnswers++;
      }
  }

  // Return the number of correct answers
  return $correctAnswers;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section class="main-section">
        <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="dashboard.php">Quiz</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="game.php">Game</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a class="btn btn-danger" href="logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container">
            <h1>Level: <?php echo $level; ?> | Lives Remaining: <?php echo $lives; ?></h1>

            <form method="POST">
                <?php
                // Display different content based on the level
                if ($level == 1) {
                    echo '<h3>Level 1: Order these letters in ascending order:</h3>';
                    echo '<input type="text" name="answers[]" maxlength="1" required>';
                    echo '<input type="text" name="answers[]" maxlength="1" required>';
                    echo '<input type="text" name="answers[]" maxlength="1" required>';
                } elseif ($level == 2) {
                    echo '<h3>Level 2: Order these letters in descending order:</h3>';
                    echo '<input type="text" name="answers[]" maxlength="1" required>';
                    echo '<input type="text" name="answers[]" maxlength="1" required>';
                    echo '<input type="text" name="answers[]" maxlength="1" required>';
                } elseif ($level == 3) {
                    echo '<h3>Level 3: Order these numbers in ascending order:</h3>';
                    echo '<input type="number" name="answers[]" required>';
                    echo '<input type="number" name="answers[]" required>';
                    echo '<input type="number" name="answers[]" required>';
                } elseif ($level == 4) {
                    echo '<h3>Level 4: Solve the following equation:</h3>';
                    echo '<input type="number" name="answers[]" required>';
                } elseif ($level == 5) {
                    echo '<h3>Level 5: What is the capital of France?</h3>';
                    echo '<input type="text" name="answers[]" required>';
                } elseif ($level == 6) {
                    echo '<h3>Level 6: Final Challenge!</h3>';
                    echo '<input type="text" name="answers[]" required>';
                }
              
                ?>
                
                <button type="submit" class="btn btn-success">Submit Answers</button>
            </form>
        </div>

    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
