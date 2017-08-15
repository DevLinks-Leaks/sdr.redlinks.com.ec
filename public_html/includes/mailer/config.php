<?php
error_reporting(E_ALL);
include_once("functions.php");
$url="http://nekaba.org";
connectToDB();
$title="BSW Mailer";

print "<link rel=\"stylesheet\" type=\"text/css\" href=\"./bswstyle.css\">";

//************************** You have to fill ***********************
$ip=$_SERVER['mysql:host=107.180.12.36;dbname=directorio','iridium','iridium'];
$from ="";
$fromName="";
$cc="";
$bcc="";
$type="";
$replyto ="";
$priority="";
?>
<meta http-equiv="refresh" content="1200">
