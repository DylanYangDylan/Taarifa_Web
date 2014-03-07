<?php
//"CategoriesList" :  [ idCate : { "idCate": idCate, "nameCate": name, "idParent": null / Parent_idCate } ]
//    "FormList" :  [ idForm : { "idForm": idForm, 
//                                        "rowData" : [ "Field_ID": idField, "Field_Name": strTitle, 
//														"Required": bIsRequired,
//                                                            "DataType": "Free Text"/"Numeric"/"Email"/"Phone #"] }

	include("mysql_connect.php");
		
	$strSqlCommand = "SELECT id, category_title, parent_id FROM category
						WHERE category_trusted != 1
						AND parent_id = 0
						AND category_visible = 1";
							
	$result = mysql_query($strSqlCommand);
//	$rowDetail = @mysql_fetch_array($result);	
        $catIdandPid=array();
	$Category = array();
	while($rowDetail = @mysql_fetch_array($result) )	
	{  
	
		array_push($catIdandPid,array("id"=>$rowDetail[0],"title"=>$rowDetail[1]));
		
		$strSqlCommand2 = "SELECT id, category_title, parent_id FROM category
							WHERE category_trusted != 1 
							AND category_visible = 1
							AND parent_id = '".$rowDetail[0]."'";
		 	
		$result2 = mysql_query($strSqlCommand2);
		
		//if parent category has sub category then ban it.
		if(mysql_num_rows($result2) == 0){
			//$Category[ $rowDetail[0] ] = array( "idCate" => $rowDetail[0], "nameCate" => $rowDetail[1], "idParent" => $rowDetail[2]);
		 	array_push($Category, array( "idCate" => $rowDetail[0], "nameCate" => $rowDetail[1], "idParent" => $rowDetail[2]));
		}
			
		while($rowDetail2 = @mysql_fetch_array($result2) )	
		{  	
			array_push($Category, array( "idCate" => $rowDetail2[0], "nameCate" => $rowDetail2[1], "idParent" => $rowDetail2[2]));
			//$Category[ $rowDetail2[0] ] = array( "idCate" => $rowDetail2[0], "nameCate" => $rowDetail2[1], "idParent" => $rowDetail2[2]);
		}
		
	}
	// 2012/12/14 Select All Form format to app
	$strSqlCommand = "SELECT id, form_title FROM form WHERE 1";
//						WHERE form_active = 1";
							
	$result = mysql_query($strSqlCommand);
//	$rowDetail = @mysql_fetch_array($result);	

	$FormList = array();
	while($rowForm = @mysql_fetch_array($result) )	
	{
		//2013/1/30 add 'tb1.field_default' in select field and marked  'AND tb2.option_name = \"field_datatype\"' tpo get all form_type
		$strSqlCommand = "SELECT tb1.id, tb1.field_name, tb1.field_required, tb1.field_type, tb2.option_value , tb1.field_default 
						FROM form_field tb1
						LEFT JOIN form_field_option tb2 ON tb2.form_field_id = tb1.id
						WHERE tb1.form_id = ".$rowForm[0] ;
						//AND tb2.option_name = \"field_datatype\"";

//var_dump( $strSqlCommand );						
		
		$resultField = mysql_query($strSqlCommand);
		$FieldList = array();
		while($rowField = @mysql_fetch_array($resultField) )
		{
			if($rowField[4]=="0")
			continue;
			
			switch ($rowField[3])
			{
				case '1':
					$fieldtype = 'textfield';
					break;
				case '2':
					$fieldtype = 'textarea';
					break;
				case '3':
					$fieldtype = 'date';
					break;
				case '4':
					$fieldtype = 'password';
					break;
				case '5':
					$fieldtype = 'radio';
					break;
				case '6':
					$fieldtype = 'checkbox';
					break;
				case '7':
					$fieldtype = 'spinner';
					break;
			}
			array_push($FieldList, array( "Field_ID" => $rowField[0], "Field_Name" => $rowField[1], "Required" => $rowField[2], "Field_Type" => $fieldtype, "Field_DataType" => $rowField[4],"Field_Default"=>$rowField[5] ));
			//$FieldList[ $rowField[0] ] = array( "Field_ID" => $rowField[0], "Field_Name" => $rowField[1], "Required" => $rowField[2], "Field_Type" => $fieldtype, "Field_DataType" => $rowField[4]);
		}		
		array_push($FormList, array( "idForm" => $rowForm[0], "nameForm" => $rowForm[1], "rowData" => $FieldList));
		//$FormList[ $rowForm[0] ] = array( "idForm" => $rowForm[0], "nameForm" => $rowForm[1], "rowData" => $FieldList);
	}
	
	//For_APK_Group
	$strSqlCommand4 = "SELECT id, GGroup_Name FROM GGroup WHERE 1";
	$result4 = mysql_query($strSqlCommand4);
	$FormList4 = array();
	array_push($FormList4, array( "idGroup" => '0', "nameGroup" => 'No Group'));
	while($rowGroup4 = mysql_fetch_array($result4)){
		//echo "what".$rowGroup4['id'];
		array_push($FormList4, array( "idGroup" => $rowGroup4['id'], "nameGroup" => $rowGroup4['GGroup_Name']));
	}//Group
	
	//while($rowGroup = @mysql_fetch_array($result4) )	
	//{	
	//	array_push($FormList4, array( "idGroup" => $rowGroup['id'], "nameGroup" => $rowGroup['GGroup_Name']));
	//}
	//echo "hehehe".$rowGroup[0];
	
	//$Items = array( 'CategoriesList' => $Category, 'FormList' => $FormList );
	$Items = array( 'CategoriesList' =>$Category , 'FormList' => $FormList,'catIdandPid'=>$catIdandPid ,'FormList4' => $FormList4);//Group
	echo json_encode($Items);
	
?>	
	