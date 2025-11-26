<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'includes/db_connect.php';

// Get service ID and amount from URL
$service_id = isset($_GET['service_id']) ? $_GET['service_id'] : '';
$amount_due = isset($_GET['amount_due']) ? $_GET['amount_due'] : '';

if (!$service_id || !$amount_due) {
    die("<h2 style='color: red;'>Invalid Payment Request.</h2>");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $payment_method = $_POST['payment_method'];

    // Redirect to respective payment page
    if ($payment_method == "UPI") {
        header("Location: upi_payment.php?service_id=$service_id&amount_due=$amount_due");
    } elseif ($payment_method == "Credit Card" || $payment_method == "Debit Card") {
        header("Location: card_payment.php?service_id=$service_id&amount_due=$amount_due&method=$payment_method");
    } elseif ($payment_method == "Net Banking") {
        header("Location: netbanking_payment.php?service_id=$service_id&amount_due=$amount_due");
    } else {
        echo "<h2 style='color: red;'>Invalid Payment Method Selected.</h2>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            padding: 20px;
        }
        .payment-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px gray;
            display: inline-block;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="payment-box">
        <h2>Payment for Service ID: <?php echo $service_id; ?></h2>
        <p>Amount Due: ₹<?php echo $amount_due; ?></p>

        <form method="POST">
            <label>Select Payment Method:</label><br>
            <input type="radio" name="payment_method" value="UPI" required> UPI<br>
            <input type="radio" name="payment_method" value="Credit Card" required> Credit Card<br>
            <input type="radio" name="payment_method" value="Debit Card" required> Debit Card<br>
            <input type="radio" name="payment_method" value="Net Banking" required> Net Banking<br><br>

            <button type="submit">Proceed to Payment</button>
        </form>
    </div>

</body>
</html>
