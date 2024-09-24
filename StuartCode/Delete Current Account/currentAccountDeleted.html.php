<!--Stuart Rossiter
	c00284845
	February, 2024
	Current Account Deleted
	A screen to confirm the deletion of the selected current account
-->
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
		<!--The ACCOUNT DELETED message, styled with the subjectbox class. Any mention of subjectboxes refers to the boxes found within the main body of the page underneath the menu bar-->
        <div class="subjectbox">
			<h1>Delete A Current Account</h1>
            <p class="subjectboxtext">
                <?php
                    include ("/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/bankConnect.inc.php");
                    $balance = $_POST['displaybalance'];
                    //dont allow deletion if balance is not 0
                    if ($balance != 0.00)
                    {
                        echo "ERROR : Balance of account id " . $_POST['displayaid'] . " is not 0. Please clear balance and try again.";
                    }
                    else
                    {
						//set the deletedFlag of the selected Current Account to be 1, signifying it has been deleted
                        $sql = "UPDATE account SET DeletedFlag = 1 WHERE account.AccountID = $_POST[displayaid]";
						//execute update
                        if (!mysqli_query($con, $sql))
                            {
                                echo mysqli_error($con);
                            }
                        else
                            {
                                echo "Account ID " . $_POST['displayaid'] . " has been closed.";
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
