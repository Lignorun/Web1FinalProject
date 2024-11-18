<?php
session_start();

// Start a new game or continue existing game
if (!isset($_SESSION['level'])) {
    $_SESSION['level'] = 1;
    $_SESSION['lives'] = 6;
}

// Generate random numbers or letters
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

function generate_letters($case = 'upper') {
    $letters = [];
    while (count($letters) < 6) {
        $letter = ($case == 'upper') ? chr(rand(65, 90)) : chr(rand(97, 122)); // Upper or lowercase
        if (!in_array($letter, $letters)) {
            $letters[] = $letter;
        }
    }
    return $letters;
}

// Determine the numbers or letters to display based on the level
if ($_SESSION['level'] == 1 || $_SESSION['level'] == 2) {
    $letters = generate_letters('upper');  // Letters for level 1 and 2 (uppercase)
} else if ($_SESSION['level'] == 3 || $_SESSION['level'] == 4) {
    $numbers = generate_numbers();  // Numbers for level 3 and 4
} else if ($_SESSION['level'] == 5 || $_SESSION['level'] == 6) {
    $letters = generate_letters('lower');  // Letters for level 5 and 6 (lowercase)
}
?>
