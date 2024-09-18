/*
    Name Of Screen: LodgementScreenFunctions.js
    Purpose Of Screen: Provides functions to populate the form using the listbox and to disable other select buttons when the options to select the accounts show up

    Student Name: Isaiah Andres
	Student Number: C00286361
	Date:31/03/2024
*/

function listboxPopulate()
{
var sel = document.getElementById("customerListbox");
var ID;
var result;
result = sel.options[sel.selectedIndex].value; //.options sets or returns the value of the option using .selectedIndex to set or return the index
var customerDetails = result.split(', '); //Splits the string using a comma
document.getElementById("fnameID").value = customerDetails[0];
document.getElementById("lnameID").value = customerDetails[1]; //Assigning the html form inputs to an array
document.getElementById("addressID").value = customerDetails[2];
document.getElementById("custID").value = customerDetails[3];
document.getElementById("accID").value = customerDetails[4];
document.getElementById("balanceID").value = customerDetails[5];
document.getElementById("customerID").value = customerDetails[3];
}

function checkLodgement()
{
    if(document.getElementById("lodgementID") <= 0)
    {
        alert("Please ensure that the lodgement is greater than 0");
        event.preventDefault;
    }
    else
    {
        
    }
}

function confirmLodgement()
{
    var confirmation
    confirmation = confirm("Are you sure you want to lodge money into this account?"); //Confirmation text that pops up when details are about to be submitted
    if(confirmation)
    {   
        document.getElementById("fnameID").disabled = false; //Certain form inputs need to be unlocked by setting the disabled flag to false in order to send the information stored
        document.getElementById("lnameID").disabled = false;
        document.getElementById("custID").disabled = false;
        document.getElementById("accID").disabled = false;
        document.getElementById("accountUsedID").disabled = false;
        return true;
    }
    else
    {
        event.preventDefault(); //if confirmation is denied then the details will be prevented from being submitted
        return false;
    }
}

function chooseCurrent()
{
    document.getElementById("accountUsedID").value = "current";
    if(document.getElementById("accID").value == null) 
    {
        document.getElementById("accID").value = document.getElementById("lodgeCurrentButton").value; 
    }
    else //Watching out for the case that the MySQL query already has the input box covered
    {
        document.getElementById("accID").value = null;
        document.getElementById("accID").value = document.getElementById("lodgeCurrentButton").value; 
    }
}

function chooseDeposit()
{
    document.getElementById("accountUsedID").value = "Deposit";
    if(document.getElementById("accID").value == null)
    {
        document.getElementById("accID").value = document.getElementById("lodgeDepositButton").value; 
    }
    else
    {
        document.getElementById("accID").value = null;
        document.getElementById("accID").value = document.getElementById("lodgeDepositButton").value; 
    }
}

function chooseLoan()
{
    document.getElementById("accountUsedID").value = "Loan";
    if(document.getElementById("accID").value == null)
    {
        document.getElementById("accID").value = document.getElementById("lodgeLoan").value; 
    }
    else
    {
        document.getElementById("accID").value = null;
        document.getElementById("accID").value = document.getElementById("lodgeLoanButton").value; 
    }
}

function checkSearch()
{
    var customerId = document.getElementById("customerID");
    var accountId = document.getElementById("accountID");

    if(customerId == "")
    {
        document.getElementById("customerID").setCustomValidity("No entry has been made in the searchbar");
        event.preventDefault;
    }
    else if(accountId == "")
    {
        document.getElementById("accountID").setCustomValidity("No entry has been made in the searchbar");
        event.preventDefault;
    }
    else
    {
        document.getElementById("customerID").setCustomValidity('');
    }
}


