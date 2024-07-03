<?php 

// Name : Diarmuid O'Neill
// Number : C00282898
// Description : 
// Date : March 2024

include "BankMenu.php"; // Includes the Bank Menu
include "bankConnect.inc.php"; // database connection

$customerID = ""; // Initialize the variable

session_start();

if(isset($_POST['Return']))		
{
	session_unset();	// Clears all session variables
}

?>
		
<script src="AccountReport.js"></script>	<!-- Links to javascript file -->

<div class="subjectbox">
	<h1>Generate Account Report</h1>
	<h4>Please select a customer for whom you want to generate an account report for</h4>
	<h4>Then select the account for which you want to generate the report for </h4>

	<!-- This form allows the user to select a customer that has either a loan account or current account -->

	<form  id="listboxform" action="AccountReportScreen.php" method="POST">	

		<?php
			
			// This block of PHP relates to the customer drop-down listbox

			if (isset($_POST['listbox']))	// Checks if a customer has been selected
			{
				$allText=$_POST['listbox'];
				$selectedCustomerID = explode(", ", $allText)[0]; 	// Extract the CustomerID
				$selectedFirstName = explode(", ", $allText)[1]; 	// Extract the FirstName
				$selectedLastName = explode(", ", $allText)[2]; 	// Extract the LastName
				session_unset();									// Resets session variables if a new customer is selected
				$_SESSION['customerID']=$selectedCustomerID;
				$_SESSION['firstName']=$selectedFirstName;
				$_SESSION['lastName']=$selectedLastName;
			}
			else if (isset($_SESSION['customerID']))	// Ensures selected customer is displayed until a new one is selected
			{
				$selectedCustomerID = $_SESSION['customerID'];
			}

			// Selects distinct customers with either a loan or current account. Distinct ensures customers are not displayed more than once

			$sql = "SELECT DISTINCT customer.CustomerID, FirstName, LastName FROM customer INNER JOIN account ON customer.CustomerID=account.CustomerID WHERE customer.DeletedFlag=0  AND account.DeletedFlag=0 AND (AccountType='loan' OR AccountType='current')";
			
			if (!$result = mysqli_query($con, $sql)) 
			{
				die('Error in querying the database' . mysqli_error($con));
			}
			
			echo "<select class='selectbox' name='listbox' id='listbox'>"; // Listbox
			
			while ($row = mysqli_fetch_array($result)) 
			{
				$customerID = $row['CustomerID']; // This block takes data from the rows in the database and assigns them to variables
				$firstName = $row['FirstName'];
				$lastName = $row['LastName'];
				$allText = "$customerID, $firstName, $lastName";

				if ($customerID == $selectedCustomerID)		// Check if this customer matches the selected customer
				{ 
					echo "<option value='$allText' selected>$firstName $lastName</option>"; // If a customer has been previously selected the 'selected' attribute is set
				} 
				else 
				{
					echo "<option value='$allText'>$firstName $lastName</option>";
				}
            }
            ?>
        </select>
		<input class="myButton" type="submit" value="Select Customer">
	</form>

	<br>

	<!-- This form allows the user to select an account for which to view transactions (it only appears after a customer has been selected) -->

	<form id="accountboxform" action="AccountReportScreen.php" method="POST"> <!-- It will refresh the screen upon submission and post variables -->

		<?php

			// This block of PHP relates to the account drop-down listbox

			if (isset($_SESSION['customerID'])) // Checks if a customer has been selected
			{			
				if (isset($_POST['accountbox']))	// Checks if an account has been selected
				{
					$accountDetails=$_POST['accountbox'];
					$selectedAccountID = explode(", ", $accountDetails)[0]; // Extract the AccountID
					$selectedAccountType = explode(", ", $accountDetails)[1]; // Extract the AccountType
					$_SESSION['AccountID']=$selectedAccountID;
					$_SESSION['accountType']=$selectedAccountType;
				}
				else if (isset($_SESSION['AccountID']))	// Ensures selected account is displayed until a new one is selected
				{
					$selectedAccountID = $_SESSION['AccountID'];
				}

				// Gets any current or loan accounts relating to the selected customer

				$sql = "SELECT AccountID, AccountType FROM account WHERE CustomerID='$selectedCustomerID' AND DeletedFlag=0 AND (AccountType='loan' OR AccountType='current')";

				if (!$result=mysqli_query($con, $sql))
				{
					die( 'Error in querying the database'.mysqli_error($con));
				}

				echo "<select class='selectbox' name='accountbox' id='accountbox'>";   // Listbox

				while ($row=mysqli_fetch_array($result))    // Loops through the array while there are results in the array
				{
					$accountID = $row['AccountID'];
					$accountType = $row['AccountType'];
					$accountDetails = "$accountID, $accountType";

					if ($accountID == $selectedAccountID)		// Check if this customer matches the selected customer
					{ 
						echo "<option value = '$accountDetails' selected>$accountType Account</option>"; // Set 'selected' attribute
					} 
					else 
					{
						echo "<option value = '$accountDetails'>$accountType Account</option>";	// This populates the listbox with options
					}
				}
				echo "</select>
					  <input class='myButton' type='submit' value='Select Account'>";
			}
				?>
			
			
		</form>
	<br>

	<!-- This form allows the user to select a start date and end date for viewing recent transactions -->

	<form id="dateform" action="AccountReportScreen.php" method="POST">		<!-- This form relates to generating the report -->
		<?php
			if (isset($_POST['report'])) // If a date for the report has been previously selected
			{
				// Retrieve the start and end dates
				$startDate = $_POST['startDate'];
				$endDate =$_POST['endDate'];
			
				// Store the selected start and end dates in session variables
				$_SESSION['startDate'] = $startDate;
				$_SESSION['endDate'] = $endDate;
				
			}
			if(isset($_SESSION['AccountID']))	// If an account has been selected
			{
				$startDate = null;
				if (isset($_SESSION['startDate'])) 	// If a start date has previously been selected
				{
					$startDate = $_SESSION['startDate'];
				}
				$endDate = null;
				if (isset($_SESSION['endDate']))  // If an end date has been previously selected
				{
					$endDate = $_SESSION['endDate'];
				}

				// Echos out the date picker, if a date has previously selected it wil already display in the date picker

				echo "<label for='startDate'>Start Date : </label>
					<input type='date' id='startDate' name='startDate' value='$startDate'>

					<br> <br>

					<label for='endDate'>End Date : </label>
					<input type='date' id='endDate' name='endDate' value='$endDate'>

					<br> <br>

					<button class='myButton' type='submit' name='report'>Generate Report</button>";
			}
		?>
	</form>

	<br>

	<?php

		// Php function that executes sql statement and processes results for report

		function generateReport($con,$sql)
		{
			$result = mysqli_query($con,$sql);


			
			echo "<table>
					<tr><th>Date</th><th>Transaction Type</th><th>Amount</th><th>Balance</th></tr>";

			while ($row=mysqli_fetch_array($result))

			{
				echo    "<td>".$row['Date']."</td>
						<td>".$row['Type']."</td>
						<td>".$row['Amount']."</td>
						<td>".$row['Balance']."</td>
						</tr>";
			}
			echo "</table>";
		}

	?>

	<br>

	<form id="Return" action="AccountReportScreen.php" method="POST">
		<input class="myButton" type="submit" name="Return" value="Return">		<!-- Return button which allows user to return to start of report screen -->
	<form>
</div>
	<?php
	if (isset($_POST['report']))	// If a date has been set
	{
		echo "<div class='subjectbox' id='transactionResults'>";

		$accountID=$_SESSION['AccountID'];	// Get all needed data for report from session variables
		$startDate=$_SESSION['startDate'];
		$endDate=$_SESSION['endDate'];
		$firstName=$_SESSION['firstName'];
		$lastName=$_SESSION['lastName'];
		$accountType=$_SESSION['accountType'];
		
		echo "<h2 style='text-decoration : underline;'>" . $accountType . " Account Report</h2>";

		echo "<h4>AccountID : " . $accountID . " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Customer Name : " . $firstName . " " . $lastName . "</h4>";

		if ($startDate!='' && $endDate!='')		// If start date and end date have been set get the transactions between those dates
		{
			$sql = "SELECT transaction.Date, Type, Amount, transaction.Balance FROM transaction INNER JOIN account ON account.AccountID=transaction.AccountID WHERE transaction.AccountID='$accountID' AND (transaction.Date>='$startDate' AND transaction.Date<='$endDate')";
		}
		else	// If start date and end date have not been set get the transactions from the last six months
		{
			$endDate=date('Y-m-d'); 	// end date is set to today
			$startDate=date('Y-m-d', strtotime('-6 months'));	// start date is set to six months back from today
			$sql = "SELECT transaction.Date, Type, Amount, transaction.Balance FROM transaction INNER JOIN account ON account.AccountID=transaction.AccountID WHERE transaction.AccountID='$accountID' AND (transaction.Date>='$startDate' AND transaction.Date<='$endDate')";
		}
		generateReport($con,$sql);	// Generate report

		echo "</div>";
	}
	?>
