//Student Name: Isaiah Andres
//Student Number: C00286361
//Date:25/02/2024
function confirmChoices()
{
    var confirmation
    confirmation = confirm("Are you sure the customer details are correct?"); //Confirmation text that pops up when details are about to be submitted
    if(confirmation)
    {   
        return true; //if confirmation is confirmed then the details will be submitted
    }
    else
    {
        event.preventDefault(); //if confirmation is denied then the details will be prevented from being submitted
        return false;
    }
}

function checkAge()
{
    var dob = new Date(document.getElementById("dobID").value); //variable to store the value of the date set  
    var today = new Date();
    var subtractionYears = today - dob //Subtracts the difference in time between the dates in miliseconds
    var difference = (subtractionYears/((1000 * 60 * 60 * 24)))/365; //calculation to turn the miliseconds involved into years for the age

    if (difference < 18) //If the start date is before the current date then the custom validity shows up
    {
        document.getElementById("dobID").setCustomValidity('The age must be above 18 or not come after the current date');
        event.preventDefault(); //prevents anything from submitting if the if statement is true
    } 
    else
    {
        document.getElementById("dobID").setCustomValidity('');//Allows the form to be submitted if the correct details are entered afterwards
    }
}

