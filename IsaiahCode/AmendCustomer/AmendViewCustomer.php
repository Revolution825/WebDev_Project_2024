		<!--
		Name Of Screen:  AmendViewCustomer.php
		Purpose Of Screen: Form that displays customer details chosen from a given listbox and allows to edit customer details-->  
		
		<!--Student Name: Isaiah Andres
		Student Number: C00286361
		Date:21/03/2024 -->
		<!--Form for the user to see customer details if they choose an option from the listbox-->     
		<?php include '../MainMenu.php' ?>
        <div class="amendBox"> <!--Div class for the amend/view form -->
            <fieldset class = "fieldsetCustomer"> <!--Fieldset for grouping together form inputs -->
            <form action = "AmendView.php" method = "POST" name = "amendForm">  <!--Start of the form that displays chosen customer details and submits the information to the AmendView file in which the MySQL statement to edit certain details takes place-->
            <legend><h1>Amend/View A Customer</h1></legend> <!--Text that displays at the top of the form-->
            <br>
			<?php include 'customerListbox.php'; ?> <!--Customer listbox file -->
            <br>
            <br>
            <input type = "button" value = "Amend Details" id = "amendViewbutton" onclick = "toggleLock()">  <!--Calls the function toggleLock() upon clicking the button -->
            <br>
			<div class="customerID"> <!--Div class for the customer's ID label and input box -->
            <label for="name">Customer ID:</label> <!--Disabled input box in which the customer ID will be displayed-->
            <input type="text" name="custID" id="custID" disabled required/> 
            </div>
            <div class="fname"> <!--Div class for the customer's first name label and input box -->
            <label for="name">Customer First Name:</label> <!--Disabled input box in which the customer first name will be displayed-->
            <input type="text" name="fnameID" id="fnameID" disabled required/>
            </div>
            <br>
			<div class="lname"> <!--Div class for the customer's surname label and input box -->
			<label for="name">Customer Surname:</label> <!--Disabled input box in which the customer surname will be displayed-->
			<input type="text" name="lnameID" id="lnameID"  disabled required/>
			</div>
			<br>
            <div class="address"><!--Div class for the customer's address label and input box -->
            <label for="address">Customer Address:</label> 
            <input type="text" name="addressID" id="addressID" disabled required/>  <!--Disabled input box in which the customer address will be displayed-->
            </div>
            <br>
            <div class="eircode"> <!--Div class for the customer's eircode label and input box -->
            <label for="eircode">Customer Eircode:</label> <!--Disabled input box in which the customer eircode will be displayed-->
            <input type="text" name="eircodeID" id="eircodeID" disabled required/> 
            </div>
            <br>
            <div class="DOB"> <!--Div class for the customer's date of birth label and input box -->
            <label for="dateOfBirth">Date Of Birth:</label> <!--Disabled input box in which the customer's date of birth will be displayed-->
            <input type="date" name="dobID" id="dobID" disabled required/> <!--Using type date rather than numbers shows a calendar in which dates can be chosen from age rating?=18 -->
            </div>
            <br>
			<div class="phoneNo"> <!--Div class for the customer's phone number label and input box -->
			<label for="phoneNo">Customer Phone Number:</label> <!--Disabled input box in which the customer phone number will be displayed-->
			<input type="tel" name="phoneNoID" id="phoneNoID" pattern="[0-9\- \(\) +]{7,}" disabled required/> <!-- input type tel allows a user to input a telephone number within the required pattern, pattern shou-->
			</div>
			<br>
			<div class="occupation">
			<label for="occupation">Customer Occupation:</label> <!--Div class for the customer's occupation label and input box -->
			<input type="text" name="occupationID" id="occupationID"disabled required/> <!--Disabled input box in which the customer occupation will be displayed-->
			</div>
			<br>
            <div class="salary">
			<label for="salary">Customer Salary:</label> <!--Div class for the customer's salary label and input box -->
			<input type="number" name="salaryID" id="salaryID" min="0" step="0.1" disabled required/> <!--Disabled input box in which the customer salary will be displayed-->
			</div>
			<br>
			<div class="email">
			<label for="email">Customer Email:</label> <!--Div class for the customer's email label and input box -->
			<input type="email" name="emailID" id="emailID" disabled required/> <!--Using this rather than numbers shows a calendar in which dates can chosen from -->
			</div>
			<br>
			<div class="guarantor">
			<label for="guarantor">Guarantor's Name:</label> <!--Div class for the customer's guarantor name label and input box -->
			<input type="text" name="gnameID" id="guarantorID" disabled /> <!--Disabled input box in which the customer's guarantor name will be displayed-->
			</div>
			<br>
            <div class="myButton"> <!--Div class for the submit button -->
            <input type="submit" value="Save Changes" name="saveChange" onclick = confirmCheck() /><br><br> <!--Submit button input. Value sets the text within the button and runs the javascript function confirmDeletion upon clicking the submit button -->
			</div>
            </fieldset>
        </div>
    </form>
	

		</div>
    </body>
</html>