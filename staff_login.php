<?php
include 'includes/db_connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST["staff_id"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM staff WHERE staff_id = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $staff_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['staff_id'] = $staff_id;
        header("Location: staff_dashboard.php");
        exit();
    } else {
        echo "<p style='color: red;'>Invalid Staff ID or Password.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(31, 25, 25); /* Light background */
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
         body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: url('stafffiamge.jpg') no-repeat center center fixed; /* Background image */
      background-size: cover; /* Ensures the image covers the entire screen */
      color:rgb(20, 2, 2);
    }

        /* Login Container */
        form {
            background:rgb(250, 243, 243);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(20, 17, 17, 0.1);
            width: 300px;
            text-align: center;
        }

        /* Headings */
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        /* Input Fields */
        input[type="text"], 
        input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Button */
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Error Message */
        p {
            text-align: center;
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div>
        <h2>Staff Login</h2>
        <form method="POST">
            <label>Staff ID:</label>
            <input type="text" name="staff_id" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

