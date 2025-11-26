<?php
$new_hashed_password = password_hash("admin123", PASSWORD_DEFAULT);
echo "New Hashed Password: " . $new_hashed_password;
?>