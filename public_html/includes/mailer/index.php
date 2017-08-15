<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PHPMailer - GMail SMTP test</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
 
<?php
// Libreria PHPMailer
require 'PHPMailer/PHPMailerAutoload.php';
 
// Creamos una nueva instancia
$mail = new PHPMailer();
 
// Activamos el servicio SMTP
$mail->isSMTP();
// Activamos / Desactivamos el "debug" de SMTP 
// 0 = Apagado 
// 1 = Mensaje de Cliente 
// 2 = Mensaje de Cliente y Servidor 
$mail->SMTPDebug = 2; 
 
// Log del debug SMTP en formato HTML 
$mail->Debugoutput = 'html'; 
 
// Servidor SMTP (para este ejemplo utilizamos gmail) 
$mail->Host = 'localhost'; 
 
// Puerto SMTP 
$mail->Port = 465; 
 
// Tipo de encriptacion SSL ya no se utiliza se recomienda TSL 
$mail->SMTPSecure = 'ssl'; 
 
// Si necesitamos autentificarnos 
$mail->SMTPAuth = true; 
 
// Usuario del correo desde el cual queremos enviar, para Gmail recordar usar el usuario completo (usuario@gmail.com) 
$mail->Username = "talentohumano@colegioamericano.net"; 
 
// Contraseña 
$mail->Password = "TalentoHumano2016."; 
 
// Conectamos a la base de datos 
$db = new mysqli('localhost', 'iridium', 'iridium', 'roles'); 
 
if ($db->connect_errno > 0) { 
    die('Imposible conectar [' . $db->connect_error . ']'); 
} 
 
$result = $db->query("SELECT id_empleado FROM empleado where va_secuencia BETWEEN 279 AND 308");
$periodo = 6;
while($row = $result->fetch_assoc()) {
  $esPrimeraVez=true;
  $ingresosDisponibles= array();
  $egresosDisponibles = array();
  $db = new mysqli('localhost', 'iridium', 'iridium', 'roles'); 
  $rolResult = $db->query("CALL ConsultaRol(". $periodo .",'".$row['id_empleado']."')");
  $mensaje="";
  while($lineaRol = $rolResult->fetch_assoc()) {
    if($esPrimeraVez){
      $empleado=$lineaRol["de_nombre"];
      $periodoNombre=$lineaRol["de_periodo_rol"];
      $cargo=$lineaRol["de_cargo"];
      $departamento=$lineaRol["de_departamento"];
      $cedula=$row['id_empleado'];
      $diasTrabajados=$lineaRol["va_dias_trabajados"];
      $valorNominal=$lineaRol["va_sueldo_nominal"];
      $horasExtras50=$lineaRol["va_horas_50"];
      $horasExtras100=$lineaRol["va_horas_100"];
      $totalIngresos=$lineaRol["va_ingreso"];
      $totalEgresos=$lineaRol["va_egreso"];
      $netoRecibir=$lineaRol["va_neto"];

      $mail->setFrom('talentohumano@colegioamericano.net', 'Talento Humano!'); 
      $mail->addAddress($lineaRol['de_mail'], $empleado);
      $mail->AddCC("sorayda.paredes@colegioamericano.edu.ec"); 
      echo $lineaRol["de_mail"];
   //La linea de asunto 
      $mail->Subject = 'Rol de Pagos!'; 
      $mensaje='<html>
                <Head>
                 <title>TABLES</title>
                 </head>
                 <body>
                 &nbsp;&nbsp;&nbsp;&nbsp;<IMG border=0 hspace=0 alt="" src="/home/sistemas3082020/public_html/admin/mailer/img/logo.png" align=baseline>
                 <tr>
                 <th>'.$empleado.'</th></font>
                 </tr>
                 <tr>
                 <th>PERIODO:'.$periodoNombre.'</th>
                 </tr>
                 <tr>
                 <th>CARGO:'.$cargo.'</th>
                 </tr>
                  <tr>
                 <tr>
                 <th>DEPARTAMENTO:'.$departamento.'</th>
                 </tr>
                 <tr>
                 <th>CI:'.$cedula.'</th>
                 </tr>
                 <tr>
                 <th>DIAS TRABAJADOS:'.$diasTrabajados.'</th>
                 </tr>
                  <tr>
                 <th>SUELDO NOMINAL:'.$valorNominal.'</th>
                 </tr>
                 <tr>
                 <th>HORAS EXTRAS 50%:'.$horasExtras50.'</th>
                 </tr>
                 <tr>
                 <th>HORAS EXTRAS 100%:'.$horasExtras100.'</th>
                 </tr>
                 <table border="1" width="500">
                   <tr>
                     <th>Ingresos</th>
                     <th>     </th>
                     <th>Egresos</th>
                     <th>    </th>  
                   </tr>

                     {{ Table }}


                   <tr>
                  <th>TOTAL INGRESOS</th>
                  <th>'.$totalIngresos.'</th>
                  <th>TOTAL EGRESOS</th>
                  <th>'.$totalEgresos.'</th>
                  </tr>
                  </table>
                  <tr>
                  <th>NETO A RECIBIR:'.$netoRecibir.'</th>
                  </tr> 
                  </body>
                 </html>';
      $esPrimeraVez= false;
    }
    if($lineaRol["de_tipo_rubro"]=="I")
      array_push($ingresosDisponibles,[$lineaRol["de_rubro"],$lineaRol["va_rubro"]]);

    if($lineaRol["de_tipo_rubro"]=="E")
      array_push($egresosDisponibles,[$lineaRol["de_rubro"],$lineaRol["va_rubro"]]);

    
  }
  $strColumna="";
  $numeroDeIngresos=count($ingresosDisponibles);
  $numeroDeEgresos=count($egresosDisponibles);
  $tamañoTabla = ($numeroDeIngresos>=$numeroDeEgresos)?$numeroDeIngresos:$numeroDeEgresos;
  for($x = 0; $x < $tamañoTabla; $x++) {
    $ingresoTitulo="";
    $ingresoValue="";
    if($x<$numeroDeIngresos){
      $ingresoTitulo=$ingresosDisponibles[$x][0];
      $ingresoValue=$ingresosDisponibles[$x][1];
    }

    $egresoTitulo="";
    $egresoValue="";
    if($x<$numeroDeEgresos){
      $egresoTitulo=$egresosDisponibles[$x][0];
      $egresoValue=$egresosDisponibles[$x][1];
    }
    $strColumna =  $strColumna.
                  "<tr>
                   <th>".$ingresoTitulo."</th>
                   <th>".$ingresoValue."</th>
                   <th>".$egresoTitulo."</th>
                   <th>".$egresoValue."</th>
                   </tr>";
  }
  $mensaje= str_replace("{{ Table }}",$strColumna,$mensaje);

  //$mail->msgHTML(file_get_contents("contenido.php"), dirname(__FILE__));
  $mail->msgHTML($mensaje);


  // Enviamos el Mensaje 
  $mail->send(); 

  // Borramos el destinatario, de esta forma nuestros clientes no ven los correos de las otras personas y parece que fuera un 炭nico correo para ellos. 
  $mail->ClearAddresses(); 
}  
?>
</body>
</html>