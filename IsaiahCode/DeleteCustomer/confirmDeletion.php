<!--
Name Of Screen: AmendView.php	
Purpose Of Screen: File in which the code to handle the editing of the custoemr details takes place
Student Name: Isaiah Andres
Student Number: C00286361
Date:10/03/2024 -->

<?php include '../MainMenu.php'?>

<div class="subjectbox">  <!--Applies css styling by putting the following php code in a div class that is to be stylised -->
<?php
include "bankConnect.inc.php"; //Including the file to connect to the database
date_default_timezone_set('UTC'); //Setting the default timezone to UTC
$ID = $_POST['custID']; //The customer ID is taken from the deletion form and is assigned to the variable $ID
$firstName = $_POST['fnameID']; //The customer first name is taken from the deletion form and is assigned to the variable $ID
$lastName = $_POST['lnameID']; //The customer last name is taken from the deletion form and is assigned to the variable $ID

if($ID == null)
{
	echo "No customer has been selected";
}
else
{
    $sql = " SELECT * FROM customer INNER JOIN account ON 
            customer.CustomerID = account.CustomerID 
            WHERE customer.customerID = $ID "; //Doing an inner join between the customer ID from the customer table and the customer ID from the account table shows if the customer has an account

    if($result = mysqli_query($con,$sql)) //MySQL query is executed here
    {
        $rowcount = mysqli_num_rows($result); //mysqli_num_rows shows the number of rows that are selected from the sql query W3Schools
    }

    if($rowcount == 0) //If the rowcount is 0, this implies that the customer has no account and is free to delete
    {
        $updateSQL = "UPDATE customer SET DeletedFlag = 1 WHERE customerID = $ID"; //MySQL query to set the DeletedFlag to 1
        $update = mysqli_query($con,$updateSQL); //MySQL query takes place 
        if(!$update) //If there is no query that took place, then this message is shown
        {
            echo("There has been an issue with the query");
        }
        else //If there is no issues then this message is shown
        {
            echo("The customer " . $firstName  . " " . $lastName . " has been deleted");
        }
        
    }
    else //If the rowcount is not 0 then this implies that the customer has an account and therefore can't be deleted
    {
        echo("The customer ". $firstName  . " " . $lastName . " can't be deleted as they have an account.");

    }
}
?>

<form action = "CustomerDeletion.php" method = "POST" > <!--Posting the information to the deletion form from the current form with no current information will direct the user back to the deletion page  --> 
<br>
    <input type = "submit" value = "Return to Deletion Page"/> <!--Brings user back to the deletion page-->

</form>
</div>