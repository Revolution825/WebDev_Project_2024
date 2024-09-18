<!--
Name Of Screen: CustomerListbox.php
Purpose Of Screen: Drop down list that is populated with results from a MySQL query to select details from the customer table 
    
Student Name: Isaiah Andres
Student Number: C00286361
Date:10/03/2024 -->

<?php
include "../bankConnect.inc.php"; //Includes the connection to the bank database
date_default_timezone_set('UTC'); //Setting the default timezone to UTC
{ $sql = "SELECT CustomerID, FirstName , LastName, Address, Eircode, DOB, Telephone, Occupation,Salary,Email,GuarantorName
    FROM customer WHERE DeletedFlag = 0"; //MySQL query to select custoemr details from the customer tables where the DeletedFlag is 0
}

if (!$result = mysqli_query($con,$sql)) //Query is executed here.
{
die( 'Error in querying the database' . mysqli_error($con)); //Message that shows if there was an issue querying the database and exits the script using the die function
}

echo "<br><select name = 'customerListbox' id = 'customerListbox' onclick = 'populate()'>"; //Creates a dropdown list using the select tag. HTML code can be used using the echo statement

while ($row = mysqli_fetch_array($result)) //Fetches the resultset as a numeric array or associative array and assigns it to the variable $row
{
    $customerid = $row['CustomerID']; //Assigning the results from the row as an associative array and assigns them to corresponding variables 
    $fname = $row['FirstName'];
    $lname = $row['LastName'];
    $address = $row['Address'];
    $eircode = $row['Eircode'];
    $dob = $row['DOB'];
    $dob = date_create($row['DOB']); //Returns new date time object that can be formatted
    $dob = date_format($dob,"Y-m-d"); //Formatting the date to 2004/12/31
    $telephone = $row['Telephone'];  //Assigning the results from the row as an associative array and assigns them to corresponding variables again
    $occupation = $row['Occupation'];
    $salary = $row['Salary'];
    $email = $row['Email'];
    $gname = $row['GuarantorName'];
    $allText = "$customerid,$fname,$lname,$address,$eircode,$dob,$telephone,$occupation,$salary,$email,$gname"; //Assigning all the variables from the resultset to a variable $alltext
    echo "<option value = '$allText'>$fname $lname </option>"; //The names of the customers will be displayed as the options within the listbox the value assigned to them is $alltext which contains the corresponding customer information
}
echo "</select>"; //End of drop down
mysqli_close($con); //Closes connection
?>
