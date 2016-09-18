<?PHP
			header ("Content-Type:text/xml; charset=utf-8");  

			include 'dbconnect.php';
			
			dbConnect();
			
			//---------------------------------------------------------------------------------------------------------------
			// Search Query!
			//---------------------------------------------------------------------------------------------------------------
			
			$querystring="SELECT * FROM resource";

			$company=getpostAJAX("company");
			$type=getpostAJAX("type");
			$location=getpostAJAX("location");
			$name=getpostAJAX("name");
			$fulltext=getpostAJAX("fulltext");
			
			if(isset($_POST['type'])||isset($_POST['name'])||isset($_POST['company'])||isset($_POST['location'])||isset($_POST['fulltext'])) $querystring.=" WHERE";
			if(isset($_POST['type'])) $querystring.=" type='".$type."'";

			if(isset($_POST['name'])||isset($_POST['company'])||isset($_POST['location'])){
					if(isset($_POST['type'])){
							$querystring.=" and (";
					}else{
							$querystring.="(";
					}

					// Handle all the cases with 1/2/3 Parameters
					if(isset($_POST['name'])){
							$querystring.="name like '%".$name."%'";
							if(isset($_POST['company'])) $querystring.=" and company like '%".$company."%'";
							if(isset($_POST['location']))$querystring.=" and location like '%".$location."%'";
					}else{
							if(isset($_POST['company'])){
									$querystring.="company like '%".mysql_real_escape_string($_POST['company'])."%'";
									if(isset($_POST['location']))$querystring.=" and location like '%".$location."%'";
							}else{
									if(isset($_POST['location'])){
												$querystring.="location like '%".$location."%'";							
									}
							} 
					
					}	
					$querystring.=")";

			}else if(isset($_POST['fulltext'])){
					if(isset($_POST['type'])){
							$querystring.=" and (name like '%".$fulltext."%' or company like '%".$fulltext."%' or location like '%".$fulltext."%')";
					}else {
							$querystring.="(name like '%".$fulltext."%' or company like '%".$fulltext."%' or location like '%".$fulltext."%')";
					}
			}

			$innerresult=mysql_query($querystring);
			
			if (!$innerresult) err("SQL Query Error: ".mysql_error(),"Resource Search Error (".$querystring.")");

			echo "<resources>\n";
			while ($innerrow = mysql_fetch_assoc($innerresult)) {
					// At the moment do nothing!
					echo "<resource \n";
					echo "    id='".presenthtml($innerrow['ID'])."'\n";
					echo "    name='".presenthtml($innerrow['name'])."'\n";
					echo "    company='".presenthtml($innerrow['company'])."'\n";
					echo "    location='".presenthtml($innerrow['location'])."'\n";
					echo "    size='".presenthtml($innerrow['size'])."'\n";
					echo "    cost='".presenthtml($innerrow['cost'])."'\n";
					echo " />\n";
					echo "\n";
			}				
			echo "</resources>\n";
						
?>