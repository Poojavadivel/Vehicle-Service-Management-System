
<?php
include 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "INSERT INTO customer (first_name, last_name, email, phone_number) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $_POST["first_name"], $_POST["last_name"], $_POST["email"], $_POST["phone_number"]);

    if ($stmt->execute()) {
        $customer_id = $stmt->insert_id; // ✅ Ensure we get the inserted customer ID

        echo "
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Registration Success</title>
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    background: linear-gradient(to right, #f8f9fa, #e3f2fd);
                    font-family: Arial, sans-serif;
                    text-align: center;
                }
                .message-box {
                    background: white;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                }
                h3 {
                    font-size: 24px;
                    color: #28a745;
                }
                p {
                    font-size: 18px;
                    font-weight: bold;
                    color: #333;
                }
            </style>
        </head>
        <body>
            <div class='message-box'>
                <h3>Customer Registered Successfully!</h3>
                <p>Your Customer ID: <strong>$customer_id</strong></p>  <!-- ✅ Display Customer ID -->
                <p>Redirecting to vehicle registration...</p>
            </div>
            <script>
                setTimeout(function() {
                    window.location.href = 'add_vehicle.php?customer_id=$customer_id';
                }, 3000);
            </script>
        </body>
        </html>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}
?>
