<?php
$service_id = isset($_GET['service_id']) ? $_GET['service_id'] : '';
$amount_due = isset($_GET['amount_due']) ? $_GET['amount_due'] : '';

if (!$service_id || !$amount_due) {
    die("Invalid Payment Request.");
}

// Example UPI ID (Replace with your actual UPI details)
$upi_id = "yourupi@bank";
$upi_link = "upi://pay?pa=$upi_id&pn=VehicleService&mc=&tid=&tr=&tn=ServicePayment&am=$amount_due&cu=INR";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPI Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        h2 {
            color: #333;
        }
        img {
            margin: 15px 0;
            border-radius: 8px;
        }
        p {
            font-size: 18px;
            color: #555;
        }
        form {
            margin-top: 20px;
        }
        input {
            width: 80%;
            padding: 10px;
            font-size: 16px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Scan this QR Code to Pay ₹<?php echo $amount_due; ?></h2>
        
        <img src="scanner_qr.jpg" alt="Scan to Pay" width="250" height="250">

        <p>UPI ID: <b><?php echo $upi_id; ?></b></p>
        <p>Once paid, enter the <b>Transaction ID</b> and click below:</p>

        <form action="payment_success.php" method="POST">
            <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">
            <label>Enter UPI Transaction ID:</label>
            <input type="text" name="transaction_id" required><br>

            <button type="submit">Confirm Payment</button>
        </form>
    </div>

</body>
</html>

