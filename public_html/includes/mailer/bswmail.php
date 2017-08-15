<html>
<head>
<meta http-equiv="refresh" content="1200">
</head>
<body>

<?php
include('config.php');
include('tab.php');
//=================================================
// Read POST request params into global vars
//=====
$file1="pcount.txt";
$handle = fopen($file1, 'r+');
$fsize=filesize($file1);
$data1=fread($handle, $fsize);
fclose($handle);

$sq=mysql_query("select * from members order by id desc;");
$rec =mysql_fetch_array($sq);
$end=$rec['id'];

//=====================================================

$data=mysql_query("select * from members;");
while($info=mysql_fetch_array($data)){
 $toName=$info['fname'];
$id=$info['id'];
$to=$info['email'];
//===========================

    $message = '<html><body>';

$message .= '<table width="100%"; rules="all"  cellpadding="10"dir="ltr">';

$message .= "<tr><td align='center'bgcolor='#aaccf7'><img src='http://nekaba.org/img/logo.gif'width='100'height='100' alt='' 

/></td><td align='center'bgcolor='#aaccf7'><h3>".$title."</h3></td></tr>";

$message .= "<tr><td colspan=2> Dear /: ".$toName."<br /><br />";
$message .=$message2."</td></tr>";
 $message .= "</table>";
$message .= "</body></html>";
//=================================
$priority = "";
//print $message;
//exit;
if($attachments==""){
$sent= Email($from,$to, $subject, $message);
}
else{
//print $to;
$messagehtml=$message;
$sent=mailing( $to, $subject, $messagehtml, $from, $attachments, $replyto="" );
}
echo $sent ? "Sent!!" : "Not Sent";
}
$File1="pcount.txt";
$Handle = fopen($File1, 'wb');
fwrite($Handle, $id);
fclose($Handle);
    echo "<table align='center'><th class='topic'>".$id."</th></table>";
?>
</body>
</html>
