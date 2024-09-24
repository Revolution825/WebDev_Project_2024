<!--
	Stuart Rossiter
	c00284845
	March, 2024
	Cash Withdrawn
	Confirms withdrawing of cash and provides transaction details
-->
<?php session_start(); ?>
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
		<!--The CASH WITHDRAWN message, styled with the subjectbox class. Any mention of subjectboxes refers to the boxes found within the main body of the page underneath the menu bar-->
        <div class="subjectbox">
			<h1>Withdraw Cash</h1>
            <p class="subjectboxtext">
				Presented below are the details of the transaction.
				
                <?php
                    include ("/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/bankConnect.inc.php");
                    $accountid = $_POST['displayaid'];
                    $balance = $_POST['displaybalance'];
                    $withdrawal = $_POST['withdraw'];
                    $name = $_POST['displayfname'] . " " . $_POST['displaysname']; 
                    $date = date_format(date_create(), "Y-m-d");
                    $newbalance = ($balance - $withdrawal);
                    if ($_SESSION['accountselected'] == "Current Accounts")
                        {
                            $accounttype = "Current";
                        }
                    else
                        {
                            $accounttype = "Deposit";
                        }
                    
                    if ($withdrawal == 0.00)
                        {
                            echo "Withdrawal of 0.00 entered. Balance of account id " . $accountid . " is unaffected.";
                        }
                    else
                        {
							//update balance based on withdrawal
                            $sql = "UPDATE account SET Balance = '$newbalance' WHERE account.AccountID = '$accountid'";
							//execute query
                            if (!mysqli_query($con, $sql))
                                {
                                    echo mysqli_error($con);
                                }
                            else
                                {
									//if query successful, get most recent transaction id
                                    $sql = "SELECT TransactionID FROM transaction ORDER BY TransactionID DESC";
									//execute query
                                    $result = mysqli_query($con, $sql);
									//if no transactions already
                                    if (mysqli_num_rows($result) == 0)
                                        {
											//transaction id = 1
                                            $transid = 1;
                                        }
                                    else
                                        {
											//otherwise, transaction id = the highest id + 1
                                            $row = mysqli_fetch_array($result);
                                            $transid = $row['TransactionID'] + 1;  
                                        }
                                    
                                    echo "<br><br>Transaction Details:<br>
                                        Transaction ID:     $transid <br>
                                        AccountID:          $accountid <br>
                                        Old Balance:        $balance <br>
                                        Amount Withdrawn:   $withdrawal <br>
                                        New Balance:        $newbalance <br>
                                        Date:               $date <br>
                                            ";
									//insert transaction into transaction table
                                    $sql = "INSERT INTO transaction (TransactionID, AccountID, AccountType, Type, Amount, Date, Balance) VALUES ('$transid', '$accountid', '$accounttype', 'Withdrawal', '$withdrawal', '$date', '$newbalance')";
                                    if(!mysqli_query($con, $sql))
                                        {
                                            echo mysqli_error($con);
                                        }
                                }
                        }
                    mysqli_close($con);
                ?>
            </p>
            <form action='/MainWebsiteCode/OIR BANK.html.php' method='post'>
                <br>
                <button type='submit'>Return To Home Page</button>
            </form>
        </div>
        
    </body>
</html>
