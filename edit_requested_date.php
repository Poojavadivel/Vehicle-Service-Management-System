<?php
include 'includes/db_connect.php';

if (isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];

    // Fetch the current requested_date
    $query = "SELECT requested_date FROM service_request WHERE service_id = '$service_id'";
    $result = mysqli_query($conn, $query);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $current_date = $row['requested_date'];
    } else {
        echo "Service ID not found!";
        exit;
    }
} else {
    echo "No service ID provided!";
    exit;
}

// Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_date = $_POST['requested_date'];
    $update = "UPDATE service_request SET requested_date = '$new_date' WHERE service_id = '$service_id'";
    
    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Requested date updated successfully.'); window.location.href='check_status.php?customer_id={$_POST['customer_id']}';</script>";
        exit;
    } else {
        echo "Failed to update: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Requested Date</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            width: 50%;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
            text-align: center;
            border: 3px solid blue;
        }
        h2 {
            color: blue;
        }
        form {
            margin-top: 15px;
        }
        label {
            font-weight: bold;
        }
        input[type="date"] {
            padding: 8px;
            border: 1px solid blue;
            border-radius: 5px;
        }
        button {
            background-color: blue;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: darkblue;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Requested Date</h2>
    <form method="POST">
        <label>Requested Date:</label>
        <input type="date" name="requested_date" value="<?php echo $current_date; ?>" required>
        <input type="hidden" name="customer_id" value="<?php echo isset($_GET['customer_id']) ? $_GET['customer_id'] : ''; ?>">
        <br><br>
        <button type="submit">Update</button>
    </form>
</div>

</body>
</html>