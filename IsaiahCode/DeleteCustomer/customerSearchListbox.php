<?php 
include '../bankConnect.inc.php'; 

if(ISSET($_POST['search']))
{
    if($_POST['custNameID'] != null)
    {
        $customerName = $_POST['custNameID'];
        $customerNameSplit = explode(" ", $customerName); //W3Schools explode function splits the string into an array and each word seperated by a space
        $fname = $customerNameSplit[0];
        $lname = $customerNameSplit[1];
        if(isset($fname) && isset($lname))
        {
            $sqlSearchCustomer = "SELECT CustomerID, FirstName , LastName, Address, Eircode, DOB, Telephone, Occupation,Salary,Email,GuarantorName
            FROM customer WHERE DeletedFlag = 0 AND FirstName = '$fname' AND LastName = '$lname'";

            if (!$result = mysqli_query($con,$sqlSearchCustomer)) //Query is executed here.
            {
            die( 'Error in querying the database' . mysqli_error($con)); //Message that shows if there was an issue querying the database and exits the script using the die function
            }
            if(mysqli_num_rows($result) >0)
            {
                echo "<br><select name = 'customerSearchListbox' id = 'customerSearchListbox' onclick = 'populateSearchListbox()'>"; //Creates a dropdown list using the select tag. HTML code can be used using the echo statement

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
                echo "<br>";
            }
            else
            {
                echo "Customer not found";
            }
        }
    }
}
?>