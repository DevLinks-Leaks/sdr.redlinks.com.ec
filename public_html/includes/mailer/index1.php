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
 
// Creamos la sentencias SQL 
$result = $db->query("SELECT * FROM rol");
 
// Iniciamos el "bucle" para enviar multiples correos. 
 
while($row = $result->fetch_assoc()) { 
    //Añadimos la direccion de quien envia el corre, en este caso Codejobs, primero el correo, luego el nombre de quien lo envia. 
 
 
    $mail->setFrom('talentohumano@colegioamericano.net', 'Talento Humano!'); 
    $mail->addAddress($row['CORREO'], $row['EMPLEADO']); 
 
    //La linea de asunto 
    $mail->Subject = 'Rol de Pagos!';  
 
    // La mejor forma de enviar un correo, es creando un HTML e insertandolo de la siguiente forma, PHPMailer permite insertar, imagenes, css, etc. (No se recomienda el uso de Javascript) 
// Estoy construyendo el rol de pagos y probando
     $mensaje='<html>
                <Head>
                 <title>TABLES</title>
                 </head>
                 <body>
                 <IMG border=0 hspace=0 alt="" src="/home/sistemas3082020/public_html/admin/mailer/img/logo.png" align=baseline>
                 <tr>
                 <th>'.$row['EMPLEADO'].'</th></font>
                 </tr>
                 <tr>
                 <th>PERIODO:'.$row['PERIODO'].'</th>
                 </tr>
                 <tr>
                 <th>CARGO:'.$row['CARGO'].'</th>
                 </tr>
                  <tr>
                 <th>AREA FUNCIONAL:'.$row['AREAFUNCIONAL'].'</th>
                 </tr>
                 <tr>
                 <th>DEPARTAMENTO:'.$row['DEPARTAMENTO'].'</th>
                 </tr>
                 <tr>
                 <th>CI:'.$row['CI'].'</th>
                 </tr>
                 <tr>
                 <th>DIAS TRABAJADOS:'.$row['DIASTRABAJADOS'].'</th>
                 </tr>
                  <tr>
                 <th>SUELDO NOMINAL:'.$row['VALORNOMINAL'].'</th>
                 </tr>
                 <tr>
                 <th>HORAS EXTRAS 50%:'.$row['HORASEXTRASCINCUENTA'].'</th>
                 </tr>
                 <tr>
                 <th>HORAS EXTRAS 100%:'.$row['HORASEXTRASCIEN'].'</th>
                 </tr>
                 <table border="1" width="500">
                   <tr>
                   <th>Ingresos</th>
                   <th>     </th>
                   <th>Egresos</th>
                   <th>    </th>  
                   </tr>
                   <tr>
                   <th>'.(($row['VALORMES'] == '0') ?'':'Sueldo Mes').'</th>
                   <th>'.(($row['VALORMES'] =='0') ?'':$row['VALORMES']).'</th>
                   <th>'.(($row['ANTICIPOQUINCENAL'] == '0') ?'':'Anticipo Quincenal').'</th>
                   <th>'.(($row['ANTICIPOQUINCENAL'] =='0') ?'':$row['ANTICIPOQUINCENAL']).'</th>
                   </tr>
                 <tr>
                   <th>'.(($row['LUNCH'] == '0') ?'':'Alimentacion').'</th>
                   <th>'.(($row['LUNCH'] == '0') ?'':$row['LUNCH']).'</th>
                   <th>'.(($row['APORTEIESS'] == '0') ?'':'Aporte Iess').'</th>
                   <th>'.(($row['APORTEIESS'] =='0') ?'':$row['APORTEIESS']).'</th>  
                   </tr>
                   <tr>
                   <th>'.(($row['HECINCUENTA'] == '0') ?'':'Horas Extras 50 ADMIN').'</th>
                   <th>'.(($row['HECINCUENTA'] =='0') ?'':$row['HECINCUENTA']).'</th>
                   <th>'.(($row['SOCIALES'] == '0') ?'':'Comisiones Sociales').'</th>
                   <th>'.(($row['SOCIALES'] == '0') ?'':$row['SOCIALES']).'</th>
                   </tr>
                   <tr>
                   '.(($row['HRCIEN'] == '0') ?'':'<th>'.(($row['HRCIEN'] == '0') ?'':'Horas Extras 100 ADMIN').'</th><th>'.(($row['HRCIEN'] =='0') ?'':$row['HRCIEN']).'</th><th>'.(($row['ANTICIPOS'] == '0') ?'':'Anticipos de sueldo').'</th><th>'.(($row['ANTICIPOS'] =='0') ?'':$row['ANTICIPOS']).'</th> ').'  
                   </tr>
                   <tr>
                   '.(($row['ALFABETIZACIONBONO'] == '0') ?'':'<th>'.(($row['ALFABETIZACIONBONO'] == '0') ?'':'Alfabetizacion Bono').'</th><th>'.(($row['ALFABETIZACIONBONO'] =='0') ?'':$row['ALFABETIZACIONBONO']).'</th><th>'.(($row['FALTASATRASOSPERMISOS'] == '0') ?'':'Faltas,atrasos,permisos').'</th><th>'.(($row['FALTASATRASOSPERMISOS'] == '0') ?'':$row['FALTASATRASOSPERMISOS']).'</th> ').'
                   </tr>
                   <tr>
                   '.(($row['BONOBI'] == '0') ?'':'<th>'.(($row['BONOBI'] == '0') ?'':'Bono BI').'</th><th>'.(($row['BONOBI'] =='0') ?'':$row['BONOBI']).'</th><th>'.(($row['AYUDAESTUDIANTIL'] == '0') ?'':'Ayuda Estudiantil').'</th><th>'.(($row['AYUDAESTUDIANTIL'] =='0') ?'':$row['AYUDAESTUDIANTIL']).'</th> ').'
                   </tr>
                   <tr>
                   '.(($row['BONOJEFECOORDINACION'] == '0') ?'':'<th>'.(($row['BONOJEFECOORDINACION'] == '0') ?'':'Bono Jefe Coordinacion').'</th><th>'.(($row['BONOJEFECOORDINACION'] =='0') ?'':$row['BONOJEFECOORDINACION']).'</th><th>'.(($row['SEGUROMEDICO'] == '0') ?'':'BMI Seguros Medicos').'</th><th>'.(($row['SEGUROMEDICO'] =='0') ?'':$row['SEGUROMEDICO']).'</th>').'  
                   </tr>
                   <tr>
                   '.(($row['BONOPORMERITO'] == '0') ?'':'<th>'.(($row['BONOPORMERITO'] == '0') ?'':'Bono Por Merito').'</th><th>'.(($row['BONOPORMERITO'] == '0') ?'':$row['BONOPORMERITO']).'</th><th>'.(($row['ADMISIONES'] == '0') ?'':'Admisiones').'</th><th>'.(($row['ADMISIONES'] == '0') ?'':$row['ADMISIONES']).'</th> ').'  
                   </tr>
                   <tr>
                   '.(($row['BONOSOCASIONALES'] == '0') ?'':'<th>'.(($row['BONOSOCASIONALES'] == '0') ?'':'Bonos Ocasionales').'</th><th>'.(($row['BONOSOCASIONALES'] == '0') ?'':$row['BONOSOCASIONALES']).'</th><th>'.(($row['CLAROMES'] == '0') ?'':'Claro Consumo Mensual').'</th><th>'.(($row['CLAROMES'] == '0') ?'':$row['CLAROMES']).'</th>').'
                   </tr>
                   <tr>
                   '.(($row['BONOR'] == '0') ?'':'<th>'.(($row['BONOR'] == '0') ?'':'Bono Responsabilidad').'</th><th>'.(($row['BONOR'] == '0') ?'':$row['BONOR']).'</th><th>'.(($row['CLAROEQUIPO'] == '0') ?'':'Claro Equipo').'</th><th>'.(($row['CLAROEQUIPO'] == '0') ?'':$row['CLAROEQUIPO']).'</th>').'
                  </tr>
                   <tr>
                   '.(($row['CARGASHORARIASBONO'] == '0') ?'':'<th>'.(($row['CARGASHORARIASBONO'] == '0') ?'':'Cargas Horarias Bono').'</th><th>'.(($row['CARGASHORARIASBONO'] == '0') ?'':$row['CARGASHORARIASBONO']).'</th><th>'.(($row['COAM'] == '0') ?'':'Club Coam').'</th><th>'.(($row['COAM'] == '0') ?'':$row['COAM']).'</th>').'
                    </tr>
                   <tr>
                   '.(($row['COMITEDEEMPRESA'] == '0') ?'':'<th>'.(($row['COMITEDEEMPRESA'] == '0') ?'':'Comite de Empresa C.A.').'</th><th>'.(($row['COMITEDEEMPRESA'] == '0') ?'':$row['COMITEDEEMPRESA']).'</th><th>'.(($row['SEGUROGENESIS'] == '0') ?'':'AFP Genesis').'</th><th>'.(($row['SEGUROGENESIS'] =='0') ?'':$row['SEGUROGENESIS']).'</th>').'
                   </tr>
                   <tr>
                   '.(($row['FONDORESERVA'] == '0') ?'':'<th>'.(($row['FONDORESERVA'] == '0') ?'':'Fondos de Reserva').'</th><th>'.(($row['FONDORESERVA'] == '0') ?'':$row['FONDORESERVA']).'</th><th>'.(($row['EXTENSIONCONYUGE'] == '0') ?'':'Extension Conyuge').'</th><th>'.(($row['EXTENSIONCONYUGE'] == '0') ?'':$row['EXTENSIONCONYUGE']).'</th').'
                   </tr>
                   <tr>
                   '.(($row['OTROSINGR'] == '0') ?'':'<th>'.(($row['OTROSINGR'] == '0') ?'':'Otros Ingresos Personal').'</th><th>'.(($row['OTROSINGR'] == '0') ?'':$row['OTROSINGR']).'</th><th>'.(($row['BONONAVIDENO'] == '0') ?'':'Anticipo Bono Navideño').'</th><th>'.(($row['BONONAVIDENO'] =='0') ?'':$row['BONONAVIDENO']).'</th> ').'
                   </tr>
                  <tr>
                  '.(($row['DECIMOCUARTO'] == '0') ?'':'<th>'.(($row['DECIMOCUARTO'] == '0') ?'':'Provision Decimo Cuarto').'</th><th>'.(($row['DECIMOCUARTO'] == '0') ?'':$row['DECIMOCUARTO']).'</th><th>'.(($row['FYBECA'] == '0') ?'':'Fybeca empleados').'</th> <th>'.(($row['FYBECA'] == '0') ?'':$row['FYBECA']).'</th>').'
                 </tr>
                  <tr>
                  '.(($row['DECIMOTERCERO'] == '0') ?'':'<th>'.(($row['DECIMOTERCERO'] == '0') ?'':'Provision Decimo Tercero').'</th> <th>'.(($row['DECIMOTERCERO'] == '0') ?'':$row['DECIMOTERCERO']).'</th><th>'.(($row['GUARDERIA'] == '0') ?'':'Guarderia').'</th> <th>'.(($row['GUARDERIA'] == '0') ?'':$row['GUARDERIA']).'</th>').'
                  </tr>
                  <tr>
                  '.(($row['VACACIONES'] == '0') ?'':'<th>'.(($row['VACACIONES'] == '0') ?'':'Vacaciones').'</th><th>'.(($row['VACACIONES'] == '0') ?'':$row['VACACIONES']).'</th><th>'.(($row['IR'] == '0') ?'':'Impuesto a la renta').'</th><th>'.(($row['IR'] == '0') ?'':$row['IR']).'</th>').'
                  </tr>
                  <tr>
                  '.(($row['SUBCOM'] == '0') ?'':'<th>'.(($row['SUBCOM'] == '0') ?'':'Subsidio familiar comite empresa').'</th><th>'.(($row['SUBCOM'] == '0') ?'':$row['SUBCOM']).'</th><th>'.(($row['MULTAS'] == '0') ?'':'Multas').'</th><th>'.(($row['MULTAS'] == '0') ?'':$row['MULTAS']).'</th>').'
                  </tr>
                  <tr>
                  '.(($row['SUBIESS'] == '0') ?'':'<th>'.(($row['SUBIESS'] == '0') ?'':'Subsidio IESS Enfermedad').'</th><th>'.(($row['SUBIESS'] == '0') ?'':$row['SUBIESS']).'</th><th>'.(($row['OTROSDESC'] == '0') ?'':'Otros Descuentos').'</th><th>'.(($row['OTROSDESC'] == '0') ?'':$row['OTROSDESC']).'</th>').'
                  </tr>
                  <tr>
                  '.(($row['CUENTASPORCOBRAR'] == '0') ?'':'<th>     </th><th>     </th><th>'.(($row['CUENTASPORCOBRAR'] == '0') ?'':'Pensiones ctas x cobrar').'</th><th>'.(($row['CUENTASPORCOBRAR'] == '0') ?'':$row['CUENTASPORCOBRAR']).'</th> ').'  
                  </tr>
                  <tr>
                  '.(($row['PRCOMEMPRE'] == '0') ?'':'<th>     </th><th>     </th><th>'.(($row['PRCOMEMPRE'] == '0') ?'':'Prestamo Comite de Empresa').'</th><th>'.(($row['PRCOMEMPRE'] == '0') ?'':$row['PRCOMEMPRE']).'</th>').'
                 </tr>
                  <tr>
                  '.(($row['PRECORPLA'] == '0') ?'':'<th>     </th><th>     </th><th>'.(($row['PRECORPLA'] == '0') ?'':'Prestamos corto plazo').'</th><th>'.(($row['PRECORPLA'] == '0') ?'':$row['PRECORPLA']).'</th>').' 
                  </tr>
                  <tr>
                  '.(($row['PREHIPIESS'] == '0') ?'':'<th>     </th><th>     </th><th>'.(($row['PREHIPIESS'] == '0') ?'':'Prestamos hipotecarios IESS').'</th><th>'.(($row['PREHIPIESS'] == '0') ?'':$row['PREHIPIESS']).'</th>').'
                  </tr>
                  <tr>
                  '.(($row['PRELARPLA'] == '0') ?'':'<th>     </th><th>     </th><th>'.(($row['PRELARPLA'] == '0') ?'':'Prestamos largo plazo').'</th><th>'.(($row['PRELARPLA'] == '0') ?'':$row['PRELARPLA']).'</th>').'  
                  </tr>
                  <tr>
                  '.(($row['PREQUIESS'] == '0') ?'':'<th>     </th><th>     </th><th>'.(($row['PREQUIESS'] == '0') ?'':'Prestamos Quirografarios Iess').'</th><th>'.(($row['PREQUIESS'] == '0') ?'':$row['PREQUIESS']).'</th>').'
                  </tr>
                  <tr>
                  '.(($row['UNINGR'] == '0') ?'':'<th>     </th><th>     </th><th>'.(($row['UNINGR'] == '0') ?'':'Uniforme Ingreso').'</th><th>'.(($row['UNINGR'] == '0') ?'':$row['UNINGR']).'</th>').'
                  </tr>
                  <tr>
                  '.(($row['UNIFORMES'] == '0') ?'':'<th>     </th><th>     </th><th>'.(($row['UNIFORMES'] == '0') ?'':'Uniforme por cobrar a empleados').'</th><th>'.(($row['UNIFORMES'] == '0') ?'':$row['UNIFORMES']).'</th> ').'
                  </tr>
                  <tr>
                  '.(($row['UNIVISA'] == '0') ?'':'<th>     </th><th>     </th><th>'.(($row['UNIVISA'] == '0') ?'':'Univisa por cobrar empleados').'</th><th>'.(($row['UNIVISA'] == '0') ?'':$row['UNIVISA']).'</th>').'
                  </tr>
                  <tr>
                  <th>TOTAL INGRESOS</th>
                  <th>'.$row['TOTALINGRESOS'].'</th>
                  <th>TOTAL EGRESOS</th>
                  <th>'.$row['TOTALEGRESOS'].'</th>
                  </tr>
                  </table>
                  <tr>
                  <th>NETO A RECIBIR:'.$row['NETOARECIBIR'].'</th>
                  </tr> 
                  </body>
                 </html>';
            
                
     //$mail->Body = $message;
  

    //$mail->msgHTML($message);    

  

    //$mail->msgHTML(file_get_contents("contenido.php"), dirname(__FILE__));
    $mail->msgHTML($mensaje);
   
    
    // Enviamos el Mensaje 
    $mail->send(); 
 
    // Borramos el destinatario, de esta forma nuestros clientes no ven los correos de las otras personas y parece que fuera un único correo para ellos. 
    $mail->ClearAddresses(); 
}  
?>
</body>
</html>