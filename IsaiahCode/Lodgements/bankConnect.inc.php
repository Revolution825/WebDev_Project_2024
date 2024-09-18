<!--Student Name: Isaiah Andres
Student Number: C00286361
Date:15/02/2024 -->

<?php
$hostname = "localhost"; // name of host or ip address
$username = "mybankaccount"; //MySQL username
$password = 'B4nk$ecure;24'; //mySQL Password

$dbname = "BankProject"; //Database Name

$con = mysqli_connect($hostname, $username, $password, $dbname); //Opens a new connection to the mysql server

if (!$con)
    {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }
?>
</body>
</html>