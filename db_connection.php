<?php
// Parametrat për lidhjen me bazën e të dhënave
$serverName = "localhost";  // Emri ose IP-ja e serverit
$connectionOptions = array(
    "Database" => "Projekti",  // Emri i databazës tuaj
    "Uid" => "Diar",          // Përdoruesi i databazës
    "PWD" => "Diar2005"       // Fjalëkalimi i databazës
);

// Krijimi i lidhjes me SQL Server
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Kontrolloni nëse lidhja është e suksesshme
if ($conn === false) {
    die("Gabim gjatë lidhjes me bazën e të dhënave: " . print_r(sqlsrv_errors(), true));
}
?>
