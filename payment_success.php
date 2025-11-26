<?php
include 'includes/db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_id = $_POST['service_id'];

    // Mark payment as successful in database
    $update_query = "UPDATE service_request SET payment_status='Paid' WHERE service_id='$service_id'";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<h2 style='color: green;'>Payment successful! Your service is now marked as Paid.</h2>";
    } else {
        echo "<h2 style='color: red;'>Payment failed: " . mysqli_error($conn) . "</h2>";
    }

    mysqli_close($conn);
}
?>
