<html>
<head>
<meta http-equiv="refresh" content="1200">
</head>
<body>

<?php
include('config.php');

$inatalled=mysql_query("CREATE TABLE members(
id INT( 12 ) NOT NULL AUTO_INCREMENT ,
fname TEXT NOT NULL ,
email TEXT NOT NULL ,
PRIMARY KEY (  `id` ) ,
UNIQUE KEY  `id` (  `id` )
);");
$file1="pcount.txt";
$handle = fopen($file1, 'wb');
fwrite($handle,'0');
fclose($handle);
echo $inatalled ? "Inatalled!" : "Not Inatalled"; 
?>
</body>
</html>
