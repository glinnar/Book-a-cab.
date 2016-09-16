<?PHP
			header ("Content-Type:text/xml; charset=utf-8");  

			include 'dbconnect.php';
			
			dbConnect();

			$name=getpostAJAX("name");
			$ID=getpostAJAX("ID");
			$firstname=getpostAJAX("firstname");
			$lastname=getpostAJAX("lastname");
			$address=getpostAJAX("address");
			$email=getpostAJAX("email");

			if (empty($ID) || empty($firstname) || empty($lastname) || empty($address) || empty($email)) err("Missing Form Data","");

			$querystring="INSERT INTO customer(lastvisit,ID, firstname,lastname,address,email) values (NOW(),'".$ID."','".$firstname."','".$lastname."','".$address."','".$email."');";
			$innerresult=mysql_query($querystring);								

			if (!$innerresult){
				err("Insert of Customer Error");
			}else{
					echo '<created status="OK"/>';
			}

?>