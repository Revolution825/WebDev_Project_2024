<?php 

// Name : Diarmuid O'Neill
// Number : C00282898
// Description : Screen which updates loan account and prints a transaction to screen
// Date : March 2024

	include "BankMenu.php";	// Includes the Bank Menu

?>

<script src="AmendViewLoanAccount.js"></script>	<!-- Links to javascript file -->

<div class="subjectbox">
<h1>Loan Account Updated</h1>
<?php

include "bankConnect.inc.php";	// database connection

// Getting a hold of needed data

$term = $_POST['showTerm'];
$loanAmount = $_POST['showLoanAmount'];
$accountID = $_POST['showAccountID'];
$monthlyRepayments = $_POST['showMonthlyRepayments'];
$balance = ($monthlyRepayments*$term)-(($monthlyRepayments*$term)*2); // Calculating new balance, this calculation ensures is negative and includes inerest payable
$oldBalance = $_POST['showBalance'];
$TodayDate = date("Y-m-d");

// Amending the details of the loan account

$sql = "UPDATE loanaccount SET Term ='$term', AmountRequested = '$loanAmount', MonthlyRepayments = '$monthlyRepayments' WHERE AccountID = '$accountID'";        // prepares sql statement for updating loan account details

if(!mysqli_query($con,$sql))    // executes sql statement
{
    echo "Error ".mysqli_error($con);
}
else
{
    if (mysqli_affected_rows($con) != 0)    // if the effected rows is not 0
    {
        echo "Account ID ". $_POST['showAccountID'] . " has been updated";      // tells us what records have been updated
    }
    else
    {
        echo "No records were changed";
    }
}

// Amending the Balance of the account

$sql = "UPDATE account SET Balance = '$balance' WHERE AccountID = '$accountID'";        // prepares sql statement for updating the balance (balance is stored in account not loanaccount)

if(!mysqli_query($con,$sql))    // executes sql statement
{
    echo "Error ".mysqli_error($con);
}
else
{
    if (mysqli_affected_rows($con) != 0)    // if the effected rows is not 0
    {
        // Do nothing, success message already printed above
    }
    else
    {
        echo "Error updating balance";
    }
}

// Creating a transaction record

if ($balance<$oldBalance)   // Checks if the new entered loan amount is less than the old balance
{
    $type="Withdrawal";  // If the new balance is less than the old balance we are dealing with a withdrawl
    $transactionAmount=$oldBalance-$balance;    // The amount on the transaction must be positive 
}
else
{
    $type="Deposit";    // If the balance is greater than the old balance we are dealing with a deposit
    $transactionAmount=$balance-$oldBalance;    // The amount on the transaction must be positive
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
    $transactionID=1; // This is the case it is the first recorded transaction
}


$sql = "INSERT INTO transaction (TransactionID, AccountID, AccountType, Type, Amount, Date, Balance) VALUES ('$transactionID','$accountID','Loan','$type','$transactionAmount','$TodayDate','$balance')";	// SQL statement for creating a transaction record
			
if (!mysqli_query($con, $sql))
{
    die ("An error in the SQL Query : " . mysqli_error($con) ); // Error checking
}

else
{
    echo "<br><h4>Transaction Details</h4>";	// Provides a printout of the created transaction
    echo "Account ID : " . $accountID;
    echo "<br>Account Type : Loan";
    echo "<br>Transaction Type : " . $type;
    echo "<br>Amount : " . $transactionAmount;
    echo "<br>Balance : " . $balance;
    echo "<br>Date : " . $TodayDate;
}

mysqli_close($con);     // closes connection
?>



<form action="AmendViewLoanAccount.php" method="POST">     <!-- Returns to AmendView.html.php upon submission -->

<br>

<input type="submit" value="Return">
</form>
</div>