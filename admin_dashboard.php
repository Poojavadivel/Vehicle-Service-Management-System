<?php
include 'includes/db_connect.php';

$sql = "SELECT sr.service_id, sr.vehicle_id, sr.customer_id, sr.service_type, sr.status, 
               sr.payment_status, sr.amount_due, s.name AS staff_name 
        FROM service_request sr 
        LEFT JOIN staff s ON sr.staff_id = s.staff_id 
        ORDER BY sr.requested_date DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Service ID</th><th>Vehicle ID</th><th>Customer ID</th><th>Service Type</th>
              <th>Status</th><th>Assigned Staff</th><th>Payment Status</th><th>Actions</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['service_id'] . "</td>";
        echo "<td>" . $row['vehicle_id'] . "</td>";
        echo "<td>" . $row['customer_id'] . "</td>";
        echo "<td>" . $row['service_type'] . "</td>";
        echo "<td>" . $row['status'] . "</td>";
        echo "<td>" . ($row['staff_name'] ? $row['staff_name'] : "Not Assigned") . "</td>";
        echo "<td>" . $row['payment_status'] . "</td>";

        echo "<td>";
        if ($row['status'] == 'Pending') {
            echo "<a href='assign_staff.php?service_id=" . $row['service_id'] . "'>Assign Staff</a> | ";
        }
        if ($row['status'] == 'Completed' && $row['payment_status'] == 'Not Paid') {
            echo "<a href='request_payment.php?service_id=" . $row['service_id'] . "'>Request Payment</a>";
        }
        echo "</td>";

        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No service requests found.</p>";
}
?>