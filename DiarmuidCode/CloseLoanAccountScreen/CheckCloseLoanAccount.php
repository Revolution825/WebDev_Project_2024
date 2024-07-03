<?php

// Name : Diarmuid O'Neill
// Number : C00282898
// Description : Screen for validating entered data and closing a loan account, also provides confirmation/error messages
// Date : March 2024

    include "BankMenu.php";	// This includes BankMenu
?>

<div class="subjectbox">
	<h1>Close Loan Account</h1>

        <?php 

			include "bankConnect.inc.php";	// Database connection

            $customerID = $_POST['showID'];	// Gets needed values from previous form and assigns them to variables
			$fname = $_POST['showFirstName'];
			$lname = $_POST['showLastName'];
            $accountID = $_POST['showAccountID'];
            $balance = $_POST['showBalance'];
				
			if ($customerID)	// Checking to make sure a customer has actually been selected
			{
                if ($balance != 0)	// Making sure balance is 0 before allowing deletion
                {
                    echo "<h4>Error, account balance must be 0 before account is eligible for deletion</h4>";
					echo "No changes made";
                }

                else	// Case executes if balance is 0
                {
                    $sql = "UPDATE account SET DeletedFlag=1 WHERE AccountID='$accountID'";	// Sets deleted flag to 1 (closing account)

					if(!mysqli_query($con,$sql))    // Executes sql statement
					{
    					echo "Error ".mysqli_error($con);	// Error Checking
					}

					else
					{
    					if (mysqli_affected_rows($con) != 0)    // If the effected rows is greater than 0
    					{
        					echo mysqli_affected_rows($con)." Account Closed";	// Writes out a confirmation message to the user confirming account is deleted
        					echo "<br>Account ID : ". $accountID;
							echo "<br>Customer ID : ". $customerID;
							echo "<br>First Name : ". $fname;
							echo "<br>Last Name : ". $lname;
    					}
    					else
    					{
        					echo "No records were changed";
    					}
					}
                }
			}

			else	// Case executes if no customer is selected
			{
				echo "<h4>Error, No customer selected, Please go back and select a customer</h4><br>";
				echo "<h4>No changes made</h4>";
			}

		?>
			<form action="CloseLoanAccount.php">
				<button type="submit" class="myButton">Return</button>	<!-- button for returning to CloseLoanAccount.php -->
			</form>
		</div>
    </body>
</html>