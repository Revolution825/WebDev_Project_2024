<?php 

// Name : Diarmuid O'Neill
// Number : C00282898
// Description : Screen which actually creates an account record and loan account record and displays confirmation to the user
// Date : Feb 2024

	include "BankMenu.php";	// Links to BankMenu
	include "bankConnect.inc.php";	// database connection
	session_start();

?>

		<div class="subjectbox">
		<h1>Loan Account Created</h1>
			<?php
        		$CustomerID=$_SESSION['showID'];	// Assigns variables for all needed data
				$AccountID=$_POST['showID'];
        		$AmountReq=$_POST['amountReq'];
				$MonthlyRepayments=$_POST['monthly'];
				$Term=$_POST['term'];
				$Balance=($MonthlyRepayments*$Term)-(($MonthlyRepayments*$Term)*2);	// This calculates the total balance payable for the loan and makes it a negative number
        		$TodayDate = date("Y-m-d");
				$firstName=$_SESSION['showFirstName'];
				$lastName=$_SESSION['showLastName'];
				$interestRate=$_SESSION['interest'];

        		$sql = "INSERT INTO account (AccountID, CustomerID, Balance, AccountType, Date) VALUES ('$AccountID','$CustomerID','$Balance','Loan','$TodayDate')";    // This is the sql statement for creating a basic account

        		if (!mysqli_query($con, $sql))
        		{
        		    die ("An error in the SQL Query : " . mysqli_error($con) ); // Error checking
        		}
			
        		$sql = "INSERT INTO loanaccount (AccountID, RateID, AmountRequested, Term, MonthlyRepayments) VALUES ('$AccountID',3,'$AmountReq','$Term','$MonthlyRepayments')";	// This is the sql statement for creating a loan account
			
        		if (!mysqli_query($con, $sql))
        		{
        		    die ("An error in the SQL Query : " . mysqli_error($con) ); // Error checking
        		}

				else
				{
					echo "Loan Account created for : " .  $firstName . " " . $lastName;	// Provides confirmation to the user after a loan account has been created
					echo "<br>Customer ID : " . $CustomerID;
					echo "<br>Account ID : " . $AccountID;
					echo "<br>Balance : " . $Balance;
					echo "<br>Term : " . $Term;
					echo "<br>Interest Rate : " . $interestRate;
					echo "<br>Monthly Repayments : " . $MonthlyRepayments;
					echo "<br>Date of Creation: " . $TodayDate;

				}

				$sql = "SELECT TransactionID FROM transaction WHERE TransactionID=(SELECT MAX(TransactionID) FROM transaction)";	// Getting the most recent TransactionID from the account table (from both active and inactive accounts)

				if (!$result=mysqli_query($con, $sql))	// Executes query
				{
					die( 'Error in querying the database'.mysqli_error($con));	// Error checking
				}

				if (mysqli_num_rows($result) > 0)	// If there are results found
				{
					$row = mysqli_fetch_assoc($result);	
					$transactionID = ($row['TransactionID']+1);	// Gets accountID of next account to be created
				}

				else 
				{
					$transactionID=1;
				}
			
        		$sql = "INSERT INTO transaction (TransactionID, AccountID, AccountType, Type, Amount, Date, Balance) VALUES ('$transactionID','$AccountID','Loan','Withdrawal','$AmountReq','$TodayDate','$Balance')";	// SQL statement for creating a transaction record
			
        		if (!mysqli_query($con, $sql))
        		{
        		    die ("An error in the SQL Query : " . mysqli_error($con) ); // Error checking
        		}

				else
				{
					echo "<br><h4>Transaction Details</h4>";	// Provides a printout of the created transaction
					echo "Account ID : " . $AccountID;
					echo "<br>Account Type : Loan";
					echo "<br>Transaction Type : Withdrawal";
					echo "<br>Amount : " . $AmountReq;
					echo "<br>Date : " . $TodayDate;
					echo "<br>Balance : " . $Balance;
				}

				mysqli_close($con);	// Closes database connection
				
			?>
				<form action="OpenLoanAccount.php">
					<button type="submit" class="myButton">Return</button>	<!-- Allows user to return to OpenLoanAccount screen -->
				</form>
		</div>
        
		
    </body>
</html>