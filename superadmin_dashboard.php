<?php
// Lidhja me databazën
include 'db_connection.php'; // Skedari me lidhjen me databazën

// Merr listën e përdoruesve
$sql = "SELECT u.id, u.emri, u.mbiemri, u.email, r.name AS roli 
        FROM users u 
        JOIN roles r ON u.role_id = r.id";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menaxhimi i Përdoruesve</title>
</head>
<body>
    <h1>Lista e Përdoruesve</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Emri</th>
            <th>Mbiemri</th>
            <th>Email</th>
            <th>Roli</th>
            <th>Veprimet</th>
        </tr>
        <?php while ($user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['emri'] ?></td>
            <td><?= $user['mbiemri'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['roli'] ?></td>
            <td>
                <a href="edit_user.php?id=<?= $user['id'] ?>">Edito</a> |
                <a href="delete_user.php?id=<?= $user['id'] ?>">Fshi</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
