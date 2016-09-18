<?PHP
			// Get the availability for a certain resource 
			//     Note: if several dates are available, all dates are returned

			// Input:  resourceID type
			// Output: resourceID name location company size cost category date dateo bookingcount bookingcost bookingclass remaining
			//         returns each availabile slot for that resource
			
			header ("Content-Type:text/xml; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
						
			$resourceid=getpostAJAX("resourceID");
			$type=getpostAJAX("type");

			$querystring="SELECT DATE_FORMAT(date,'%Y-%m-%d %H:%i') as date,DATE_FORMAT(dateto,'%Y-%m-%d %H:%i') as dateto,resourceID,name,location,company,size,cost,category FROM resource,resourceavailability where resourceavailability.resourceID=resource.ID ";

			if(isset($_POST['resourceID'])&&isset($_POST['type'])){
					$querystring.=" and resourceID='".$resourceid."' and type='".$type."'";
			}else if(isset($_POST['type'])){
					$querystring.=" and type='".$type."'";
			}else if(isset($_POST['resourceID'])){
					$querystring.=" and resourceID='".$resourceid."'";
			}

			$querystring.=" order by resourceID,date ";
			$innerresult=mysql_query($querystring);
			
			if (!$innerresult) err("SQL Query Error: ".mysql_error(),"Conference filter database querying error");

			echo "<avail>\n";
			while ($innerrow = mysql_fetch_assoc($innerresult)) {

					echo "<availability \n";
					
					$querystring="SELECT count(*) as counted FROM booking where resourceid='".$innerrow['resourceID']."' and date='".$innerrow['date']."'";
					$sinnerresult=mysql_query($querystring);
					if (!$sinnerresult) err("SQL Query Error: ".mysql_error()."Counting Error");
					while ($sinnerrow = mysql_fetch_assoc($sinnerresult)) {
							$counted=$sinnerrow['counted'];
					}
					$size=$innerrow['size']; 
					$bookingpercent=($counted/$size);
					$cost=$innerrow['cost'];
					$remaining=$size-$counted;
					
					// Static Price
					$bookingclass=0;
					$bookingcost=$cost;

					echo "    resourceID='".presenthtml($innerrow['resourceID'])."'\n";
					echo "    name='".presenthtml($innerrow['name'])."'\n";
					echo "    location='".presenthtml($innerrow['location'])."'\n";
					echo "    company='".presenthtml($innerrow['company'])."'\n";
					echo "    size='".$innerrow['size']."'\n";
					echo "    cost='".$innerrow['cost']."'\n";
					echo "    category='".$innerrow['category']."'\n";
					echo "    date='".$innerrow['date']."'\n";
					echo "    dateto='".$innerrow['dateto']."'\n";
					echo "    bookingcount='".$counted."'\n";
					echo "    bookingcost='".$bookingcost."'\n";
					echo "    bookingclass='".$bookingclass."'\n";
					echo "    remaining='".$remaining."'\n";

					echo " />\n";
					echo "\n";

			}				
			echo "</avail>\n";
						
?>