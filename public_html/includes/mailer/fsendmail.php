<html>
<head>
<link rel="stylesheet" type="text/css" href="bswstyle.css">
</head>
<body>
<?php
 include('header.php'); 



if(isset($_POST['submit'])){
$univ1=$_POST['univ'];
//--------------------------------------------------------------------------------------------------------------
$data2=mysql_query("select *  from associat;");

$i=0;
$j=0;
 while( $info=mysql_fetch_array($data2)){
$university=$info['university'];

$univ=strstr($university,$univ1);
if($univ){
$email[$j]=$info['email'];
$fname[$j]=$info['fname'];
$j=$j+1;

}
}

$count=count($email);

//---------------------------------------------------------------------------------------------------------------
$file1="fcount.txt";
$handle = fopen($file1, 'r+');
$fsize=filesize($file1);
$b=fread($handle, $fsize);
$bb=$b+25;
fclose($handle);
//------------------------------------------------------------
$file2="msg.txt";
$handle1 = fopen($file2, 'r+');
$fsize=filesize($file2);
$message2=fread($handle1, $fsize);
fclose($handle1);
//---------------------------------
$admin='abdelwahab';
  

//------------------------------------------------------------------
    include('config-inc.php');
 $att=explode('/',$attatch);
$files=$att[1];
//=======================================================================
  for($kk=$b;$kk<=$bb;$kk++){
$mailto=$email[$kk];
 $name=$fname[$kk];
$id=$kk;
$message=$title."
           "."
        "."عزيزي الدكتور"."
           ".$name."
           ".$message2."                                                                 
          "."مع خالص تحياتي"."                
          "."دكتور محمد الشقفي"."  
          "."رئيس مجلس الإدارة"."                            
       "."tel: 01004778974"."
       ".""."
             ";
$message=strip_tags($message);
if($id>$count){
$File1="fcount.txt";
$Handle = fopen($File1, 'wb');
fwrite($Handle, '0');
fclose($Handle);
exit;}
if($files!=""){
mail_attachment($attatch, $mailto, $mailfrom,$replyto, $subject, $message);
//print $message."<br>";

}
else{

mail($mailto, "Subject: $subject", $message, "From: $mailfrom" );
//print $message."<br>";

}
}
$new=$id;
if($files!=""){
mail_attachment($attatch, $mailto, $mailfrom,$replyto, $subject, $message);
//print $message."<br>";

}
else{

mail("To:$mailfrom", "Subject: $subject", $message, "From: $mailfrom" );
//print $message."<br>";
}
$File1="fcount.txt";
$Handle = fopen($File1, 'wb');


fwrite($Handle, $new);

fclose($Handle);
print"<table align=\"center\"><th class=\"topic\">";
print"Done mail send"."<br/>";
print $new;
print"</th></table>";
exit;
}
?>
<table align="center"><td><form method="post" action="fsendmail.php">
أدخل إسم الجامعة<input type="text" name="univ">
<input type="submit"name="submit"value="submit">
</form>
</td></table>
</body>
</html>
