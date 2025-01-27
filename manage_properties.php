<?php
session_start();
include 'db_connection.php';

// Kontrollo nëse përdoruesi është admin ose superadmin
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] != 2 && $_SESSION['user_role'] != 3)) {
    header("Location: login.html");
    exit();
}

// Merr të gjitha pronat
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Properties - CasaNova</title>
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'nav.php'; ?>

    <div class="dashboard-container">
        <div class="header-actions">
            <h1>Manage Properties</h1>
            <a href="add_property.php" class="add-btn"><i class="fas fa-plus"></i> Add New Property</a>
        </div>

        <div class="properties-table">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Area</th>
                        <th>Bedrooms</th>
                        <th>Bathrooms</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src="<?php echo $row['image_url']; ?>" alt="Property" class="property-thumbnail"></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo ucfirst($row['type']); ?></td>
                        <td>$<?php echo number_format($row['price']); ?></td>
                        <td>
                            <select class="status-select" data-id="<?php echo $row['id']; ?>" onchange="updateStatus(this)">
                                <option value="available" <?php echo $row['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
                                <option value="sold" <?php echo $row['status'] == 'sold' ? 'selected' : ''; ?>>Sold</option>
                                <option value="rented" <?php echo $row['status'] == 'rented' ? 'selected' : ''; ?>>Rented</option>
                            </select>
                        </td>
                        <td><?php echo $row['area']; ?> m²</td>
                        <td><?php echo $row['bedrooms']; ?></td>
                        <td><?php echo $row['bathrooms']; ?></td>
                        <td>
                            <a href="edit_property.php?id=<?php echo $row['id']; ?>" class="action-btn edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteProperty(<?php echo $row['id']; ?>)" class="action-btn delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function updateStatus(select) {
        const propertyId = select.dataset.id;
        const newStatus = select.value;
        
        fetch('update_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${propertyId}&status=${newStatus}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status updated successfully');
            } else {
                alert('Error updating status');
            }
        });
    }

    function deleteProperty(id) {
        if (confirm('Are you sure you want to delete this property?')) {
            fetch('delete_property.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error deleting property');
                }
            });
        }
    }
    </script>
</body>
</html> 