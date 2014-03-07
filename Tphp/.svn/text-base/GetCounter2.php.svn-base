<?php
header("Content-type: text/javascript");
	include("mysql_connect.php");
//category: id, parent_id, category_title, category_color, category_visible = 1, category_trusted = 0
//incident_category: incident_id, category_id
//incident: id, form_id

//form: id, form_active = 1
//form_field:id, form_id, field_name, field_required
//form_response: id, form_field_id, incident_id, form_response
//form_field_option: form_field_id, option_name = field_datatype, option_value = numeric

// Search for Counter for each Cateogry.
if( !isset( $_GET['Par'] ) || $_GET['Par'] == -1 )
{

	// Step 1.
	// Search all Category:
		$strSqlCommand = "	SELECT tbParent.id, tbParent.category_title, tbChild.id, tbChild.category_title
							FROM category tbParent
							LEFT JOIN category tbChild ON tbChild.parent_id = tbParent.id
							WHERE tbParent.parent_id = 0
							AND tbParent.category_trusted = 0
							AND tbParent.category_visible = 1
							AND tbParent.parent_id = 0
							AND tbParent.category_trusted = 0
							AND tbParent.category_visible = 1";
								
		$resultCate = mysql_query($strSqlCommand);
	$Items = array();
		$Items[ 'tittle' ] = array( "tittle" => "Category");
		while($rowCate = @mysql_fetch_array($resultCate) )	
		{
//			var_dump($rowCate);
			
			// Step 2.
			if( !isset( $_GET['Counter'] ) || $_GET['Counter'] == -1 )
			{
				// get Count of Category:
				$strSqlCommand = "	SELECT tbData.form_response
									FROM incident tbReport
									LEFT JOIN form_response tbData ON tbData.incident_id = tbReport.id
									LEFT JOIN incident_category tbCate ON tbCate.incident_id = tbReport.id
									WHERE tbData.form_field_id = ". $_GET['Counter'];
	
				if( $rowCate[2] == NULL)
				{
					$strSqlCommand .= " AND tbCate.category_id = ". $rowCate[0];
				}
				else
				{
					$strSqlCommand .= " AND tbCate.category_id = ". $rowCate[2];
				}
				
				$resultCount = mysql_query($strSqlCommand);
				
				$rowCount = @mysql_fetch_array($resultCount);
				
				if( $rowCate[2] == NULL)
					$Items["data"][ $rowCate[0] ] = array( "id" => $rowCate[0], "cate_name" => $rowCate[1], "counter" => $rowCount[0]);
				else
					$Items["data"][ $rowCate[2] ] = array( "id" => $rowCate[2], "cate_name" => $rowCate[3], "counter" => $rowCount[0]);	
			}
			else
			{
				// get Count of Category:
				$strSqlCommand = "	SELECT tbData.form_response
									FROM incident tbReport
									LEFT JOIN form_response tbData ON tbData.incident_id = tbReport.id
									LEFT JOIN incident_category tbCate ON tbCate.incident_id = tbReport.id
									WHERE tbData.form_field_id = ". $_GET['Counter'];
	
				if( $rowCate[2] == NULL)
				{
					$strSqlCommand .= " AND tbCate.category_id = ". $rowCate[0];
				}
				else
				{
					$strSqlCommand .= " AND tbCate.category_id = ". $rowCate[2];
				}
				
				$resultCount = mysql_query($strSqlCommand);
				
				$rowCount = @mysql_fetch_array($resultCount);
				
				if( $rowCate[2] == NULL)
					$Items["data"][ $rowCate[0] ] = array( "id" => $rowCate[0], "cate_name" => $rowCate[1], "counter" => $rowCount[0]);
				else
					$Items["data"][ $rowCate[2] ] = array( "id" => $rowCate[2], "cate_name" => $rowCate[3], "counter" => $rowCount[0]);					
			}
		}
	echo json_encode($Items);	


}
// Search for Counter for each range of field.
else
{
	// Step 1.
	// Get field Name
	$strSqlCommand = "	SELECT field_name
						FROM form_field
						WHERE id = ".$_GET['Par'];
	$resultName = mysql_query($strSqlCommand);
			
	$rowName = @mysql_fetch_array($resultName);
	
	$Items = array();
	$Items[ 'tittle' ] = array( "tittle" => $rowName[0]);
	// Search all Category:
	$nRange = 20;

		for( $i = 0 ; $i * $nRange < 100 ; $i++ )
		{
//			var_dump($rowCate);
			
			// Step 2.
			// get Count of Category:
			$strSqlCommand = "	SELECT Count(*)
								FROM form_response
								WHERE form_field_id = ".$_GET['Par']."
								AND form_response > ".$i * $nRange."
								AND form_response <= ".($i+1) * $nRange;
			
			$resultCount = mysql_query($strSqlCommand);
			
			$rowCount = @mysql_fetch_array($resultCount);
			
			$Items["data"][ $i ] = array( "id" => $i, "cate_name" => $i * $nRange . "% ~ ".($i+1) * $nRange."%" , "counter" => $rowCount[0]);

		}
	echo json_encode($Items);	
}
	
?>	
	
