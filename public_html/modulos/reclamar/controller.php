<?php
session_start();
require_once('../../core/controllerBase.php');
require_once('../general/model.php');
require_once('../periodo/model.php');
require_once('constants.php');
require_once('model.php');
require_once('view.php');

function handler()
{	require('../../core/rutas.php');
	$rol = get_mainObject('Premio');
	$periodo = get_mainObject('Periodo');
	$event = get_actualEvents(array(VIEW_GET_ALL, VIEW_SET), VIEW_GET_ALL);
	$user_data = get_frontData();

    switch ($event)
	{	case VIEW_GET_ALL:
			if (isset($_SESSION['IN']))
			{	if($_SESSION['IN']!="OK")
				{	$_SESSION['IN']="KO";
					header("Location: http://".$domain."/admisiones_americano/salir.php");
				}
				else
				{	$data["usua_nomb"]=$_SESSION["usua_nomb"];
					$data["usua_apel"]=$_SESSION["usua_apel"];
					$data["usua_correo"]=$_SESSION["usua_correo"];
					$data["rol_descripcion"]=$_SESSION["rol_descripcion"];
					$data['puntaje'] = $_SESSION['puntaje'];
				}
			}
			else
			{	header("Location: http://".$domain."/admisiones_americano");
			}
            //$rol->get_all($_SESSION['puntaje']);
			$rol->get_all_all( );
      		if(count($rol->rows)>0)
			{	global $diccionario;
				$table .= "<table class='display datatable' id='tbl_roles'>
							<thead><tr>
								<th style='text-align:left;'>Código</th>
								<th style='text-align:left;'>Nombre</th>
								<th style='text-align:left;'>Puntos</th>
								<th style='text-align:left;'>Adquirir</th>
							</tr></thead>";
				foreach( $rol->rows as $row )
				{	if( $row['premio_codigo'] != NULL )
					{	$table.= "<tr>";
						foreach( $row as $valor )
						{	$table.= "<td>".$valor."</td>";
						}
						if( $row['premio_puntaje'] <= $_SESSION['puntaje'] )
							$table.= "<td align='center'><span onclick='carga_edit(".$row['premio_codigo'].",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/reclamar/controller.php"'.")' class='btn_opc_lista_eliminar fa fa-gift' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='".
							$row['premio_codigo']."_editar' onmouseover='$(this).tooltip(".'"show"'.")' title='Adquirir regalo' data-placement='left'>&nbsp;</span></td>";
						else
							$table.= "<td><div style='font-size:x-small;'>Te faltan ".($row['premio_puntaje'] - $_SESSION['puntaje'])." Ptos.</div></td>";
						$table.= "</tr>";
					}
				}
				$table .= "</table>";
				$data['tabla'] = $table;
				$data['mensaje'] = "Listado de premios";
				$data['puntaje_personal'] = $_SESSION['puntaje'];
      		}
			else
			{	$data = array('mensaje'=>$rol->mensaje);
      		}
			$periodo->get_combo_all();
			$data["{cmb_periodos}"] = array("elemento"  => "combo", 
										   "datos"     => $periodo->rows,
										   "options"   => array("name"=>"periodo_select","id"=>"periodo_select","class"=>"form-control","required"=>"required","onchange"=>"change_periodo('".$diccionario['rutas_head']['ruta_html']."/general/controller.php')","style"=>"margin-top:7px"),
										   "selected"  => $_SESSION['peri_codi']);
      		retornar_vista(VIEW_GET_ALL, $data);
            break;
        case GET_ALL_DATA:
            //$rol->get_all($_SESSION['puntaje']);
			$rol->get_all_all( );
      		if(count($rol->rows)>0)
			{	global $diccionario;
				$table .= "<table class='display datatable' id='tbl_roles'>
							<thead><tr>
								<th style='text-align:left;'>Código</th>
								<th style='text-align:left;'>Nombre</th>
								<th style='text-align:left;'>Puntos</th>
								<th style='text-align:left;'>Adquirir</th>
							</tr></thead>";
				foreach( $rol->rows as $row )
				{	if( $row['premio_codigo'] != NULL )
					{	$table.= "<tr>";
						foreach( $row as $valor )
						{	$table.= "<td>".$valor."</td>";
						}
						if( $row['premio_puntaje'] <= $_SESSION['puntaje'] )
							$table.= "<td align='center'><span onclick='carga_edit(".$row['premio_codigo'].",".'"modal_edit_body"'.",".'"'.$diccionario['rutas_head']['ruta_html'].'/reclamar/controller.php"'.")' class='btn_opc_lista_eliminar fa fa-gift' aria-hidden='true' data-toggle='modal' data-target='#modal_edit' id='".
							$row['premio_codigo']."_editar' onmouseover='$(this).tooltip(".'"show"'.")' title='Adquirir regalo' data-placement='left'>&nbsp;</span></td>";
						else
							$table.= "<td><div style='font-size:x-small;'>Te faltan ".($row['premio_puntaje'] - $_SESSION['puntaje'])." Ptos.</div></td>";
						$table.= "</tr>";
					}
				}
				$table .= "</table>";
				$data['tabla'] = $table;
				$data['mensaje'] = "Listado de roles:";
      		}
			else
			{	
				$data = array('mensaje'=>$rol->mensaje);
      		}
            retornar_result($data);
            break;
        case GET:
            $rol->get($user_data['codigo']);
            $data = array('rol_codigo'=>$user_data['codigo'],
                          'rol_descripcion'=>$rol->premio_descripcion,
						  'puntos'=>$rol->premio_puntaje,
						  'puntos_mios'=>$_SESSION['puntaje'],
						  'puntos_sobrantes'=> ( $_SESSION['puntaje'] - $rol->premio_puntaje ) );
            retornar_formulario(VIEW_EDIT, $data);
            break;
        case EDIT:
            $rol->edit($user_data);
			if ( $rol->mensaje == "¡Exito! Premio reclamado correctamente" )
			{	
				$_SESSION['puntaje'] = $_SESSION['puntaje'] - $user_data['puntos'];
				
				$price = new Premio();
				$price-> get_specific_price_name ( $user_data['codigo'] );
				
				require '../../includes/mailer/PHPMailer/PHPMailerAutoload.php';
				$mail = new PHPMailer(true);                                  // the true param means it will throw exceptions on errors, which we need to catch
				$mail->isSMTP();   
				// Activamos / Desactivamos el "debug" de SMTP 
				// 0 = Apagado 
				// 1 = Mensaje de Cliente 
				// 2 = Mensaje de Cliente y Servidor 
				$mail->SMTPDebug = 0; 

				// Log del debug SMTP en formato HTML 
				$mail->Debugoutput = 'html';

				// telling the class to use SMTP transport
				$mail->Host = 'smtp.gmail.com';                    			// Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                                     // Enable SMTP authentication
				$mail->Username = 'sistemas@redlinks.com.ec';    			// SMTP username
				$mail->Password = 'R3dlink51981';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            		// Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587; 
				
				$mail->AddAddress( $_SESSION['usua_correo'], $_SESSION['usua_nomb'] );
				$mail->AddAddress('sistemas@redlinks.com.ec');
				$cc = new Premio();
				$cc->get_users_mails ( 2 );
				foreach ($cc->rows as $row )
				{	if($row['usua_correo'] != NULL)
						$mail->AddAddress( $row['usua_correo'] );
				}
				$mail->SetFrom('no-responder@redlinks.com.ec');
				$mail->Subject = 'Felicidades, reclamaste un premio desde el Sistemas de Redlinks :D ';
				$mail->AltBody = 'Para ver este correo, por favor use un visualizador de email compatible con HTML.'; 
				$body="<html><head><meta charset='UTF-8'><title></title></head><body>";
				
				$body .="<h1>Sistema de Redlinks</h1>";
				$body .="<p>Estimado ".$_SESSION['usua_nomb'] .",</p>";
				$body .="<p>Usted ha reclamado un '".$price->rows[0]['premio_descripcion']."'. Acérquese al área de Recursos Humanos para que pueda retirar su premio.
						<br>
						<br>Muchas gracias por ser un BUEN EMPLEADO : ).
						</p>";
				$body .="<p></p>";
				$body .="<p>Atentamente, </p>";
				$body .="<p>SDRL</p>";
				$body.="</body></html>";
				$mail->MsgHTML($body);                                        // optional - MsgHTML will create an alternate automatically
				$mail->isHTML(true);                                          // Set email format to HTML
				$mail->CharSet = 'UTF-8';
				$mail->Send();
			}
			print_r( $rol->mensaje );
			break;
        default :
        	break;
    }
}
handler();
?>