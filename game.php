<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Level</title>
</head>
<body>
    <header>
        <h1>Game Level</h1>
    </header>    
    <main>
        <?php        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        require_once 'gameController.php';

        $level = isset($_GET['level']) ? (int)$_GET['level'] : 1;

        // Initialize lives if not already set
        if (!isset($_SESSION['lives'])) {
            $_SESSION['lives'] = 5;  // Set initial lives
        }

        echo "<p id='lives'>Lives remaining: " . $_SESSION['lives'] . "</p>";

        if ($_SESSION['lives'] <= 0) {
            echo "<p>Game Over! You have used all your lives.</p>";
        }

        // Game logic for different levels
        switch ($level) {
            case 1:
                $displayedLetters = generate_random_letters();
                $_SESSION['displayed_letters'] = $displayedLetters;
                echo '<form id="gameForm" action="gameController.php" method="post">';
                echo '<input type="hidden" name="level" value="1">';
                echo '<label for="letters">Order these letters in ascending order:</label><br>';
                foreach ($displayedLetters as $letter) {
                    echo "<span>$letter</span> ";
                }
                echo '<br>';
                for ($i = 0; $i < count($displayedLetters); $i++) {
                    echo '<input type="text" name="letters[]" required><br>';
                }
                echo '<button type="submit">Submit</button>';
                echo '</form>';
                
                break;
            case 2:
                $displayedLetters = generate_random_letters();
                $_SESSION['displayed_letters'] = $displayedLetters;
                echo '<form id="gameForm" action="gameController.php" method="post">';
                echo '<input type="hidden" name="level" value="2">';
                echo '<label for="letters">Order these letters in descending order:</label><br>';
                foreach ($displayedLetters as $letter) {
                    echo "<span>$letter</span> ";
                }
                echo '<br>';
                for ($i = 0; $i < count($displayedLetters); $i++) {
                    echo '<input type="text" name="letters[]" required><br>';
                }
                echo '<button type="submit">Submit</button>';
                echo '</form>';
                break;
            case 3:
                $displayedNumbers = generate_random_numbers();
                var_dump($_SESSION['displayed_numbers']);
                echo '<form id="gameForm" action="gameController.php" method="post">';
                 echo '<input type="hidden" name="level" value="3">';
                 echo '<label for="numbers">Order these numbers in ascending order:</label><br>';
                foreach ($_SESSION['displayed_numbers'] as $number) {
                    echo "<span>$number</span> ";
                }
                echo '<br>';
                for ($i = 0; $i < count($_SESSION['displayed_numbers']); $i++) {
                    echo '<input type="number" name="numbers[]" required><br>';
                }
                echo '<button type="submit">Submit</button>';
                echo '</form>';
                break;

            case 4:
                $displayedNumbers = generate_random_numbers();
                var_dump($_SESSION['displayed_numbers']);
                echo '<form id="gameForm" action="gameController.php" method="post">';
                echo '<input type="hidden" name="level" value="4">';
                echo '<label for="numbers">Order these numbers in descending order:</label><br>';
                // Display numbers to the user
                foreach ($_SESSION['displayed_numbers'] as $number) {
                    echo "<span>$number</span> ";
                }
                echo '<br>';
                // Input fields for user to enter their order
                for ($i = 0; $i < count($_SESSION['displayed_numbers']); $i++) {
                    echo '<input type="number" name="numbers[]" required><br>';
                }
                echo '<button type="submit">Submit</button>';
                echo '</form>';
                break;

            case 5:
                $displayedLetters = generate_random_letters();
                $_SESSION['displayed_letters'] = $displayedLetters;
                echo '<form id="gameForm" action="gameController.php" method="post">';
                echo '<input type="hidden" name="level" value="5">';
                echo '<label for="first_letter">Identify the first (smallest) and last (largest) letter:</label><br>';
                // Display the random letters
                foreach ($_SESSION['displayed_letters'] as $letter) {
                    echo "<span>$letter</span> ";
                }
                echo '<br>';
                echo '<input type="text" name="first_letter" placeholder="Smallest letter" required>';
                echo '<input type="text" name="last_letter" placeholder="Largest letter" required><br>';
                echo '<button type="submit">Submit</button>';
                echo '</form>';
                break;
            case 6:
                $displayedNumbers = generate_random_numbers();
                $_SESSION['displayed_numbers'] = $displayedNumbers;
                echo '<form id="gameForm" action="gameController.php" method="post">';
                echo '<input type="hidden" name="level" value="6">';
                echo '<label for="numbers">Identify the smallest and largest numbers:</label><br>';
                foreach ($displayedNumbers as $number) {
                    echo "<span>$number</span> ";
                }
                echo '<br>';
                echo '<input type="text" name="smallest_number" required>';
                echo '<input type="text" name="largest_number" required><br>';
                echo '<button type="submit">Submit</button>';
                echo '</form>';
                break;
            default:
                echo 'Invalid game level.';
                break;
        }
        ?>
    </main>

    <script>
   document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('gameForm');
    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission behavior

            const formData = new FormData(form); // Gather form data

            // Perform the fetch request to send the form data
            fetch('gameController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log("Response status:", response.status);  // Log the response status
                if (!response.ok) { // Check if the response is successful
                    throw new Error('Network response was not ok');
                }
                return response.text(); // Read as text first to inspect raw response
            })
            .then(text => {
                console.log("Response text:", text); // Log the raw response text
                try {
                    const data = JSON.parse(text); // Parse the response as JSON manually
                    alert(data.message); // Display the response message

                    // Handle game progress
                    if (data.next_level) {
                        // Move to the next level if provided
                        window.location.href = `game.php?level=${data.next_level}`;
                    } else if (data.lives !== undefined) {
                        // Update lives remaining if it's part of the response
                        document.getElementById('lives').innerText = `Lives remaining: ${data.lives}`;
                    } else if (data.game_over) {
                        // Show a restart button if game over
                        document.getElementById('restartButton').style.display = 'block';
                    }
                } catch (error) {
                    console.log("Response text:", text); // Check what is returned
                    alert("Failed to parse server response.");
                }
            })
            .catch(error => {
                console.error('Error:', error); // Catch network or other errors
                alert("There was an error with your request. Please try again.");
            });
        });
    } else {
        console.error("Form with id 'gameForm' not found.");
    }
});

    </script>
</body>
</html>
