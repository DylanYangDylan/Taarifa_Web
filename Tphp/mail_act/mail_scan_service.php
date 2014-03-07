<?php
ignore_user_abort(true);
set_time_limit(0);
include_once ('/home/ghdistri/public_html/Tphp/mail_act/PHPMailer/class.phpmailer.php');
echo $today=date("H:i:s");

while(file_get_contents("/home/ghdistri/public_html/Tphp/mail_act/gate.cfg")=="Y"){
 
$f=fopen("/home/ghdistri/public_html/Tphp/mail_act/mail_log.html","ab");
						fwrite($f,"[".date("Y-m-d H:i:s",strtotime("now"))."--Timer Test]</br>");
						fclose($f);
												
$db_server = "localhost";

$db_name = "db3";

$db_user = "db3";
$db_passwd = "fletcheR01!!";

$link=mysql_pconnect($db_server, $db_user, $db_passwd) or
    die("Can't Link to Database Server!");

//setting for UTF8
mysql_query("SET NAMES utf8");

//select Database
if(!@mysql_select_db($db_name))
        die("Can't select this database!");

$query = "select * from mail_info;";
												   	
$mails= mysql_query($query );
		
		
	while ($row=@mysql_fetch_array($mails,MYSQL_ASSOC)){
		$mail=null;
		$mail = new PHPMailer;

		$mail->IsSMTP();                                      // Set mailer to use SMTP
		$mail->Host = "localhost";  // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'young@ghdistrictsmonitor.org';                            // SMTP username
		$mail->Password = '123465';                           // SMTP password
		//$mail->SMTPSecure = 'ssl';
		$mail->SMTPDebug = 1;                            // Enable encryption, 'ssl' also accepted
		
		
		$mail->From = 'admin@ghdistrictsmonitor.org';
		$mail->FromName = 'admin';
		
		
		//echo $row['mail_to'];
		$toArray = explode(',',$row['mail_to']); 

		for($index=0;$index<count($toArray);$index++){ 
		$mail->AddAddress($toArray[$index]);
		} 
		
		
		$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
		//$mail->AddAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->AddAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->IsHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = $row['sub'];
		$mail->Body    = $row['msg'];
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		
		$nowTime = date("Y-m-d H:i:s",strtotime("now")); 
		
		switch($row['every']){
		  case '0':
		    continue;
		  break;
		
		 case '2':
			 
			 if(date("D-H",strtotime("now"))==date("D-H",strtotime( $row['time']))){
				 if(!$mail->Send()) {
					   echo 'Message could not be sent.';
					   echo 'Mailer Error: ' . $mail->ErrorInfo;
					   exit;
					}else{
						$f=fopen("/home/ghdistri/public_html/Tphp/mail_act/mail_log.html","ab");
						fwrite($f,"[send time:".date("Y-m-d H:i:s",strtotime( $row['time']))."-Now".date("Y-m-d H:i:s",strtotime("now"))."-to ".$row['mail_to']."--WEEK send ok]<br>");
						fclose($f);
					}
			 }
		  break;
		  
		 case '3':
		      
			 if(date("j-H",strtotime("now"))==date("j-H",strtotime( $row['time']))){
				 if(!$mail->Send()) {
					   echo 'Message could not be sent.';
					   echo 'Mailer Error: ' . $mail->ErrorInfo;
					   exit;
					}else{
						$f=fopen("/home/ghdistri/public_html/Tphp/mail_act/mail_log.html","ab");
						fwrite($f,"[send time:".date("Y-m-d H:i:s",strtotime( $row['time']))."-Now".date("Y-m-d H:i:s",strtotime("now"))."-to ".$row['mail_to']."--MONTH send ok]<br>");
						fclose($f);
					}
			 }
		  break;
		  case '1':
		     
		        if(date("H",strtotime("now"))==date("H",strtotime($row['time']))){
			if(!$mail->Send()) {
					   echo 'Message could not be sent.';
					   echo 'Mailer Error: ' . $mail->ErrorInfo;
					   exit;
					}else{
						$f=fopen("/home/ghdistri/public_html/Tphp/mail_act/mail_log.html","ab");
						fwrite($f,"[send time:".date("Y-m-d H:i:s",strtotime( $row['time']))."-Now".date("Y-m-d H:i:s",strtotime("now"))."-to ".$row['mail_to']."--DAY send ok]<br>");
						fclose($f);
					}
			 }
		  break;
		  default:
		  break;
		  
		  
		}
		
		}

	if($link){
		mysql_close($link);
	}
	@mysql_free_result($mails);
	unset($query);
	unset($f);
	$cord=fopen("/home/ghdistri/public_html/Tphp/mail_act/mail_run.html","ab");
	fwrite($cord,"[".date("Y-m-d H:i:s",strtotime('Now'))."]GO<br>");
	fclose($cord);
    // 要處理的工作
	$cord=null;
	$db_server = null;
	$db_name = null;
	$db_user = null;
	$db_passwd = null;
	$row＝null;
	//mysql_close();
    sleep(900); // sleep sec
    $ch=null;
   $options=null;
    $ch = curl_init();

    $options = array( 
      CURLOPT_URL => "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'], 
      CURLOPT_HEADER => false, 
      CURLOPT_RETURNTRANSFER => true, 
      CURLOPT_TIMEOUT=>1,
      CURLOPT_USERAGENT => "mail Bot", 
      CURLOPT_FOLLOWLOCATION => true
    );

    //curl_setopt_array($ch, $options);
    //curl_exec($ch);
  exit();
}
?>