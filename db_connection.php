<?php
// Parametrat për lidhjen me bazën e të dhënave
$serverName = "localhost";  // Emri ose IP-ja e serverit
$username = "Diar";  // Përdoruesi i databazës
$password = "Diar2005";  // Fjalëkalimi i databazës
$dbname = "projekti";  // Emri i databazës tuaj (ensure this matches exactly with your database name)

// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Krijimi i lidhjes me MySQL/MariaDB
$conn = new mysqli($serverName, $username, $password, $dbname);

// Kontrolloni nëse lidhja është e suksesshme
if ($conn->connect_error) {
    die("Gabim gjatë lidhjes me bazën e të dhënave: " . $conn->connect_error);
}
//echo "Lidhja me bazën e të dhënave është bërë me sukses!";
