<?php
include 'includes/db_connect.php';

if (!isset($_GET['service_id'])) {
    die("Error: Service ID is missing.");
}

$service_id = $_GET['service_id'];

$sql = "UPDATE service_request SET payment_status = 'Paid' WHERE service_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $service_id);

if ($stmt->execute()) {
    echo "<h3>Payment Successful!</h3>";
    echo "<script>setTimeout(() => { window.location.href = 'check_status.php'; }, 3000);</script>";
} else {
    echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
}
?>