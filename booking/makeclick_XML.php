<?PHP
			header ("Content-Type:text/xml; charset=utf-8");  
			include 'dbconnect.php';
		
			dbConnect();

			$customerID=getpostAJAX("customerID");
			$type=getpostAJAX("type");
			$clickdata=getpostAJAX("clickdata");

			if(isset($_POST['customerID'])&&isset($_POST['customerID'])&&isset($_POST['customerID'])){
					$querystring="INSERT INTO click(time,type,customerID,clickdata) values (NOW(),'".mysql_real_escape_string($type)."','".mysql_real_escape_string($customerID)."','".mysql_real_escape_string($clickdata)."');";
					$innerresult=mysql_query($querystring);											
			}else{
					err("Click data was not passed to application");
			}

			if (!$innerresult){
					echo '<created status="Error: '.mysql_error().'"/>';			
			}else{
					echo '<created status="OK"/>';
			}

?>
