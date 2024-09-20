<!--Student Name: Isaiah Andres
Student Number: C00286361
Date:25/02/2024 -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="stylesheet" href="AddCustomer.css">
        <title>OIR Banking System</title>
		<script type="text/javascript" src="AddCustomer.js" ></script>
    </head>
    <body>
		<!--The start of the menu bar at the top-->
		<div class="navbar">
			<!--The list of items that make up the options on the top menu bar-->
			<ul class="nav-list" style="list-style-type: none">
				<li><a href="#">Lodgements</a></li>
				<li><a href="#">Withdrawals</a></li>
				<!--Dropdown menu for customers-->
				<li class="dropdown">
					<a href="#">Customers</a>
					<div class="dropdown-content">
						<a class="dropdownItem" href="#">Create</a><br>
						<a class="dropdownItem" href="#">View/Amend</a><br>
						<a class="dropdownItem" href="#">Delete</a>
					</div>
				</li>
				<!--Dropdown menu for all accounts, with nested dropdown menus-->
				<li class="dropdown">
					<a href="#">Accounts</a>
					<div class="dropdown-content">
						<!--The dropdown menu for loan accounts, nested within the accounts dropdown menu-->
						<div class="nestedLoan">
							<a class="dropdownItem" href="#">Loan Account</a>
							<div class="dropdown-content-loan">
								<a class="dropdownItem" href="#">Create</a><br>
								<a class="dropdownItem" href="#">View/Amend</a><br>
								<a class="dropdownItem" href="#">Delete</a>
							</div>
						</div><br>
						<!--The dropdown menu for current accounts, nested within the accounts dropdown menu-->
						<div class="nestedCurrent">
							<a class="dropdownItem" href="#">Current Account</a>
							<div class="dropdown-content-current">
								<a class="dropdownItem" href="#">Create</a><br>
								<a class="dropdownItem" href="#">View/Amend</a><br>
								<a class="dropdownItem" href="#">Delete</a>
							</div>
						</div><br>
						<!--The dropdown menu for deposit accounts, nested within the accounts dropdown menu-->
						<div class="nestedDeposit">
							<a class="dropdownItem" href="#">Deposit Account</a>
							<div class="dropdown-content-deposit">
								<a class="dropdownItem" href="#">Create</a><br>
								<a class="dropdownItem" href="#">View/Amend</a><br>
								<a class="dropdownItem" href="#">Delete</a>
							</div>
						</div>
					</div>
				</li>
				<!--Logo of the bank, which links back to the homepage-->
				<li><a href="OIR BANK.html"><img src="logo2.png" alt="Brand logo"></a></li>
				<li class="dropdown">
					<a href="#">Management Menu</a>
					<div class="dropdown-content">
						<!--NOTE: nestedCurrent and dropdown-content-current are used here for the sake of reducing code redundancy. The name isn't fitting, but it works perfectly-->
						<div class="nestedCurrent">
							<a class="dropdownItem" href="#">Charge/Calculate Interest</a><br>
							<div class="dropdown-content-current">
								<a class="dropdownItem" href="#">Overdrawn Current Accounts</a><br>
								<a class="dropdownItem" href="#">View/Amend</a><br>
								<a class="dropdownItem" href="#">Delete</a>
							</div>
						</div>
						<!--NOTE: nestedDeposit and dropdown-content-deposit areused here for the sake of reducing code redundancy. The name isn't fitting, but it works perfectly-->
						<div class="nestedDeposit">
							<a class="dropdownItem" href="#">Change Rates</a><br>
							<div class="dropdown-content-deposit">
								<a class="dropdownItem" href="#">Deposit Accounts</a><br>
								<a class="dropdownItem" href="#">Current Accounts</a><br>
								<a class="dropdownItem" href="#">Loan Accounts</a>
							</div>
						<div></div>
					</div>
				</li>
				<li><a href="#">Quotes</a></li>
				<li class="dropdown">
					<a href="#">Reports</a>
					<div class="dropdown-content">
						<!--NOTE: nestedCurrent and dropdown-content-current are used here for the sake of reducing code redundancy. The name isn't fitting, but it works perfectly-->
						<div class="nestedCurrent">
							<a class="dropdownItem" href="#">History</a><br>
							<div class="dropdown-content-current">
								<a class="dropdownItem" href="#">Deposit Account History</a><br>
								<a class="dropdownItem" href="#">Loan Account History</a><br>
								<a class="dropdownItem" href="#">Current Account History</a>
							</div>
						</div>
						<!--NOTE: nestedDeposit and dropdown-content-deposit areused here for the sake of reducing code redundancy. The name isn't fitting, but it works perfectly-->
						<div class="nestedDeposit">
							<a class="dropdownItem" href="#">Reports</a><br>
							<div class="dropdown-content-deposit">
								<a class="dropdownItem" href="#">Customer Report</a><br>
								<a class="dropdownItem" href="#">Current Account Interest Report</a><br>
								<a class="dropdownItem" href="#">Account Report</a>
							</div>
						<div></div>
					</div>
				</li>
				<li><a href="#">Change Password</a></li>
			</ul>
		</div>
		<!--Form submission box for the user to enter in the customer's details-->     
        <div class="submissionBox">

		</div>
        <div class="subjectbox">  
        <?php //Placing the php code in the div for the subjectbox stylises the php results in the same way as the rest of the website

include 'bankConnect.inc.php';  //Uses the php file that starts a new conncetion to the database
date_default_timezone_set("UTC"); //Sets default timezone to utc

echo "The details submitted are: <br>";

echo "First Name :" . $_POST['fname'] . "<br>"; //Displays the information from the html file
echo "Last Name :" . $_POST['lname'] . "<br>"; //Displays the information from the html file
echo "Address :" . $_POST['address'] . "<br>";
echo "Eircode :" . $_POST['eircode'] . "<br>";
$date=date_create($_POST['dob']); //Date object is created
echo "Date of Birth is :" . date_format($date,"d/m/Y") . "<br>"; 
echo "Phone Number :" . $_POST['phoneNo'] . "<br>";
echo "Occupation :" . $_POST['occupation'] . "<br>";
echo "Salary :" . $_POST['salary'] . "<br>";
echo "Email :" . $_POST['email'] . "<br>";
echo "Guarantor :" . $_POST['gname'] . "<br>";

//mysql query that allows the user to insert the values from the html form to the database fields using POST 
$sqlMax =  "SELECT MAX(CustomerId) AS maxID FROM customer";
$result = mysqli_query($con,$sqlMax); //mysql query that selects the highest value from the customer ID from the customer, calling it maxid allows for it to be entered to the row array as an index and to get the result  
$row = mysqli_fetch_assoc($result); //Fetches the result row as an associative array or as a numerical array
$maxID = $row['maxID']; //Assigning the row with maxID as its index to the variable $maxID
$maxID++; //Increments the maxID to represent the next ID which is to be auto-incremented

echo "<br>A record has been added for " . $_POST['fname']; //Displays the information for the corresponding database details
echo "<br>The customer ID is " . $maxID; //Message that shows the newly added customer's ID

$sql = "Insert into customer (CustomerID,FirstName,LastName,Address,Eircode,DOB,Telephone,Occupation,Salary,Email,GuarantorName) VALUES  
($maxID,'$_POST[fname]','$_POST[lname]','$_POST[address]','$_POST[eircode]','$_POST[dob]','$_POST[phoneNo]','$_POST[occupation]','$_POST[salary]','$_POST[email]','$_POST[gname]')"; //Updated input which now allows for the email and phone number from the html file to be entered

if (!mysqli_query($con,$sql)) //Statement that appears if there is an error with the query
{
die ("An Error in the SQL Query: " . mysqli_error($con) );
}

mysqli_close($con);
?>
    
<form action = "AddCustomer.html" method = "POST" > <!--Information taken from AddCustomer.html -->
    <br>
    <input type = "submit" value = "Return to Insert Page"/> <!--Brings user back to the insert page-->
    </body>
</html>

</div>