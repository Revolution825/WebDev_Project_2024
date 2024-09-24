<!--Stuart Rossiter
	c00284845
	February, 2024
	Current Account Added
	A screen to show that a current account has been created
-->
<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="/MainWebsiteCode/MainStyling.css">
        <title>OIR Banking System</title>
    </head>
    <body>
		<?PHP include("/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/MainMenu.php");?>
		<!--The ACCOUNT ADDED message, styled with the subjectbox class. Any mention of subjectboxes refers to the boxes found within the main body of the page underneath the menu bar-->
        <div class="subjectbox">
			<h1>Current Account Added</h1>
            <p class="subjectboxtext">
            Current Account has been added.
            </p>
            <form action='/MainWebsiteCode/OIR BANK.html.php' method='post'>
                <br>
                <button type='submit'>Return To Home Page</button>
            </form>
        </div>
        <?php
			//used to prevent backtracking
			$_SESSION['currentCreated'] = 1;
            include ("/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/bankConnect.inc.php");
            date_default_timezone_set('UTC');
			$date = date_create();
			$dateString = date_format($date, "Y-m-d");
            $balance = 0.00 + (float) $_POST['added'];
			//Inserts the current account that's being created into the accounts table
            $sql = "INSERT INTO account (AccountID, CustomerID, Balance, AccountType, Date, DeletedFlag) VALUES ($_POST[displayid], $_POST[displaycid], $balance, 'current', '$dateString', 0)";
			//executes insertion
            $result = mysqli_query($con, $sql);
			//gets the most recent rate for current accounts
            $sql = "SELECT * FROM rate WHERE type = 'current' ORDER BY RateID DESC";
			//executes query
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
			//inserts the created current account details into the currentaccount table
            $sql = "INSERT INTO currentaccount VALUES ($_POST[displayid], $row[RateID], $_POST[overdraft])";
			//executes insertion
            $result = mysqli_query($con, $sql);
			if ($balance > 0.00)
			{ 
				//if balance is greater than 0, transaction must be made
				//get most recent transaction id
                $sql = "SELECT * FROM transaction ORDER BY TransactionID DESC";
                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) == 0)
                    {
						//if transaction table is empty, make the id = 1
                        $transactionID = 1;
                    }
                else
                    {
						//if transactions exist, take highest ID and add 1
                        $row = mysqli_fetch_array($result);
                        $transactionID = $row['TransactionID'] + 1;
                    }
				//insert transaction details into transaction table
				$sql = "INSERT INTO transaction (TransactionID, AccountID, AccountType, Type, Amount, Date, Balance) VALUES ($transactionID, $_POST[displayid], 'Current', 'Initial Deposit', $balance, '$dateString', $balance)";
				//execute insertion
				$result = mysqli_query($con, $sql);
			}
			mysqli_close($con);
        ?>
    </body>
</html>
