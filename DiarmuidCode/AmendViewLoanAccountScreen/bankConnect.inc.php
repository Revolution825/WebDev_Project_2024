<?php
$hostname = "localhost"; // name of host or ip address
$username = "mybankaccount"; //MySQL username
$password = 'B4nk$ecure;24'; //mySQL Password

$dbname = "BankProject"; //Database Name

$con = mysqli_connect($hostname, $username, $password, $dbname);

if (!$con)
    {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }
?>