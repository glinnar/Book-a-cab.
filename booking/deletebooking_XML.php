<?PHP
			header ("Content-Type:text/xml; charset=utf-8");  

			include 'dbconnect.php';
			
			dbConnect();
			
			// Get and escape the variables from post
			$resource=getpostAJAX("resourceID");
			$date=getpostAJAX("date");
			$user=getpostAJAX("customerID");

			$innerresult=0;
			$querystring="";
			
			if((isset($_POST['resourceID']))&&(isset($_POST['date']))&&(isset($_POST['customerID']))){
					// Delete temp bookings for this user
					$querystring="DELETE FROM booking WHERE customerID='".$user."' and date='".$date."' and resourceID='".$resource."'";
					$innerresult=mysql_query($querystring);		
			}

			if (!$innerresult){
					err("Could not delete booking for user: ".$user." ".$querystring."\n",""); 
			}else{
					echo '<deleted status="OK"/>';
			}


?>