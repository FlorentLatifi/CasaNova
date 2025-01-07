<?php
// Lidhja me databazën
include 'db_connection.php'; // Sigurohu që të kesh një lidhje të saktë

// Kontrollo nëse ID-ja është dërguar me metodën POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $user_id = $_POST['id'];

    // Fshi përdoruesin nga baza e të dhënave
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = sqlsrv_prepare($conn, $sql, array($user_id));

    if (sqlsrv_execute($stmt)) {
        // Redirekto te lista e përdoruesve
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error deleting user: " . print_r(sqlsrv_errors(), true);
    }
} else {
    echo "Invalid request.";
}

sqlsrv_close($conn);
?>