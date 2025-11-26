<?php
include 'includes/db_connect.php';

if (!isset($_GET['customer_id'])) {
    die("Error: Customer ID is missing.");
}

$customer_id = $_GET['customer_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = $_POST["model"];
    $company_name = $_POST["company_name"];
    $vehicle_number = $_POST["vehicle_number"];
    $service_type = $_POST["service_type"];

    // Insert vehicle details into the 'vehicle' table
    $sql_vehicle = "INSERT INTO vehicle (customer_id, model, company_name, vehicle_number, service_type) VALUES (?, ?, ?, ?, ?)";
    $stmt_vehicle = $conn->prepare($sql_vehicle);
    $stmt_vehicle->bind_param("issss", $customer_id, $model, $company_name, $vehicle_number, $service_type);

    if ($stmt_vehicle->execute()) {
        $vehicle_id = $stmt_vehicle->insert_id;

        // Insert a service request into the 'service_request' table
        $sql_service = "INSERT INTO service_request (customer_id, vehicle_id, service_type, status, payment_status) 
                        VALUES (?, ?, ?, 'Pending', 'Not Paid')";
        $stmt_service = $conn->prepare($sql_service);
        $stmt_service->bind_param("iis", $customer_id, $vehicle_id, $service_type);
        $stmt_service->execute();

        echo "
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Vehicle Registered</title>
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
            </style>
        </head>
        <body>
            
            <script>
                setTimeout(function() {
                    window.location.href = 'view_services.php?customer_id=$customer_id&vehicle_id=$vehicle_id';
                }, 3000);
            </script>
        </body>
        </html>";
    } else {
        echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
    <style>
        /* Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Light Background */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #ffffff, #e3f2fd);
            color: #333;
        }

        /* Form Container */
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        /* Heading */
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
            color: #2c3e50;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 14px;
            text-align: left;
            font-weight: bold;
            margin-top: 10px;
        }

        input, select {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
        }

        input:focus, select:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
        }

        /* Submit Button */
        button {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px;
            margin-top: 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        button:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        /* Responsive for Mobile */
        @media (max-width: 600px) {
            .container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Vehicle Details</h2>
        <form method="POST">
            <label>Model:</label>
            <input type="text" name="model" required>
            
            <label>Company Name:</label>
            <input type="text" name="company_name" required>
            
            <label>Vehicle Number:</label>
            <input type="text" name="vehicle_number" required>
            
            <label>Select Service Type:</label>
            <select name="service_type" required>
                <option value="Oil Change">Oil Change</option>
                <option value="Brake Inspection">Brake Inspection</option>
                <option value="Tire Replacement">Tire Replacement</option>
                <option value="Battery Check">Battery Check</option>
                <option value="Engine Repair">Engine Repair</option>
                <option value="Car Wash">Car Wash</option>
                <option value="Clutch Repair">Clutch Repair</option>
                <option value="Exhaust System Repair">Exhaust System Repair</option>
                <option value="Transmission Service">Transmission Service</option>
                <option value="Fuel System Service">Fuel System Service</option>
                <option value="Suspension Repair">Suspension Repair</option>
                <option value="Wheel Alignment">Wheel Alignment</option>
                <option value="AC Repair">AC Repair</option>
                <option value="Radiator Service">Radiator Service</option>
                <option value="Horn Repair">Horn Repair</option>
                <option value="Coolant System Flush">Coolant System Flush</option>
                <option value="Steering Alignment">Steering Alignment</option>
                <option value="Spark Plug Replacement">Spark Plug Replacement</option>
                <option value="Electrical System Repair">Electrical System Repair</option>
                <option value="Complete Vehicle Inspection">Complete Vehicle Inspection</option>
            </select>
            
            <button type="submit">Add Vehicle</button>
        </form>
    </div>
</body>
</html>
