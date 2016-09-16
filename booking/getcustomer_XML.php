<?PHP
			header ("Content-Type:text/xml; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			$customerID=getpostAJAX("customerID");
			
			$querystring="SELECT * FROM customer";
			if(isset($_POST['customerID'])){
					$querystring.=" WHERE ID='".$customerID."'";
			}
			$innerresult=mysql_query($querystring);
			
			if (!$innerresult) err("SQL Query Error: ".mysql_error(),"Conference filter database querying error");

			echo "<customers>\n";
			while ($innerrow = mysql_fetch_assoc($innerresult)) {
					// At the moment do nothing!
					echo "<customer \n";
					echo "    id='".presenthtml($innerrow['ID'])."'\n";
					echo "    firstname='".presenthtml($innerrow['firstname'])."'\n";
					echo "    lastname='".presenthtml($innerrow['lastname']." ")."'\n";
					echo "    address='".presenthtml($innerrow['address'])."'\n";
					echo "    lastvisit='".presenthtml($innerrow['lastvisit'])."'\n";
					echo "    email='".presenthtml($innerrow['email'])."'\n";
					echo " />\n";
					echo "\n";
			}				
			echo "</customers>\n";

			if(isset($_POST['customerID'])){
					$querystring="UPDATE customer SET lastvisit=now() WHERE ID='".$customerID."'";
					$innerresult=mysql_query($querystring);
					if (!$innerresult) err("SQL Query Error: ".mysql_error(),"Customer Update Error");
			}
						
?>
