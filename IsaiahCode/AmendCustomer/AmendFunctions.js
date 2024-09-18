/*
		Name Of Screen: AmendFunctions.js
		Purpose Of Screen: Javascript file that involves functions for populating the form with customer information upon clicking the customer listbox and a function for a confirmation pop up if the user clicks on the submit button.
        As well as unlocking the form inputs for upon confirming and submitting the details
			
		Student Name: Isaiah Andres
		Student Number: C00286361
		Date:21/03/2024 */

function populate()
{
var sel = document.getElementById("customerListbox"); //Takes the value from customerListbox
var result;
result = sel.options[sel.selectedIndex].value; //.options sets or returns the value of the option using .selectedIndex to set or return the index
var customerDetails = result.split(','); //Splits the string using a comma
document.getElementById("custID").value = customerDetails[0];
document.getElementById("fnameID").value = customerDetails[1]; //Assigning the html form inputs to an array
document.getElementById("lnameID").value = customerDetails[2];
document.getElementById("addressID").value = customerDetails[3];
document.getElementById("eircodeID").value = customerDetails[4];
document.getElementById("dobID").value = customerDetails[5];
document.getElementById("phoneNoID").value = customerDetails[6];
document.getElementById("occupationID").value = customerDetails[7];
document.getElementById("salaryID").value = customerDetails[8];
document.getElementById("emailID").value = customerDetails[9];
document.getElementById("guarantorID").value = customerDetails[10];
}

function toggleLock()
{
if (document.getElementById("amendViewbutton").value == "Amend Details")  //Allows the user to edit the input fields if the value of the button is Amend Details by setting the disabled flag to false apart from the customer id. Also changes the text of the button to view details
{
    document.getElementById("custID").disabled = true;
    document.getElementById("fnameID").disabled = false;
    document.getElementById("lnameID").disabled = false;
    document.getElementById("addressID").disabled = false;
    document.getElementById("eircodeID").disabled = false;
    document.getElementById("dobID").disabled = false;
    document.getElementById("phoneNoID").disabled = false;
    document.getElementById("occupationID").disabled = false;
    document.getElementById("salaryID").disabled = false;
    document.getElementById("emailID").disabled = false;
    document.getElementById("guarantorID").disabled = false;
    document.getElementById("amendViewbutton").value = "View Details";
}
else
{
    document.getElementById("custID").disabled = true; //Disables the fields again if the value of the button is view details
    document.getElementById("fnameID").disabled = true;
    document.getElementById("lnameID").disabled = true;
    document.getElementById("addressID").disabled = true;
    document.getElementById("eircodeID").disabled = true;
    document.getElementById("dobID").disabled = true;
    document.getElementById("phoneNoID").disabled = true;
    document.getElementById("occupationID").disabled = true;
    document.getElementById("salaryID").disabled = true;
    document.getElementById("emailID").disabled = true;
    document.getElementById("guarantorID").disabled = true;
    document.getElementById("amendViewbutton").value = "Amend Details";
}
}

function confirmCheck()
{
var response;
response = confirm("Are you sure you want to save these changes?"); //Confirm message that asks if the user wants to save these changes
if(response)
{  
    document.getElementById("custID").disabled = false; //Allows the user to edit and submit the fields if the user confirms that the details are correct
    document.getElementById("fnameID").disabled = false;
    document.getElementById("lnameID").disabled = false;
    document.getElementById("addressID").disabled = false;
    document.getElementById("eircodeID").disabled = false;
    document.getElementById("dobID").disabled = false;
    document.getElementById("phoneNoID").disabled = false;
    document.getElementById("occupationID").disabled = false;
    document.getElementById("salaryID").disabled = false;
    document.getElementById("emailID").disabled = false;
    document.getElementById("guarantorID").disabled = false;
    return true;
}
else    
 {
    populate(); //Calls the javascript functions involved if the user doesn't confirm
    toggleLock();
    return false;
 }
}

