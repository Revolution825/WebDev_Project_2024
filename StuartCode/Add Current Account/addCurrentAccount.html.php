<!--Stuart Rossiter
	c00284845
	February, 2024
	Add Current Account
	A screen allowing the user to select a customer, for whom they will be creating a current account
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
		<div class="subjectbox">
			<h1>Open a Current Account</h1>
			<p class="subjectboxtext">
			Please select a customer from the dropdown, or enter their customer number in the provided box.
			<div id="found"></div>
            <?php
                include "/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/bankConnect.inc.php";
				date_default_timezone_set("GMT");
				//Used for preventing backtracking \/
				$_SESSION['currentCreated'] = 0;
				
                $sql = "SELECT CustomerID, FirstName, LastName, Address, Eircode, DOB, Telephone FROM customer WHERE DeletedFlag=0";
				
				//query is run to select details from customers
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
                        $alltext = "$customerid,$firstname,$surname,$address,$eircode,$dob,$telephone";
                        echo"<option value = '$alltext'>$firstname $surname</option>";
                    }
                echo "</select>";
                mysqli_close($con);
            ?>
            </p>
			<form action="addCurrentAccount.html.php" method="post">
				<label for="search">Search By ID</label>
				<input type="number" name="search" id="search">
				<button type="submit">Search Customers</button>
			</form>
            <form class="customerDetails" action="detailCurrentAccount.html.php" method="post" onsubmit="return confirmDetails()">
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
				<button style="margin-left:35%; margin-top: 20px; width: 200px;" type="submit">Create Account</button>
            </form>
		</div>
		<?php
		    include	"/var/www/vhosts/c2p-bank.candept.com/httpdocs/MainWebsiteCode/bankConnect.inc.php";
			date_default_timezone_set("GMT");
			if (isset($_POST["search"]) && $_POST["search"] != null)
				{
					$search = $_POST["search"];
					$sql = "SELECT CustomerID, FirstName, LastName, Address, Eircode, DOB, Telephone FROM customer WHERE DeletedFlag=0 AND CustomerId=$search";
					//Query is run for details from a customer with provided id
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
                        	$alltext = "'$customerid,$firstname,$surname,$address,$eircode,$dob,$telephone'";
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
							</script>";
						}
					else
						{
							echo
							"
							<script>
							document.getElementById('found').innerHTML = 'The customer with id $search was not found.';
							</script>
							";
						}
				}
			mysqli_close($con);
		?>
        <script>
			if (document.getElementById('displayid').disabled == false)
				{
					toggleLock();
				}
			//populates the onscreen form with the values from the listbox
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
            }
			//prompts the user to confirm that the correct customer is chosen
			function confirmDetails()
			{
				if (document.getElementById("displayid").value > 0)
				{
					var status = confirm("Are you sure you wish to create a Current Account for the following Customer? \n ID: " + document.getElementById("displayid").value + " Name: " + document.getElementById("displayfname").value + " " + document.getElementById("displaysname").value);
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
			//toggles fields for the sake of POSTing
			function toggleLock()
			{
				if (document.getElementById('displayid').disabled)
				{
					document.getElementById('displayid').disabled = false;
					document.getElementById('displayfname').disabled = false;
					document.getElementById('displaysname').disabled = false;
					document.getElementById('displayaddress').disabled = false;
					document.getElementById('displayeircode').disabled = false;
					document.getElementById('displaydob').disabled = false;
					document.getElementById('displaytelephone').disabled = false;
				}
				else
				{
					document.getElementById('displayid').disabled = true;
					document.getElementById('displayfname').disabled = true;
					document.getElementById('displaysname').disabled = true;
					document.getElementById('displayaddress').disabled = true;
					document.getElementById('displayeircode').disabled = true;
					document.getElementById('displaydob').disabled = true;
					document.getElementById('displaytelephone').disabled = true;
				}
			}
        </script>
    </body>
</html>
