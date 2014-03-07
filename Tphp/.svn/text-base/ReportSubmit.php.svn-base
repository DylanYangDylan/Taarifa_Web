<?php 

//  "mainReport" : { "idForm": idForm, "Title": strTitle, "Descript": txtDescription, "ReportDate": dateReport, "ReportAddDate": dateAddReport, "SimCardSn": phoneNumber  },
//  "additionReport" : { array of { "id" : idField, "value" : valField } },
//  "user" : { "firstName" : firstName, "lastName": lastName, "email": email },
//  "location" : { "lat": lat, "lng": lng },
//  "categoriesList" : { array of idCategory },

error_reporting(E_ALL ^ E_NOTICE);
$rep=$_POST['Report'];
$json = str_replace('\"', '"', $_POST['Report'] );


	include("mysql_connect.php");

$req_dump = print_r( $json, TRUE);
$fp = fopen('FULL_Request'.date("Y_m_d_H_i_s").'.log', 'a');
fwrite($fp, $req_dump);
fclose($fp);

	 
	$objReport = json_decode( $json );

$req_dump = print_r( $objReport, TRUE);
$fp = fopen('request'.date("Y_m_d_H_i_s").'.log', 'a');
fwrite($fp, $req_dump);
fclose($fp);

$fx = fopen('look'.date("Y_m_d_H_i_s").'.log', 'a');
fwrite($fx, $rep);
fclose($fx);

$SqlCommandForEmail = 'Select `id` from `users` where `email` = "'.$objReport->user->email.'"';
$resultMail = mysql_query($SqlCommandForEmail);
$resultMailEach = mysql_fetch_array($resultMail);
$Mail_rows = mysql_num_rows($resultMail);

	if( isset( $objReport ) )
	{
	
		$position = $objReport->location->lat . "," . $objReport->location->lng;

		$strSqlCommand = 'INSERT INTO location (location_name, latitude, longitude, location_visible ) 
							VALUES ("'.$position.'", "'.$objReport->location->lat . '","' . $objReport->location->lng.'", 1)';
		if (!mysql_query($strSqlCommand))
 		{
	 		echo '<Error Message="'.mysql_error().'" Domain="UserUpload" />';
			error_log( "[".date("Y-m-d H:i:s")."] : ".mysql_error()."\n", 3, "upload-errors.log" );  
			error_log( $strSqlCommand."\n", 3, "upload-errors.log" );  
				
			exit;
 		}

		// Get New Media ID
		$idLocation= mysql_insert_id();	
		
		if($objReport->mainReport->idGroup==0){
		//Insert a New Group to SQL and Change ggroup_id FROM incident table
			$strSqlCommand20131111  = "INSERT INTO `GGroup` (`GGroup_Name`) VALUES ('".$objReport->mainReport->Title."');";
				mysql_query($strSqlCommand20131111);
			$strSqlCommand20131111_1  = "SELECT `id` FROM `GGroup` WHERE `GGroup_Name`='".$objReport->mainReport->Title."'";
				$Analysis = mysql_query($strSqlCommand20131111_1);
				while($rowAnalysis = mysql_fetch_array($Analysis)){
					$Forggroup_iduse = $rowAnalysis['id'];
				}
		
		//Group Version For Report Title is New Group
		//distinct by enter right email let user can view report 
			if($Mail_rows==0){
				$strSqlCommand = 'INSERT INTO incident (location_id, ggroup_id, form_id, user_id, incident_title, 
									incident_description, incident_date, incident_dateadd, incident_zoom ) 
									VALUES ("'.$idLocation.'", "'.$Forggroup_iduse.'", "'.$objReport->mainReport->idForm . '", 1, "' . $objReport->mainReport->Title.'",  
									"'.$objReport->mainReport->Descript.'", "'.$objReport->mainReport->ReportDate.'", "'.$objReport->mainReport->ReportAddDate.'", 6)';
			}else{
				$strSqlCommand = 'INSERT INTO incident (location_id, ggroup_id, form_id, user_id, incident_title, 
									incident_description, incident_date, incident_dateadd, incident_zoom ) 
									VALUES ("'.$idLocation.'", "'.$Forggroup_iduse.'", "'.$objReport->mainReport->idForm . '", "'.$resultMailEach['id'].'", "' . $objReport->mainReport->Title.'",  
									"'.$objReport->mainReport->Descript.'", "'.$objReport->mainReport->ReportDate.'", "'.$objReport->mainReport->ReportAddDate.'", 6)';
			}
			
			if (!mysql_query($strSqlCommand))
 			{
	 			echo '<Error Message="'.mysql_error().'" Domain="UserUpload" />';
				error_log( "[".date("Y-m-d H:i:s")."] : ".mysql_error()."\n", 3, "upload-errors.log" );  
				error_log( $strSqlCommand."\n", 3, "upload-errors.log" );  
				
				exit;
 			}	
		
		}
		else{
		//Group Version For Group DorpDown List
		//distinct by enter right email let user can view report 
			if($Mail_rows==0){
				$strSqlCommand = 'INSERT INTO incident (location_id, ggroup_id, form_id, user_id, incident_title, 
									incident_description, incident_date, incident_dateadd, incident_zoom ) 
									VALUES ("'.$idLocation.'", "'.$objReport->mainReport->idGroup.'", "'.$objReport->mainReport->idForm . '", 1, "' . $objReport->mainReport->Title.'",  
									"'.$objReport->mainReport->Descript.'", "'.$objReport->mainReport->ReportDate.'", "'.$objReport->mainReport->ReportAddDate.'", 6)';
			}else{
				$strSqlCommand = 'INSERT INTO incident (location_id, ggroup_id, form_id, user_id, incident_title, 
									incident_description, incident_date, incident_dateadd, incident_zoom ) 
									VALUES ("'.$idLocation.'", "'.$objReport->mainReport->idGroup.'", "'.$objReport->mainReport->idForm . '", "'.$resultMailEach['id'].'", "' . $objReport->mainReport->Title.'",  
									"'.$objReport->mainReport->Descript.'", "'.$objReport->mainReport->ReportDate.'", "'.$objReport->mainReport->ReportAddDate.'", 6)';
			}
			
			if (!mysql_query($strSqlCommand))
 			{
	 			echo '<Error Message="'.mysql_error().'" Domain="UserUpload" />';
				error_log( "[".date("Y-m-d H:i:s")."] : ".mysql_error()."\n", 3, "upload-errors.log" );  
				error_log( $strSqlCommand."\n", 3, "upload-errors.log" );  
				
				exit;
 			}
		}
		
		// Get New Media ID
		$idReport= mysql_insert_id();
					
		//if (is_array($Data)) {
			foreach ((array)$objReport->additionReport as $Data)
			{			
				$strSqlCommand = 'INSERT INTO form_response (form_field_id, incident_id, form_response ) 
									VALUES ('.$Data->id.', '.$idReport . ', "'.$Data->value.'")';
				if (!mysql_query($strSqlCommand))
				{
					echo '<Error Message="'.mysql_error().'" Domain="UserUpload" />';
					error_log( "[".date("Y-m-d H:i:s")."] : ".mysql_error()."\n", 3, "upload-errors.log" );  
					error_log( $strSqlCommand."\n", 3, "upload-errors.log" );  
						
					exit;
				}		
			}
		//}
		
		
		
		$strSqlCommand = 'INSERT INTO incident_person (incident_id, location_id, person_first, person_last, person_email, person_date)
							VALUES ('.$idReport.', '.$idLocation.', "'.$objReport->user->firstName . '", "' . $objReport->user->lastName.'", "'.$objReport->user->email.'", "'.$objReport->mainReport->ReportAddDate.'")';
		if (!mysql_query($strSqlCommand))
 		{
	 		echo '<Error Message="'.mysql_error().'" Domain="UserUpload" />';
			error_log( "[".date("Y-m-d H:i:s")."] : ".mysql_error()."\n", 3, "upload-errors.log" );  
			error_log( $strSqlCommand."\n", 3, "upload-errors.log" );  
				
			exit;
 		}
		
		
		//save SimCardNo
		
		$strSqlCommand = 'INSERT INTO incident_phone (incident_id, phoneNumber, JSONValue)
							VALUES ('.$idReport.', "'.$objReport->mainReport->SimCardSn.'", "'.mysql_real_escape_string($rep).'")';
		if (!mysql_query($strSqlCommand))
 		{
	 		echo '<Error Message="'.mysql_error().'" Domain="UserUpload" />';
			error_log( "[".date("Y-m-d H:i:s")."] : ".mysql_error()."\n", 3, "upload-errors.log" );  
			error_log( $strSqlCommand."\n", 3, "upload-errors.log" );  
				
			exit;
 		}
		
		
		foreach ((array)$objReport->categoriesList as $Data)
		{
			$strSqlCommand = 'INSERT INTO incident_category (incident_id, category_id ) 
								VALUES ('.$idReport.', '.$Data.')';
			if (!mysql_query($strSqlCommand))
			{
				echo '<Error Message="'.mysql_error().'" Domain="UserUpload" />';
				error_log( "[".date("Y-m-d H:i:s")."] : ".mysql_error()."\n", 3, "upload-errors.log" );  
				error_log( $strSqlCommand."\n", 3, "upload-errors.log" );  
					
				exit;
			}	
		}
		
		$Items = array( 'incident_id' =>$idReport , 'location_id' => $idLocation );
		
		$Items = str_replace('\"', '"', $Items );
		echo json_encode($Items);
	}
	
?>	