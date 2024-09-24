<!--
	Stuart Rossiter
	c00284845
	April, 2024
	Fetch Transactions
	Fetches transactions for given account, to be used for amend/view current account to display last 10 transactions
-->
<?php
    include("/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/bankConnect.inc.php");
    if(ISSET($_POST['accountid']))
    {
        $accountid = $_POST['accountid'];
    }
	//Select transactions of account ID provided
    $sql = "SELECT * FROM transaction WHERE AccountID = $accountid ORDER BY TransactionID DESC";
	//execute query
	if(!$result = mysqli_query($con, $sql))
    	{
        	die('ERROR IN QUERYING THE DATABASE' . mysqli_error($con));
        }
		$counter = 0;
		echo "
				<table>
				<tr>
					<th>Transaction ID</th>
					<th>Account ID</th>
					<th>Type</th>
					<th>Amount</th>
					<th>Date</th>";
		//Echo out table with last 10 transactions, or less if specified
		while ($row = mysqli_fetch_array($result) and $counter < 10)
		{
			echo "
			<tr>
				<td>" . $row['TransactionID'] . "</td>
				<td>" . $row['AccountID'] . "</td>
				<td>" . $row['Type'] . "</td>
				<td>" . $row['Amount'] . "</td>
				<td>" . $row['Date'] . "</td>";
			$counter++;
		}
	echo "</table></script>";
    mysqli_close($con);
