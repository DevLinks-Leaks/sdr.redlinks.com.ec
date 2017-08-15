<?php

function connectToDB() {
	global  $dbhost, $dbuser, $dbpass, $dbname,$mysql,$mysqli;

	($mysql = mysql_connect("$dbhost", "$dbuser", "$dbpass")) || die("Couldn't connect to MySQL");

	// select db:
	mysql_select_db("$dbname", $mysql) || die("Couldn't open db: $dbname. Error if any was: ".mysql_error() );
} // end func dbConnect();

//********************** newuser ************************************************


//=========================================
function mailing( $to, $subject, $messagehtml, $from, $attachments, $replyto="" ) {
        // handles mime type for better receiving
// A loop is set up for the attachments to be included.

        $uid = md5(uniqid(time()));
 
        // build the headers for attachment and html
        $h = "From: $from\r\n";
        if ($replyto) $h .= "Reply-To: ".$replyto."\r\n";
        $h .= "MIME-Version: 1.0\r\n";
        $h .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        $h .= "This is a multi-part message in MIME format.\r\n";
        $h .= "--".$uid."\r\n";
        $h .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $h .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $h .= $messagehtml."\r\n\r\n";
if($attachments != null) {
  foreach ($attachments as $attachment)  {
    $attachment = explode(":", $attachment);
  
        $ext = strrchr( $attachment[1] , '.');
        $ftype = "";
        if ($ext == ".doc") $ftype = "application/msword";
 if ($ext == ".docx") $ftype = "application/msword";
        if ($ext == ".jpg") $ftype = "image/jpeg";
        if ($ext == ".png") $ftype = "image/png";
        if ($ext == ".gif") $ftype = "image/gif";
        if ($ext == ".zip") $ftype = "application/zip";
        if ($ext == ".pdf") $ftype = "application/pdf";
        if ($ftype=="") $ftype = "application/octet-stream";
       
        // read file into $data var
   $ff=$attachment[0];
      $file =	file_get_contents($ff);
     
    
        // split the file into chunks for attaching
        $content = chunk_split(base64_encode($file));

        $h .= "--".$uid."\r\n";
        $h .= "Content-Type: ".$ftype."; name=\"".basename($attachment[1])."\"\r\n";
        $h .= "Content-Transfer-Encoding: base64\r\n";
        $h .= "Content-Disposition: attachment; filename=\"".basename($attachment[1])."\"\r\n\r\n";
      
$h .= $content."\r\n\r\n";

}

 }
  
        $h .= "--".$uid."--";
        // send mail
// print $ff."<br>".$h."<br>";
//exit;
        return mail( $to, $subject, strip_tags($messagehtml), str_replace("\r\n","\n",$h) ) ;
  
    }

//=================================================
/*function mailing( $to, $subject, $messagehtml, $from, $fileatt, $replyto="" ) {
        // handles mime type for better receiving
        $ext = strrchr( $fileatt[1] , '.');
        $ftype = "";
        if ($ext == ".doc") $ftype = "application/msword";
        if ($ext == ".jpg") $ftype = "image/jpeg";
        if ($ext == ".png") $ftype = "image/jpeg";
        if ($ext == ".gif") $ftype = "image/gif";
        if ($ext == ".zip") $ftype = "application/zip";
        if ($ext == ".pdf") $ftype = "application/pdf";
        if ($ftype=="") $ftype = "application/octet-stream";
       
        // read file into $data var
   $ff=$fileatt[0];
      $file =	file_get_contents($ff);
      //  $data = fread($file );
//print $data;
//exit;
      //  fclose($file);
 //print $fileatt[0];
//exit;
        // split the file into chunks for attaching
        $content = chunk_split(base64_encode($file));
        $uid = md5(uniqid(time()));
 
        // build the headers for attachment and html
        $h = "From: $from\r\n";
        if ($replyto) $h .= "Reply-To: ".$replyto."\r\n";
        $h .= "MIME-Version: 1.0\r\n";
        $h .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
        $h .= "This is a multi-part message in MIME format.\r\n";
        $h .= "--".$uid."\r\n";
        $h .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $h .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $h .= $messagehtml."\r\n\r\n";
        $h .= "--".$uid."\r\n";
        $h .= "Content-Type: ".$ftype."; name=\"".basename($fileatt[1])."\"\r\n";
        $h .= "Content-Transfer-Encoding: base64\r\n";
        $h .= "Content-Disposition: attachment; filename=\"".basename($fileatt[1])."\"\r\n\r\n";
        $h .= $content."\r\n\r\n";
        $h .= "--".$uid."--";
 
        // send mail
        return mail( $to, $subject, strip_tags($messagehtml), str_replace("\r\n","\n",$h) ) ;
 
 
    }*/
//********************************* Newlink ***********************************


//-----------------------------------------------------

//===============================================================
function Email($from,$to, $subject, $message){
return mail($from,$to, $subject, $message);
}
?>
