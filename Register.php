<?php
// Parametrat për lidhjen me SQL Server
$serverName = "localhost";  // Ose IP adresën e serverit tuaj
$connectionOptions = array(
    "Database" => "Projekti",  // Emri i databazës që përdorni
    "Uid" => "Diar",  // Përdoruesi për lidhjen me MSSQL
    "PWD" => "Diar2005"   // Fjalëkalimi i përdoruesit
);

// Lidhja me SQL Server
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Kontrolloni nëse lidhja ka dështuar
if ($conn === false) {
    die("Gabim në lidhjen me databazën: " . print_r(sqlsrv_errors(), true));
}

// Kontrolloni nëse formulari është dërguar me metodën POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Merrni të dhënat nga formulari
    $emri = $_POST['emri'];
    $mbiemri = $_POST['mbiemri'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $role = $_POST['role'];

    // Kontrolloni nëse fjalëkalimi dhe konfirmimi i fjalëkalimit përputhen
    if ($password != $cpassword) {
        die("Fjalëkalimi dhe konfirmimi i fjalëkalimit nuk përputhen.");
    }

    // Hashing fjalëkalimi për siguri
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Parametrat për pyetjen SQL për regjistrimin e përdoruesit
    $sql = "INSERT INTO users (emri, mbiemri, email, password, role) VALUES (?, ?, ?, ?, ?)";

    // Parametrat për pyetjen
    $params = array($emri, $mbiemri, $email, $hashedPassword, $role);

    // Ekzekuto pyetjen SQL
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Kontrolloni nëse ka ndodhur një gabim gjatë ekzekutimit të pyetjes
    if ($stmt === false) {
        die("Gabim gjatë regjistrimit: " . print_r(sqlsrv_errors(), true));
    } else {
        header("Location: login.html");
        exit(); // Sigurohuni që të ndaloni ekzekutimin e mëtejshëm
    }
}

// Mbyll lidhjen me databazën
sqlsrv_close($conn);
?>
