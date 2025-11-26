<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Service counts
$count_query = "SELECT 
    COUNT(*) AS total, 
    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) AS pending, 
    SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) AS completed,
    SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) AS in_progress
    FROM service_request";
$count_result = mysqli_query($conn, $count_query);
$counts = mysqli_fetch_assoc($count_result);

// Staff count and details
$staff_query = "SELECT * FROM staff";
$staff_result = mysqli_query($conn, $staff_query);
$staff_count = mysqli_num_rows($staff_result);
$staff_list = [];
while ($staff = mysqli_fetch_assoc($staff_result)) {
    $staff_list[] = $staff;
}

// Service request list
$query = "SELECT sr.*, s.name AS staff_name FROM service_request sr 
          LEFT JOIN staff s ON sr.staff_id = s.staff_id";
$result = mysqli_query($conn, $query);

// Staff dropdown options
$staff_options = "";
$staff_result2 = mysqli_query($conn, "SELECT * FROM staff");
while ($staff = mysqli_fetch_assoc($staff_result2)) {
    $staff_options .= "<option value='{$staff['staff_id']}'>{$staff['name']}</option>";
}

// Assign staff logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assign_staff'])) {
    $staff_id = $_POST['staff_id'];
    $service_id = $_POST['service_id'];

    $update_query = "UPDATE service_request SET staff_id = '$staff_id' WHERE service_id = '$service_id'";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Staff assigned successfully!'); window.location.href='admin_panel.php';</script>";
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Summary & Management</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%);
            background-attachment: fixed;
            padding: 20px;
            color: #333;
        }

        h2 {
            text-align: center;
            font-size: 32px;
            color: #2d3436;
            margin-bottom: 40px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            width: 230px;
            padding: 20px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            transition: transform 0.2s ease-in-out;
            text-align: center;
            border-left: 6px solid #6c5ce7;
        }

        .card:hover {
            animation: shake 0.4s;
            transform: translateY(-6px);
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }

        .card h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .card p {
            font-size: 20px;
            font-weight: bold;
            color: #6c5ce7;
        }

        .toggle-btn {
            background: #6c5ce7;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
            margin: 20px auto;
            display: block;
            transition: background 0.3s;
        }

        .toggle-btn:hover {
            background: #5a4cd9;
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        ul {
            padding-left: 20px;
        }

        ul li {
            margin: 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(255,255,255,0.85);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            font-size: 15px;
        }

        th {
            background: #6c5ce7;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        select, button {
            padding: 5px;
            border-radius: 5px;
        }

        .logout {
            margin-top: 30px;
            display: inline-block;
            padding: 10px 20px;
            background: #d63031;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            float: right;
            transition: 0.3s;
        }



        .logout:hover {
            background: #c0392b;
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        #detailsTable {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
</head>
<body>

<h2>🌟 Admin Dashboard</h2>

<div class="card-container">
    <div class="card"><h3>📋 Total Service Requests</h3><p><?php echo $counts['total']; ?></p></div>
    <div class="card"><h3>⏳ Pending Services</h3><p><?php echo $counts['pending']; ?></p></div>
    <div class="card"><h3>✅ Completed Services</h3><p><?php echo $counts['completed']; ?></p></div>
    <div class="card"><h3>🔧 In Progress</h3><p><?php echo $counts['in_progress']; ?></p></div>
    <div class="card"><h3>👨‍🔧 Total Staff</h3><p><?php echo $staff_count; ?></p></div>
</div>

<div class="glass-box">
    <h3>👥 Staff Details</h3>
    <ul>
        <?php foreach ($staff_list as $staff): ?>
            <li><strong><?php echo $staff['name']; ?></strong> – <?php echo $staff['position']; ?> (<?php echo $staff['expertise']; ?>)</li>
        <?php endforeach; ?>
    </ul>
</div>

<button class="toggle-btn" onclick="toggleDetails()">📂 Show/Hide Full Service Details</button>

<div id="detailsTable" style="display: none;">
    <table>
        <tr>
            <th>Service ID</th>
            <th>Customer ID</th>
            <th>Vehicle ID</th>
            <th>Service Type</th>
            <th>Status</th>
            <th>Payment Status</th>
            <th>Assigned Staff</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['service_id']; ?></td>
                <td><?php echo $row['customer_id']; ?></td>
                <td><?php echo $row['vehicle_id']; ?></td>
                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['payment_status']; ?></td>
                <td>
                    <?php if (!empty($row['staff_name'])): ?>
                        <?php echo $row['staff_name']; ?>
                    <?php else: ?>
                        <form method="POST">
                            <input type="hidden" name="service_id" value="<?php echo $row['service_id']; ?>">
                            <select name="staff_id" required>
                                <option value="">Assign Staff</option>
                                <?php echo $staff_options; ?>
                            </select>
                            <button type="submit" name="assign_staff">Assign</button>
                        </form>
                    <?php endif; ?>
                </td>
                <td><a href="request_payment.php?service_id=<?php echo $row['service_id']; ?>">Request Payment</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<a href="logout.php" class="logout">Logout</a>

<script>
function toggleDetails() {
    var table = document.getElementById("detailsTable");
    table.style.display = (table.style.display === "none") ? "block" : "none";
}
</script>
<a href="dashboard.html" class="back-btn">← Back to Dashboard</a>

</body>
</html>


