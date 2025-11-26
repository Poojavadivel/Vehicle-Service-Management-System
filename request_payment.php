<?php
include 'includes/db_connect.php';

if (!isset($_GET['service_id'])) {
    die("Service ID is required.");
}

$service_id = $_GET['service_id'];

// Fetch service details
$query = "SELECT * FROM service_request WHERE service_id = '$service_id'";
$result = mysqli_query($conn, $query);
$service = mysqli_fetch_assoc($result);

if (!$service) {
    die("Service not found.");
}

// Handle payment request submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount_due = $_POST['amount_due'];

    $update_query = "UPDATE service_request SET amount_due = '$amount_due', payment_status = 'Pending' WHERE service_id = '$service_id'";

    if (mysqli_query($conn, $update_query)) {
        echo "<p style='color: green;'>Payment Requested Successfully!</p>";
        echo "<a href='admin_panel.php'>Go Back</a>";
        exit;
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Payment</title>
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
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Request Payment for Service ID: <?php echo $service_id; ?></h2>

        <form method="POST">
            <label>Enter Amount Due:</label>
            <input type="number" name="amount_due" required>
            <br><br>
            <button type="submit">Request Payment</button>
        </form>
    </div>

</body>
</html>