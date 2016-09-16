                                                                                                                       
        var isvalid=false;                                                                                                                             
        var size=0;  

// lagarar kund
function storeCustomer()                    
   { 
   var customerID=document.getElementById("customerID").value;                          
    var firstname=document.getElementById("firstname").value;                  
    var lastname=document.getElementById("lastname").value;                                                       
    var email=document.getElementById("email").value;                                                 
    var address=document.getElementById("address").value;
         
    $.ajax({
     type: 'POST',
     url: 'booking/makecustomer_XML.php',                                                                     
     data: { ID: escape(customerID),                                                                         
      firstname: escape(firstname),                                                                                 
      lastname: escape(lastname),                                                                                      
      email: escape(email),                                                                                                    
      address: escape(address),                                                                          
     },
     success:  ResultCustomer                                                                                          
    });   
   }
// Returnerar kund
   function ResultCustomer(returnedData)                                                                                
   {                                                                                                                
    // Iterate over all nodes in root node (i.e. the 'created' element in root which has an attribute called status)
    for (i = 0; i < returnedData.childNodes.length; i++) {                                           
      if(returnedData.childNodes.item(i).nodeName=="created"){                                       
       
 alert("user is created");

                               
      }
 
    }
   }
                                                                                                                                       
      
// låter användaren logga in
function userLogin(){
if(!!$("#login").val()){
    customerID = $("#login").val(); 
  }else{
    return false;
  }
    $.ajax({
    type: 'POST',
    url: 'booking/getcustomer_XML.php',                                                                                       
    data: { customerID: escape(customerID)},                                                       
    success:  ResultCustomerID                                                                                      
   });
  } 

function ResultCustomerID(returnedData)                                                               
  {                                                                                                 
   var resultset=returnedData.childNodes[0];                                                          
   for (i = 0; i < resultset.childNodes.length; i++) {                                       
     if(resultset.childNodes.item(i).nodeName=="customer"){                                                                 
       var user=resultset.childNodes.item(i);
     username = user.attributes['id'].nodeValue;
     var userfound = true;                                                                            
     }
   }
   // No user was found, display error.
  if(!userfound) {
    alert("kom ej in");
  }
  // User was found, store session
  else {
  sessionStorage.setItem("username", username);

    window.location.href = "Medlem.html";
  }
}
// Medlemssidan
function Medlemssida(){

  var user = sessionStorage.getItem("username");
  if(user != null){
 $("h1#message").html(' Välkommen '+ user);
  } else{
     window.location.href = "Login.html";
  }
  

}
// Loggar ut 
function Logout() {
  sessionStorage.clear(); 
   window.location.href = "index.html";
   uppdateraKundvagn();   
}
// Bokar plats i resursen
    function bookPosition(position)    

    {                                                                                                                                                  
     var rebate=0;                                                                                                                                     
     var resource="Taxibil";                                                                                      
     var bookingdate=document.getElementById("date").value;                                                                                            
     var customer=sessionStorage.getItem("username"); 
     var status = 1; 
     


                                                                                                                                                       
          $.ajax({                                                                                                                                     
              type: 'POST',                                                                                                                            
              url: 'booking/makebooking_XML.php',                                                                                                   
              data: {  
                    Name: "a11gusli",                                                                                                                          
                   resourceID: resource,                                                                                                               
                   date: bookingdate,                                                                                                                  
                   customerID: customer,                                                                                                               
                   rebate: rebate,                                                                                                                     
                   status: status, // 2 = "Real" booking.                                                                                                 
                   position: position,                                                                                                                 
              type: 'a11gusli'    // Filter out bookings made from other applications application.                                                   
                                           // Most commonly user name of student                                                                       
              },                                                                                                                                       
              success:  bookingmade,                                                                                                                   
              error: errormsg                                                                                                                          
        });                                                                                                                                            
    }    // Bokning klar
              function bookingmade(returnedData)                                                                                                                 
    {        
    uppdateraKundvagn();                                                                                                                                           
      alert('Bil bokad!');                                                                                                                                
      processinputbox();
      getCustomer();  
                                                                                                                                  
    } 
      function errormsg(jqXHR,textStatus,errorThrown) {                                                                                                  
         alert(jqXHR.responseText);                                                                                                                     
    }     

       // Häntar användarnamn     
function getName(){

var customer=sessionStorage.getItem("username");  
   $('#resource').attr('placeholder',customer);
}
// Rutnätet där man kan trycka för att boka bil.
    function drawResult()                                                                                                                              
    {                                                                                                                                                  
     // Use size from initial ajax call                                                                                                                
     // Generate Table including booking Javascript calls                                                                                              
     var output="<table border='1'class='tablestuff' >";                                                                                                                  
     output+="<tr>";                                                                                                                                   
     var matchedbooking,matched;                                                                                                                       
     for(i = 0; i < size; i++) {                                                                                                                       
      matched=false;                                                                                                                                   
      for (j = 0; j < resultset.childNodes.length; j++) {                                                                                              
       if(resultset.childNodes.item(j).nodeName=="booking"){                                                                                           
        var booking=resultset.childNodes.item(j);                                                                                                      
        if(i==booking.attributes['position'].nodeValue){                                                                                               
         matchedbooking=booking;                                                                                                                       
         matched=true;                                                                                                                                 
        }                                                                                                                                              
       }                                                                                                                                               
      }                                                                                                                                                
                                                                                                                                                       
      if(matched){                                                                                                                                     
       output+="<td bgcolor='#ffeedd'>  </td>";                                                                                              
      }else{                                                                                                                                           
       output+="<td bgcolor='#ffffff' onclick='bookPosition("+i+")' style='cursor:pointer;'>  </td>";                                        
      }                                                                                                                                                
      if(i%4==3) output+="</tr><tr>";                                                                                                                  
     }                                                                                                                                                 
                                                                                                                                                       
     output+="</tr>";                                                                                                                                  
     output+="</table>"                                                                                                                                
     var div=document.getElementById('OutputDiv');                                                                                                     
     div.innerHTML=output;                                                                                                                             
    }                                                                                                                                                   
        function ResultBooking(returnedData)                                                                                                           
        {                                                                                                                                              
           // An XML DOM document is returned from AJAX                                                                                                
           resultset=returnedData.childNodes[0];                                                                                                       
           isvalid=true;                                                                                                                               
                                                                                                                                                       
           drawResult();                                                                                                                               
        }                                                                                                                                              
                                                                                                                                                       
        function ResultSize(returnedData)                                                                                                              
        {                                                                                                                                              
          // An XML DOM document is returned from AJAX                                                                                                 
          var resultsetsize=returnedData.childNodes[0];                                                                                                
                                                                                                                                                       
          // Iterate over all nodes in root node (i.e. resources)                                                                                      
          for (i = 0; i < resultsetsize.childNodes.length; i++) {                                                                                      
            if(resultsetsize.childNodes.item(i).nodeName=="resource"){                                                                                 
              var resource=resultsetsize.childNodes.item(i);                                                                                           
              size=resource.attributes['size'].nodeValue;                                                                                              
            }                                                                                                                                          
          }                                                                                                                                            
        }                                                                                                                                              
           
           // Hämtar bokningar och resurser                                                                                                                                            
        function processinputbox()                                                                                                                     
        {                                                                                                                                              
          resource= "Taxibil";                                                                                       
          bookingdate=document.getElementById("date").value;                                                                                           
                                                                                                                                                       
                $.ajax({                                                                                                                               
           type: 'POST',                                                                                                                               
           url: 'booking/getresourcesize_XML.php',                                                                                                  
           data: { resourceID: resource},                                                                                                              
           success:  ResultSize                                                                                                                        
          });                                                                                                                                          
                                                                                                                                                       
                                                                                                                                                       
                $.ajax({                                                                                                                               
           type: 'POST',                                                                                                                               
           url: 'booking/getbookings_XML.php',                                                                                                      
           data: {                                                                                                                                     
             resourceID: resource,                                                                                                                     
             date: bookingdate,                                                                                                                        
             type: 'a11gusli'    // Filter out bookings made from other applications application.                                                    
                                           // Most commonly user name of student                                                                       
           },                                                                                                                                          
           success:  ResultBooking                                                                                                                     
          });                                                                                                                                          
        }   


       function ResultBookingCustomer(returnedData)                                                                                                        
   {                                                                                                                                                   
    // An XML DOM document is returned from AJAX                                                                                                       
    var resultset=returnedData.childNodes[0];                                                                                                          
                                                                                                                                                       
    var output="<table>";                                                                                                                              
                                                                                                                                                       
    // Iterate over all nodes in root node (i.e. bookings)                                                                                             
    for (i = 0; i < resultset.childNodes.length; i++) {                                                                                                
     // Iterate over all child nodes of that node that are booking nodes                                                                               
     if(resultset.childNodes.item(i).nodeName=="booking"){                                                                                             
      // Retrieve first name and last name for node                                                                                                    
      var booking=resultset.childNodes.item(i);                                                                                                        
                                                                                                                                                       
      output+="<tr>";                                                                                                                                  
      output+="<td>"+booking.attributes['company'].nodeValue+"</td>";                                                                                  
      output+="<td>"+booking.attributes['name'].nodeValue+"</td>";                                                                                     
      output+="<td>"+booking.attributes['location'].nodeValue+"</td>";                                                                                 
      output+="<td>"+booking.attributes['date'].nodeValue+"</td>";                                                                                     
      output+="</tr>";                                                                                                                                 
                                                                                                                                                       
     }                                                                                                                                                 
    }                                                                                                                                                  
                                                                                                                                                       
    output+="</table>"                                                                                                                                 
    var div=document.getElementById('OutputDiv');                                                                                                      
    div.innerHTML=output;                                                                                                                              
   }                                                                                                                                                   
                // Hämtar kundbokningar                                                                                                                                       
   function getCustomer()                                                                                                                          
   {                                                                                                                                                   
    customer =document.getElementById("customerID").value;                                                                                             
          $.ajax({                                                                                                                                     
      type: 'POST',                                                                                                                                    
      url: 'booking/getcustomerbookings_XML.php',                                                                                                   
      data: {                                                                                                                                          
       customerID: escape(customer),                                                                                                                   
       type: 'a11gusli'    // Filter out bookings made from other applications application.                                                          
                             // Most commonly user name of student                                                                                     
      },                                                                                                                                               
      success:  ResultBookingCustomer,                                                                                                                 
     });                                                                                                                                               
   }  
   // uppdaterar kundvagnen
   function uppdateraKundvagn(){
    var customer=sessionStorage.getItem("username"); 
    $.ajax({
              type: 'POST',                                                                                         
              url: 'booking/getcustomerbookings_XML.php',                                                                 
              data: {                                                                                                      
                   customerID: escape(customer),                                                                                  
                   type: 'a11gusli'    // Filter out bookings made from other applications application.                 
                                           // Most commonly user name of student                                         
              },
              success:  function(returnedData){
          var resultset=returnedData.childNodes[0];
          var user = sessionStorage.getItem("username");
          var antal=0;
          var summa=0;                                                   
          for (i = 0; i < resultset.childNodes.length; i++) { 
                                                   
          if(resultset.childNodes.item(i).nodeName=="booking"){                            
            var resource=resultset.childNodes.item(i);     
            if(user==resource.attributes['customerID'].nodeValue){
              antal++;
            }
            summa += parseInt(resource.attributes['cost'].nodeValue);
          }
          }
          if(summa > 0){
            $("span#Kundvagn").html( antal + " resor bokade " + " | " + summa + "kr");
          }else{
            $("span#Kundvagn").html("Kundvagnen är tom");
          }
        }
        });
}