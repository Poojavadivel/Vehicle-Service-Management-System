<?php
$service_id = isset($_GET['service_id']) ? $_GET['service_id'] : '';
$amount_due = isset($_GET['amount_due']) ? $_GET['amount_due'] : '';

if (!$service_id || !$amount_due) {
    die("Invalid Payment Request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Net Banking Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }
        h2 {
            color: #333;
        }
        label {
            display: block;
            font-weight: bold;
            margin: 10px 0 5px;
            text-align: left;
        }
        select, input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Select Your Bank to Pay ₹<?php echo $amount_due; ?></h2>
        <form action="payment_success.php" method="POST">
            <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">
            
            <label>Select Bank:</label>
            <select name="bank" required>
                <option value="SBI">State Bank of India</option>
                <option value="HDFC">HDFC Bank</option>
                <option value="ICICI">ICICI Bank</option>
                <option value="Axis">Axis Bank</option>
            </select>

            <label>User ID:</label>
            <input type="text" name="user_id" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login and Pay</button>
        </form>
    </div>

</body>
</html>
