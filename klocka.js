                                                                                                                                        
   var canvas,                                                                                                                                         
    context,                                                                                                                                           
    boatImage,                                                                                                                                         
    magnification,                                                                                                                                     
    scaleOfSourceImage=4; // Original image is 4 times as large (2560x1920px) as the displayed size (640x480px)                                        
                                                                                                                                                       
   window.onload=function(){                                                                                                                           
    canvas=document.getElementById("a");                                                                                                               
    context=canvas.getContext("2d");                                                                                                                   
    magnification=170;                                                                                                                                 
    boatImage=document.getElementById("taxiImage");                                                                                                    
    boatImage.addEventListener("mousemove",drawMagnification,false);                                                                                   
    boatImage.addEventListener("mousedown",setMagnification,false);                                                                                    
    boatImage.addEventListener('contextmenu', function(event){event.preventDefault();}, false); //Prevent the context menu to be displayed when right mouse button is clicked
   }                                                                                                                                                   
    //Sets level of magnification                                                                                                                      
    function setMagnification(event){                                                                                                                  
        //Check which mouse button is pressed down                                                                                                     
        if(event.which==3)          //Right mouse button                                                                                               
           magnification+=10;                                                                                                                          
        else                        //Left or middle mouse button                                                                                      
           magnification-=10;                                                                                                                          
        if(magnification>500) magnification=500;                                                                                                       
        if(magnification<10) magnification=10;                                                                                                         
        drawMagnification(event);                                                                                                                      
    }                                                                                                                                                  
                                                                                                                                                       
   function drawMagnification(event){                                                                                                                  
    //Get mouse position                                                                                                                               
    var positionOfTheGardenImageElement=findPos(event.target); //event.target is the image                                                             
    var x=event.pageX-positionOfTheGardenImageElement.x;                                                                                               
    var y=event.pageY-positionOfTheGardenImageElement.y;                                                                                               
                                                                                                                                                       
    //Clip the canvas                                                                                                                                  
    context.beginPath();                                                                                                                               
    context.arc(canvas.width*0.5, canvas.height*0.5, canvas.width*0.5, 0, Math.PI*2, false);                                                           
    context.closePath();                                                                                                                               
    context.fill();                                                                                                                                    
    context.clip();                                                                                                                                    
                                                                                                                                                       
    //Determine source x and y positions                                                                                                               
    var sx=x*scaleOfSourceImage-magnification*0.5;                                                                                                     
    var sy=y*scaleOfSourceImage-magnification*0.5;                                                                                                     
    if(sx<0) sx=0;                                                                                                                                     
    if(sy<0) sy=0;                                                                                                                                     
                                                                                                                                                       
    //Draw magnification of image in canvas                                                                                                            
    context.drawImage(boatImage,sx,sy,magnification,magnification,0,0,canvas.width,canvas.height);                                                     
                                                                                                                                                       
    //Draw circle around magnification                                                                                                                 
    context.lineWidth=4;                                                                                                                               
    context.beginPath();                                                                                                                               
    context.arc(canvas.width*0.5, canvas.height*0.5, canvas.width*0.5-1, 0, Math.PI*2, false);                                                         
    context.closePath();                                                                                                                               
    context.stroke();                                                                                                                                  
                                                                                                                                                       
    //Place the canvas element centered on the mouse position                                                                                          
    var canvasx=event.pageX-canvas.width*0.5;                                                                                                          
    var canvasy=event.pageY-canvas.height*0.5;                                                                                                         
    canvas.style.left=canvasx+"px";                                                                                                                    
    canvas.style.top=canvasy+"px";                                                                                                                     
   }                                                                                                                                                   
                                                                                                                                                       
   //Finds the position of any DOM element in the document by recursion - should work in most modern browsers                                          
   function findPos(obj) {                                                                                                                             
      var curleft = curtop = 0;                                                                                                                        
      if (obj.offsetParent) {                                                                                                                          
         curleft = obj.offsetLeft                                                                                                                      
         curtop = obj.offsetTop                                                                                                                        
         while (obj = obj.offsetParent) {                                                                                                              
            curleft += obj.offsetLeft                                                                                                                  
            curtop += obj.offsetTop                                                                                                                    
         }                                                                                                                                             
      }                                                                                                                                                
      return {x:curleft, y:curtop} //Returns the position of the element as an object                                                                  
   }                                                                                                                                                   
                                                                                                                                                       
   </script>   