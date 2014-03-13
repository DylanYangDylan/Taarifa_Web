<?php       
   require_once('mysql/mysql.class.php');       		                   
   if( $_POST['title'])
   {            
      $MysqlObj = new SQLObj(); 
      $MysqlObj->connect();	
      SavePersonInfo($MysqlObj,$_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['datetime']);
      SaveIncident($MysqlObj,$_POST['title'],$_POST['description'],$_POST['datetime']);
      SaveLocation($MysqlObj,$_POST['longitude'],$_POST['latitude'],$_POST['datetime']);                                      
   }
   function SavePersonInfo($MysqlObj , $FirstName,$LastName,$Email,$DateTime)
   {      
      $strSQL = sprintf("insert into incident_person(person_first,person_last,person_email,person_date)values('%s','%s','%s','%s')",
                          $FirstName,$LastName,$Email,$DateTime);                                                                                                                                                                                                                                                                                                                                                      
      $MysqlObj->RunSQL($strSQL);         
   }

   function SaveIncident($MysqlObj , $ReportTitle,$Description,$DateTime)
   {                 
      $strSQL = sprintf("insert into incident(incident_title,incident_description,incident_date)values('%s','%s','%s')",
                          $ReportTitle,$Description,$DateTime);                                                                                                                                                                                                                                                                                                                                                      
      $MysqlObj->RunSQL($strSQL);               
   }
            
   function SaveLocation($MysqlObj , $Lai,$Long,$DateTime)
   {   
      $strSQL = sprintf("insert into location(latitude,longitude,location_date)values(%s,%s,'%s')",
                        $Lai,$Long,$DateTime);                                                                                                                                                                                                                                                                                                                                                      
      $MysqlObj->RunSQL($strSQL);         
   }        
?> 