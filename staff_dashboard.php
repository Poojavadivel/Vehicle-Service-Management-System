<?php
include 'includes/db_connect.php';
session_start();

if (!isset($_SESSION['staff_id'])) {
    header("Location: staff_login.php");
    exit();
}

$staff_id = $_SESSION['staff_id'];
$sql = "SELECT * FROM service_request WHERE staff_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        /* Heading */
        h2 {
            color: #007bff;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Table Styling */
        table {
            width: 80%;
            border-collapse: collapse;
            background: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }

        td {
            background-color: #f9f9f9;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Select Dropdown */
        select {
            padding: 6px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Button Styling */
        button {
            padding: 8px 12px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 5px;
            transition: 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        /* Back Button */
        .back-button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        .back-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h2>Assigned Service Requests</h2>
    <table>
        <tr>
            <th>Service ID</th>
            <th>Vehicle ID</th>
            <th>Service Type</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['service_id']; ?></td>
                <td><?php echo $row['vehicle_id']; ?></td>
                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <form action="update_status.php" method="POST">
                        <input type="hidden" name="service_id" value="<?php echo $row['service_id']; ?>">
                        <select name="status">
                            <option value="Pending" <?php if ($row['status'] == "Pending") echo "selected"; ?>>Pending</option>
                            <option value="In Progress" <?php if ($row['status'] == "In Progress") echo "selected"; ?>>In Progress</option>
                            <option value="Completed" <?php if ($row['status'] == "Completed") echo "selected"; ?>>Completed</option>
                        </select>
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Back Button at the Bottom -->
    <button class="back-button" onclick="window.location.href='dashboard.html'">Back to Dashboard</button>

</body>
</html>
