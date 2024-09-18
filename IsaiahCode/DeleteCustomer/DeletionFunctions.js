/*
		Name Of Screen: DeletionFunctions.js
		Purpose Of Screen: Javascript file that involves functions for populating the form with customer information upon clicking the customer listbox and a function for a confirmation pop up if the user clicks on the submit button.
			
		Student Name: Isaiah Andres
		Student Number: C00286361
		Date:10/03/2024 */

function populate()
{
var sel = document.getElementById("customerListbox"); //Takes the value from customerListbox
var result;
result = sel.options[sel.selectedIndex].value; //.options sets or returns the value of the option using .selectedIndex to set or return the index
var customerDetails = result.split(','); //Splits the string using a comma
document.getElementById("custID").value = customerDetails[0];
document.getElementById("fnameID").value = customerDetails[1]; //Assigning the array values to the values of the form
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

function populateSearchListbox()
{
var sel = document.getElementById("customerSearchListbox"); //Takes the value from customerListbox
var result;
result = sel.options[sel.selectedIndex].value; //.options sets or returns the value of the option using .selectedIndex to set or return the index
var customerDetails = result.split(','); //Splits the string using a comma
document.getElementById("custID").value = customerDetails[0];
document.getElementById("fnameID").value = customerDetails[1]; //Assigning the array values to the values of the form
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

function confirmDeletion()
{
    var confirmation
    confirmation = confirm("Are you sure you want to delete this customer?"); //Confirmation text that pops up when details are about to be submitted
    if(confirmation)
    {   
        document.getElementById("custID").disabled = false; //Setting this to false allows the information to be submitted to the confirmDeletion page
        document.getElementById("fnameID").disabled = false;
        document.getElementById("lnameID").disabled = false;
        return true; //if confirmation is confirmed then the details will be submitted
    }
    else
    {
        event.preventDefault(); //if confirmation is denied then the details will be prevented from being submitted
        return false;
    }
}

function searchCustomer()
{
    var name;
    document.getElementById("searchCustomer").value = name;
}

