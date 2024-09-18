<?php
include "bankConnect.inc.php";

$sql = "SELECT FirstName , LastName, Address, customer.CustomerID, AccountID, Balance FROM customer INNER JOIN account ON customer.CustomerID = account.CustomerID WHERE customer.DeletedFlag = 0"; //MySQL query to select the customer details

if (!$result = mysqli_query($con,$sql))
{
die( 'Error in querying the database' . mysqli_error($con)); //Message that is displayed if there is an error with the query
}

echo "<br><select name = 'customerListbox' id = 'customerListbox' onclick = 'listboxPopulate()'>"; //Shows the drop down list through the <select> element

while ($row = mysqli_fetch_array($result)) //fetches the results of the MySQL query as an associative array
{
    $fname = $row['FirstName'];
    $lname = $row['LastName'];
    $address = $row['Address'];
    $custID = $row['CustomerID'];
    $accID = $row['AccountID'];
    $balance = $row['Balance'];

    $allText = " $fname, $lname, $address, $custID, $accID, $balance"; //Assigning all the variables to the variable alltext
    echo "<option value = '$allText'>$fname $lname </option>"; //The values to be displayed for each customer option is stored in all text 
}
echo "</select>";
?>