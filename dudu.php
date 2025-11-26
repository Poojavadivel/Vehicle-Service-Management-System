<?php
$entered_password = "admin123"; // Enter the password you are testing
$stored_hash = '$2y$10$5WjYtsh5u2Yy3LgNOuhzSO5B9xOqY6FQHePAV8aVbDxPZSoHYpo.y'; // Your stored hash

if (password_verify($entered_password, $stored_hash)) {
    echo "Password match!";
} else {
    echo "Password does not match!";
}
?>