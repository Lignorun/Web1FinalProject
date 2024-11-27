<?php

// Function to sanitize input data
function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $field = sanitize($_POST['field']);
    $value = sanitize($_POST['value']);

    switch ($field) {
        case "name":
            if (!preg_match("/^[a-zA-Z]/", $value)) {
                echo "Name must start with a letter a-z or A-Z.";
            }
            break;

        case "email":
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                echo "Please enter a valid email address.";
            }
            break;

        case "password":
            if (strlen($value) < 6) {
                echo "Password must be at least 6 characters long.";
            }
            break;

        default:
            echo "";
    }
}
?>
