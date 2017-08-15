<?php
	include("resize-class.php");
	
	if (!function_exists('lastId')) {
		function lastId($queryID){
			sqlsrv_next_result($queryID);
			sqlsrv_fetch($queryID);
			return sqlsrv_get_field($queryID, 0);
		}
	}
	if (!function_exists('notas_prom_quali')) {
		function notas_prom_quali($peri_codi,$mate_tipo,$prom){
			// me da el valor en Cualitativo de valor en el periodo 
			include ('dbconf.php');		 
			$params_permi = array($peri_codi,$mate_tipo,$prom);		
			$sql_permi="{call nota_peri_cual_prom_value(?,?,?)}";
			$nota_peri_cual_prom_value = sqlsrv_query($conn, $sql_permi, $params_permi); 
			$row_nota_peri_cual_prom_value = sqlsrv_fetch_array($nota_peri_cual_prom_value);	 
			return $row_nota_peri_cual_prom_value['nota_peri_cual_refe'];
			 
		}
	}
	
	if (!function_exists('notas_prom_quali_deta')) {
		function notas_prom_quali_deta($peri_codi,$mate_tipo,$prom){
			// me da el valor en Cualitativo de valor en el periodo 
			include ('dbconf.php');		 
			$params_permi = array($peri_codi,$mate_tipo,$prom);		
			$sql_permi="{call nota_peri_cual_prom_value(?,?,?)}";
			$nota_peri_cual_prom_value = sqlsrv_query($conn, $sql_permi, $params_permi); 
			$row_nota_peri_cual_prom_value = sqlsrv_fetch_array($nota_peri_cual_prom_value);	 
			return $row_nota_peri_cual_prom_value['nota_peri_cual_deta'];
			 
		}
	}
	
	if (!function_exists('notas_prom_quali_deta_2')) {
		function notas_prom_quali_deta_2($peri_codi,$mate_tipo,$prom){
			// me da el valor en Cualitativo de valor en el periodo
			include ('dbconf.php');
			$params_permi = array($peri_codi,$mate_tipo,$prom);
			$sql_permi="{call nota_peri_cual_prom_value(?,?,?)}";
			$nota_peri_cual_prom_value = sqlsrv_query($conn, $sql_permi, $params_permi);
			$row_nota_peri_cual_prom_value = sqlsrv_fetch_array($nota_peri_cual_prom_value);
			return $row_nota_peri_cual_prom_value['nota_peri_cual_deta_2'];
	
		}
	}
	
	if (!function_exists('permiso_activo')) {
		function permiso_activo($perm_codi){
			session_start();
			include ('dbconf.php');
			$usua_codi=$_SESSION['usua_codi'];
			$params_permi = array($usua_codi,$perm_codi);
			
			$sql_permi="{call usua_permi_info(?,?)}";
			$permi = sqlsrv_query($conn, $sql_permi, $params_permi); 
			$row_permi = sqlsrv_fetch_array($permi);
			if($row_permi['veri']>0){
				return true;
			}else{
				return false;
			}
		}
	}
	
	if (!function_exists('registrar_auditoria')) {
		function registrar_auditoria($accion, $detalle){
			session_start();
			include ('dbconf.php');
			$usua_tipo_codi=$_SESSION['USUA_TIPO_CODI'];
			
			switch ($_SESSION['USUA_TIPO'])
			{
				case 'A':
					$usua_codi=$_SESSION['alum_usua'];	
				break;
				
				case 'R':
					$usua_codi=$_SESSION['repr_usua'];	
				break;
				
				case 'D':
					$usua_codi=$_SESSION['prof_usua'];
				break;
				
				case 'K':
					$usua_codi=$_SESSION['usua_codi'];	
				break;
			}
			
			$params = array($accion,$usua_codi,$usua_tipo_codi,$detalle);
			
			$sql="{call audi_add(?,?,?,?)}";
			$audi = sqlsrv_query($conn, $sql, $params); 
			$row_audi = sqlsrv_fetch_array($audi);
			if($row_audi['ident']>0){
				return true;
			}else{
				return false;
			}
		}
	}
	if (!function_exists('session_activa')) {
		function session_activa($rol){
			session_start();
			/*1. administrador */
			/*2. docente */
			/*3. alumno/representante */
			switch ($rol)
			{
				case 1:
					if(isset($_SESSION['ISBIEN_ADMIN']))
					{
						if ($_SESSION['ISBIEN_ADMIN'] <> 'YESIN') 
						{
							header("Location: ../index.php");
						}
					} 
					else
					{		
						header("Location: ../index.php");		
					}
				break;
				
				case 2:
					if(isset($_SESSION['ISBIEN_PROF']))
					{
						if ($_SESSION['ISBIEN_PROF'] <> 'YESIN') 
						{
							header("Location: ../index.php");
						}
					} 
					else
					{		
						header("Location: ../index.php");		
					}
				break;
				
				case 3:
					if(isset($_SESSION['ISBIEN_ALUM']))
					{
						if ($_SESSION['ISBIEN_ALUM'] <> 'YESIN') 
						{
							header("Location: ../index.php");
						}
					} 
					else
					{		
						header("Location: ../index.php");		
					}
				break;
			}
		}
	}
	if (!function_exists('PeriodoActivo')) {
		function PeriodoActivo($peri_etap_codi){
			include ('dbconf.php');
			$params3 = array($peri_etap_codi);
			
			$sql="{call peri_acti_etap(?)}";
			$peri_acti_etap = sqlsrv_query($conn, $sql, $params3);  
			$row_peri_acti_etap = sqlsrv_fetch_array($peri_acti_etap);
			$_SESSION['peri_codi']=$row_peri_acti_etap['peri_codi'];
			$_SESSION['peri_deta']=$row_peri_acti_etap['peri_deta'];
			$_SESSION['peri_ano']=$row_peri_acti_etap['peri_ano'];		
		}
	}
	if (!function_exists('Periodo_Distribucion_Peri_Codi')) {
		function Periodo_Distribucion_Peri_Codi($peri_dist_codi){
			include ('dbconf.php');
			$params3 = array($peri_dist_codi);
			
			$sql="{call peri_dist_peri_codi(?)}";
			$peri_dist_peri_codi = sqlsrv_query($conn, $sql, $params3);  
			$row_peri_dist_peri_codi = sqlsrv_fetch_array($peri_dist_peri_codi);
			return $row_peri_dist_peri_codi['peri_codi'];
			
		}
	}
	if (!function_exists('Alumno_codi_alum_curs_para_codi')) {
		function Alumno_codi_alum_curs_para_codi($alum_curs_para_codi){
			include ('dbconf.php');
			$params3 = array($peri_dist_codi);
			
			$sql="{call peri_dist_peri_codi(?)}";
			$peri_dist_peri_codi = sqlsrv_query($conn, $sql, $params3);  
			$row_peri_dist_peri_codi = sqlsrv_fetch_array($peri_dist_peri_codi);
			return $row_peri_dist_peri_codi['peri_codi'];
			
		}
	}
	if (!function_exists('tipo_por_etapa')) {
		function tipo_por_etapa($tipo){
			if ($tipo==1) return 'A';
			if ($tipo==2) return 'R';
			if ($tipo==3) return 'D';
			if ($tipo==4) return 'K';		
			return 0; 
		}
	}
 
	if (!function_exists('Salir')) {
		function Salir() { 
			session_start();
			session_unset();
			session_destroy();
			$server=$_SERVER['SERVER_NAME'];
			header("Location:http://".$server."/index.php");
		} 
	}
	if (!function_exists('salir_stay')) {
		function salir_stay() { 
			session_start();
			session_unset();
			session_destroy();
		} 
	}
	if (!function_exists('para_sist')) {
		function para_sist($para_sist_codi){
			include ('dbconf.php');
			$params3 = array($para_sist_codi);
			
			$sql="{call para_sist_info(?)}";
			$para_sist_info = sqlsrv_query($conn, $sql, $params3);  
			$row_para_sist_info = sqlsrv_fetch_array($para_sist_info);
			
			return $row_para_sist_info['para_sist_valu']; 
		}
	}
	if (!function_exists('peri_nota_max')) {
		function peri_nota_max($peri_codi){
			include ('dbconf.php');
			$params3 = array($peri_codi);
			
			$sql="{call peri_info(?)}";
			$peri_info = sqlsrv_query($conn, $sql, $params3);  
			$row_peri_info = sqlsrv_fetch_array($peri_info);
			
			return $row_peri_info['peri_nota_max']; 
		}
	}
	
	if (!function_exists('envio_correo')) {
		function envio_correo($mensaje,$mensaje1,$mensaje2,$mensaje3,$email_destino){
			require_once "includes/class.phpmailer.php";
			$tabla='';
			
			$mail = new phpmailer();
			$mesj.= "<h2>Recuperaci&oacute;n de Contrase&ntilde;a: </h2>";
			$mesj.="";
			$mesj .= $mensaje.$mensaje1.$mensaje2.$mensaje3;
			$mesj .= "<p> Enviado el " . date('d/m/Y H:i:s', time())."</p>";
			
			$mail -> From = "uemagsys@gmail.com";
			$mail -> FromName = "Sistema Academico Educalinks";
			//$mail -> AddBCC ($email_destino);
			$mail -> AddAddress ($email_destino);
			
			$mail -> Subject = "Mail Informativo";
			$mail -> Body = $mesj;
			$mail -> IsHTML (true);
			
			$mail->IsSMTP();
			$mail->Host = 'ssl://smtp.gmail.com';
			$mail->Port = 465;
			
			$mail->SMTPAuth = true;
			$mail->Username = 'uemagsys@gmail.com';
			$mail->Password = 'svqndbjjvcnsjmkq';//Uemag2014
			
			if(!$mail->Send()){
				//echo 'Error: ' . $mail->ErrorInfo;
				$erro=$mail->ErrorInfo;
				//header("Location: adm_mail_masi_ok.php?ok=N&erro=".$erro);
			}	
		}
	}
	if (!function_exists('getBrowser')) {
		function getBrowser()
		{
			$u_agent = $_SERVER['HTTP_USER_AGENT'];
			$bname = 'Unknown';
			$platform = 'Unknown';
			$version= "";
		
			//First get the platform?
			if (preg_match('/linux/i', $u_agent)) {
				$platform = 'linux';
			}
			elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
				$platform = 'mac';
			}
			elseif (preg_match('/windows|win32/i', $u_agent)) {
				$platform = 'windows';
			}
		   
			// Next get the name of the useragent yes seperately and for good reason
			if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
			{
				$bname = 'Internet Explorer';
				$ub = "MSIE";
			}
			elseif(preg_match('/Firefox/i',$u_agent))
			{
				$bname = 'Mozilla Firefox';
				$ub = "Firefox";
			}
			elseif(preg_match('/Chrome/i',$u_agent))
			{
				$bname = 'Google Chrome';
				$ub = "Chrome";
			}
			elseif(preg_match('/Safari/i',$u_agent))
			{
				$bname = 'Apple Safari';
				$ub = "Safari";
			}
			elseif(preg_match('/Opera/i',$u_agent))
			{
				$bname = 'Opera';
				$ub = "Opera";
			}
			elseif(preg_match('/Netscape/i',$u_agent))
			{
				$bname = 'Netscape';
				$ub = "Netscape";
			}
		   
			// finally get the correct version number
			$known = array('Version', $ub, 'other');
			$pattern = '#(?<browser>' . join('|', $known) .
			')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
			if (!preg_match_all($pattern, $u_agent, $matches)) {
				// we have no matching number just continue
			}
		   
			// see how many we have
			$i = count($matches['browser']);
			if ($i != 1) {
				//we will have two since we are not using 'other' argument yet
				//see if version is before or after the name
				if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
					$version= $matches['version'][0];
				}
				else {
					$version= $matches['version'][1];
				}
			}
			else {
				$version= $matches['version'][0];
			}
		   
			// check if we have a number
			if ($version==null || $version=="") {$version="?";}
		   
			return array(
				'userAgent' => $u_agent,
				'name'      => $bname,
				'version'   => $version,
				'platform'  => $platform,
				'pattern'    => $pattern
			);
		} 
	}
	
	
	if (!function_exists('get_parametro')) {
		function get_parametro($clie_codi, $para_codi){
			//Retorna el valor del parámetro del cliente consultado
			include ('dbconf_main.php');		 
			$params = array($clie_codi, $para_codi);		
			$sql = "{call clie_para_cons(?,?)}";
			$para_cons = sqlsrv_query($conn, $sql, $params); 
			$row = sqlsrv_fetch_array($para_cons);	 
			return $row['para_valo'];
			 
		}
	}
	if (!function_exists('trunc_round')) {
		function trunc_round($numero){
			if (para_sist(40)==1)
			{
				$nota = floor($numero*pow(10,para_sist(41)));
				$nota = $nota/pow(10,para_sist(41));
			}
			else
				$nota = number_format($numero,para_sist(41));
			
			return number_format($nota,2,'.',',');
	
		}
	}
	if (!function_exists('truncar')) {
		function truncar($numero){
			return substr($numero,0,strpos($numero,".")+(para_sist(41)+1));
		}
	}
	if (!function_exists('get_opcion')) {
		function get_opcion($clie_codi, $opci_codi){
			//Retorna si tiene la opcion del sistema disponible el cliente
			include ('dbconf_main.php');		 
			$params = array($clie_codi, $opci_codi);		
			$sql = "{call clie_opci_cons(?,?)}";
			$opci_codi = sqlsrv_query($conn, $sql, $params); 
			$row = sqlsrv_fetch_array($opci_codi);	 
			return $row['opci_valo'];
			 
		}
	}
	
	
	if (!function_exists('background_index')) {
		function background_index($clie_codi){

			// ruta de foto fondo			 
			$file_exi='theme/images/background/bg_web_login_' . $clie_codi . '.jpg';
			
            if (file_exists($file_exi)) {
                $Url=$file_exi;
            } 
            else {
                $Url='theme/images/background/bg_web_login_0.jpg';
            }
						
			return $Url;
			 
		}
	}

	if (!function_exists('nota_peri_cual_cons')) {
		function nota_peri_cual_cons($peri_codi, $nota_refe_cabe_codi, $nota){
			// me da el valor en Cualitativo de valor en el periodo 
			include ('dbconf.php');		 
			$params_permi = array($peri_codi, $nota_refe_cabe_codi, $nota);		
			$sql_permi="{call nota_peri_cual_cons(?,?,?)}";
			$nota_peri_cual_prom_value = sqlsrv_query($conn, $sql_permi, $params_permi); 
			$row_nota_peri_cual_prom_value = sqlsrv_fetch_array($nota_peri_cual_prom_value);	 
			return $row_nota_peri_cual_prom_value['nota_peri_cual_refe'];
		}
	}
	
	if (!function_exists('alum_tiene_deuda')) {
		function alum_tiene_deuda($alum_codi, $curs_para_codi){
			// Consulta si un estudiante tiene deuda
			include ('dbconf.php');		 
			$params_permi = array($alum_codi, $curs_para_codi);		
			$sql_permi="{call alum_curs_para_tiene_deuda(?,?)}";
			$nota_peri_cual_prom_value = sqlsrv_query($conn, $sql_permi, $params_permi); 
			$row_nota_peri_cual_prom_value = sqlsrv_fetch_array($nota_peri_cual_prom_value);	 
			return $row_nota_peri_cual_prom_value['alum_tiene_deuda'];
		}
	}
	
	if (!function_exists('curs_para_nive_cons')) {
		function curs_para_nive_cons($curs_para_codi){
			//Retorna si tiene la opcion del sistema disponible el cliente
			include ('dbconf.php');		 
			$params = array($curs_para_codi);		
			$sql = "{call curs_para_info(?)}";
			$stmt = sqlsrv_query($conn, $sql, $params); 
			$row = sqlsrv_fetch_array($stmt);	 
			return $row['nive_codi'];
			 
		}
	}
	
	if (!function_exists('es_tutor')) {
		function es_tutor($prof_codi, $peri_codi){
			//Retorna el número de cursos de donde es tutor
			include ('dbconf.php');		 
			$params = array($prof_codi, $peri_codi);	
			$sql = "{call prof_es_tutor(?,?)}";
			$stmt = sqlsrv_query($conn, $sql, $params); 
			$row = sqlsrv_fetch_array($stmt);	 
			return $row['tuto_num'];
			 
		}
	}
	
	if (!function_exists('curs_para_mate_prof_info')) {
		function curs_para_mate_prof_info($curs_para_mate_prof_codi){
			//Retorna arreglo con información del curso y materia
			//de un profesor
			include ('dbconf.php');		 
			$params = array($curs_para_mate_prof_codi);	
			$sql = "{call curs_para_mate_prof_info(?)}";
			$stmt = sqlsrv_query($conn, $sql, $params); 
			$row = sqlsrv_fetch_array($stmt);	 
			return $row;
		}
	}
	
	if (!function_exists('print_usua_info')) {
		function print_usua_info(){
			$info_date = getdate ();
			$fecha_hora = $info_date['mday']."/".
						  $info_date['mon']."/".
						  $info_date['year']." ".
						  $info_date['hours'].":".
						  $info_date['minutes'].":".
						  $info_date['seconds'];
			$info = " <strong>Usuario: </strong>".$_SESSION['usua_codi'].
					" <strong>Fecha y hora: </strong>".$fecha_hora;
			return $info;
		}
	}
	if (!function_exists('pasarMayusculas'))
	{   function pasarMayusculas($cadena)
		{   $cadena = strtoupper($cadena); 
			$cadena = str_replace("á", "Á", $cadena); 
			$cadena = str_replace("é", "É", $cadena); 
			$cadena = str_replace("í", "Í", $cadena); 
			$cadena = str_replace("ó", "Ó", $cadena); 
			$cadena = str_replace("ú", "Ú", $cadena); 
			$cadena = str_replace("ñ", "Ñ", $cadena); 
			return ($cadena); 
		}	
	}
	if (!function_exists('pasarMinusculas'))
	{   function pasarMinusculas($cadena)
		{   $cadena = strtolower($cadena); 
			$cadena = str_replace("Á", "á", $cadena); 
			$cadena = str_replace("É", "é", $cadena); 
			$cadena = str_replace("Í", "í", $cadena); 
			$cadena = str_replace("Ó", "ó", $cadena); 
			$cadena = str_replace("Ú", "ú", $cadena);
			$cadena = str_replace("Ñ", "ñ", $cadena); 
			return ($cadena); 
		}	
	}
	if (!function_exists('PrimeraMayuscula'))
	{
		function PrimeraMayuscula($string)
		{
			$string =ucwords(pasarMinusculas($string));

			foreach (array('-', '\'') as $delimiter) {
			  if (strpos($string, $delimiter)!==false) {
				$string =implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
			  }
			}
			return $string;
		}
	}
	if (!function_exists('validarTildeHTML'))
	{
		function validarTildeHTML($cadena)
		{   $cadena = str_replace("Ñ", "&Ntilde;", $cadena);
			$cadena = str_replace("Á", "&Aacute;", $cadena);
			$cadena = str_replace("É", "&Eacute;", $cadena);
			$cadena = str_replace("Í", "&Iacute;", $cadena);
			$cadena = str_replace("Ó", "&Oacute;", $cadena);
			$cadena = str_replace("Ú", "&Uacute;", $cadena);
			$cadena = str_replace("ñ", "&ntilde;", $cadena); 
			$cadena = str_replace("á", "&Aacute;", $cadena);
			$cadena = str_replace("é", "&Eacute;", $cadena);
			$cadena = str_replace("í", "&Iacute;", $cadena);
			$cadena = str_replace("ó", "&Oacute;", $cadena);
			$cadena = str_replace("ú", "&Uacute;", $cadena); 
			return ($cadena); 
		}
	}
	if (!function_exists('validarTildeHTMLreves'))
	{
		function validarTildeHTMLreves($cadena)
		{   $cadena = str_replace("&Ntilde;","Ñ", $cadena);
			$cadena = str_replace("&Aacute;","A", $cadena);
			$cadena = str_replace("&Eacute;","E", $cadena);
			$cadena = str_replace("&Iacute;","I", $cadena);
			$cadena = str_replace("&Oacute;","O", $cadena);
			$cadena = str_replace("&Uacute;","U", $cadena);
			$cadena = str_replace("&ntilde;","ñ", $cadena); 
			$cadena = str_replace("&Aacute;","a", $cadena);
			$cadena = str_replace("&Eacute;","e", $cadena);
			$cadena = str_replace("&Iacute;","i", $cadena);
			$cadena = str_replace("&Oacute;","o", $cadena);
			$cadena = str_replace("&Uacute;","u", $cadena); 
			return ($cadena); 
		}
	}
	if (!function_exists('test_input'))
	{   function test_input($data)
		{   $data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}
	}
	if (!function_exists('get_ciudad_institucion'))
	{   function get_ciudad_institucion()
		{   return para_sist(31);
		}
	}
	if (!function_exists('genera_tabla_por_columnas'))
	{   function genera_tabla_por_columnas($array_con_td, $num_columnas=1, $border=0, $width='100%', $align='center')
		{	$aux = 0;
			$c = count($array_con_td);
			$body = "";
			$body.='<tr style="vertical-align:top;">';
			while ($aux < $c)
			{	$body.=  $array_con_td[$aux];
				//if ($aux & 1) $body.='</tr><tr>';
				$aux+=1;
				if (fmod($aux, $num_columnas)==0) $body.='</tr><tr style="vertical-align:top;">';
			}
			$body.='</tr>';
			$table= "<table width='".$width."' align='".$align."' border='".$border."'>";
			$table.= $body;
			$table.= "</table>";
			
			return $table;
		}
	}
	if (!function_exists('genera_tabla_por_columnas134'))
	{   function genera_tabla_por_columnas134($num_columnas, $numero_registros, $array_con_td)
		{	$aux = 0;
			$c = $numero_registros;
			$body = "";
			if ($c & 1) //'odd';
			{	$body.='<tr style="vertical-align:top;">';
				while ($aux < $c)
				{	$body.=  $array_con_td[$aux];
					if ($aux & 1) $body.= '</tr><tr style="vertical-align:top;">';
					$aux+=1;
				}
				$body.='</tr>';
			}
			else //'even';
			{ 	$body.='<tr style="vertical-align:top;">';
				while ($aux < $c)
				{	$body.=  $array_con_td[$aux];
					//if ($aux & 1) $body.='</tr><tr>';
					$aux+=1;
					if (fmod($aux, $num_columnas)==0) $body.='</tr><tr style="vertical-align:top;">';
				}
				$body.='</tr>';
			}
			$table= "<table width='70%' align='center'>";
			$table.= $body;
			$table.= "</table>";
			
			return $table;
		}
	}
	// funcion para validar la cedula de Ecuador//
	//Autor: Oliver Veliz
	//año:2010
	if (!function_exists('validarCI'))
	{   function validarCI($strCedula)
		{	//El decimo Digito es un resultante de un calculo
			//Se trabaja con los 9 digitos de la cedula
			//Cada digito de posicion impar se lo duplica, si este es mayor que 9 se resta 9
			//Se suman todos los resultados de posicion impar
			//Ahora se suman todos los digitos de posicion par
			//se suman los dos resultados
			//se resta de la decena inmediata superior
			//este es el decimo digito
			//si la suma nos resulta 10, el decimo digito es cero

			if(is_null($strCedula) || empty($strCedula))
			{	//compruebo si que el numero enviado es vacio o null
				echo "Por Favor Ingrese la Cedula";
			}
			else
			{	//caso contrario sigo el proceso
				if(is_numeric($strCedula))
				{	$total_caracteres=strlen($strCedula);// se suma el total de caracteres
					if($total_caracteres==10)
					{	//compruebo que tenga 10 digitos la cedula
						$nro_region=substr($strCedula, 0,2);//extraigo los dos primeros caracteres de izq a der
						if($nro_region>=1 && $nro_region<=24)
						{	// compruebo a que region pertenece esta cedula//
							$ult_digito=substr($strCedula, -1,1);//extraigo el ultimo digito de la cedula
							//extraigo los valores pares//
							$valor2=substr($strCedula, 1, 1);
							$valor4=substr($strCedula, 3, 1);
							$valor6=substr($strCedula, 5, 1);
							$valor8=substr($strCedula, 7, 1);
							$suma_pares=($valor2 + $valor4 + $valor6 + $valor8);
							//extraigo los valores impares//
							$valor1=substr($strCedula, 0, 1);
							$valor1=($valor1 * 2);
							if($valor1>9){ $valor1=($valor1 - 9); }else{ }
							$valor3=substr($strCedula, 2, 1);
							$valor3=($valor3 * 2);
							if($valor3>9){ $valor3=($valor3 - 9); }else{ }
							$valor5=substr($strCedula, 4, 1);
							$valor5=($valor5 * 2);
							if($valor5>9){ $valor5=($valor5 - 9); }else{ }
							$valor7=substr($strCedula, 6, 1);
							$valor7=($valor7 * 2);
							if($valor7>9){ $valor7=($valor7 - 9); }else{ }
							$valor9=substr($strCedula, 8, 1);
							$valor9=($valor9 * 2);
							if($valor9>9){ $valor9=($valor9 - 9); }else{ }

							$suma_impares=($valor1 + $valor3 + $valor5 + $valor7 + $valor9);
							$suma=($suma_pares + $suma_impares);
							$dis=substr($suma, 0,1);//extraigo el primer numero de la suma
							$dis=(($dis + 1)* 10);//luego ese numero lo multiplico x 10, consiguiendo asi la decena inmediata superior
							$digito=($dis - $suma);
							if($digito==10){ $digito='0'; }else{ }//si la suma nos resulta 10, el decimo digito es cero
							if ($digito==$ult_digito)
							{	//comparo los digitos final y ultimo
								echo "Cedula Correcta";
							}
							else
							{	echo "Cedula Incorrecta";
							}
						}else
						{	echo "Este Nro de Cedula no corresponde a ninguna provincia del ecuador";
						}
						echo "Es un Numero y tiene el numero correcto de caracteres que es de ".$total_caracteres."";

					}else
					{	echo "Es un Numero y tiene solo".$total_caracteres;
					}
				}else
				{	echo "Esta Cedula no corresponde a un Nro de Cedula de Ecuador";
				}
			}
		}
	}
?>