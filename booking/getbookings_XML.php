<?PHP
			// Get bookings made for a certain resourceID and a certain date.
			//     Note: more than one can be returned as you can book more than one position, depending on the size attribute of the resource 

			// Input:  resourceID, date, type
			// Output: resourceID, name, location, company, size, cost, category, date, dateto, bookingcount, bookingcost, bookingclass, remaining
			//         returns each availabile slot for that resource

			header ("Content-Type:text/xml; charset=utf-8");  
			include 'dbconnect.php';
			
			dbConnect();
			
			$querystring="SELECT resource.size,resource.type,booking.customerID,booking.resourceID,resource.name,resource.company,resource.location,DATE_FORMAT(booking.date,'%Y-%m-%d %H:%i') as date,DATE_FORMAT(booking.dateto,'%Y-%m-%d %H:%i') as dateto,booking.cost,booking.rebate,booking.position,booking.status,auxdata FROM booking,resource where resource.ID=booking.resourceID ";

			if(isset($_POST['date'])) $querystring.=" and date='".urldecode($_POST['date'])."'";
			if(isset($_POST['resourceID'])) $querystring.=" and resourceID='".htmlentities(urldecode($_POST['resourceID']))."'";
			if(isset($_POST['type'])) $querystring.=" and resource.type='".htmlentities(urldecode($_POST['type']))."'";

			$querystring.=" order by resourceid,position";
			$innerresult=mysql_query($querystring);
			
			if (!$innerresult) err("SQL Query Error: ".mysql_error(),"Conference filter database querying error");
			
			echo "<bookings>\n";
			while ($innerrow = mysql_fetch_assoc($innerresult)) {
					// At the moment do nothing!
					echo "<booking \n";
					echo "    application='".presenthtml($innerrow['type'])."'\n";
					echo "    customerID='".presenthtml($innerrow['customerID'])."'\n";
					echo "    resourceID='".presenthtml($innerrow['resourceID'])."'\n";
					echo "    name='".presenthtml($innerrow['name'])."'\n";
					echo "    company='".presenthtml($innerrow['company'])."'\n";
					echo "    location='".presenthtml($innerrow['location'])."'\n";
					echo "    date='".$innerrow['date']."'\n";
					echo "    dateto='".$innerrow['dateto']."'\n";
					echo "    position='".$innerrow['position']."'\n";
					echo "    status='".$innerrow['status']."'\n";
					echo "    cost='".$innerrow['cost']."'\n";				
					echo "    size='".$innerrow['size']."'\n";				
					echo "    auxdata='".presenthtml($innerrow['auxdata'])."'\n";				
					echo " />\n";
					echo "\n";
			}				
			echo "</bookings>\n";
						
?>
