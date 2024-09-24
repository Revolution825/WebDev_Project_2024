<!--
	Stuart Rossiter
	c00284845
	March, 2024
	Withdraw Cash
	Allows selection of current or deposit accounts for withdrawing cash from, and entering of amount to withdraw
-->
<?php session_start(); 
//Default to current accounts on first open
if (!isset($_SESSION['accountselected']))
    {
        $_SESSION['accountselected'] = "Current Accounts";
    }
?>
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
		<div class="subjectbox">
			<h1>Withdraw Cash</h1>
			<p class="subjectboxtext">
			Please select a customer from the dropdown, or enter their customer number, or <br> their account number in the provided box.
			<div id="found"></div>
            <?php
                include "/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/bankConnect.inc.php";
				date_default_timezone_set("GMT");
				if(ISSET($_POST['accountselected']))
                    {
                        $_SESSION['accountselected'] = $_POST['accountselected'];
                    }
                if($_SESSION['accountselected'] == "Current Accounts")
                    {
						//if current accounts button selected, populate listbox with current accounts
                        $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, currentaccount.OverdraftLimit FROM ((customer INNER JOIN account ON customer.CustomerID = account.CustomerID) INNER JOIN currentaccount ON account.AccountID = currentaccount.AccountID) WHERE account.DeletedFlag=0 AND account.AccountType='current'";
                    }
                else
                    {
						//else, deposit accounts button must be selected, populate listbox with deposit accounts
                        $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance FROM ((customer INNER JOIN account ON customer.CustomerID = account.CustomerID) INNER JOIN depositaccount ON account.AccountID = depositaccount.AccountID) WHERE account.DeletedFlag=0 AND account.AccountID = depositaccount.AccountID";
                    }
				//execute query
                if(!$result = mysqli_query($con, $sql))
                    {
                        die('ERROR IN QUERYING THE DATABASE' . mysqli_error($con));
                    }
                echo"<br><select name='listbox' id='listbox' onclick='populate()'>";
                while($row = mysqli_fetch_array($result))
                    {
                        $customerid = $row['CustomerID'];
                        $firstname = $row['FirstName'];
                        $surname = $row['LastName'];
                        $address = $row['Address'];
                        $eircode = $row['Eircode'];
                        $dateOfBirth = $row['DOB'];
                        $dob = date_create($dateOfBirth);
                        $dob = date_format($dob,"Y-m-d");
                        $telephone = $row['Telephone'];
                        $accountid = $row['AccountID'];
                        $balance = $row['Balance'];
						//if current accounts selected, add overdraft limit to alltext
                        if (isset($row['OverdraftLimit']))
                            {
                                $overdraft=$row['OverdraftLimit'];
                            }
                        else 
                            {
                                $overdraft = "";
                            }
                        $alltext = "$customerid,$firstname,$surname,$address,$eircode,$dob,$telephone,$accountid,$balance,$overdraft";
                        echo"<option value = '$alltext'>$firstname $surname</option>";
                    }
                echo "</select>";
                mysqli_close($con);
            ?>
            </p>
			<form action="withdrawCash.html.php" method="post">
				<label for="search">Search By ID</label>
				<input type="number" name="search" id="search">
                <input type="radio" id="customerID" name="selection" value="CustomerID" checked>
                Customer ID
                <input type="radio" id="accountID" name="selection" value="AccountID">
                Account ID
				<button type="submit">Search Customers</button>
			</form>
            <form action="withdrawCash.html.php" method="POST">
                <input disabled type="submit" id="currentSelect" name="accountselected" value="Current Accounts">
                <input type="submit" id="depositSelect" name="accountselected" value="Deposit Accounts">
            </form>
            <form class="customerDetails" action="cashWithdrawn.html.php" method="post" onsubmit="return confirmDetails()">
                <label for="displayid">Customer ID</label>
                <input type="number" name="displayid" id="displayid" disabled placeholder="Customer ID">

                <label for="displayfname">First Name</label>
                <input type="text" name="displayfname" id="displayfname" disabled placeholder="First Name">
                <label for="displaysname">Surname</label>
                <input type="text" name="displaysname" id="displaysname" disabled placeholder="Surname">
                <label for="displayaddress">Address</label>
                <input type="text" name="displayaddress" id="displayaddress" disabled placeholder="Address">
                <label for="displayeircode">Eircode</label>
                <input type="text" name="displayeircode" id="displayeircode" disabled placeholder="Eircode">
                <label for="displaydob">Date of Birth</label>
                <input type="date" name="displaydob" id="displaydob" disabled placeholder="Date of Birth">
                <label for="displaytelephone">Telephone</label>
                <input type="text" name="displaytelephone" id="displaytelephone" disabled placeholder="Telephone">
                <label for="displayaid">Account ID</label>
                <input type="number" name="displayaid" id="displayaid" disabled placeholder="Account ID">
                <label for="displaybalance">Balance</label>
                <input type="number" name="displaybalance" id="displaybalance" disabled placeholder="Balance">
                <label id="overdraftlabel" for="displaybalance">Overdraft Limit</label>
                <input type="number" name="overdraftlimit" id="overdraftlimit" disabled placeholder="Overdraft Limit">				
				<label for="withdraw">Amount to Withdraw</label>				
				<input type="number" name="withdraw" id="withdraw" step="0.01" min="0" required placeholder="Amount To Withdraw">
				<button style="margin-left:35%; margin-top: 20px; width: 200px;" type="submit">Withdraw Cash</button>
            </form>
		</div>
		<?php
		    include	"/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/bankConnect.inc.php";
			date_default_timezone_set("GMT");
            
			if (isset($_POST["search"]) && $_POST["search"] != null)
				{
					$search = $_POST["search"];
                    if ($_POST["selection"] == "CustomerID")
                        {
							//if customerID selected
                            if (isset($_SESSION['accountselected']) and $_SESSION['accountselected'] == "Deposit Accounts")
                            {
								//search for deposit account by customerID if deposit account selected
                                $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, account.AccountType FROM (customer INNER JOIN account ON customer.CustomerID = account.CustomerID) WHERE account.DeletedFlag=0 AND account.AccountType='deposit' AND customer.CustomerID = $search";
                            }
                            else if(isset($_SESSION['accountselected']) and $_SESSION['accountselected'] == "Current Accounts")
                            {
								//otherwise if current account selected, search for them by customer id
                                $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, account.AccountType FROM (customer INNER JOIN account ON customer.CustomerID = account.CustomerID) WHERE account.DeletedFlag=0 AND account.AccountType='current' AND customer.CustomerID = $search";       
                            }
                        }
                    else
                        {
							//if customerid not selected, search by accountid, which works regardless of current or deposit account
                            $sql = "SELECT customer.CustomerID, customer.FirstName, customer.LastName, customer.Address, customer.Eircode, customer.DOB, customer.Telephone, account.AccountID, account.Balance, account.AccountType FROM (customer INNER JOIN account ON customer.CustomerID = account.CustomerID) WHERE account.DeletedFlag=0 AND (account.AccountType='current' OR account.AccountType='deposit') AND account.AccountID = $search";
                        }
					if(!$result = mysqli_query($con, $sql))
                        {
                            die('ERROR IN QUERYING THE DATABASE' . mysqli_error($con));
                        }
					if ($row = mysqli_fetch_array($result))
						{
							echo "
							<script>
								document.getElementById('found').innerHTML = '';
							</script>";
							$customerid = $row['CustomerID'];
                        	$firstname = $row['FirstName'];
                        	$surname = $row['LastName'];
                        	$address = $row['Address'];
                        	$eircode = $row['Eircode'];
                        	$dateOfBirth = $row['DOB'];
                        	$dob = date_create($dateOfBirth);
                        	$dob = date_format($dob,"Y-m-d");
                        	$telephone = $row['Telephone'];
                            $accountid = $row['AccountID'];
                            $balance = $row['Balance'];
                            if ($row['AccountType'] == "current")
                            {
                                $sql = "SELECT OverdraftLimit FROM currentaccount WHERE AccountID = '$row[AccountID]'";
                                $row = mysqli_fetch_array(mysqli_query($con, $sql));
                                $overdraft=$row['OverdraftLimit'];
                                $_SESSION['accountselected'] = "Current Accounts";
                            }
                            else 
                            {
                                $overdraft = "";
                                $_SESSION['accountselected'] = "Deposit Accounts";
                            }
                        	$alltext = "'$customerid,$firstname,$surname,$address,$eircode,$dob,$telephone,$accountid,$balance,$overdraft'";
							echo"
							<script>
								var result = $alltext;
								var customerDetails = result.split(',');
                				document.getElementById('displayid').value = customerDetails[0];
                				document.getElementById('displayfname').value = customerDetails[1];
                				document.getElementById('displaysname').value = customerDetails[2];
                				document.getElementById('displayaddress').value = customerDetails[3];
                				document.getElementById('displayeircode').value = customerDetails[4];
                				document.getElementById('displaydob').value = customerDetails[5];
                				document.getElementById('displaytelephone').value = customerDetails[6];
                                document.getElementById('displayaid').value = customerDetails[7];
                                document.getElementById('displaybalance').value = customerDetails[8];
                                document.getElementById('overdraftlimit').value = customerDetails[9];
								document.getElementById('withdraw').value = 0.00;
								var max;
								if (customerDetails[9] == '')
									{
										max = parseFloat(customerDetails[8]);
									}
								else
									{
										max = parseFloat(customerDetails[8]) + parseFloat(customerDetails[9]);
									}
								document.getElementById('withdraw').max = max;
											</script>";
						}
					else
						{
							echo
							"
							<script>
							document.getElementById('found').innerHTML = 'The $_POST[selection] $search was not found.';
							</script>
							";
						}
				}
                if(ISSET($_SESSION['accountselected']))
                    {
                        if($_SESSION['accountselected'] == "Current Accounts")
                            {
                                echo "
                                <script>
                                    document.getElementById('currentSelect').disabled = true;
                                    document.getElementById('depositSelect').disabled = false;
                                    document.getElementById('overdraftlimit').style.visibility = 'visible';
                                    document.getElementById('overdraftlabel').style.visibility = 'visible';
                                </script>";
                            }
                        else
                            {
                                echo "
                                <script>
                                    document.getElementById('currentSelect').disabled = false;
                                    document.getElementById('depositSelect').disabled = true;
                                    document.getElementById('overdraftlimit').style.visibility = 'hidden';
                                    document.getElementById('overdraftlabel').style.visibility = 'hidden';
                                </script>";
                            }
                    }
			mysqli_close($con);
		?>
        <script>
			if (document.getElementById('displayid').disabled == false)
				{
					toggleLock();
				}
            function populate()
            {
                var sel = document.getElementById("listbox");
                var result;
                result = sel.options[sel.selectedIndex].value;
                var customerDetails = result.split(',');
                document.getElementById("displayid").value = customerDetails[0];
                document.getElementById("displayfname").value = customerDetails[1];
                document.getElementById("displaysname").value = customerDetails[2];
                document.getElementById("displayaddress").value = customerDetails[3];
                document.getElementById("displayeircode").value = customerDetails[4];
				document.getElementById("displaydob").value = customerDetails[5];
                document.getElementById("displaytelephone").value = customerDetails[6];
                document.getElementById('displayaid').value = customerDetails[7];
                document.getElementById('displaybalance').value = customerDetails[8];
                document.getElementById('overdraftlimit').value = customerDetails[9];
				document.getElementById('withdraw').value = 0.00;
				//Max for withdrawal is balance + overdraft limit
				var max;
				if (customerDetails[9] == "")
					{
						max = parseFloat(customerDetails[8]);
					}
				else
					{
						max = parseFloat(customerDetails[8]) + parseFloat(customerDetails[9]);
					}
				document.getElementById('withdraw').max = max;
            }
			function confirmDetails()
			{
				if (document.getElementById("displayid").value > 0)
				{
					var status = confirm("Are you sure you wish to Withdraw " + document.getElementById("withdraw").value + " from the <?php $string = mb_substr("$_SESSION[accountselected]", 0, -1); echo "$string";?> of the following Customer? \n ID: " + document.getElementById("displayid").value + " Name: " + document.getElementById("displayfname").value + " " + document.getElementById("displaysname").value);
					if (status)
						{
							toggleLock();
						}
					return status;
				}
				else
				{
					alert("No Customer Selected!");
					return false;
				}
			}
			function toggleLock()
			{
				if (document.getElementById('displayid').disabled)
				{
					document.getElementById('displayaid').disabled = false;
                	document.getElementById('displaybalance').disabled = false;
					document.getElementById('displayfname').disabled = false;
					document.getElementById('displaysname').disabled = false;
					document.getElementById('withdraw').disabled = false;
				}
				else
				{
					document.getElementById('displayaid').disabled = true;
                	document.getElementById('displaybalance').disabled = true;
					document.getElementById('displayfname').disabled = true;
					document.getElementById('displaysname').disabled = true;
					document.getElementById('withdraw').disabled = true;
				}
			}
        </script>
    </body>
</html>
