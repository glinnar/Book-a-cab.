<?PHP
			// Get the availability for a certain resource by searching name, location and company in addition to the type

			// Input:  name, location, company, type
			// Output: resourceID, name, location, company, size, cost, category, date, dateto, bookingcount, bookingcost, bookingclass, remaining
			//         returns each availabile slot for that resource
			
			header ("Content-Type:text/xml; charset=utf-8");  

			include 'dbconnect.php';
			
			dbConnect();
			
			$name=getpostAJAX("name");
			$location=getpostAJAX("location");
			$company=getpostAJAX("company");
			$type=getpostAJAX("type");

			$querystring="SELECT DATE_FORMAT(date,'%Y-%m-%d %H:%i') as date,DATE_FORMAT(dateto,'%Y-%m-%d %H:%i') as dateto,resourceID,name,location,company,size,cost,category FROM resource,resourceavailability where resourceavailability.resourceID=resource.ID ";

			// Search i.e. if either name location or company are set
			if(cntparam(isset($_POST['name']),isset($_POST['location']),isset($_POST['company']),0)>1){	
					$querystring.=" and (";
					if(isset($_POST['name'])){
							$querystring.="resource.name like '%".$name."%'";
							if(isset($_POST['location'])) $querystring.="or resource.location like '%".$location."%'";
							if(isset($_POST['company'])) $querystring.="or resource.company like '%".$company."%'";
					}else{
							if(isset($_POST['location'])){
									// Location is set, perhaps also company
									$querystring.="resource.location like '%".$location."%'";						
									if(isset($_POST['company'])) $querystring.="or resource.company like '%".$company."%'";
							}else{
									// Neither name or location, must be company
									$querystring.="resource.company like '%".$company."%'";						
							}
					}
					$querystring.=")";					
			}else if(isset($_POST['name'])){
							$querystring.="and resource.name like '%".$name."%'";
			}else if(isset($_POST['location'])){
							$querystring.="and resource.location like '%".$location."%'";
			}else if(isset($_POST['company'])){
							$querystring.="and resource.company like '%".$company."%'";
			}
			if(isset($_POST['type'])){
					$querystring.="and resource.type='".$type."'";
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
					$remaining=$size-$counted;

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
					echo "    remaining='".$remaining."'\n";

					echo " />\n";
					echo "\n";

			}				
			echo "</avail>\n";

?>