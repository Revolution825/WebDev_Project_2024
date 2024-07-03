<?php

// Name : Diarmuid O'Neill
// Number : C00282898
// Description : Screen which requests some more data from the user regarding the creation of a loan account
// Date : Feb 2024

	include "BankMenu.php";	// includes the BankMenu
	session_start();
?>

		<script src="OpenLoanAccount.js"></script>	<!-- Links to javascript file -->

		<div class="subjectbox">
			<h1>Open Loan Account</h1>

            <?php 
				
				$CustomerID = $_SESSION['showID'];	// Getting data from session variables
				$firstName = $_SESSION['showFirstName'];
				$lastName = $_SESSION['showLastName'];
				

				include "bankConnect.inc.php";	// Database connection

				echo "<h4>You are creating a loan account for " . $firstName . " " . $lastName . ", Customer ID : " . $CustomerID . "<br>A unique account ID has been assigned</h4>"; 

				$sql = "SELECT AccountID FROM account WHERE AccountID=(SELECT MAX(AccountID) FROM account)";	// Getting the most recent AccountID from the account table (from both active and inactive accounts)

				if (!$result=mysqli_query($con, $sql))	// Executes query
				{
					die( 'Error in querying the database'.mysqli_error($con));	// Error checking
				}

				if (mysqli_num_rows($result) > 0)	// If there are results found
				{
					$row = mysqli_fetch_assoc($result);	
					$AccountID = ($row['AccountID']+1);	// Gets accountID of next account to be created
				}

				else 
				{
					$AccountID=1;
				}

				$sql = "SELECT InterestRate FROM rate WHERE RateID=3";	// Getting a hold of the annual loan account interest rate for loan calculations

				if (!$result=mysqli_query($con, $sql))	// Executes query
				{
					die( 'Error in querying the database'.mysqli_error($con));	// Error checking
				}

				if (mysqli_num_rows($result) > 0) // If results found
				{
					$row = mysqli_fetch_assoc($result);

					$InterestRate = $row['InterestRate'];

					$_SESSION['interest']=$InterestRate;	// Put the interest rate into a session variable
				}

				mysqli_close($con);	// Closes database connection

			?>

			<script> var InterestRate = <?php echo $InterestRate; // Assigns Interest rate to a variable in javascript ?>; </script>	

			<p id="display">
				<form id="myForm" onsubmit="return confirmCheck()" onload="lock2()" action="LoanAccountTransaction.php" method="POST">	<!-- Asks the user to confirm, moves to LoanAccountTransaction upon submission, lock2 locks the form onload -->
					<div class="inputbox">
						<label>Account ID : </label>
						<input type="text" tabindex="-1" name="showID" id="showID" disabled value="<?php echo $AccountID; ?>">
					</div>
					<div class="inputbox">
						<label>Amount Requested : </label>
						<input type="number" min="0" step="100" name="amountReq" id="amountReq" placeholder="Amount Requested..." required>
					</div>
					<div class="inputbox">
						<label>Term : </label>
						<input type="number" min="0" step="1" name="term" id="term" placeholder="Term in Months..." required>
					</div>
					<div class="inputbox">
						<label>Monthly Repayments : </label>
						<input type="number" name="monthly" id="monthly" disabled>
					</div>

					<input class="myButton" onclick="update()" type="submit" value="Confirm Details"> <!-- Update() calculates monthly repayments -->

				</form>
				
				<button onclick="update()" class="myButton">Calculate Repayments</button>	<!-- Calculates repayments and populates relavent form field -->

				<form action="OpenLoanAccount.php">
					<button type="submit" class="myButton">Return Without Saving</button>	<!-- Allows user to return to the previous page -->
				</form>
			</p>
		</div>
    </body>
</html>