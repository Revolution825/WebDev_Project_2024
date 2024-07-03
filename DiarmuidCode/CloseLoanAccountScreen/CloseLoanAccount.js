// Name : Diarmuid O'Neill
// Number : C00282898
// Description : Javascript file containing functions for closing a loan account
// Date : March 2024

function populate()
{
    // Populates main form from listbox
    var sel = document.getElementById("listbox");
    var result;
    result = sel.options[sel.selectedIndex].value;
    var customerDetails = result.split(', ');
    document.getElementById("showID").value = customerDetails[0];
    document.getElementById("showFirstName").value = customerDetails[1];
    document.getElementById("showLastName").value = customerDetails[2];
    document.getElementById("showAddress").value = customerDetails[3];
    document.getElementById("showEircode").value = customerDetails[4];
    document.getElementById("showDOB").value = customerDetails[5];
    document.getElementById("showTelephone").value = customerDetails[6];
    document.getElementById("showAccountID").value = customerDetails[7];
    document.getElementById("showBalance").value = customerDetails[8];
}

function toggleLock()   // function for enabling and disabling fields in the form
{
    document.getElementById("showID").disabled = false;
    document.getElementById("showFirstName").disabled = false;
    document.getElementById("showLastName").disabled = false;
    document.getElementById("showAccountID").disabled = false;
    document.getElementById("showBalance").disabled = false;
}

function lock() // locks form again so data cannot be altered
{
    document.getElementById("showID").disabled = true;
    document.getElementById("showFirstName").disabled = true;
    document.getElementById("showLastName").disabled = true;
    document.getElementById("showAccountID").disabled = true;
    document.getElementById("showBalance").disabled = true;
}

function confirmDelete()
{
    // Prompts user to confirm
    var response;

    response = confirm("Are you sure you want to delete the loan account specified?"); // Creates a confirmation pop-up
    if(response)
    {
        toggleLock();
        return true // Allows form to be send through to the database if it returns true
    }
    else 
    {
        return false
    }
}