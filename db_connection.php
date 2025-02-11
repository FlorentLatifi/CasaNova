<?php
// Parametrat për lidhjen me bazën e të dhënave
$serverName = "localhost";  // Emri ose IP-ja e serverit
$username = "Diar";         // Përdoruesi i databazës
$password = "Diar2005";     // Fjalëkalimi i databazës
$dbname = "Projekti";       // Emri i databazës tuaj

// Krijimi i lidhjes me MySQL
$conn = new mysqli($serverName, $username, $password, $dbname);

// Kontrollo lidhjen
if ($conn->connect_error) {
    die("Gabim gjatë lidhjes me bazën e të dhënave: " . $conn->connect_error);
}
