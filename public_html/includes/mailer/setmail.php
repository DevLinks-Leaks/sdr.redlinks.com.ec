<html>
<head>
<title> Sending Email </title>
</head>
<body>
<?php
include('header.php');
//======
$file2="tab.php";
$Hand = fopen($file2, 'wb');

$tab1="<?"."php"."
      ";
     fwrite($Hand, $tab1);
fclose($Hand);

//=================================================
// Read POST request params into global vars
if(isset($_POST['submit'])){
//=====
$file1="pcount.txt";
$handle = fopen($file1, 'wb');
fwrite($handle,'0');
fclose($handle);
//===================================================
 $subject = $_POST['subject'] ;
 $message2=$_POST['message2'];

//$tab=$_POST['tab'];

//===========================================

//=====================================================
//=====================================================
$file_dir ="./uploads/";
//====================================
$file2="tab.php";
$Hand = fopen($file2, 'a');
$tab1 ="$"."message2="."'".$message2."';"."
               ";
$tab1 .="$"."subject="."'".$subject."';"."
     ";
     fwrite($Hand, $tab1);
     
fclose($Hand);

//==================================
$n=$_POST['n'];
if($n!=0){
$i=0;
foreach($_FILES as $file_name => $file_array) {

	if (is_uploaded_file($file_array["tmp_name"])) {

		move_uploaded_file($file_array["tmp_name"], "$file_dir/".$file_array["name"]) or die ("Couldn't copy");

	}
	$att[$i]="./uploads/".$file_array["name"];
$art[$i]=$file_array["name"];
$cc="";
$bcc="";
$type="";
$priority = "";
	$i++;
	

}
$l=0;

	while($l<=$n-1){
	$attachments[$l] = "$att[$l]:$art[$l]";

		//=======================================
		$file2="tab.php";
$Hand = fopen($file2, 'a');

  
       $tab1 ="$"."attachments[".$l."]="."'".$attachments[$l]."';"."
     ";
          fwrite($Hand, $tab1);



//================================================


$l++;

}
$tab1 ="?".">";
     fwrite($Hand, $tab1);

fclose($Hand);
header("location:bswmaill.php");
}
else{
  $file2="tab.php";
$Hand = fopen($file2, 'a');

  

     $attachments="";
          $tab1 ="$"."attachments=".'"'.$attachments.'";'.'
              ';
              $tab1 .="?".">";

               fwrite($Hand, $tab1);
 fclose($Hand);
}
header("location:bswmail.php");
}

//=============================================================================
if(isset($_POST["submit1"])){
$n=$_POST['numbers'];

?>
<table align="center" dir="ltr"><td>
<h3 align="center">Send Mail</h3>
<form id="contact form" name="form1" enctype="multipart/form-data" method="post" action="" style="width: 592px" dir="ltr">
<br>
<b>Subject :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; </b>
<input type="text"name="subject" style="width: 241px"><br>
<input type="hidden"name="n"value="<?php print $n;?></php>">
<b>Message:</b><br><textarea  name="message2" cols="60" rows="10" dir="rtl" >
</textarea><br>
<?php 

for($k=1;$k<=$n;$k++){

	echo"<b>"."Attachment".$k.":</b><input name=\"".'fileatt'.$k."\" type=\"file\"><br>";
	  }  
 
    ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit"name="submit"value="submit">
</form>
 <?php }
else{
print"<table align=\"center\" dir=\"ltr\"><form dir=\"rtl\"method=\"post\"action=\"".$_SERVER["PHP_SELF"]."\"><th class=\"nform\">No of Attachments</th><th><input style=\"width:30px\"type=\"text\" name=\"numbers\"></th>";
print"<tr><th><input type=\"submit\" value=\"Submit\"name=\"submit1\"></th>";
print"</form></table>";
}
?>
</td></table>
</body>
</html>
