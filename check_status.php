<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'includes/db_connect.php';

// Get customer_id from the form
$customer_id = isset($_GET['customer_id']) ? trim($_GET['customer_id']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Service Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid black;
        }
        th {
            background-color: green;
            color: white;
        }
        .pay-button {
            background-color: orange;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .pay-button:hover {
            background-color: darkorange;
        }
        .dashboard-btn {
            background-color: blue;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 5px;
            display: block;
            margin: 20px auto;
            width: fit-content;
        }
        .edit-link {
            color: blue;
            text-decoration: none;
        }
        .edit-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Check Your Service Status</h2>
<form method="GET" action="check_status.php">
    <label>Enter Customer ID:</label>
    <input type="text" name="customer_id" required>
    <button type="submit">Check Status</button>
</form>

<?php
if (!empty($customer_id)) {
    // Fetch service requests for the given customer ID
    $query = "SELECT * FROM service_request WHERE customer_id = '$customer_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("<h2 style='color: red;'>Query Failed: " . mysqli_error($conn) . "</h2>");
    }

    $num_rows = mysqli_num_rows($result);

    if ($num_rows == 0) {
        echo "<h2 style='color: red;'>No service records found for Customer ID: $customer_id</h2>";
    } else {
        echo "<h3>Searching for Customer ID: $customer_id</h3>";
        echo "<table>
                <tr>
                    <th>Service ID</th>
                    <th>Vehicle ID</th>
                    <th>Staff ID</th>
                    <th>Requested Date</th>
                    <th>Status</th>
                    <th>Amount Due</th>
                    <th>Payment Status</th>
                    <th>Service Type</th>
                    <th>Action</th>
                </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['service_id']}</td>
                    <td>{$row['vehicle_id']}</td>
                    <td>{$row['staff_id']}</td>
                    <td>
                        {$row['requested_date']}
                        <br>
                        <a href='edit_requested_date.php?service_id={$row['service_id']}' class='edit-link'>Edit</a>
                    </td>
                    <td>{$row['status']}</td>
                    <td>₹{$row['amount_due']}</td>
                    <td>{$row['payment_status']}</td>
                    <td>{$row['service_type']}</td>
                    <td>";
            if ($row['payment_status'] == 'Pending') {
                echo "<form action='payment.php' method='GET'>
                        <input type='hidden' name='service_id' value='{$row['service_id']}'>
                        <input type='hidden' name='amount_due' value='{$row['amount_due']}'>
                        <button type='submit' class='pay-button'>Pay Now</button>
                      </form>";
            } else {
                echo "<span style='color: green;'>Paid</span>";
            }
            echo "</td></tr>";
        }
        echo "</table>";
    }
}
?>

<!-- Centered "Back to Dashboard" Button -->
<a href="dashboard.html" class="dashboard-btn">Back to Dashboard</a>

</body>
</html>

<?php mysqli_close($conn); ?>
