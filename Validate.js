


function checkLength(textInput, lowerLimit, upperLimit){
    if(textInput.value.length>=lowerLimit && textInput.value.length<=upperLimit) textInput.className="isValid";
    else textInput.className="isNotValid";
}



function validatenumber(telefon)
{
    var number = /^[0-9]{10}$/;
    if(telefon.value.match(number))
    {

    }
    else
    {
        if(!telefon.value.match(number))
        {
            alert("Det får bara finnas siffror, max 10 stycken T.ex. 0777-727272");
        }
    }
}

function validateForm() {
    var x =  document.getElementById("customerID").value;
    if (x == null || x == "") {
        alert("Ett KundID måste fyllas i");
        return false;
    }
    var x =  document.getElementById("firstname").value;
    if (x == null || x == "") {
        alert("Ett förnamn måste fyllas i");
        return false;
    }
    var x =  document.getElementById("lastname").value;
    if (x == null || x == "") {
        alert("Ett Efternamn måste fyllas i");
        return false;
    }
    var x=document.getElementById("email").value;
    var atpos=x.indexOf("@");
    var dotpos=x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
    {
        alert("Not a valid e-mail address");
        return false;
    }
    var x =  document.getElementById("address").value;
    if (x == null || x == "") {
        alert("En adress måste fyllas i");
        return false;
    }

}
function validateKontakt() {
    var x = document.forms["Kontakt"]["Fnamn"].value;
    if (x == null || x == "") {
        alert("First name must be filled out");
        return false;
    }
    var x = document.forms["Kontakt"]["Enamn"].value;
    if (x == null || x == "") {
        alert("First name must be filled out");
        return false;
    }

    var x = document.forms["Kontakt"]["email"].value;
    var atpos=x.indexOf("@");
    var dotpos=x.lastIndexOf(".");
    if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
    {
        alert("Not a valid e-mail address");
        return false;
    }
}