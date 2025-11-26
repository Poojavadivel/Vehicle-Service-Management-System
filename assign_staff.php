<?php
include 'includes/db_connect.php'; 

if (!isset($_GET['service_id'])) {
    die("Service ID is required.");
}

$service_id = $_GET['service_id'];

// Fetch the assigned staff (if any)
$query = "SELECT sr.*, s.name AS staff_name FROM service_request sr 
          LEFT JOIN staff s ON sr.staff_id = s.staff_id 
          WHERE sr.service_id = '$service_id'";

$result = mysqli_query($conn, $query);
$service = mysqli_fetch_assoc($result);

if (!$service) {
    die("Service not found.");
}

// Fetch available staff for dropdown
$staff_query = "SELECT * FROM staff";
$staff_result = mysqli_query($conn, $staff_query);

// Handle staff assignment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];

    $update_query = "UPDATE service_request SET staff_id = '$staff_id' WHERE service_id = '$service_id'";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<p style='color: green;'>Staff assigned successfully!</p>";
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
    <title>Assign Staff</title>
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
        <h2>Assign Staff to Service ID: <?php echo $service_id; ?></h2>

        <?php if (!empty($service['staff_name'])) { ?>
            <p><strong>Assigned Staff:</strong> <?php echo $service['staff_name']; ?></p>
            <a href="admin_panel.php">Go Back</a>
        <?php } else { ?>
            <form method="POST">
                <label>Select Staff:</label>
                <select name="staff_id" required>
                    <option value="">-- Select Staff --</option>
                    <?php while ($staff = mysqli_fetch_assoc($staff_result)) { ?>
                        <option value="<?php echo $staff['staff_id']; ?>"><?php echo $staff['name']; ?></option>
                    <?php } ?>
                </select>
                <br><br>
                <button type="submit">Assign Staff</button>
            </form>
        <?php } ?>
    </div>

</body>
</html>