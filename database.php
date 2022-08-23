<?php
session_start();

function DB()
{
// LIVE
// /* */

// TEST 
/*
$servername = "194.100.1.222";
$username = "sa";
$password = "P@ssw0rd";
$database = "TESTData";
$port = "1433";
*/

// Local - SDM10 
/**/
$servername = "DESKTOP-I70LJ7S\SQLEXPRESS";
$username = "";
$password = "";
$database = "AINDATA";
$port = "1433";

try {
    $db = new PDO("sqlsrv:server=$servername,$port;Database=$database;ConnectionPooling=0", $username, $password,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );
    return $db;
} catch (PDOException $e) {
    echo ("Error connecting to SQL Server: " . $e->getMessage());
}
}


date_default_timezone_set("Asia/Kuala_Lumpur");


?>