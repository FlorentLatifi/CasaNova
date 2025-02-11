<?php
// Parametrat për lidhjen me bazën e të dhënave
$serverName = "localhost";  // Emri ose IP-ja e serverit
$username = "correct_username";  // Përdoruesi i databazës
$password = "correct_password";  // Fjalëkalimi i databazës
$dbname = "Projekti";       // Emri i databazës tuaj

// Krijimi i lidhjes me MySQL/MariaDB
$conn = new mysqli($serverName, $username, $password, $dbname);

// Kontrolloni nëse lidhja është e suksesshme
if ($conn->connect_error) {
    die("Gabim gjatë lidhjes me bazën e të dhënave: " . $conn->connect_error);
}
//echo "Lidhja me bazën e të dhënave është bërë me sukses!";
