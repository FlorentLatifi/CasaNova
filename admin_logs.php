<?php
session_start();
include 'db_connection.php';

// Kontrollo nëse përdoruesi është superadmin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 3) {
    header("Location: login.html");
    exit();
}

// Merr të gjitha veprimet e administratorëve
$sql = "SELECT pa.*, p.title as property_title, u.emri, u.mbiemri, u.email 
        FROM product_actions pa 
        LEFT JOIN products p ON pa.product_id = p.id 
        LEFT JOIN users u ON pa.user_id = u.id 
        ORDER BY pa.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Logs - CasaNova</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="dashboard-container">
        <h1>Administrator Activity Logs</h1>

        <div class="logs-table">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Admin</th>
                        <th>Action</th>
                        <th>Property</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date('Y-m-d H:i:s', strtotime($row['created_at'])); ?></td>
                        <td>
                            <?php echo $row['emri'] . ' ' . $row['mbiemri']; ?><br>
                            <small><?php echo $row['email']; ?></small>
                        </td>
                        <td>
                            <span class="action-badge <?php echo $row['action_type']; ?>">
                                <?php echo ucfirst($row['action_type']); ?>
                            </span>
                        </td>
                        <td><?php echo $row['property_title']; ?></td>
                        <td><?php echo $row['action_details']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 