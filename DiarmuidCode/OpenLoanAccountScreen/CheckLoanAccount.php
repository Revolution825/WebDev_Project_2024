<?php 

// Name : Diarmuid O'Neill
// Number : C00282898
// Description : Screen which performs some checks on entered data, moves to next screen if data is valid or displays an error if not
// Date : Feb 2024

	include "BankMenu.php"; // Includes Bank Menu
?>

		<div class="subjectbox">
			<h1>Open Loan Account</h1>

            <?php 
				session_start();

                $_SESSION['showID']=$_POST['showID'];	// Sets session variables
				$fname=$_POST['showFirstName'];
				$lname=$_POST['showLastName'];
				$_SESSION['showFirstName']=$fname;
				$_SESSION['showLastName']=$lname;


				$CustomerID = $_SESSION['showID'];
				
				if ($CustomerID)	// Checking to make sure a customer has actually been selected
				{

					include "bankConnect.inc.php";	// database connection

					$sql = "SELECT AccountID FROM account WHERE DeletedFlag=0 AND CustomerID='$CustomerID' AND AccountType='loan'"; // Checking to make sure customer does not already have a loan account

					if (!$result=mysqli_query($con, $sql))	// Query executed
					{
						die( 'Error in querying the database'.mysqli_error($con));
					}

					if (mysqli_num_rows($result) > 0)	// if results are returned
					{
						echo "<h4>Customer ID : " . $CustomerID . " already has a Loan account<br>You can only create one account of each type per customer<br>Please go back and select a different customer";
					}

                    else
                    {
                        header('Location: SetupLoanAccount.php');	// Links to next page
                    }
				}

				else
				{
					echo "<h4>Error, No customer selected, Please go back and select a customer</h4>";	// Error checking
				}

			?>
				<form action="OpenLoanAccount.php">		
					<button type="submit" class="myButton">Return Without Saving</button>	<!-- Allows user to return to previous page -->
				</form>
		</div>
    </body>
</html>