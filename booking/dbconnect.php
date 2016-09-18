<?PHP
			//---------------------------------------------------------------------------------------------------------------
			// presenthtml - Allows us to pass national characters - & is replaced with %
			//---------------------------------------------------------------------------------------------------------------

			function presenthtml($str) {
					return str_replace("&","%",htmlentities($str));
			}

			//---------------------------------------------------------------------------------------------------------------
			// getpost - Allows us to pass posts even if array position does not exist
			//---------------------------------------------------------------------------------------------------------------

			function getpost($param) {
					if(isset($_POST[$param])){
							$ret=$_POST[$param];
					}else{
							$ret="";			
					}
					return $ret;
			}
			
			//---------------------------------------------------------------------------------------------------------------
			// getpostAJAX - Allows us to pass posts even if array position does not exist
			//---------------------------------------------------------------------------------------------------------------

			function getpostAJAX($param) {
					if(isset($_POST[$param])){
							$ret=mysql_real_escape_string(htmlentities(urldecode($_POST[$param])));
					}else{
							$ret="";			
					}
					return $ret;
			}

			

			//---------------------------------------------------------------------------------------------------------------
			// cntparam - Counts number of booleans that are true
			//---------------------------------------------------------------------------------------------------------------

			function cntparam($p1,$p2,$p3,$p4) {
					$cnt=0;
					if($p1) $cnt++;
					if($p2) $cnt++;
					if($p3) $cnt++;
					if($p4) $cnt++;				
					return $cnt;
			}

			//---------------------------------------------------------------------------------------------------------------
			// err - Displays nicely formatted error and exits
			//---------------------------------------------------------------------------------------------------------------
			
			function err($errmsg,$hdr='') {
					echo "<span class=\"err\">Serious Error: <br/><i>$errmsg</i></span>";
					exit;
			}
			
			//---------------------------------------------------------------------------------------------------------------
			// dbConnect - Makes database connection
			//---------------------------------------------------------------------------------------------------------------
			
			function dbConnect() {
				
				$printHeaderFunction=0;
				
				// send header info to err()?
				if ($printHeaderFunction) {
					$hdr = 'Database Connect Error';
				} else {
					$hdr = '';
				}

				// Connect to DB server
				$OC_db = mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or err("could not connect to database ".mysql_errno(),$hdr);
			
				// Select DB
				mysql_select_db(DB_NAME) or err("could not select database \"".DB_NAME."\" error code".mysql_errno(),$hdr);
				
			}

			define("DB_USER","");
			define("DB_PASSWORD","");
			define("DB_HOST","localhost");
			define("DB_NAME","BookingSystem");


?>
