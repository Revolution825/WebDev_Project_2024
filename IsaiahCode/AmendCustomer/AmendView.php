<!--
Name Of Screen: AmendView.php	
Purpose Of Screen: File in which the code to handle the editing of the custoemr details takes place

Student Name: Isaiah Andres
Student Number: C00286361
Date:29/03/2024 -->
<?php include '../MainMenu.php'; ?>

<div class = "subjectbox" >
	
<?php include '../bankConnect.inc.php'; ?>

<?php
date_default_timezone_set('UTC');
$dbDate = date("Y-m-d", strtotime($_POST['dobID'])); //to match date format in database

$sql = "UPDATE customer SET FirstName = '$_POST[fnameID]', LastName = '$_POST[lnameID]', Address = '$_POST[addressID]', Eircode = '$_POST[eircodeID]', DOB = '$_POST[dobID]',
        Telephone = '$_POST[phoneNoID]', Occupation = '$_POST[occupationID]', Salary = '$_POST[salaryID]', Email = '$_POST[emailID]', GuarantorName = '$_POST[gnameID]' 
        WHERE CustomerID = '$_POST[custID]'"; //MySQL query to update the values based on the form inputs

if (!mysqli_query($con, $sql))
{
    echo "Error ".mysqli_error($con); // Shows error if there is a problem with the MySQL statement or connection
}
else
{
    if (mysqli_affected_rows($con) != 0)
        {
            echo mysqli_affected_rows($con)." record(s) updated <br>"; //Shows how many records have been affected using mysqli_affected_rows
            echo "Customer Id " .  $_POST['custID'].", ".$_POST['fnameID'] . " " . $_POST['lnameID'] //Shows the record which has been updated using the Customer id and name 
            ." ". "has been updated";
        }
   else
        {
            echo "No records were changed"; //If the number of affected rows is zero, this message is shown
        }
}
?>

<form action = "AmendViewCustomer.php" method = "POST" > <!--Button that returns to the deletion page -->
<br>
    <input type = "submit" value = "Return to Insert Page"/> <!--Brings user back to the deletion page-->
</form>
</div>
</div>
