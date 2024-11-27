<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect if not logged in
    exit();
}

$user_id = $_SESSION['user_id'];
$lives = 6;
$level = 1;

// Generate random numbers/letters for each level
function generate_numbers() {
    $numbers = [];
    while (count($numbers) < 6) {
        $num = rand(0, 100);
        if (!in_array($num, $numbers)) {
            $numbers[] = $num;
        }
    }
    return $numbers;
}

function generate_letters() {
    $letters = [];
    while (count($letters) < 6) {
        $letter = chr(rand(65, 90)); // Uppercase letters (A-Z)
        if (!in_array($letter, $letters)) {
            $letters[] = $letter;
        }
    }
    return $letters;
}

$numbers = generate_numbers();
$letters = generate_letters();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_input = array_map('trim', $_POST['input']);
    
    // Validate the user's input and game logic
    if ($level == 1) {
        // Level 1: Order letters in ascending order
        $correct = $letters;
        sort($correct);
        
        if ($user_input == $correct) {
            echo "Correct! Move to next level.";
            $level++;
        } else {
            echo "Incorrect! Try again.";
            $lives--;
        }
    }
    // Add logic for other levels (level 2 to 6) here...
    
    if ($lives <= 0) {
        echo "Game Over!";
        // Save the result to the database
        $conn = new mysqli('localhost', 'root', '', 'quiz_db');
        $stmt = $conn->prepare("INSERT INTO game_results (user_id, result, lives_used) VALUES (?, 'game over', ?)");
        $stmt->bind_param('ii', $user_id, 6 - $lives);
        $stmt->execute();
    }
}
?>

<h1>Level <?php echo $level; ?> - Game</h1>

<!-- Dynamic Form Generation for Level -->
<form method="POST">
    <?php if ($level == 1): ?>
        <h3>Order these letters in ascending order:</h3>
        <?php foreach ($letters as $letter): ?>
            <input type="text" name="input[]" value="" maxlength="1" required>
        <?php endforeach; ?>
    <?php endif; ?>

<?php if ($_SESSION['level'] == 2): ?>
    <h3>Level 2: Order these letters in descending order</h3>
    <form method="POST">
        <?php foreach ($letters as $letter): ?>
            <input type="text" name="input[]" value="" maxlength="1" required>
        <?php endforeach; ?>
        <button type="submit">Submit</button>
    </form>
<?php endif; ?>

<?php if ($_SESSION['level'] == 3): ?>
    <h3>Level 3: Order these numbers in ascending order</h3>
    <form method="POST">
        <?php foreach ($numbers as $number): ?>
            <input type="text" name="input[]" value="" maxlength="2" required>
        <?php endforeach; ?>
        <button type="submit">Submit</button>
    </form>
<?php endif; ?>

<?php if ($_SESSION['level'] == 4): ?>
    <h3>Level 4: Order these numbers in descending order</h3>
    <form method="POST">
        <?php foreach ($numbers as $number): ?>
            <input type="text" name="input[]" value="" maxlength="2" required>
        <?php endforeach; ?>
        <button type="submit">Submit</button>
    </form>
<?php endif; ?>

<?php if ($_SESSION['level'] == 5): ?>
    <h3>Level 5: Identify the smallest and largest letter</h3>
    <form method="POST">
        <label for="first_letter">Smallest letter: </label>
        <input type="text" name="first_letter" required>
        
        <label for="last_letter">Largest letter: </label>
        <input type="text" name="last_letter" required>
        
        <button type="submit">Submit</button>
    </form>
<?php endif; ?>

<?php if ($_SESSION['level'] == 6): ?>
    <h3>Level 6: Identify the smallest and largest number</h3>
    <form method="POST">
        <label for="smallest_number">Smallest number: </label>
        <input type="text" name="smallest_number" required>
        
        <label for="largest_number">Largest number: </label>
        <input type="text" name="largest_number" required>
        
        <button type="submit">Submit</button>
    </form>
<?php endif; ?>

    <button type="submit">Submit</button>
</form>

<p>Lives remaining: <?php echo $lives; ?></p>
