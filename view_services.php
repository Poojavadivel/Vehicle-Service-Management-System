<?php
include 'includes/db_connect.php'; // Ensure this file is correctly included

// Get customer_id and vehicle_id from GET request
$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
$vehicle_id = isset($_GET['vehicle_id']) ? $_GET['vehicle_id'] : '';

if (!$customer_id || !$vehicle_id) {
    die("Customer ID and Vehicle ID are required.");
}

// Fetch service request details based on customer_id and vehicle_id
$query = "SELECT * FROM service_request WHERE customer_id = '$customer_id' AND vehicle_id = '$vehicle_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("<p style='color: red;'>Query Failed: " . mysqli_error($conn) . "</p>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Service Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px gray;
            display: inline-block;
            text-align: left;
        }
        h2 {
            color: #333;
        }
        p {
            font-size: 18px;
        }
        strong {
            color: #4CAF50;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .back-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Service Request Details</h2>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<p><strong>Service ID:</strong> {$row['service_id']}</p>";
                echo "<p><strong>Service Type:</strong> {$row['service_type']}</p>";
                echo "<p><strong>Status:</strong> {$row['status']}</p>";
                echo "<p><strong>Payment Status:</strong> {$row['payment_status']}</p>";
            }
        } else {
            echo "<p>No service requests found for this customer and vehicle.</p>";
        }

        // Close database connection
        mysqli_close($conn);
        ?>
        
        <a href="dashboard.html" class="back-button">Back to Dashboard</a>
    </div>
    <p>Remember the service Id to check the status</p>

</body>
</html>
