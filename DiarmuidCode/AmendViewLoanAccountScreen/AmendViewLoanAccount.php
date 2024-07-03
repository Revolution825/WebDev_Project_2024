<?php 

// Name : Diarmuid O'Neill
// Number : C00282898
// Description : Screen allowing a user to choose an account to view or amend
// Date : March 2024

	include "BankMenu.php";	// Includes the Bank Menu
    include "bankConnect.inc.php";	// database connection
?>
<script src="AmendViewLoanAccount.js"></script>	<!-- Links to javascript file -->


<div class="subjectbox">
    <h1>Amend/View a Loan Account</h1>
    <h4>Please select a customer whos loan account you wish to view/amend </h4>
    <h4>Choose a customer from the drop-down or search up their customerID </h4>
    <h4>Alternatively you can search up a loan account using an accountID </h4>

    <p class="subjectboxtext">

    <form action="AmendViewLoanAccount.php" method="POST"> <!-- This Form relates to the searchbar, upon searching the page is refreshed and the main form is populated -->

<?php

    // This block of PHP relates to the drop-down listbox

    $sql = "SELECT customer.CustomerID, FirstName, LastName, Address, Eircode, DOB, Telephone, account.AccountID, Balance, Term, AmountRequested, MonthlyRepayments FROM customer INNER JOIN account ON customer.CustomerID=account.CustomerID INNER JOIN loanaccount ON account.AccountID=loanaccount.AccountID WHERE customer.DeletedFlag=0 AND AccountType='loan' AND account.DeletedFlag=0 ";

    if (!$result=mysqli_query($con, $sql))
    {
        die( 'Error in querying the database'.mysqli_error($con));
    }

    echo "<select name='listbox' id='listbox' onclick='populate()'>";   // Listbox, upon clicking the main form is populated with the data of the selected customer

    while ($row=mysqli_fetch_array($result))    // Loops through the array while there are results in the array
    {

        $CustomerID = $row['CustomerID'];   // This block takes data from the rows in the database and assigns them to variables
        $FirstName = $row['FirstName'];
        $LastName = $row['LastName'];
        $Address  = $row['Address'];
        $Eircode = $row['Eircode'];
        $dateOfBirth = $row['DOB'];
        $DOB = date_create($row['DOB']);
        $DOB = date_format($DOB, "Y-m-d");
        $Telephone = $row['Telephone'];
        $AccountID = $row['AccountID'];
        $Balance = $row['Balance'];
        $Term = $row['Term'];
        $LoanAmount = $row['AmountRequested'];
        $MonthlyRepayments = $row['MonthlyRepayments'];



        $allText = "$CustomerID, $FirstName, $LastName, $Address, $Eircode, $DOB, $Telephone, $AccountID, $Balance, $Term, $LoanAmount, $MonthlyRepayments";
        echo "<option value = '$allText'>$FirstName $LastName</option>";    // This populates the listbox with options
    }
    echo "</select>";
?>


        <input style="width: 100px; margin-left:30px;" type="text" name="search" placeholder="CustomerID..." >  <!-- SearchBox -->
        <button type="submit">Search</button>    <!-- Search Button, populates main form upon clicking -->

    </form>

    <br>

    
    
    <form action="AmendViewLoanAccount.php" method="POST"> <!-- This Form relates to the searchbar, upon searching the page is refreshed and the main form is populated -->
        <input style="width: 100px; margin-left:145px;" type="text" name="searchAccount" placeholder="AccountID..." >  <!-- SearchBox -->
        <button type="submit">Search</button>    <!-- Search Button, populates main form upon clicking -->
    </form>

    <?php

    // This block of PHP relates to the Account ID search bar

    $AccountID=null;   // AccountID initialized to null

    if(isset($_POST['searchAccount'])) 
    {
        $AccountID=$_POST['searchAccount'];

        // This gets customer and account details

        $sql = "SELECT customer.CustomerID, FirstName, LastName, Address, Eircode, DOB, Telephone, account.AccountID, Balance, Term, AmountRequested, MonthlyRepayments FROM customer INNER JOIN account ON customer.CustomerID=account.CustomerID INNER JOIN loanaccount ON account.AccountID=loanaccount.AccountID WHERE customer.DeletedFlag=0 AND account.AccountID='$AccountID' AND AccountType='loan' AND account.DeletedFlag=0";

        if (!$result=mysqli_query($con, $sql))
        {
            die( 'Error in querying the database'.mysqli_error($con));
        }

        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);

            // Fetching values from the database

            $CustomerID = $row['CustomerID'];
            $FirstName = $row['FirstName'];
            $LastName = $row['LastName'];
            $Address  = $row['Address'];
            $Eircode = $row['Eircode'];
            $DOB = date('Y-m-d', strtotime($row['DOB']));
            $Telephone = $row['Telephone'];
            $AccountID = $row['AccountID'];
            $Balance = $row['Balance'];
            $Term = $row['Term'];
            $LoanAmount = $row['AmountRequested'];
            $MonthlyRepayments = $row['MonthlyRepayments'];
        }

        else 
        {
            // Handle case when no results are found
            $CustomerID = $FirstName = $LastName = $Address = $Eircode = $DOB = $Telephone = $AccountID = $Balance = $Term = $LoanAmount = $MonthlyRepayments = "";
        }
    }
?>

<?php

    // This block of PHP relates to the customer ID search bar

    $customerID=null;   // CustomerID initialized to null

    if(isset($_POST['search'])) 
    {
        $customerID=$_POST['search'];

        // This gets customer and account details

        $sql = "SELECT customer.CustomerID, FirstName, LastName, Address, Eircode, DOB, Telephone, account.AccountID, Balance, Term, AmountRequested, MonthlyRepayments FROM customer INNER JOIN account ON customer.CustomerID=account.CustomerID INNER JOIN loanaccount ON account.AccountID=loanaccount.AccountID WHERE customer.DeletedFlag=0 AND customer.CustomerID='$customerID' AND AccountType='loan' AND account.DeletedFlag=0";

        if (!$result=mysqli_query($con, $sql))
        {
            die( 'Error in querying the database'.mysqli_error($con));
        }

        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);

            // Fetching values from the database

            $CustomerID = $row['CustomerID'];
            $FirstName = $row['FirstName'];
            $LastName = $row['LastName'];
            $Address  = $row['Address'];
            $Eircode = $row['Eircode'];
            $DOB = date('Y-m-d', strtotime($row['DOB']));
            $Telephone = $row['Telephone'];
            $AccountID = $row['AccountID'];
            $Balance = $row['Balance'];
            $Term = $row['Term'];
            $LoanAmount = $row['AmountRequested'];
            $MonthlyRepayments = $row['MonthlyRepayments'];
        }

        else 
        {
            // Handle case when no results are found
            $CustomerID = $FirstName = $LastName = $Address = $Eircode = $DOB = $Telephone = $AccountID = $Balance = $Term = $LoanAmount = $MonthlyRepayments = "";
        }
    }
?>

<?php

$sql = "SELECT InterestRate FROM rate WHERE RateID=3";	// Getting a hold of the annual loan account interest rate for loan calculations

if (!$result=mysqli_query($con, $sql))	// Executes query
{
	die( 'Error in querying the database'.mysqli_error($con));	// Error checking
}

if (mysqli_num_rows($result) > 0) // If results found
{
	$row = mysqli_fetch_assoc($result);

	$InterestRate = $row['InterestRate'];
    
}

mysqli_close($con); // Closes database connection

?>

<script> var InterestRate = <?php echo $InterestRate; // Assigns Interest rate to a variable in javascript ?>; </script>

    <input class="myButton" type="button" value="Amend Details" id="amendViewbutton" onclick="toggleLock()"> <!-- Button for choosing to ammend details or view details -->

    <p id="display">
        <form id="myForm" action="AmendDetails.php" onload="lock()" onsubmit="return confirmCheck()" method="POST">   <!-- locks form onload, prompts user to confirm details and unlocks form to allow posting, moves to CheckCloseLoanAccount.php upon submission -->

        <div class="inputbox">
        <label>Customer ID : </label>
        <input type="text" name="showID" id="showID" disabled value="<?php echo $CustomerID; ?>">
        </div>	

        <div class="inputbox">
        <label>First Name : </label>
        <input type="text" name="showFirstName" id="showFirstName" disabled value="<?php echo $FirstName; ?>">
        </div>

        <div class="inputbox">
        <label>LastName : </label>
        <input type="text" name="showLastName" id="showLastName" disabled value="<?php echo $LastName; ?>">
        </div>

        <div class="inputbox">
        <label>Address : </label>
        <input type="text" name="showAddress" id="showAddress" disabled value="<?php echo $Address; ?>">
        </div>

        <div class="inputbox">
        <label>Eircode : </label>
        <input type="text" name="showEircode" id="showEircode" disabled value="<?php echo $Eircode; ?>">
        </div>

        <div class="inputbox">
        <label>Date of Birth : </label>
        <input type="date" name="showDOB" id="showDOB" disabled value="<?php echo $DOB; ?>">
        </div>

        <div class="inputbox">
        <label>Telephone : </label>
        <input type="text" name="showTelephone" id="showTelephone" disabled value="<?php echo $Telephone; ?>">
        </div>

        <div class="inputbox">
        <label>Account ID : </label>
        <input type="text" name="showAccountID" id="showAccountID" disabled value="<?php echo $AccountID; ?>">
        </div>

        <div class="inputbox">
        <label>Balance : </label>
        <input type="text" name="showBalance" id="showBalance" disabled value="<?php echo $Balance; ?>">
        </div>

        <div class="inputbox">
        <label>Term : </label>
        <input type="number" name="showTerm" id="showTerm" disabled value="<?php echo $Term; ?>">
        </div>

        <div class="inputbox">
        <label>Loan Amount : </label>
        <input type="number" name="showLoanAmount" id="showLoanAmount" disabled value="<?php echo $LoanAmount; ?>">
        </div>

        <div class="inputbox">
        <label>Monthly Repayments : </label>
        <input type="number" name="showMonthlyRepayments" id="showMonthlyRepayments" disabled value="<?php echo $MonthlyRepayments; ?>">
        </div>

        <input class="myButton" type="submit" value="Save Changes">

        </form>
</div>
</body>
</html>