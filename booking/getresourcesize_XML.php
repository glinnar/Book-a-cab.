<?PHP
			header ("Content-Type:text/xml; charset=utf-8");  

			include 'dbconnect.php';
			
			dbConnect();
			
			$resource=getpostAJAX("resourceID");
			
			$querystring="SELECT size FROM resource";
			if(isset($_POST['resourceID'])) $querystring.=" where ID='".$resource."'";

			$innerresult=mysql_query($querystring);
			
			if (!$innerresult) err("SQL Query Error: ".mysql_error(),"Resource Search Error (".$querystring.")");

			echo "<resources>\n";
			while ($innerrow = mysql_fetch_assoc($innerresult)) {
					// At the moment do nothing!
					echo "<resource \n";
					echo "    size='".$innerrow['size']."'\n";
					echo " />\n";
					echo "\n";
			}				
			echo "</resources>\n";
						
?>
