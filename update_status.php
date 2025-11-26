<?php
include 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_id = $_POST["service_id"];
    $status = $_POST["status"];

    $sql = "UPDATE service_request SET status = ? WHERE service_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $service_id);

    if ($stmt->execute()) {
        echo "<script>alert('Status Updated Successfully!'); window.location.href='staff_dashboard.php';</script>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}
?>