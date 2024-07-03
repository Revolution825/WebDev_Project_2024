// Name : Diarmuid O'Neill
// Number : C00282898
// Description : Javascript file containing functions for amending and viewing loan accounts
// Date : March 2024

function lock() // locks form again so data cannot be altered
{
    document.getElementById("showAccountID").disabled = true;
    document.getElementById("showTerm").disabled = true;
    document.getElementById("showLoanAmount").disabled = true;
    document.getElementById("showMonthlyRepayments").disabled = true;
    document.getElementById("showBalance").disabled = true;
}

function toggleLock()   // function for enabling and disabling fields in the form
{
    if (document.getElementById("amendViewbutton").value == "Amend Details")
    { 
        document.getElementById("showTerm").disabled = false;
        document.getElementById("showLoanAmount").disabled = false;
        document.getElementById("amendViewbutton").value = "View Details";
    }
    else
    {
        document.getElementById("showTerm").disabled = true;
        document.getElementById("showLoanAmount").disabled = true;
        document.getElementById("amendViewbutton").value = "Amend Details";
    }
}

function confirmCheck() // Confirming changes
{
    var response;
    response = confirm('Are you sure you want to save these changes?')
    if (response)
    {
        document.getElementById("showAccountID").disabled = false;
        document.getElementById("showTerm").disabled = false;
        document.getElementById("showLoanAmount").disabled = false;
        document.getElementById("showMonthlyRepayments").disabled = false;
        document.getElementById("showBalance").disabled = false;
        updateRepayments();
        return true
    }
    else
    {
        populate();
        toggleLock();
        return false;
    }
}

function updateRepayments()
{
    // Calculates monthly interest rate and updates relavent field in form
    var term =document.getElementById("showTerm").value;
    var amountReq =document.getElementById("showLoanAmount").value;
    
    var monthlyInterest = InterestRate/12;  // Change annual interest rate to monthly interest rate

    var monthlyRepayment = ((amountReq*monthlyInterest) / (1 - Math.pow(1+monthlyInterest, -term))).toFixed(2); // Formula for monthly payment rounded to 2 decimel places

    document.getElementById("showMonthlyRepayments").value=monthlyRepayment;
}

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
    document.getElementById("showTerm").value = customerDetails[9];
    document.getElementById("showLoanAmount").value = customerDetails[10];
    document.getElementById("showMonthlyRepayments").value = customerDetails[11];
}