<?php
require_once('mysql/mysql.class.php');
 
$target_path = "../media/uploads/";
$target_path = $target_path . $_POST["filename"] . '.'  . $_POST["extname"];

$req_dump = print_r( $target_path, TRUE);
$fp = fopen('Upload_Request'.date("Y_m_d_H_i_s").'.log', 'a');
fwrite($fp, $req_dump);
fclose($fp);

$target_filename   = $_POST["filename"] . '.'  . $_POST["extname"];
$target_filename_t = $_POST["filename"] . 't.' . $_POST["extname"];
$target_filename_m = $_POST["filename"] . 'm.' . $_POST["extname"];

$MysqlObj = new SQLObj(); 
$MysqlObj->connect();

if(move_uploaded_file($_FILES['image0']['tmp_name'], $target_path))
{
     $percent = 5/8;
     $percentSmall = 1/8;
          
     ResizeImage($target_path,$percent, substr($target_path,0,strlen($target_path)-4)      . 't.' . $_POST["extname"]);
     ResizeImage($target_path,$percentSmall, substr($target_path,0,strlen($target_path)-4) . 'm.' . $_POST["extname"]);    

     SaveMedia($MysqlObj,$target_filename,$target_filename_t,$target_filename_m,$_POST["Date"], $_POST['incident_id'], $_POST["location_id"]);

} else
{
    echo "There was an error uploading the file, please try again!";
}
      

function SaveMedia($MysqlObj , $target_filename,$target_filename_t,$target_filename_m,$Date, $idReport, $idLocation )
{   
      $strSQL = sprintf("insert into media(media_type,media_link,media_medium,media_thumb,media_date, incident_id, location_id )values(1,'%s','%s','%s','%s', '%s', '$s')",
                       $target_filename,$target_filename_t,$target_filename_m,$Date, $idReport, $idLocation);
$req_dump = print_r( $strSQL, TRUE);
$fp = fopen('upload.log', 'a');
fwrite($fp, $req_dump);
fclose($fp);

      $MysqlObj->RunSQL($strSQL);         
}     

 function ResizeImage($filename,$percent,$target_filename)
{  
      list($width, $height) = getimagesize($filename);
      $new_width = $width * $percent;
      $new_height = $height * $percent;
      $image_p = imagecreatetruecolor($new_width, $new_height);
      $image = imagecreatefromjpeg($filename);
      imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
      imagejpeg($image_p, $target_filename , 100);
  }

?>