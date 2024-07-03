// Name : Diarmuid O'Neill
// Number : C00282898
// Description : Javascript file containing functions for opening a loan account
// Date : Feb 2024

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
    document.getElementById("showDOB").value = customerDetails[4];
    document.getElementById("showTelephone").value = customerDetails[5];
}

function update()
{
    // Calculates monthly interest rate and updates relavent field in form
    var term = document.getElementById("term").value;
    var amountReq = document.getElementById("amountReq").value;

    var monthlyInterest = InterestRate/12;  // Change annual interest rate to monthly interest rate

    var monthlyRepayment = ((amountReq*monthlyInterest) / (1 - Math.pow(1+monthlyInterest, -term))).toFixed(2); // Formula for monthly payment rounded to 2 decimel places

    document.getElementById("monthly").value=monthlyRepayment;
}

function confirmCheck()
{
    // Prompts user to confirm
    var response;
    response = confirm("Are you sure you have entered the correct details before creating a new loan account? "); // Creates a confirmation pop-up
    if(response)
    {
        toggleLock2();
        return true // Allows form to be send through to the database if it returns true
    }
    else 
    {
        return false
    }
}

function toggleLock()   // function for enabling and disabling fields in the form
{
        document.getElementById("showID").disabled = false;
        document.getElementById("showFirstName").disabled = false;
        document.getElementById("showLastName").disabled = false;
}

function lock() // locks form again so data cannot be altered
{
    document.getElementById("showID").disabled = true;
    document.getElementById("showFirstName").disabled = true;
    document.getElementById("showLastName").disabled = true;
}

function toggleLock2()   // function for enabling and disabling fields in the form
{
    document.getElementById("showID").disabled = false;
    document.getElementById("monthly").disabled = false;
        
}

function lock2() // locks form again so data cannot be altered
{
    document.getElementById("showID").disabled = true;
    document.getElementById("monthly").disabled = true;
}