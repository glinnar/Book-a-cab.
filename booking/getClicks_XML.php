<?PHP
			header ("Content-Type:text/xml; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			$querystring="select count(*) as numberofclicks,clickdata,customerid,type from click ";

			if((isset($_POST['customerID']))&&(isset($_POST['type']))) $querystring.=" where customerID='".$_POST['customerID']."' and type='".$_POST['type']."'";
			else if(isset($_POST['customerID'])) $querystring.=" WHERE customerID='".$_POST['customerID']."'";
			else if(isset($_POST['type'])) $querystring.=" WHERE type='".$_POST['type']."'";
			
			$querystring.=" group by clickdata order by numberofclicks desc;";
			
			$innerresult=mysql_query($querystring);			
			if (!$innerresult) err("SQL Query Error: ".mysql_error(),"Conference filter database querying error");

			echo "<clicks>\n";
			while ($innerrow = mysql_fetch_assoc($innerresult)) {
					// At the moment do nothing!
					echo "<click \n";
					echo "    numberofclicks='".$innerrow['numberofclicks']."'\n";
					echo "    customerid='".$innerrow['customerid']."'\n";
					echo "    type='".$innerrow['type']."'\n";
					echo "    clickdata='".$innerrow['clickdata']."'\n";
					echo " />\n";
					echo "\n";
			}				
			echo "</clicks>\n";
						
?>