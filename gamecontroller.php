<?php
// Ensure the session is started once
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to generate random letters
function generate_random_letters($count = 6) {
    $letters = range('A', 'Z');
    shuffle($letters);
    return array_slice($letters, 0, $count);
}

// Function to generate random numbers
function generate_random_numbers() {
    return [rand(1, 100), rand(1, 100), rand(1, 100), rand(1, 100), rand(1, 100), rand(1, 100)];
}

if (!isset($_SESSION['displayed_numbers'])) {
    $_SESSION['displayed_numbers'] = generate_random_numbers();
}

if (!isset($_SESSION['displayed_letters'])) {
    $_SESSION['displayed_letters'] = generate_random_letters(); // Ensure this function is defined
}

// Initialize lives and game state if not already set
if (!isset($_SESSION['lives'])) {
    $_SESSION['lives'] = 6;
}

if (!isset($_SESSION['level'])) {
    $_SESSION['level'] = 1;  // Start at level 1
}

$lives = $_SESSION['lives'];
$level = $_SESSION['level'];
$response = ['message' => '', 'next_level' => null, 'lives' => $lives, 'game_over' => false];

// Handle game logic based on the level
switch ($level) {
    case 1:
        // Level 1: Ordering letters in ascending order
        // Ensure that the session variable is set and is an array
if (!isset($_SESSION['displayed_letters']) || !is_array($_SESSION['displayed_letters'])) {
    $_SESSION['displayed_letters'] = generate_random_letters();  // Initialize it with random letters
}

$correct_order = $_SESSION['displayed_letters'];
sort($correct_order);  // Now sort the array

        $user_order = isset($_POST['letters']) ? $_POST['letters'] : [];
        if ($user_order == $correct_order) {
            $response['message'] = 'Correct! Proceed to next level.';
            $_SESSION['level'] = $level + 1;  // Move to next level
            $response['next_level'] = $level + 1;
        } else {
            $_SESSION['lives']--;
            $response['message'] = 'Incorrect order. Try again.';
            if ($_SESSION['lives'] <= 0) {
                $response['message'] = 'Game Over! You have no lives left.';
                $response['game_over'] = true;
            }
        }
        break;

    case 2:
        // Level 2: Ordering letters in descending order
        $correct_order = $_SESSION['displayed_letters'];
        rsort($correct_order);
        $user_order = isset($_POST['letters']) ? $_POST['letters'] : [];
        if ($user_order == $correct_order) {
            $response['message'] = 'Correct! Proceed to next level.';
            $_SESSION['level'] = $level + 1;  // Move to next level
            $response['next_level'] = $level + 1;
        } else {
            $_SESSION['lives']--;
            $response['message'] = 'Incorrect order. Try again.';
            if ($_SESSION['lives'] <= 0) {
                $response['message'] = 'Game Over! You have no lives left.';
                $response['game_over'] = true;
            }
        }
        break;

    case 3:
        // Level 3: Ordering numbers in ascending order
        if (!isset($_SESSION['displayed_numbers'])) {
            $_SESSION['displayed_numbers'] = generate_random_numbers();
        }

        $correct_order = $_SESSION['displayed_numbers'];  // The numbers to be sorted
        sort($correct_order);  // Sorting the correct order

        // Handling user input after form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_order = isset($_POST['numbers']) ? $_POST['numbers'] : [];

            // Check if the user order matches the correct order
            if ($user_order == $correct_order) {
                // Correct answer, move to the next level
                $response['message'] = 'Correct! Proceed to next level.';
                $_SESSION['level'] = $_SESSION['level'] + 1;  // Move to next level
                $response['next_level'] = $_SESSION['level'];
            } else {
                // Incorrect order, decrease lives
                $_SESSION['lives']--;
                $response['message'] = 'Incorrect order. Try again.';
                if ($_SESSION['lives'] <= 0) {
                    $response['message'] = 'Game Over! You have no lives left.';
                    $response['game_over'] = true;
                }
            }
        }

        break;

    case 4:
        // Level 4: Ordering numbers in descending order
        if (!isset($_SESSION['displayed_numbers'])) {
            $_SESSION['displayed_numbers'] = generate_random_numbers();
        }
        $correct_order = $_SESSION['displayed_numbers'];
        rsort($correct_order);
        $user_order = isset($_POST['numbers']) ? $_POST['numbers'] : [];
        if ($user_order == $correct_order) {
            $response['message'] = 'Correct! Proceed to next level.';
            $_SESSION['level'] = $level + 1;  // Move to next level
            $response['next_level'] = $level + 1;
        } else {
            $_SESSION['lives']--;
            $response['message'] = 'Incorrect order. Try again.';
            if ($_SESSION['lives'] <= 0) {
                $response['message'] = 'Game Over! You have no lives left.';
                $response['game_over'] = true;
            }
        }
        break;

    case 5:
        // Level 5: Identifying the smallest and largest letters
        $sorted_letters = $_SESSION['displayed_letters'];
        $correct_first = strtoupper($sorted_letters[0]); // Smallest letter
        $correct_last = strtoupper($sorted_letters[count($sorted_letters) - 1]);
        $user_first = isset($_POST['first_letter']) ? strtoupper($_POST['first_letter']) : '';
        $user_last = isset($_POST['last_letter']) ? strtoupper($_POST['last_letter']) : '';
        
        if ($user_first == $correct_first && $user_last == $correct_last) {
            $response['message'] = 'Correct! Proceed to next level.';
            $_SESSION['level'] = $level + 1;  // Move to next level
            $response['next_level'] = $level + 1;
        } else {
            $_SESSION['lives']++;
            $response['message'] = 'Incorrect answer. Try again.';
            if ($_SESSION['lives'] <= 0) {
                $response['message'] = 'Game Over! You have no lives left.';
                $response['game_over'] = true;
            }
        }
        break;

    case 6:
        // Level 6: Identifying the smallest and largest numbers
        $correct_smallest = min($_SESSION['displayed_numbers']);
        $correct_largest = max($_SESSION['displayed_numbers']);
        $user_smallest = isset($_POST['smallest_number']) ? (int)$_POST['smallest_number'] : null;
        $user_largest = isset($_POST['largest_number']) ? (int)$_POST['largest_number'] : null;

        if ($user_smallest == $correct_smallest && $user_largest == $correct_largest) {
            $response['message'] = 'Correct! You have completed the game.';
            $_SESSION['level'] = $level + 1;  // Move to next level (game completion)
            $response['next_level'] = null;
        } else {
            $_SESSION['lives']--;
            $response['message'] = 'Incorrect answer. Try again.';
            if ($_SESSION['lives'] <= 0) {
                $response['message'] = 'Game Over! You have no lives left.';
                $response['game_over'] = true;
            }
        }
        break;

    default:
        $response['message'] = 'Invalid level.';
        break;
    }

// Return the response as JSON
echo json_encode($response);
?>
